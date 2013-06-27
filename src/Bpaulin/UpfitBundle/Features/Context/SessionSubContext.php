<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Behat\Behat\Context\BehatContext;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Context\Step;

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
            new Step\Then("the \".record_properties dd.exercise\" element should contain \"".$exercise->getName()."\""),
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

    /**
     * @Given /^I do the followings workouts:$/
     */
    public function iDoTheFollowingsWorkouts(TableNode $table)
    {
        $hash = $table->getHash();
        $steps = array();
        foreach ($hash as $row) {
            $steps[] = new Step\Then('I should be on "'.$row['exercise'].'" workout page');
            $steps[] = new Step\When('I fill in "bpaulin_upfitbundle_workouttype_grade" with "'.$row['grade'].'"');
            $steps[] = new Step\When('I press "'.$row['action'].'"');
            switch ($row['action']) {
                case 'Abandon':
                    $steps[] = new Step\When('I should see a "info" message "'.$row['exercise'].' abandoned"');
                    break;
                case 'Pass':
                    $steps[] = new Step\When('I should see a "info" message "'.$row['exercise'].' passed"');
                    # code...
                    break;
                case 'Done':
                    break;
                default:
                    break;
            }
        }

        return $steps;
    }

    /**
     * @Given /^I should see following workouts:$/
     */
    public function iShouldSeeFollowingWorkouts(TableNode $table)
    {
        // | exercise  | status      | grade |
        $hash = $table->getHash();
        $lis = $this->getMainContext()->getMink()
                                ->getSession()
                                ->getPage()
                                ->findAll('css', "ul.workouts li");
        foreach ($hash as $index => $row) {
            $exercise = $lis[$index]->find('css', '.exercise')->getText();
            if ($exercise != $row['exercise']) {
                throw new \Exception($exercise.' is not expected, '.$row['exercise'].' wanted ');
            }
            $status = $lis[$index]->find('css', '.status')->getText();
            if ($status != $row['status']) {
                throw new \Exception($status.' is not expected, '.$row['status'].' wanted ');
            }
            $grade = $lis[$index]->find('css', '.grade')->getText();
            if ($grade != $row['grade']) {
                throw new \Exception($grade.' is not expected, '.$row['grade'].' wanted ');
            }
        }
    }

    /**
     * @Given /^I fill in workout form with the following:$/
     */
    public function iFillInWorkoutFormWithTheFollowing(TableNode $table)
    {
        //bpaulin_upfitbundle_programtype_stages_0_difficultyUnit
        $form = 'bpaulin_upfitbundle_workouttype_';
        foreach ($table->getRowsHash() as $field => $value) {
            $this->getMainContext()->fillField($form.$field, $value);
        }
    }
}
