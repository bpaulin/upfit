<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Session;
use Bpaulin\UpfitBundle\Entity\Workout;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testCalculateAverageGrade()
    {
        $session = new Session();
        $session->setGradeToAverage();
        $this->assertEquals(0, $session->getGrade());

        $workout = new Workout();
        $session->addWorkout($workout->setGrade(2));
        $session->setGradeToAverage();
        $this->assertEquals(0, $session->getGrade());

        $workout->setDone(true);
        $session->setGradeToAverage();
        $this->assertEquals(2, $session->getGrade());

        $workout = new Workout();
        $session->addWorkout($workout->setGrade(1)->setDone(true));
        $session->setGradeToAverage();
        $this->assertEquals(2, $session->getGrade());

        $workout = new Workout();
        $session->addWorkout($workout->setGrade(1)->setDone(true));
        $session->setGradeToAverage();
        $this->assertEquals(1, $session->getGrade());
    }
}
