<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Exercise;

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
}
