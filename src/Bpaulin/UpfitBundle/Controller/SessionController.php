<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Entity\Session;
use Bpaulin\UpfitBundle\Form\SessionType;
use Bpaulin\UpfitBundle\Form\WorkoutType;

/**
 * Program controller.
 *
 */
class SessionController extends Controller
{
    /**
     * List user's sessions
     *
     * @Route("/member/session", name="member_session")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BpaulinUpfitBundle:Session')->findBy(
            array(
                'user' => $this->get('security.context')->getToken()->getUser()
            )
        );

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
        if ($entity->getUser() != $this->get('security.context')->getToken()->getUser()) {
            throw new AccessDeniedException('');
        }

        return array(
            'entity'      => $entity,
        );
    }

    /**
     * Start a new session
     *
     * @Route("/member/session/new/{follow}/{id}", name="member_session_new")
     * @Template()
     */
    public function newAction($follow, $id)
    {
        if ($follow != 'program' && $follow != 'session') {
            throw new Exception();
        }
        $em = $this->getDoctrine()->getManager();
        $session = new Session();
        $session->setUser($this->get('security.context')->getToken()->getUser());

        if ($follow == 'program') {
            $program = $em->getRepository('BpaulinUpfitBundle:Program')->find($id);
            if (!$program) {
                throw new NotFoundException('program not found');
            }
            $session->initWithProgram($program);
        } elseif ($follow == 'session') {
            $origin = $em->getRepository('BpaulinUpfitBundle:Session')->findOneBy(
                array(
                    'id'    => $id,
                    'user'  => $this->get('security.context')->getToken()->getUser()
                )
            );
            if (!$origin) {
                throw new NotFoundException('session not found');
            }
            $session->initWithSession($origin);
        }
        $em->persist($session);
        $em->flush();

        return $this->redirect($this->generateUrl('member_session_workout', array('id' => $session->getId())));
    }

    /**
     * Display or save next workout
     *
     * @Route("/member/session/{id}/workout", name="member_session_workout")
     * @Template()
     */
    public function workoutAction(Request $request, Session $session)
    {
        if ($session->getUser() != $this->get('security.context')->getToken()->getUser()) {
            throw new AccessDeniedException('');
        }

        $next = $session->getNextWorkout();
        if (!$next) {
            $this->get('session')->getFlashBag()->add(
                'success',
                'session finished'
            );

            return $this->redirect($this->generateUrl('member_session_edit', array('id' => $session->getId())));
        }

        $form   = $this->createForm(new WorkoutType(), $next);

        $form->handleRequest($request);
        if ($form->isValid()) {
            if ($form->get('done')->isClicked()) {
                $session->doneWorkout();
            } elseif ($form->get('pass')->isClicked()) {
                $session->passWorkout();
                $this->get('session')->getFlashBag()->add(
                    'info',
                    $next->getExercise()->getName().' passed'
                );
            } elseif ($form->get('abandon')->isClicked()) {
                $session->abandonWorkout();
                $this->get('session')->getFlashBag()->add(
                    'info',
                    $next->getExercise()->getName().' abandoned'
                );
            }
            $em = $this->getDoctrine()->getManager();
            $em->persist($session);
            $em->flush();

            return $this->redirect($this->generateUrl('member_session_workout', array('id' => $session->getId())));
        }

        return array(
            'entity' => $session,
            'form'   => $form->createView()
        );
    }

    /**
     * Edit session's details
     *
     * @Route("/member/session/{id}/edit", name="member_session_edit")
     * @Template()
     */
    public function editAction(Session $session)
    {
        if ($session->getUser() != $this->get('security.context')->getToken()->getUser()) {
            throw new AccessDeniedException('');
        }

        if (!$session->getGrade()) {
            $session->setGradeToAverage();
        }
        $editForm = $this->createForm(new SessionType(), $session);

        return array(
            'entity'      => $session,
            'edit_form'   => $editForm->createView(),
        );
    }

    /**
     * Update session's details
     *
     * @Route("/member/session/{id}", name="member_session_update")
     * @Method("PUT")
     * @Template("BpaulinUpfitBundle:Session:edit.html.twig")
     */
    public function updateAction(Request $request, Session $entity)
    {
        if ($entity->getUser() != $this->get('security.context')->getToken()->getUser()) {
            throw new AccessDeniedException('');
        }
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

    /**
     * Deletes a Session entity.
     *
     * @Route("/member/session/{id}/delete", name="member_session_delete")
     * @Method("GET")
     * @Template()
     */
    public function deleteAction(Session $entity)
    {
        $deleteForm = $this->createDeleteForm($entity->getId());

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Session entity.
     *
     * @Route("/member/session/{id}", name="member_session_delete_confirm")
     * @Method("DELETE")
     */
    public function confirmDeleteAction(Request $request, Session $entity)
    {
        $form = $this->createDeleteForm($entity->getid());
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($entity);
            $em->flush();
            $this->get('session')->getFlashBag()->add(
                'success',
                $this->get('translator')->trans('Session '.$entity->getName().' deleted')
            );
        }

        return $this->redirect($this->generateUrl('member_session'));
    }

    /**
     * Display unfinished sessions
     * @Method("GET")
     */
    public function todoAction()
    {
        $em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('BpaulinUpfitBundle:Session')->findUnfinishedByUser(
            $this->get('security.context')->getToken()->getUser()
        );

        return $this->render(
            'BpaulinUpfitBundle:Session:todo.html.twig',
            array(
                'sessions' => $entities
            )
        );
    }

    /**
     * Creates a form to delete a Session entity by id.
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
