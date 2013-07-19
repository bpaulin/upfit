<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\User;
use Bpaulin\UpfitBundle\Entity\Objective;
use Bpaulin\UpfitBundle\Entity\Muscle;

class UserTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        $entity = new User();
        $this->assertNull($entity->getId());
    }

    public function testAddAndRemoveObjective()
    {
        $user = new User();
        $objective = new Objective();

        $user->addObjective($objective);
        $this->assertContains($objective, $user->getObjectives());

        $user->removeObjective($objective);
        $this->assertNotContains($objective, $user->getObjectives());
    }

    public function testFillObjectives()
    {
        $muscles = array();
        $user = new User();
        $objectives = array();
        for ($i=0; $i < 4; $i++) {
            $muscle = new Muscle();
            $muscles[$i] = $muscle;
            $objective = new Objective();
            $objective->setWill($i)
                ->setMuscle($muscles[$i]);
            $objectives[$i] = $objective;
        }
        for ($i=0; $i < 3; $i++) {
            $user->addObjective($objectives[$i]);
        }

        $this->assertFalse($user->getObjectiveByMuscle($muscles[3]));

        $this->assertEquals(
            $user->getObjectiveByMuscle($muscles[1]),
            $objectives[1]
        );

        $user->fillObjectives($muscles);

        $this->assertNotEquals(
            $user->getObjectiveByMuscle($muscles[3]),
            false
        );
        $this->assertEquals(
            $user->getObjectiveByMuscle($muscles[3])->getWill(),
            0
        );
    }
}
