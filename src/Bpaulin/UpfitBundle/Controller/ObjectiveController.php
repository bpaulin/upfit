<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bpaulin\UpfitBundle\Entity\Muscle;
use Bpaulin\UpfitBundle\Form\ObjectivesType;

/**
 * Muscle controller.
 *
 * @Route("/member/objectives")
 */
class ObjectiveController extends Controller
{
    /**
     * Display objectives
     *
     * @Route("", name="member_objectives")
     * @Template()
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BpaulinUpfitBundle:Muscle')->findAll();
        $user = $this->get('security.context')->getToken()->getUser();
        $user->FillObjectives($entities);

        $editForm = $this->createForm(new ObjectivesType(), $user);

        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Objectives updated')
            );

            return $this->redirect($this->generateUrl('member_objectives'));
        }

        return array(
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Finds and displays a Muscle entity.
     *
     * @Route("/{id}", name="member_muscle_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Muscle $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }
}
