<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Employee;
use AppBundle\Entity\RecurringEmployeeFeedback;
use AppBundle\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\Security\Core\Tests\Encoder\PasswordEncoder;
use Symfony\Component\Serializer\Encoder\EncoderInterface;

class LoadEmployeeData implements FixtureInterface, ContainerAwareInterface
{
    use ContainerAwareTrait;

    public function load(ObjectManager $manager)
    {
        $employeesData = [
            ['jane.doe@fit.app', 'Jane', 'Doe', '@slackbot'],
            ['john.doe@fit.app', 'John', 'Doe', '@slackbot'],
            ['hans.wurst@fit.app', 'Hans', 'Wurst', '@slackbot'],
            ['gabi.mustermann@fit.app', 'Gabi', 'Mustermann', '@slackbot'],
            ['max.musterfrau@fit.app', 'Max', 'Musterfrau', '@slackbot'],
            ['florian.beyerlein@hmmh.de', 'Florian', 'Beyerlein', '@floplus'],
            ['vanessa.wrede@hmmh.de', 'Vanessa', 'Wrede', '@vanessa_wrede'],
            ['julian.nuss@hmmh.de', 'Julian', 'Nuß', '@julian.nuss'],
        ];

        $employees = [];

        foreach ($employeesData as $employeeData) {
            $employee = new Employee();
            $employee->setEmail($employeeData[0]);
            $employee->setFirstName($employeeData[1]);
            $employee->setLastName($employeeData[2]);
            $employee->setSlackHandle($employeeData[3]);

            $manager->persist($employee);
            $manager->flush();

            $employees[] = $employee;
        }

        $previousEmployee = null;
        /** @var Employee $employee */
        foreach ($employees as $employee) {
            if ($previousEmployee) {
                $employee->setSuperiors(new ArrayCollection([$previousEmployee]));
                $manager->persist($employee);
                $manager->flush();
            }

            $previousEmployee = $employee;

            $this->createRef($manager, $employee);
        }

        $user = new User();
        $user->setUsername('admin');
        $user->setEmail('admin@fit.app');
        $user->setEnabled(true);
        $user->addRole('ADMIN_ROLE');
        $user->setSuperAdmin(true);

        // the 'security.password_encoder' service requires Symfony 2.6 or higher
        /** @var PasswordEncoder $encoder */
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($user, 'secret');
        $user->setPassword($password);

        $manager->persist($user);
        $manager->flush();
    }

    protected function createRef(ObjectManager $manager, Employee $employee)
    {
        // first feedback in the next month or so
        $ref = new RecurringEmployeeFeedback();
        $ref->setEmployee($employee);

        $targetDate = new \DateTime();
        $targetDate->add(new \DateInterval(sprintf('P%dD', rand(1, 60))));
        $ref->setTargetDate($targetDate);
        $manager->persist($ref);

        //older feedback with all data set
        $ref = new RecurringEmployeeFeedback();
        $ref->setEmployee($employee);

        $targetDate = new \DateTime();
        $targetDate->sub(new \DateInterval(sprintf('P%dD', rand(300, 600))));
        $ref->setTargetDate($targetDate);
        $ref->setAppointedDate($targetDate);
        $manager->persist($ref);

        $manager->flush();
    }
}
