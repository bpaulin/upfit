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

        $weight = new Weight();
        $editForm = $this->createForm(new WeightType(), $weight);

        $lastWeight = $em->getRepository('BpaulinUpfitBundle:Weight')->findBy(
            array(
                'user' => $this->get('security.context')->getToken()->getUser()
            ),
            array(
                'dateRecord' => 'DESC'
            )
        );

        return array(
            'entity' => $weight,
            'lastWeight' => $lastWeight,
            'form'   => $editForm->createView(),
        );
    }

    /**
     * Creates a new Weight entity.
     *
     * @Route("/member/weight", name="member_weight_create")
     * @Method("POST")
     * @Template("BpaulinUpfitBundle:Weight:index.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Weight();
        $entity->setDateRecord(new \DateTime("today"));
        $entity->setUser($this->get('security.context')->getToken()->getUser());

        $form = $this->createForm(new WeightType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
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
}
