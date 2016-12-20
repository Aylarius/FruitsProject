<?php

namespace FruitsBundle\Controller;

use FruitsBundle\Entity\Fruits;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Serializer;



/**
 * Fruit controller.
 *
 */
class FruitsController extends Controller
{
    public function getAllAction()
    {
        // Get data from database
        $em = $this->getDoctrine()->getManager();
        $fruits = $em->getRepository('FruitsBundle:Fruits')->findAll();

        // Return as JSON
        $fruits = $this->get('serializer')->serialize($fruits, 'json');
        return new JsonResponse(json_decode($fruits));
    }


    public function newAction(Request $request)
    {
        // Get data and decode JSON
        $data = json_decode(json_encode($request->request->all()), true);

        // Create new album entity
        $fruit = new Fruits();
        $fruit->setNomFruit($data['nomFruit']);
        $fruit->setQuantite($data['quantite']);

        // Send to database
        $em = $this->getDoctrine()->getManager();
        $em->persist($fruit);
        $em->flush();

        // Return as JSON
        $serializer = $this->get('serializer');
        $response = $serializer->serialize($data, 'json');
        return new JsonResponse(json_decode($response));

    }


    public function getOneAction(Fruits $fruit)
    {
        // Return as JSON
        $fruit = $this->get('serializer')->serialize($fruit, 'json');
        return new JsonResponse(json_decode($fruit));
    }


    public function editAction(Request $request, Fruits $fruit)
    {
        // Get data and decode JSON
        $data = json_decode(json_encode($request->request->all()), true);

        // Update data
        if (isset($data['nomFruit'])) {
            $fruit->setNomFruit($data['nomFruit']);
        }
        if (isset($data['quantite'])) {
            $fruit->setQuantite($data['quantite']);
        }

        // Get all data as JSON
        $em = $this->getDoctrine()->getManager();
        $em->persist($fruit);
        $em->flush();

        // Return as JSON
        $fruit = $this->get('serializer')->serialize($fruit, 'json');
        return new JsonResponse(json_decode($fruit));
    }


    public function deleteAction(Fruits $fruit)
    {
        // Delete from database
        $em = $this->getDoctrine()->getManager();
        $em->remove($fruit);
        $em->flush($fruit);

        // Return as JSON
        $fruit = $this->get('serializer')->serialize($fruit, 'json');
        return new JsonResponse(json_decode($fruit));
    }







    /**
     * Lists all fruit entities.
     *

    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $fruits = $em->getRepository('FruitsBundle:Fruits')->findAll();

        return $this->render('FruitsBundle:Fruits:index.html.twig', array(
            'fruits' => $fruits,
        ));
    }


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


    public function showAction(Fruits $fruit)
    {
        $deleteForm = $this->createDeleteForm($fruit);

        return $this->render('FruitsBundle:Fruits:show.html.twig', array(
            'fruit' => $fruit,
            'delete_form' => $deleteForm->createView(),
        ));
    }


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


    private function createDeleteForm(Fruits $fruit)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('fruits_delete', array('id' => $fruit->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }

    */
}
