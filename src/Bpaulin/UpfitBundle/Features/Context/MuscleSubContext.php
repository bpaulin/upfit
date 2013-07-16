<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

class MuscleSubContext extends BehatContext
{
    public function __construct()
    {
        // do subcontext initialization
    }

    /**
     * @Then /^I should see a link to following muscles:$/
     */
    public function iShouldSeeALinkToFollowingMuscles(TableNode $table)
    {
        $hash = $table->getHash();
        $steps  = array();
        foreach ($hash as $row) {
            $steps[] = new Step\Then("I should see a link to muscle \"".$row['muscle']."\"");
        }

        return $steps;
    }

    /**
     * @Then /^I should see a link to muscle "([^"]*)"$/
     */
    public function iShouldSeeALinkToMuscle($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $muscle = $em->getRepository('BpaulinUpfitBundle:Muscle')->findOneByName($name);

        return new Step\Then("I should see a link to \"/member/muscle/".$muscle->getId()."\"");
    }

    /**
     * @When /^I fill in objectives form with the following:$/
     */
    public function iFillInObjectivesFormWithTheFollowing(TableNode $table)
    {
        foreach ($table->getHash() as $index => $row) {
            $field = 'bpaulin_upfitbundle_objectivestype_objectives_'.$index.'_will';
            $this->getMainContext()->fillField($field, $row['will']);
        }
    }

    /**
     * @Given /^objectives form should be filled with the following:$/
     */
    public function objectivesFormShouldBeFilledWithTheFollowing(TableNode $table)
    {
        foreach ($table->getHash() as $index => $row) {
            $field = $this->getMainContext()->getMink()
                            ->getSession()
                            ->getPage()
                            ->find('css', '#bpaulin_upfitbundle_objectivestype_objectives_'.$index.'_will');
            if (!$field) {
                throw new \Exception('field not found');
            }
            if ($field->getAttribute('value') != $row['will']) {
                throw new \Exception($field->getAttribute('value').' not expected, '.$row['will'].' wanted');
            }
        }
    }
}
