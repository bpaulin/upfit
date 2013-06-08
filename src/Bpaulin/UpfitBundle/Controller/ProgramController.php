<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Form\ProgramType;

/**
 * Program controller.
 *
 * @Route("/admin/program")
 */
class ProgramController extends Controller
{

    /**
     * Lists all Program entities.
     *
     * @Route("", name="admin_program")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BpaulinUpfitBundle:Program')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Program entity.
     *
     * @Route("/", name="admin_program_create")
     * @Method("POST")
     * @Template("BpaulinUpfitBundle:Program:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Program();
        $form = $this->createForm(new ProgramType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Program '.$entity->getName().' created')
            );

            return $this->redirect($this->generateUrl('admin_program'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Program entity.
     *
     * @Route("/new", name="admin_program_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Program();
        $form   = $this->createForm(new ProgramType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Program entity.
     *
     * @Route("/{id}", name="admin_program_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Program $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Displays a form to edit an existing Program entity.
     *
     * @Route("/{id}/edit", name="admin_program_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction(Program $entity)
    {
        $editForm = $this->createForm(new ProgramType(), $entity);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Program entity.
     *
     * @Route("/{id}", name="admin_program_update")
     * @Method("PUT")
     * @Template("BpaulinUpfitBundle:Program:edit.html.twig")
     */
    public function updateAction(Request $request, Program $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new ProgramType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Program '.$entity->getName().' updated')
            );
            return $this->redirect($this->generateUrl('admin_program'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Deletes a Program entity.
     *
     * @Route("/{id}", name="admin_program_delete_confirm")
     * @Method("DELETE")
     */
    public function confirmDeleteAction(Request $request, Program $entity)
    {
        $form = $this->createDeleteForm($entity->getid());
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Program '.$entity->getName().' deleted')
            );
        }

        return $this->redirect($this->generateUrl('admin_program'));
    }

    /**
     * Deletes a Program entity.
     *
     * @Route("/{id}/delete", name="admin_program_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction(Program $entity)
    {
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Creates a form to delete a Program entity by id.
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
