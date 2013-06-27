<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Stage;
use Bpaulin\UpfitBundle\Entity\Exercise;

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
        $this->assertEquals( $stage->getExercise(), $stage->getExercise() );
        $this->assertEquals( $stage->getPosition(), $stage->getPosition() );
        $this->assertEquals( $stage->getSets(), $stage->getSets() );
        $this->assertEquals( $stage->getNumber(), $stage->getNumber() );
        $this->assertEquals( $stage->getUnit(), $stage->getUnit() );
        $this->assertEquals( $stage->getDifficulty(), $stage->getDifficulty() );
        $this->assertEquals( $stage->getDifficultyUnit(), $stage->getDifficultyUnit() );
    }
}
