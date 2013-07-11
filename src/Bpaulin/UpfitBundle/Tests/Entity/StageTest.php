<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Stage;
use Bpaulin\UpfitBundle\Entity\Exercise;
use Bpaulin\UpfitBundle\Entity\Program;

class StageTest extends \PHPUnit_Framework_TestCase
{
    public function testCreateWorkout()
    {
        $exercise = new Exercise();

        $stage = new Stage();
        $stage->setExercise($exercise)
            ->setPosition(1)
            ->setSets(2)
            ->setNumber(3)
            ->setUnit(4)
            ->setDifficulty(5)
            ->setDifficultyUnit(6);

        $workout = $stage->createWorkout();
        $this->assertEquals($stage->getExercise(), $workout->getExercise());
        $this->assertEquals($stage->getPosition(), $workout->getPosition());
        $this->assertEquals($stage->getSets(), $workout->getSets());
        $this->assertEquals($stage->getNumber(), $workout->getNumber());
        $this->assertEquals($stage->getUnit(), $workout->getUnit());
        $this->assertEquals($stage->getDifficulty(), $workout->getDifficulty());
        $this->assertEquals($stage->getDifficultyUnit(), $workout->getDifficultyUnit());
    }

    public function testGetAndSetProgram()
    {
        $session = new Stage();
        $program = new Program();
        $session->setProgram($program);
        $this->assertEquals($program, $session->getProgram());
    }
}
