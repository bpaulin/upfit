<?php

namespace Bpaulin\UpfitBundle\DataFixtures\ORM\Prod;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Bpaulin\UpfitBundle\Entity\Exercise;
use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Entity\Stage;

class LoadCam97Data extends AbstractFixture implements
    FixtureInterface,
    ContainerAwareInterface,
    OrderedFixtureInterface
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
    }

    protected function cam97Back(ObjectManager $manager)
    {
        $position = 0;
        $program = new Program();
        $program->setName('Cam97-back');

        $exercise = new Exercise();
        $exercise->setName('Le papillon');
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(8)
            ->setUnit('Reps')
            ->setdifficulty(3)
            ->setdifficultyUnit('kgs')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("L'oiseau");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(8)
            ->setUnit('Reps')
            ->setdifficulty(3)
            ->setdifficultyUnit('kgs')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("Les coudes a l'equerre");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(8)
            ->setUnit('Reps')
            ->setdifficulty(3)
            ->setdifficultyUnit('kgs')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName('La prière');
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(2)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $manager->persist($program);
        $manager->flush();
    }

    protected function cam97Pectoral(ObjectManager $manager)
    {
        $position = 0;
        $program = new Program();
        $program->setName('Cam97-pectoral');

        $exercise = new Exercise();
        $exercise->setName("Les coudes en charnière");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(8)
            ->setUnit('Reps')
            ->setdifficulty(6)
            ->setdifficultyUnit('kgs')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("Les pompes");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("Le pull-over");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setdifficulty(10)
            ->setdifficultyUnit('kgs')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName('Le genou plieur');
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(2)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $manager->persist($program);
        $manager->flush();
    }

    protected function cam97Legs(ObjectManager $manager)
    {
        $position = 0;
        $program = new Program();
        $program->setName('Cam97-legs');

        $exercise = new Exercise();
        $exercise->setName("Fentes");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("Squat");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setdifficulty(10)
            ->setdifficultyUnit('kgs')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName('Cheville en main');
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(2)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $manager->persist($program);
        $manager->flush();
    }

    protected function cam97Abs(ObjectManager $manager)
    {
        $position = 0;
        $program = new Program();
        $program->setName('Cam97-abs');

        $exercise = new Exercise();
        $exercise->setName("Le paquet");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("La bicyclette");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("Le relevé de buste");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("Le relevé de buste négatif");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(1)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $exercise = new Exercise();
        $exercise->setName("Relevé de tête");
        $manager->persist($exercise);
        $stage = new Stage();
        $stage
            ->setPosition($position++)
            ->setSets(2)
            ->setNumber(15)
            ->setUnit('Reps')
            ->setExercise($exercise);
        $program->AddStage($stage);

        $manager->persist($program);
        $manager->flush();
    }

    public function load(ObjectManager $manager)
    {
        $this->cam97Pectoral($manager);
        $this->cam97Back($manager);
        $this->cam97Legs($manager);
        $this->cam97Abs($manager);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2;
    }
}
