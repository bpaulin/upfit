<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Home Controller
 */
class HomeController extends Controller
{
    /**
     * landing page
     *
     * @Route("/", name="upfit_index")
     * @Template()
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * generic home page
     *
     * @Route("/home", name="upfit_home")
     * @Template()
     */
    public function homeAction()
    {
        if ($this->get('security.context')->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('upfit_admin'));
        } else {
            return $this->redirect($this->generateUrl('upfit_member'));
        }
    }

    /**
     * admin home page
     *
     * @Route("/admin", name="upfit_admin")
     * @Template()
     */
    public function adminAction()
    {
        return array();
    }

    /**
     * member home page
     *
     * @Route("/member", name="upfit_member")
     * @Template()
     */
    public function memberAction()
    {
        return array();
    }
}
