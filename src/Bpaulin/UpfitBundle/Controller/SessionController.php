<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Entity\Session;
use Bpaulin\UpfitBundle\Form\SessionType;

/**
 * Program controller.
 *
 */
class SessionController extends Controller
{
    /**
     * @Route("/member/session", name="member_session")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BpaulinUpfitBundle:Session')->findAll();

        return array(
            'entities' => $entities,
        );
    }

    /**
     * Finds and displays a Session entity.
     *
     * @Route("/member/session/{id}", name="member_session_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction(Session $entity)
    {
        return array(
            'entity'      => $entity,
        );
    }

    /**
     * @Route("/member/session/new/{follow}/{id}", name="member_session_new")
     * @Template()
     */
    public function newAction($follow, $id)
    {
        if ($follow != 'program') {
            throw new Exception();
        }
        $em = $this->getDoctrine()->getManager();

        $program = $em->getRepository('BpaulinUpfitBundle:Program')->find($id);
        if (!$program) {
            throw new NotFoundException('program not found');
        }

        $session = new Session();
        $session->initWithProgram($program);
        $em->persist($session);
        $em->flush();

        return $this->redirect($this->generateUrl('member_session_workout', array('id' => $session->getId())));
    }

    /**
     * @Route("/member/session/{id}/workout", name="member_session_workout")
     * @Template()
     */
    public function workoutAction(Session $session)
    {
        $next = $session->getNextWorkout();
        if (!$next) {

            $this->get('session')->getFlashBag()->add(
                'success',
                'session finished'
            );
            return $this->redirect($this->generateUrl('member_session_edit', array('id' => $session->getId())));
        }
        return array(
            'session' => $session
        );
    }

    /**
     * @Route("/member/session/{id}/workout/abandon", name="member_session_workout_abandon")
     * @Template()
     */
    public function workoutAbandonAction(Session $session)
    {
        $em = $this->getDoctrine()->getManager();
        $next = $session->getNextWorkout();

        $session->abandonWorkout();

        $em->persist($session);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'info',
            $next->getExercise()->getName().' abandonned'
        );

        return $this->redirect($this->generateUrl('member_session_workout', array('id' => $session->getId())));
    }

    /**
     * @Route("/member/session/{id}/workout/pass", name="member_session_workout_pass")
     * @Template()
     */
    public function workoutPassAction(Session $session)
    {
        $em = $this->getDoctrine()->getManager();
        $next = $session->getNextWorkout();

        $session->passWorkout();

        $em->persist($session);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'info',
            $next->getExercise()->getName().' passed'
        );


        return $this->redirect($this->generateUrl('member_session_workout', array('id' => $session->getId())));
    }

    /**
     * @Route("/member/session/{id}/workout/done", name="member_session_workout_done")
     * @Template()
     */
    public function workoutDoneAction(Session $session)
    {
        $em = $this->getDoctrine()->getManager();

        $session->doneWorkout();

        $em->persist($session);
        $em->flush();

        return $this->redirect($this->generateUrl('member_session_workout', array('id' => $session->getId())));
    }

    /**
     * @Route("/member/session/{id}/edit", name="member_session_edit")
     * @Template()
     */
    public function editAction(Session $session)
    {
        $editForm = $this->createForm(new SessionType(), $session);

        return array(
            'entity'      => $session,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Edits an existing Program entity.
     *
     * @Route("/member/session/{id}", name="member_session_update")
     * @Method("PUT")
     * @Template("BpaulinUpfitBundle:Session:edit.html.twig")
     */
    public function updateAction(Request $request, Session $entity)
    {
        $em = $this->getDoctrine()->getManager();

        $editForm = $this->createForm(new SessionType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em = $this->getDoctrine()->getManager();

            $em->persist($entity);
            $em->flush();

            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Session '.$entity->getName().' updated')
            );
            return $this->redirect($this->generateUrl('member_session'));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
        );

    }
}
