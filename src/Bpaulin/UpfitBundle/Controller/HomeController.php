<?php

namespace Bpaulin\UpfitBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

class HomeController extends Controller
{
    /**
     * @Route("/", name="upfit_index")
     * @Template()
     */
    public function indexAction()
    {
        return array('name' => 'Bruno');
    }

    /**
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
     * @Route("/admin", name="upfit_admin")
     * @Template()
     */
    public function adminAction()
    {
        return array('name' => 'Bruno');
    }

    /**
     * @Route("/member", name="upfit_member")
     * @Template()
     */
    public function memberAction()
    {
        return array('name' => 'Bruno');
    }
}
