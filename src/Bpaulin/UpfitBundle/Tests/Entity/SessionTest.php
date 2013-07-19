<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Session;
use Bpaulin\UpfitBundle\Entity\User;
use Bpaulin\UpfitBundle\Entity\Workout;
use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Entity\Stage;

class SessionTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        $entity = new Session();
        $this->assertNull($entity->getId());
    }

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

    public function testGetAndSetName()
    {
        $session = new Session();
        $name = 'test session name';
        $session->setName($name);
        $this->assertEquals($name, $session->getName());
    }

    public function testGetAndSetGrade()
    {
        $session = new Session();
        $grade = 1;
        $session->setGrade($grade);
        $this->assertEquals($grade, $session->getGrade());
    }

    public function testGetAndSetComment()
    {
        $session = new Session();
        $comment = "aaaaaaaa\nbbbbbb";
        $session->setComment($comment);
        $this->assertEquals($comment, $session->getComment());
    }

    public function testGetAndSetUser()
    {
        $session = new Session();
        $user = new User();
        $session->setUser($user);
        $this->assertEquals($user, $session->getUser());
    }

    public function testGetAndSetBeginning()
    {
        $session = new Session();
        $beginning = new \DateTime();
        $session->setBeginning($beginning);
        $this->assertEquals($beginning, $session->getBeginning());
    }

    public function testInitWithProgram()
    {
        $program = new Program();
        $program->setName('name');
        for ($i=0; $i < 4; $i++) {
            $program->addStage(new Stage());
        }
        $session = new Session();
        $session->initWithProgram($program);
        $this->assertEquals($session->getComment(), $program->getName());
        $this->assertEquals(count($session->getWorkouts()), count($program->getStages()));
    }

    public function testWorkoutWorkflow()
    {
        $session = new Session();

        $workout1 = new Workout();
        $workout1->setPosition(1);
        $session->addWorkout($workout1);

        $workout2 = new Workout();
        $workout2->setPosition(2);
        $session->addWorkout($workout2);

        $workout3 = new Workout();
        $workout3->setPosition(3);
        $session->addWorkout($workout3);

        $this->assertEquals($workout1, $session->getNextWorkout());

        $session->passWorkout();
        $this->assertEquals($workout2, $session->getNextWorkout());
        $this->assertNull($workout1->isDone());

        $session->abandonWorkout();
        $this->assertEquals($workout3, $session->getNextWorkout());
        $this->assertFalse($workout2->isDone());

        $session->doneWorkout();
        $this->assertEquals($workout1, $session->getNextWorkout());
        $this->assertTrue($workout3->isDone());

        $session->doneWorkout();
        $this->assertFalse($session->getNextWorkout());

        $follow = new Session();
        $follow->initWithSession($session);
        $this->assertEquals(count($follow->getWorkouts()), count($session->getWorkouts())-1);
    }

    public function testInitBeginning()
    {
        $session = new Session();
        $this->assertNull($session->getBeginning());

        $session->initBeginning();
        $this->assertInstanceOf('DateTime', $session->getBeginning());
    }
}
