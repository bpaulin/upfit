<?php

namespace Bpaulin\UpfitBundle\DataFixtures\ORM\Prod;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bpaulin\UpfitBundle\Entity\Muscle;

class LoadMuscleData implements FixtureInterface, ContainerAwareInterface
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
        $muscleNames = array(
            "Trapezius",
            "Deltoid",
            "Biceps",
            "Triceps",
            "Forearm",
            "Pectoral",
            "Abs",
            "Oblique Abs",
            "Dorsal",
            "Lumbar",
            "Gluteus",
            "Adductor",
            "Quadriceps",
            "Femoral",
            "Calf"
        );
        foreach ($muscleNames as $name) {
            $muscle = new Muscle();
            $muscle->setName($name);
            $manager->persist($muscle);
        }
        $manager->flush();
    }
}
