<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Session;
use Bpaulin\UpfitBundle\Entity\Workout;

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function testCalculateAverageGrade()
    {
        $session = new Session();
        $session->setDifficultyToAverage();
        $this->assertEquals(0, $session->getDifficulty());

        $workout = new Workout();
        $session->addWorkout($workout->setGrade(2));
        $session->setDifficultyToAverage();
        $this->assertEquals(0, $session->getDifficulty());

        $workout->setDone(true);
        $session->setDifficultyToAverage();
        $this->assertEquals(2, $session->getDifficulty());

        $workout = new Workout();
        $session->addWorkout($workout->setGrade(1)->setDone(true));
        $session->setDifficultyToAverage();
        $this->assertEquals(2, $session->getDifficulty());

        $workout = new Workout();
        $session->addWorkout($workout->setGrade(1)->setDone(true));
        $session->setDifficultyToAverage();
        $this->assertEquals(1, $session->getDifficulty());
    }
}
