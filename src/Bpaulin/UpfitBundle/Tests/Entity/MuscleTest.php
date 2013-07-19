<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Muscle;

class MuscleTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        $entity = new Muscle();
        $this->assertNull($entity->getId());
    }

    public function testGetAndSetName()
    {
        $muscle = new Muscle();
        $will = 4;
        $muscle->setName($will);
        $this->assertEquals($will, $muscle->getName());
    }
}
