<?php

namespace Bpaulin\UpfitBundle\Features\Context;

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

    /** @beforeScenario */
    public function setup($event)
    {
    }

    /** @AfterScenario */
    public function teardown($event)
    {
        $userManager = $this->kernel->getContainer()->get('fos_user.user_manager');

        // Pour récupérer la liste de tous les utilisateurs
        foreach ($userManager->findUsers() as $user) {
            // Pour supprimer un utilisateur
            $userManager->deleteUser($user);
        };
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
        $userManager = $this->kernel->getContainer()->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername("admin")
            ->setEmail("admin@upfit.com")
            ->setPlainPassword("admin")
            ->setRoles(array('ROLE_ADMIN'))
            ->setEnabled(true);

        $userManager->updateUser($user, true);
    }

    /**
     * @Given /^a member named "([^"]*)"$/
     */
    public function aMemberNamed($arg1)
    {
        $userManager = $this->kernel->getContainer()->get('fos_user.user_manager');

        $user = $userManager->createUser();
        $user->setUsername("member")
            ->setEmail("member@upfit.com")
            ->setPlainPassword("member")
            ->setRoles(array('ROLE_USER'))
            ->setEnabled(true);

        $userManager->updateUser($user, true);
    }

    /**
     * @Then /^I should see a link to "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeALinkToInArea($url, $area)
    {
        $this->lastLink = $url;
        return $this->assertElementOnPage("#".$area."-area [href$='".$url."']");
    }

    /**
     * @When /^I follow this link$/
     */
    public function iFollowThisLink()
    {
        $this->getMink()
            ->getSession()
            ->visit($this->lastLink);
        return new Step\Then("the response status code should be 200");
    }

    /**
     * @Given /^I fill in the following$/
     */
    public function iFillInTheFollowing(TableNode $table)
    {
        $hash = $table->getHash();
        foreach ($hash as $row) {
            return array(
                new Step\Then("I fill in \"username\" with \"".$row['username']."\""),
                new Step\Then("I fill in \"password\" with \"".$row['password']."\""),
            );
        }
    }

    /**
     * @Then /^I should be on "([^"]*)" homepage$/
     */
    public function iShouldBeOnHomepage($role)
    {
        return array(
            new Step\Given("I should be on \"/".$role."\""),
            new Step\Then("the response status code should be 200")
        );
    }

    /**
     * @Given /^I should see "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeInArea($text, $area)
    {
        return new Step\Then("the \""."#".$area."-area"."\" element should contain \"$text\"");
    }
}
