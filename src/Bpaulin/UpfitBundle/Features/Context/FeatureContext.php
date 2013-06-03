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
        $this->useContext('program', new ProgramSubContext());
        $this->useContext('exercise', new ExerciseSubContext());
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

    /** @beforeScenario */
    public function setup($event)
    {
        $em = $this->kernel->getContainer()->get('doctrine')->getManager();
        $em->getConnection()->query(
            'START TRANSACTION;SET FOREIGN_KEY_CHECKS=0; TRUNCATE TABLE exercise; SET FOREIGN_KEY_CHECKS=1; COMMIT;'
        );
        $em->getConnection()->query(
            'START TRANSACTION;SET FOREIGN_KEY_CHECKS=0; TRUNCATE TABLE program; SET FOREIGN_KEY_CHECKS=1; COMMIT;'
        );

        $userManager = $this->kernel->getContainer()->get('fos_user.user_manager');

        // Pour récupérer la liste de tous les utilisateurs
        foreach ($userManager->findUsers() as $user) {
            // Pour supprimer un utilisateur
            $userManager->deleteUser($user);
        };
    }

    /** @AfterScenario */
    public function teardown($event)
    {
    }

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
     * @Then /^I should see a link to "([^"]*)"$/
     */
    public function iShouldSeeALinkTo($url)
    {
        $this->lastLink = $url;
        return $this->assertElementOnPage("a[href$='".$url."']");
    }

    /**
     * @Then /^I should see a link to "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeALinkToInArea($url, $area)
    {
        $this->lastLink = $url;
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
        return new Step\Then("the response status code should be 200");
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

    /**
     * @Given /^I am admin$/
     */
    public function iAmAdmin()
    {
        return array(
            new Step\Given("a administrator named \"admin\""),
            new Step\Given("I am \"admin\"")
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
                    ->visit("/".$role);
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
}
