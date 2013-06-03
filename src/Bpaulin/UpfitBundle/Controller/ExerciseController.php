<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bpaulin\UpfitBundle\Entity\Exercise;
use Bpaulin\UpfitBundle\Form\ExerciseType;

/**
 * Exercise controller.
 *
 * @Route("/admin/exercise")
 */
class ExerciseController extends Controller
{

    /**
     * Lists all Exercise entities.
     *
     * @Route("", name="admin_exercise")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BpaulinUpfitBundle:Exercise')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Exercise entity.
     *
     * @Route("/", name="admin_exercise_create")
     * @Method("POST")
     * @Template("BpaulinUpfitBundle:Exercise:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Exercise();
        $form = $this->createForm(new ExerciseType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Exercise '.$entity->getName().' created')
            );

            return $this->redirect($this->generateUrl('admin_exercise'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Exercise entity.
     *
     * @Route("/new", name="admin_exercise_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Exercise();
        $form   = $this->createForm(new ExerciseType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Exercise entity.
     *
     * @Route("/{id}", name="admin_exercise_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Exercise $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Exercise entity.
     *
     * @Route("/{id}/edit", name="admin_exercise_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Exercise $entity)
    {
        $editForm = $this->createForm(new ExerciseType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Exercise entity.
     *
     * @Route("/{id}", name="admin_exercise_update")
     * @Method("PUT")
     * @Template("BpaulinUpfitBundle:Exercise:edit.html.twig")
     */
    public function updateAction(Request $request, Exercise $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new ExerciseType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Exercise '.$entity->getName().' updated')
            );
            return $this->redirect($this->generateUrl('admin_exercise'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Exercise entity.
     *
     * @Route("/{id}", name="admin_exercise_delete_confirm")
     * @Method("DELETE")
     */
    public function confirmDeleteAction(Request $request, Exercise $entity)
    {
        $form = $this->createDeleteForm($entity->getid());
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Exercise '.$entity->getName().' deleted')
            );
        }

        return $this->redirect($this->generateUrl('admin_exercise'));
    }

    /**
     * Deletes a Exercise entity.
     *
     * @Route("/{id}/delete", name="admin_exercise_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction(Request $request, Exercise $entity)
    {
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to delete a Exercise entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm();
    }
}
