<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;
use Behat\Behat\Exception\PendingException;

class ProgramSubContext extends BehatContext
{
    public function __construct()
    {
        // do subcontext initialization
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
     * @Then /^I should see a link to following programs:$/
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
     * @Then /^I should see a link to consult following programs:$/
     */
    public function iShouldSeeALinkToConsultFollowingPrograms(TableNode $table)
    {
        $hash = $table->getHash();
        $steps  = array();
        foreach ($hash as $row) {
            $steps[] = new Step\Then("I should see a link to consult program \"".$row['program']."\"");
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
        if (!$program) {
            throw new \Exception('program not found');
        }
        return new Step\Then("I should see a link to \"/admin/program/".$program->getId()."\"");
    }

    /**
     * @Then /^I should see a link to consult program "([^"]*)"$/
     */
    public function iShouldSeeALinkToConsultProgram($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $program = $em->getRepository('BpaulinUpfitBundle:Program')->findOneByName($name);
        if (!$program) {
            throw new \Exception('program not found');
        }
        return new Step\Then("I should see a link to \"/member/program/".$program->getId()."\"");
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

    /**
     * @Given /^I should see the following stages:$/
     */
    public function iShouldSeeTheFollowingStages(TableNode $table)
    {
        $hash = $table->getHash();
        $steps  = array();
        foreach ($hash as $row) {
            $steps[] = new Step\Then(
                "the \".record_properties dd.stages\" element should contain \"".$row['stages']."\""
            );
        }
        return $steps;
    }

    /**
     * @Given /^I should not see the following stages:$/
     */
    public function iShouldNotSeeTheFollowingStages(TableNode $table)
    {
        $hash = $table->getHash();
        $steps  = array();
        foreach ($hash as $row) {
            $steps[] = new Step\Then(
                "the \".record_properties dd.stages\" element should not contain \"".$row['stages']."\""
            );
        }
        return $steps;
    }

    /**
     * @Given /^I click delete on stage "([^"]*)"$/
     */
    public function iClickDeleteOnStage($indexStage)
    {
        $stages = $this->getMainContext()->getSession()->getPage()->findAll('css', '.sf2fc-item');
        $stage = $stages[$indexStage];
        $stage->find('css', '.sf2fc-remove')->click();
    }

    /**
     * @Given /^I click on add a stage$/
     */
    public function iClickOnAddAStage()
    {
        $this->getMainContext()->getSession()->getPage()->find('css', '.sf2fc-add')->click();
    }
}
