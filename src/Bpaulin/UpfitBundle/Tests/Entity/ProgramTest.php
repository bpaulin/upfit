<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Entity\Muscle;
use Bpaulin\UpfitBundle\Entity\Stage;
use Bpaulin\UpfitBundle\Entity\Exercise;
use Bpaulin\UpfitBundle\Entity\Intensity;
use Bpaulin\UpfitBundle\Entity\User;
use Bpaulin\UpfitBundle\Entity\Objective;

class ProgramTest extends \PHPUnit_Framework_TestCase
{
    public function testGetId()
    {
        $entity = new Program();
        $this->assertNull($entity->getId());
    }

    public function testGetAndSetName()
    {
        $program = new Program();
        $name = 'test program name';
        $program->setName($name);
        $this->assertEquals($name, $program->getname());
    }

    public function testAddAndRemoveStage()
    {
        $program = new Program();
        $stage = new Stage();

        $program->addStage($stage);
        $this->assertContains($stage, $program->getStages());

        $program->removeStage($stage);
        $this->assertNotContains($stage, $program->getStages());
    }

    public function getValidTestData()
    {
        return array(
            array(
                "data"=> array(
                    'exercises' => array(
                        array( -1, 0, 0, 1),
                    ),
                    'user'    => array( -1, 0, 0, 1),
                    'grade'   => 1
                ),
            ),
            array(
                "data"=> array(
                    'exercises' => array(
                        array( -1, 1, -1, 1),
                    ),
                    'user'    => array( 1, -1, 1, -1),
                    'grade'   => 0
                ),
            ),
            array(
                "data"=> array(
                    'exercises' => array(
                        array( 1, 1, 1, 1),
                    ),
                    'user'    => array( 0, 1, 1, 0),
                    'grade'   => 0.75
                ),
            ),
            array(
                "data"=> array(
                    'exercises' => array(
                        array( 1, 1, 1, 1),
                    ),
                    'user'    => array( -1, 1, 1, -1),
                    'grade'   => 0.50
                ),
            ),
            array(
                "data"=> array(
                    'exercises' => array(
                        array( 1, 1, 1, 1),
                    ),
                    'user'    => array( -1, -1, 1, -1),
                    'grade'   => 0.25
                ),
            ),
        );
    }

    /**
     * @dataProvider getValidTestData
     */
    public function testProgramShouldEvaluateItselfAgaintsUserObjectives($data)
    {
        $user = new User();
        $program = new Program();

        $muscles = array();
        for ($i=0; $i < count($data['user']); $i++) {
            $muscles[$i] = new Muscle();
            $muscles[$i]->setName("muscle$i");

            $objective = new Objective();
            $objective
                ->setMuscle($muscles[$i])
                ->setWill($data['user'][$i]);
            $user->addObjective($objective);
        }

        for ($j=0; $j < count($data['exercises']); $j++) {
            $exercise = new Exercise();
            for ($i=0; $i < count($data['user']); $i++) {
                $intensity = new Intensity();
                $intensity
                    ->setIntensity($data['exercises'][$j][$i])
                    ->setMuscle($muscles[$i]);
                $exercise->addIntensity($intensity);
            }
            $stage = new Stage();
            $stage->setExercise($exercise);
            $program->addStage($stage);
        }
        $this->assertSame(
            $program->getGradeForUser($user),
            $data['grade']
        );
    }
}
