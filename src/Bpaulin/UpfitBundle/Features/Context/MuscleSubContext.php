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
}
