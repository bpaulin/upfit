<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;

use Behat\Behat\Context\BehatContext;
use Behat\Behat\Exception\PendingException;
use Behat\Gherkin\Node\PyStringNode;
use Behat\Gherkin\Node\TableNode;

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

    /**
     * Initializes context with parameters from behat.yml.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
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

    //
    // Place your definition and hook methods here:
    //
    //    /**
    //     * @Given /^I have done something with "([^"]*)"$/
    //     */
    //    public function iHaveDoneSomethingWith($argument)
    //    {
    //        $container = $this->kernel->getContainer();
    //        $container->get('some_service')->doSomethingWith($argument);
    //    }
    //

    /**
     * @Given /^a administrator named "([^"]*)"$/
     */
    public function aAdministratorNamed($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^a member named "([^"]*)"$/
     */
    public function aMemberNamed($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should see a link to "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeALinkToInArea($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @When /^I follow this link$/
     */
    public function iFollowThisLink()
    {
        throw new PendingException();
    }

    /**
     * @Given /^I fill in the following$/
     */
    public function iFillInTheFollowing(TableNode $table)
    {
        throw new PendingException();
    }

    /**
     * @Then /^I should be on "([^"]*)" homepage$/
     */
    public function iShouldBeOnHomepage($arg1)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I should see a "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeAInArea($arg1, $arg2)
    {
        throw new PendingException();
    }

    /**
     * @Given /^I should see "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeInArea($arg1, $arg2)
    {
        throw new PendingException();
    }
}
