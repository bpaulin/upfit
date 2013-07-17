<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Exercise;
use Bpaulin\UpfitBundle\Entity\Intensity;
use Bpaulin\UpfitBundle\Entity\Workout;
use Bpaulin\UpfitBundle\Entity\Stage;
use Bpaulin\UpfitBundle\Entity\Muscle;

class ExerciseTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        $entity = new Exercise();
        $this->assertNull($entity->getId());
    }

    public function testGetAndSetName()
    {
        $exercise = new Exercise();
        $name = 'test exercise name';
        $exercise->setName($name);
        $this->assertEquals($name, $exercise->getname());
    }

    public function testAddAndRemoveIntensity()
    {
        $exercise = new Exercise();
        $intensity = new Intensity();

        $exercise->addIntensity($intensity);
        $this->assertContains($intensity, $exercise->getIntensities());

        $exercise->removeIntensity($intensity);
        $this->assertNotContains($intensity, $exercise->getIntensities());
    }

    public function testAddAndRemoveStage()
    {
        $exercise = new Exercise();
        $stage = new Stage();

        $exercise->addStage($stage);
        $this->assertContains($stage, $exercise->getStages());

        $exercise->removeStage($stage);
        $this->assertNotContains($stage, $exercise->getStages());
    }

    public function testAddAndRemoveWorkout()
    {
        $exercise = new Exercise();
        $workout = new Workout();

        $exercise->addWorkout($workout);
        $this->assertContains($workout, $exercise->getWorkouts());

        $exercise->removeWorkout($workout);
        $this->assertNotContains($workout, $exercise->getWorkouts());
    }

    public function testFillObjectives()
    {
        $muscles = array();
        $exercise = new Exercise();
        $intensities = array();
        for ($i=0; $i < 4; $i++) {
            $muscle = new Muscle();
            $muscles[$i] = $muscle;
            $intensity = new Intensity();
            $intensity
                ->setIntensity($i)
                ->setMuscle($muscles[$i]);
            $intensities[$i] = $intensity;
        }
        for ($i=0; $i < 3; $i++) {
            $exercise->addIntensity($intensities[$i]);
        }

        $this->assertFalse($exercise->getIntensityByMuscle($muscles[3]));

        $this->assertEquals(
            $exercise->getIntensityByMuscle($muscles[1]),
            $intensities[1]
        );

        $exercise->fillIntensities($muscles);

        $this->assertNotEquals(
            $exercise->getIntensityByMuscle($muscles[3]),
            false
        );
        $this->assertEquals(
            $exercise->getIntensityByMuscle($muscles[3])->getIntensity(),
            0
        );
    }
}
