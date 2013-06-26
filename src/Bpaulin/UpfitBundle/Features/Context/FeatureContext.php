<?php

namespace Bpaulin\UpfitBundle\Features\Context;


use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;
use Behat\Behat\Event\ScenarioEvent;
use Behat\Behat\Context\Step;

//
// Require 3rd-party libraries here:
//
//   require_once 'PHPUnit/Autoload.php';
//   require_once 'PHPUnit/Framework/Assert/Functions.php';
//

/**
 * Feature context.
 */
class FeatureContext extends MinkContext implements KernelAwareInterface
{
    private $kernel;
    private $parameters;
    private $lastLink;

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
        $this->useContext('program', new ProgramSubContext());
        $this->useContext('exercise', new ExerciseSubContext());
        $this->useContext('session', new SessionSubContext());
    }

    /**
     * Sets HttpKernel instance.
     * This method will be automatically called by Symfony2Extension ContextInitializer.
     *
     * @param KernelInterface $kernel
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * Get HttpKernel instance.
     */
    public function getKernel()
    {
        return $this->kernel;
    }

    /**
     * @Then /^I should see a link to "([^"]*)"$/
     */
    public function iShouldSeeALinkTo($url)
    {
        $result = $this->assertElementOnPage("a[href$='".$url."']");
        $this->lastLink  = $this->getMink()
                                ->getSession()
                                ->getPage()
                                ->find('css', "a[href$='".$url."']")
                                ->getAttribute('href');
        return $result;
    }

    /**
     * @Then /^I should see a link to "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeALinkToInArea($url, $area)
    {
        $this->lastLink  = $this->getMink()
                                ->getSession()
                                ->getPage()
                                ->find('css', "#".$area."-area a[href$='".$url."']")
                                ->getAttribute('href');
        return $this->assertElementOnPage("#".$area."-area a[href$='".$url."']");
    }

    /**
     * @When /^I follow this link$/
     */
    public function iFollowThisLink()
    {
        $this->getMink()
            ->getSession()
            ->visit($this->lastLink);
        //return new Step\Then("the response status code should be 200");
    }

    /**
     * @Then /^I should be on "([^"]*)" homepage$/
     */
    public function iShouldBeOnHomepage($role)
    {
        return array(
            new Step\Given("I should be on \"/".$role."\""),
        );
    }

    /**
     * @Given /^I should see "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeInArea($text, $area)
    {
        return new Step\Then("the \""."#".$area."-area"."\" element should contain \"$text\"");
    }

    /**
     * @Then /^I should not see a link to any page for "([^"]*)"$/
     */
    public function iShouldNotSeeALinkToAnyPageFor($user)
    {
        return $this->assertElementNotOnPage("a[href^='/".$user."']");
    }


    /**
     * @Given /^I am admin$/
     */
    public function iAmAdmin()
    {
        return array(
            new Step\Given("I am \"admin\"")
        );
    }
    /**
     * @Given /^I am member$/
     */
    public function iAmMember()
    {
        return array(
            new Step\Given("I am \"member\"")
        );
    }

    /**
     * @Given /^I am "([^"]*)"$/
     */
    public function iAm($name)
    {
        return array(
            new Step\Given("I am on \"/login\""),
            new Step\When("I fill in \"_username\" with \"$name\""),
            new Step\When("I fill in \"_password\" with \"$name\""),
            new Step\When("I press \"_submit\"")
        );
    }

    /**
     * @Given /^I am on "([^"]*)" homepage$/
     */
    public function iAmOnHomepage2($role)
    {
        return $this->getMink()
                    ->getSession()
                    ->visit($this->locatePath("/".$role));
    }

    /**
     * @Given /^I fill in "([^"]*)" form with the following:$/
     */
    public function iFillInFormWithTheFollowing($form, TableNode $table)
    {
        $form = 'bpaulin_upfitbundle_'.$form.'type_';
        foreach ($table->getRowsHash() as $field => $value) {
            $this->fillField($form.$field, $value);
        }
    }

    /**
     * @Given /^I should see a "([^"]*)" message "([^"]*)"$/
     */
    public function iShouldSeeAMessage($type, $texte)
    {
        return new Step\Then("I should see \"$texte\" in the \"#notification-area .alert-$type\" element");
    }

    /**
     * @Given /^I should see "([^"]*)" as "([^"]*)"$/
     */
    public function iShouldSeeAs($value, $label)
    {
        return new Step\Then("the \".record_properties dd.$label\" element should contain \"$value\"");
    }
}
