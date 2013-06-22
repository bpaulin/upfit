<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

class ExerciseSubContext extends BehatContext
{
    public function __construct()
    {
        // do subcontext initialization
    }

    /**
     * @Given /^I am on exercise "([^"]*)" page$/
     */
    public function iAmOnExercisePage($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $exercise = $em->getRepository('BpaulinUpfitBundle:Exercise')->findOneByName($name);
        return $this->getMainContext()->getMink()
            ->getSession()
            ->visit($this->getMainContext()->locatePath("/admin/exercise/".$exercise->getId()));
    }

    /**
     * @Then /^I should see a link to following exercises:$/
     */
    public function iShouldSeeALinkToFollowingExercises(TableNode $table)
    {
        $hash = $table->getHash();
        $steps  = array();
        foreach ($hash as $row) {
            $steps[] = new Step\Then("I should see a link to exercise \"".$row['exercise']."\"");
        }
        return $steps;
    }

    /**
     * @Then /^I should see a link to exercise "([^"]*)"$/
     */
    public function iShouldSeeALinkToExercise($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $exercise = $em->getRepository('BpaulinUpfitBundle:Exercise')->findOneByName($name);
        return new Step\Then("I should see a link to \"/admin/exercise/".$exercise->getId()."\"");
    }

    /**
     * @Given /^I should not see a link to exercise "([^"]*)"$/
     */
    public function iShouldNotSeeALinkToExercise($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $exercise = $em->getRepository('BpaulinUpfitBundle:Exercise')->findOneByName($name);
        if (!$exercise) {
            return true;
        }
        return new Step\Then("I should not see a link to \"/admin/exercise/".$exercise->getId()."\"");
    }

    /**
     * @Then /^I should see a link to edit exercise "([^"]*)"$/
     */
    public function iShouldSeeALinkToEditExercise($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $exercise = $em->getRepository('BpaulinUpfitBundle:Exercise')->findOneByName($name);
        return new Step\Then("I should see a link to \"/admin/exercise/".$exercise->getId()."/edit\"");
    }

    /**
     * @Then /^I should see a link to delete exercise "([^"]*)"$/
     */
    public function iShouldSeeALinkToDeleteExercise($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $exercise = $em->getRepository('BpaulinUpfitBundle:Exercise')->findOneByName($name);
        return new Step\Then("I should see a link to \"/admin/exercise/".$exercise->getId()."/delete\"");
    }

    /**
     * @Then /^I should see a link to create exercise$/
     */
    public function iShouldSeeALinkToCreateExercise()
    {
        return new Step\Then("I should see a link to \"/admin/exercise/new\"");
    }
}
