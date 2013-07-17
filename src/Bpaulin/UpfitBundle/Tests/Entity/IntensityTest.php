<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Intensity;
use Bpaulin\UpfitBundle\Entity\Exercise;

class IntensityTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        $entity = new Intensity();
        $this->assertNull($entity->getId());
    }

    public function testGetAndSetUser()
    {
        $objective = new Intensity();
        $exercise = new Exercise();
        $objective->setExercise($exercise);
        $this->assertEquals($exercise, $objective->getExercise());
    }
}
