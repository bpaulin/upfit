<?php

namespace Bpaulin\UpfitBundle\DataFixtures\ORM;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bpaulin\UpfitBundle\Entity\Muscle;
use Bpaulin\UpfitBundle\Entity\Exercise;
use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Entity\Stage;
use Bpaulin\UpfitBundle\Entity\Club;
use Bpaulin\UpfitBundle\Entity\Member;

class LoadDemoData implements FixtureInterface, ContainerAwareInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    public function load(ObjectManager $manager)
    {
        $userManager = $this->container->get('fos_user.user_manager');

        $member = $userManager->createUser();
        $member->setUsername("member")
            ->setEmail("member@upfit.com")
            ->setPlainPassword("member")
            ->setRoles(array('ROLE_USER'))
            ->setEnabled(true);
        $userManager->updateUser($member, true);

        $admin = $userManager->createUser();

        $admin->setUsername("admin")
            ->setEmail("admin@upfit.com")
            ->setPlainPassword("admin")
            ->setRoles(array('ROLE_ADMIN'))
            ->setEnabled(true);
        $userManager->updateUser($admin, true);

        $userClub1 = $userManager->createUser();
    }
}
