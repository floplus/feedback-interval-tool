<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Employee;
use AppBundle\Entity\RecurringEmployeeFeedback;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadEmployeeData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $employeesData = [
            ['jane.doe@fit.app', 'Jane', 'Doe'],
            ['john.doe@fit.app', 'John', 'Doe'],
            ['hans.wurst@fit.app', 'Hans', 'Wurst'],
            ['gabi.mustermann@fit.app', 'Gabi', 'Mustermann'],
            ['max.musterfrau@fit.app', 'Max', 'Musterfrau'],
        ];

        $employees = [];

        foreach ($employeesData as $employeeData) {
            $employee = new Employee();
            $employee->setEmail($employeeData[0]);
            $employee->setFirstName($employeeData[1]);
            $employee->setLastName($employeeData[2]);

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
    }

    protected function createRef(ObjectManager $manager, Employee $employee)
    {
        // first feedback in the next month or so
        $ref = new RecurringEmployeeFeedback();
        $ref->setEmployee($employee);

        $targetDate = new \DateTime();
        $targetDate->add(new \DateInterval(sprintf('P%dD', rand(25, 90))));
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
