<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bpaulin\UpfitBundle\Entity\Muscle;

/**
 * Muscle controller.
 *
 * @Route("/member/muscle")
 */
class MuscleController extends Controller
{
    /**
     * List muscles
     *
     * @Route("", name="member_muscle")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BpaulinUpfitBundle:Muscle')->findAll();

        return array(
            'entities' => $entities,
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
