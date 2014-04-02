<?php

namespace Bpaulin\UpfitBundle\DataFixtures\ORM\Test;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadDevData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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

        $other = $userManager->createUser();
        $other->setUsername("other")
            ->setEmail("other@upfit.com")
            ->setPlainPassword("other")
            ->setRoles(array('ROLE_USER'))
            ->setEnabled(true);
        $userManager->updateUser($other, true);

        $admin = $userManager->createUser();
        $admin->setUsername("admin")
            ->setEmail("admin@upfit.com")
            ->setPlainPassword("admin")
            ->setRoles(array('ROLE_ADMIN'))
            ->setEnabled(true);
        $userManager->updateUser($admin, true);

        $manager->flush();

        $this->addReference('admin', $admin);
        $this->addReference('member', $member);
        $this->addReference('other', $other);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 0;
    }
}
