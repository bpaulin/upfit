<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

class ProgramSubContext extends BehatContext
{
    public function __construct()
    {
        // do subcontext initialization
    }

    /**
     * @Given /^a program named "([^"]*)"$/
     */
    public function aProgramNamed($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $className = $em->getRepository('BpaulinUpfitBundle:Program')->getClassName();

        $program = new $className;
        $program->setName($name);

        $em->persist($program);
        $em->flush();

        return $program;
    }

    /**
     * @Given /^a program named "([^"]*)" with following stages:$/
     */
    public function aProgramNamedWithFollowingStages($name, TableNode $table)
    {
        $program = $this->aProgramNamed($name);
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $className = $em->getRepository('BpaulinUpfitBundle:Stage')->getClassName();

        $hash = $table->getHash();
        $steps  = array();
        foreach ($hash as $position => $row) {
            $exercise = $this->getMainContext()->getSubcontext('exercise')->anExerciseNamed($row['exercise']);

            $stage = new $className;
            $stage->setProgram($program)
                ->setExercise($exercise)
                ->setPosition($position)
                ->setSets($row['sets'])
                ->setNumber($row['number'])
                ->setUnit($row['unit'])
                ->setDifficulty($row['difficulty'])
                ->setDifficultyUnit($row['unit']);

            $em->persist($stage);
        }
        $em->flush();
    }

    /**
     * @Given /^I am on program "([^"]*)" page$/
     */
    public function iAmOnProgramPage($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $program = $em->getRepository('BpaulinUpfitBundle:Program')->findOneByName($name);
        return $this->getMainContext()->getMink()
            ->getSession()
            ->visit($this->getMainContext()->locatePath("/admin/program/".$program->getId()));
    }

    /**
     * @Then /^I should see a link to following programs$/
     */
    public function iShouldSeeALinkToFollowingPrograms(TableNode $table)
    {
        $hash = $table->getHash();
        $steps  = array();
        foreach ($hash as $row) {
            $steps[] = new Step\Then("I should see a link to program \"".$row['program']."\"");
        }
        return $steps;
    }

    /**
     * @Then /^I should see a link to program "([^"]*)"$/
     */
    public function iShouldSeeALinkToProgram($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $program = $em->getRepository('BpaulinUpfitBundle:Program')->findOneByName($name);
        return new Step\Then("I should see a link to \"/admin/program/".$program->getId()."\"");
    }

    /**
     * @Given /^I should not see a link to program "([^"]*)"$/
     */
    public function iShouldNotSeeALinkToProgram($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $program = $em->getRepository('BpaulinUpfitBundle:Program')->findOneByName($name);
        if (!$program) {
            return true;
        }
        return new Step\Then("I should not see a link to \"/admin/program/".$program->getId()."\"");
    }

    /**
     * @Then /^I should see a link to edit program "([^"]*)"$/
     */
    public function iShouldSeeALinkToEditProgram($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $program = $em->getRepository('BpaulinUpfitBundle:Program')->findOneByName($name);
        return new Step\Then("I should see a link to \"/admin/program/".$program->getId()."/edit\"");
    }

    /**
     * @Then /^I should see a link to delete program "([^"]*)"$/
     */
    public function iShouldSeeALinkToDeleteProgram($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $program = $em->getRepository('BpaulinUpfitBundle:Program')->findOneByName($name);
        return new Step\Then("I should see a link to \"/admin/program/".$program->getId()."/delete\"");
    }

    /**
     * @Then /^I should see a link to create program$/
     */
    public function iShouldSeeALinkToCreateProgram()
    {
        return new Step\Then("I should see a link to \"/admin/program/new\"");
    }

    /**
     * @Given /^I fill in last stage form with the following:$/
     */
    public function iFillInLastStageFormWithTheFollowing(TableNode $table)
    {
        //bpaulin_upfitbundle_programtype_stages_0_difficultyUnit
        $form = 'bpaulin_upfitbundle_programtype_stages_0_';
        foreach ($table->getRowsHash() as $field => $value) {
            $this->getMainContext()->fillField($form.$field, $value);
        }
    }
}
