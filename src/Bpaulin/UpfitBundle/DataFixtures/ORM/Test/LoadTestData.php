<?php

namespace Bpaulin\UpfitBundle\DataFixtures\ORM\Test;

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

class LoadTestData implements FixtureInterface, ContainerAwareInterface
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

        $exercises = array();
        for ($i=1; $i < 6; $i++) {
            $exercise = new Exercise();
            $exercise->setName("exercise$i");
            $manager->persist($exercise);
            $exercises[$i] = $exercise;
        }
        $manager->flush();

        $programs = array();
        for ($i=1; $i < 6; $i++) {
            $program = new Program();
            $program->setName("program$i");
            for ($j=1; $j < 6; $j++) {
                $stage = new Stage();
                $stage->setExercise($exercises[$j])
                    ->setPosition($j)
                    ->setSets($j)
                    ->setnumber($j)
                    ->setUnit($j)
                    ->setDifficulty($j)
                    ->setDifficultyUnit($j);
                $program->addStage($stage);
            }
            $manager->persist($program);
            $programs[$i] = $program;
        }
        $manager->flush();
    }
}
