<?php

namespace AppBundle\Command;

use AppBundle\AppBundle;
use AppBundle\Entity\RecurringEmployeeFeedback;
use AppBundle\Repository\RecurringEmployeeFeedbackRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class CollectUnappointedFeedbackCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('fit:collect:unappointed-feedback')
            ->setDescription('Look for feedback with missing appointed dates that are due to be appointed.')
            ->addArgument('threshold', InputArgument::REQUIRED, 'Threshold in days that an feedback may be in the future not to collect it.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $threshold = (int)$input->getArgument('threshold');

        $output->writeln(sprintf('Collecting feedbacks not yet appointed in %d days', $threshold));

        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->get('doctrine.orm.default_entity_manager');

        /** @var RecurringEmployeeFeedbackRepository $repository */
        $repository = $entityManager->getRepository('AppBundle\Entity\RecurringEmployeeFeedback');

        $feedbacks = $repository->findUnappointed($threshold);

        /** @var \OldSound\RabbitMqBundle\RabbitMq\Producer $producer */
        $producer = $this->getContainer()->get('old_sound_rabbit_mq.unappointed_feedback_producer');


        /** @var RecurringEmployeeFeedback $feedback */
        foreach ($feedbacks as $feedback) {
            $output->writeln(sprintf('Feedback with missing appointed date: %s', $feedback));

            $msg = array('feedback_id' => $feedback->getId());
            $producer->publish(serialize($msg));
        }

    }

}
