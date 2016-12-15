<?php

namespace FruitsBundle\Controller;

use FruitsBundle\Entity\Fruits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Fruit controller.
 *
 */
class FruitsController extends Controller
{
    /**
     * Lists all fruit entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fruits = $em->getRepository('FruitsBundle:Fruits')->findAll();

        return $this->render('FruitsBundle:Fruits:index.html.twig', array(
            'fruits' => $fruits,
        ));
    }

    /**
     * Creates a new fruit entity.
     *
     */
    public function newAction(Request $request)
    {
        $fruit = new Fruits();
        $form = $this->createForm('FruitsBundle\Form\FruitsType', $fruit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($fruit);
            $em->flush($fruit);

            return $this->redirectToRoute('fruits_show', array('id' => $fruit->getId()));
        }

        return $this->render('FruitsBundle:Fruits:new.html.twig', array(
            'fruit' => $fruit,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a fruit entity.
     *
     */
    public function showAction(Fruits $fruit)
    {
        $deleteForm = $this->createDeleteForm($fruit);

        return $this->render('FruitsBundle:Fruits:show.html.twig', array(
            'fruit' => $fruit,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing fruit entity.
     *
     */
    public function editAction(Request $request, Fruits $fruit)
    {
        $deleteForm = $this->createDeleteForm($fruit);
        $editForm = $this->createForm('FruitsBundle\Form\FruitsType', $fruit);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('fruits_edit', array('id' => $fruit->getId()));
        }

        return $this->render('FruitsBundle:Fruits:edit.html.twig', array(
            'fruit' => $fruit,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a fruit entity.
     *
     */
    public function deleteAction(Request $request, Fruits $fruit)
    {
        $form = $this->createDeleteForm($fruit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($fruit);
            $em->flush($fruit);
        }

        return $this->redirectToRoute('fruits_index');
    }

    /**
     * Creates a form to delete a fruit entity.
     *
     * @param Fruits $fruit The fruit entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Fruits $fruit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fruits_delete', array('id' => $fruit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
