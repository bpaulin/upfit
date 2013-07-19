<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Objective;
use Bpaulin\UpfitBundle\Entity\User;

class ObjectiveTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        $entity = new Objective();
        $this->assertNull($entity->getId());
    }

    public function testGetAndSetWill()
    {
        $objective = new Objective();
        $will = 4;
        $objective->setWill($will);
        $this->assertEquals($will, $objective->getWill());
    }

    public function testGetAndSetUser()
    {
        $objective = new Objective();
        $user = new User();
        $objective->setUser($user);
        $this->assertEquals($user, $objective->getUser());
    }
}
