<?php

namespace AppBundle\Controller;

use AppBundle\Repository\RecurringEmployeeFeedbackRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $entityManager = $this->get('doctrine.orm.default_entity_manager');

        /** @var RecurringEmployeeFeedbackRepository $repository */
        $repository = $entityManager->getRepository('AppBundle\Entity\RecurringEmployeeFeedback');

        $unappointedFeedbacks = $repository->findUnappointed(30);

        $appointedFeedbacks = $repository->findAppointed(30);

        $data = [
            [
                "value" => count($unappointedFeedbacks),
                "color" => "#F7464A",
                "highlight" => "#FF5A5E",
                "label" => "Unappointed Feedbacks",
            ],
            [
                "value" => count($appointedFeedbacks),
                "color" => "#46BFBD",
                "highlight" => "#5AD3D1",
                "label" => "Appointed Feedbacks",
            ],
        ];


        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.root_dir').'/..'),
            'data' => json_encode($data),
        ]);
    }
}
