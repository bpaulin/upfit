<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Workout;
use Bpaulin\UpfitBundle\Entity\Session;

class WorkoutTest extends \PHPUnit_Framework_TestCase
{
    public function testGetAndSetSession()
    {
        $workout = new Workout();
        $session = new Session();
        $workout->setSession($session);
        $this->assertEquals($session, $workout->getSession());
    }
}
