<?php

namespace Bpaulin\UpfitBundle\DataFixtures\ORM\Test;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bpaulin\UpfitBundle\Entity\Exercise;
use Bpaulin\UpfitBundle\Entity\Session;
use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Entity\Stage;
use Bpaulin\UpfitBundle\Entity\Muscle;
use Bpaulin\UpfitBundle\Entity\Member;

class LoadTestData extends AbstractFixture implements FixtureInterface, ContainerAwareInterface, OrderedFixtureInterface
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
        $muscles = array();
        for ($i=1; $i < 3; $i++) {
            $muscle = new Muscle();
            $muscle->setName("muscle$i");
            $manager->persist($muscle);
            $muscles[$i] = $muscle;
        }
        $manager->flush();

        $exercises = array();
        for ($i=1; $i < 3; $i++) {
            $exercise = new Exercise();
            $exercise->setName("exercise$i");
            $manager->persist($exercise);
            $exercises[$i] = $exercise;
        }
        $manager->flush();

        $programs = array();
        for ($i=1; $i < 2; $i++) {
            $program = new Program();
            $program->setName("program$i");
            for ($j=1; $j < 3; $j++) {
                $stage = new Stage();
                $stage->setExercise($exercises[$j])
                    ->setPosition($j)
                    ->setSets($j)
                    ->setNumber($j)
                    ->setUnit($j)
                    ->setDifficulty($j)
                    ->setDifficultyUnit($j);
                $program->addStage($stage);
            }
            $manager->persist($program);
            $programs[$i] = $program;
        }
        $manager->flush();

        $session = new Session();
        $session->initWithProgram($programs[1])
                ->setName('session1')
                ->setUser($this->getReference('member'));
        foreach ($session->getWorkouts() as $workout) {
            $workout->setDone(true);
        }
        $manager->persist($session);
        $manager->flush();

        $session = new Session();
        $session->initWithProgram($programs[1])
                ->setName('wrong_user')
                ->setUser($this->getReference('other'));
        $manager->persist($session);
        $manager->flush();

        $unfinished = new Session();
        $unfinished->initWithProgram($programs[1])
                ->setName('session unfinished')
                ->setUser($this->getReference('member'));
        $manager->persist($unfinished);
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
