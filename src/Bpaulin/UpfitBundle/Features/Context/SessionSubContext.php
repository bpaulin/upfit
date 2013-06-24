<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;
use Behat\Behat\Exception\PendingException;

class SessionSubContext extends BehatContext
{
    public function __construct()
    {
        // do subcontext initialization
    }

    /**
     * @Then /^I should see a link to begin session following "([^"]*)" "([^"]*)"$/
     */
    public function iShouldSeeALinkToBeginSessionFollowing($type, $name)
    {
        if ($type != 'program' && $type != 'session') {
            throw new \Exception('only available for program or session');
        }
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $class = 'BpaulinUpfitBundle:'.ucwords($type);
        $entity = $em->getRepository($class)->findOneByName($name);
        if (!$entity) {
            throw new \Exception("$type not found");
        }
        return new Step\Then("I should see a link to \"/member/session/new/$type/".$entity->getId()."\"");
    }

    /**
     * @Then /^I should be on "([^"]*)" workout page$/
     */
    public function iShouldBeOnWorkoutPage($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $exercise = $em->getRepository('BpaulinUpfitBundle:Exercise')->findOneByName($name);
        if (!$exercise) {
            throw new \Exception('exercise not found');
        }
        return array(
            new Step\Then("the \"#exercise-name\" element should contain \"".$exercise->getName()."\""),
        );
    }

    /**
     * @Given /^I fill in session form with the following:$/
     */
    public function iFillInSessionFormWithTheFollowing(TableNode $table)
    {
        //bpaulin_upfitbundle_programtype_stages_0_difficultyUnit
        $form = 'bpaulin_upfitbundle_sessiontype_';
        foreach ($table->getRowsHash() as $field => $value) {
            $this->getMainContext()->fillField($form.$field, $value);
        }
    }

    /**
     * @Given /^I should see a link to session "([^"]*)"$/
     */
    public function iShouldSeeALinkToSession($name)
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $session = $em->getRepository('BpaulinUpfitBundle:Session')->findOneByName($name);
        if (!$session) {
            throw new \Exception();
        }
        return new Step\Then("I should see a link to \"/member/session/".$session->getId()."\"");
    }

    /**
     * @Then /^I should not have access to other users session$/
     */
    public function iShouldNotHaveAccessToOtherUsersSession()
    {
        $em = $this->getMainContext()->getKernel()->getContainer()->get('doctrine')->getManager();
        $session = $em->getRepository('BpaulinUpfitBundle:Session')->findOneByName('wrong_user');
        if (!$session) {
            throw new \Exception();
        }
        return array(
            new Step\Given('I am on "/member/session/'.$session->GetId().'"'),
            new Step\Then('I should see "Forbidden"'),
            new Step\Given('I am on "/member/session/'.$session->GetId().'/edit"'),
            new Step\Then('I should see "Forbidden"'),
        );
    }
}
