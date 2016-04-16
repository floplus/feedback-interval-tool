<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\RecurringEmployeeFeedback;
use AppBundle\Form\RecurringEmployeeFeedbackType;

/**
 * RecurringEmployeeFeedback controller.
 *
 * @Route("/recurringemployeefeedback")
 */
class RecurringEmployeeFeedbackController extends Controller
{
    /**
     * Lists all RecurringEmployeeFeedback entities.
     *
     * @Route("/", name="recurringemployeefeedback_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $recurringEmployeeFeedbacks = $em->getRepository('AppBundle:RecurringEmployeeFeedback')->findAll();

        return $this->render('recurringemployeefeedback/index.html.twig', array(
            'recurringEmployeeFeedbacks' => $recurringEmployeeFeedbacks,
        ));
    }

    /**
     * Creates a new RecurringEmployeeFeedback entity.
     *
     * @Route("/new", name="recurringemployeefeedback_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $recurringEmployeeFeedback = new RecurringEmployeeFeedback();
        $form = $this->createForm('AppBundle\Form\RecurringEmployeeFeedbackType', $recurringEmployeeFeedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recurringEmployeeFeedback);
            $em->flush();

            return $this->redirectToRoute('recurringemployeefeedback_show', array('id' => $recurringEmployeeFeedback->getId()));
        }

        return $this->render('recurringemployeefeedback/new.html.twig', array(
            'recurringEmployeeFeedback' => $recurringEmployeeFeedback,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a RecurringEmployeeFeedback entity.
     *
     * @Route("/{id}", name="recurringemployeefeedback_show")
     * @Method("GET")
     */
    public function showAction(RecurringEmployeeFeedback $recurringEmployeeFeedback)
    {
        $deleteForm = $this->createDeleteForm($recurringEmployeeFeedback);

        return $this->render('recurringemployeefeedback/show.html.twig', array(
            'recurringEmployeeFeedback' => $recurringEmployeeFeedback,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing RecurringEmployeeFeedback entity.
     *
     * @Route("/{id}/edit", name="recurringemployeefeedback_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, RecurringEmployeeFeedback $recurringEmployeeFeedback)
    {
        $deleteForm = $this->createDeleteForm($recurringEmployeeFeedback);
        $editForm = $this->createForm('AppBundle\Form\RecurringEmployeeFeedbackType', $recurringEmployeeFeedback);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($recurringEmployeeFeedback);
            $em->flush();

            return $this->redirectToRoute('recurringemployeefeedback_edit', array('id' => $recurringEmployeeFeedback->getId()));
        }

        return $this->render('recurringemployeefeedback/edit.html.twig', array(
            'recurringEmployeeFeedback' => $recurringEmployeeFeedback,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a RecurringEmployeeFeedback entity.
     *
     * @Route("/{id}", name="recurringemployeefeedback_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, RecurringEmployeeFeedback $recurringEmployeeFeedback)
    {
        $form = $this->createDeleteForm($recurringEmployeeFeedback);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($recurringEmployeeFeedback);
            $em->flush();
        }

        return $this->redirectToRoute('recurringemployeefeedback_index');
    }

    /**
     * Creates a form to delete a RecurringEmployeeFeedback entity.
     *
     * @param RecurringEmployeeFeedback $recurringEmployeeFeedback The RecurringEmployeeFeedback entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(RecurringEmployeeFeedback $recurringEmployeeFeedback)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('recurringemployeefeedback_delete', array('id' => $recurringEmployeeFeedback->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
