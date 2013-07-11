<?php

namespace Bpaulin\UpfitBundle\Tests\Entity;

use Bpaulin\UpfitBundle\Entity\Program;
use Bpaulin\UpfitBundle\Entity\Stage;

class ProgramTest extends \PHPUnit_Framework_TestCase
{
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
}
