<?php

namespace Bpaulin\UpfitBundle\DataFixtures\ORM\Dev;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bpaulin\UpfitBundle\Entity\Weight;

class LoadWeightData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        // weight objectives
        $member = $this->getReference('member');
        $member->setWeightObjective(74);
        $member->setWeightTolerance(2);
        $manager->persist($member);

        // weights history
        $since = 700; // days
        $periodMax = 5; // days
        $from = 94; // kgs
        $to = 77; // kgs
        $day = $since;
        do {
            $weight = new Weight();
            $weight->setDateRecord(new \DateTime($day." days ago"))
                ->setWeight($to + ($from-$to)*($day/$since) + rand(-2, 2))
                ->setUser($member);
            $manager->persist($weight);
            $day = $day - rand(1, $periodMax);
        } while ($day > 0);

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1;
    }
}
