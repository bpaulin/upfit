<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bpaulin\UpfitBundle\Entity\Weight;
use Bpaulin\UpfitBundle\Form\WeightType;
use Bpaulin\UpfitBundle\Form\WeightObjectiveType;

/**
 * Weight controller.
 *
 */
class WeightController extends AbstractController
{
    /**
     * Weight Tracker page
     *
     * @Route("/member/weight", name="member_weight")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $repoWeight = $em->getRepository('BpaulinUpfitBundle:Weight');

        $weights = $repoWeight->findBy(
            array('user' => $user),
            array('dateRecord' => 'ASC')
        );

        $weight = end($weights);
        reset($weights);
        if (!$weight || $weight->getDateRecord()->diff(new \DateTime("today"))->format('%a') !== '0') {
            $weight = new Weight();
        }
        $editForm = $this->createForm(new WeightType(), $weight, array(
            'action' => $this->generateUrl('member_weight_store'),
            'method' => 'POST',
        ));

        $objectiveForm = $this->createForm(new WeightObjectiveType(), $user, array(
            'action' => $this->generateUrl('member_weight_objective'),
            'method' => 'POST',
        ));

        $weekWeight = $repoWeight->average($user, 7);
        $monthWeight = $repoWeight->average($user, 30);

        return array(
            'entity'      => $weight,
            'lastWeight'  => $weights,
            'weekWeight'  => $weekWeight,
            'monthWeight' => $monthWeight,
            'form'        => $editForm->createView(),
            'objectiveForm' => $objectiveForm->createView(),
        );
    }

    /**
     * Store today's weight.
     *
     * @Route("/member/weight/store", name="member_weight_store")
     * @Method("POST")
     */
    public function storeAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();
        $repoWeight = $em->getRepository('BpaulinUpfitBundle:Weight');

        $weights = $repoWeight->findBy(
            array('user' => $user),
            array('dateRecord' => 'ASC')
        );

        $entity = end($weights);
        reset($weights);
        if (!$entity || $entity->getDateRecord()->diff(new \DateTime("today"))->format('%a') !== '0') {
            $entity = new Weight();
            $entity->setDateRecord(new \DateTime("today"));
            $entity->setUser($this->get('security.context')->getToken()->getUser());
        }

        $form = $this->createForm(new WeightType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Weight stored')
            );

            return $this->redirect($this->generateUrl('member_weight'));
        }

        $this->get('session')->getFlashBag()->add(
            'error',
            $this->get('translator')->trans('Weight not stored')
        );

        return $this->redirect($this->generateUrl('member_weight'));
    }

    /**
     * Set User weight objective
     *
     * @Route("/member/weight/objective", name="member_weight_objective")
     * @Method("POST")
     */
    public function objectiveAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->get('security.context')->getToken()->getUser();

        $objectiveForm = $this->createForm(new WeightObjectiveType(), $user);
        $objectiveForm->bind($request);

        if ($objectiveForm->isValid()) {
            $em->persist($user);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Objective set')
            );

            return $this->redirect($this->generateUrl('member_weight'));
        }

        $this->get('session')->getFlashBag()->add(
            'error',
            $this->get('translator')->trans('Objective not set')
        );

        return $this->redirect($this->generateUrl('member_weight'));

    }
}
