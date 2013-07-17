<?php

namespace Bpaulin\UpfitBundle\Features\Context;

use Symfony\Component\HttpKernel\KernelInterface;
use Behat\Symfony2Extension\Context\KernelAwareInterface;
use Behat\MinkExtension\Context\MinkContext;
use Behat\Behat\Exception\PendingException;

use Behat\Gherkin\Node\TableNode;
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
        $this->useContext('objective', new ObjectiveSubContext());
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

    protected function assertElementContainsIcon($element, $iconClass)
    {
        $icon = $element->find('css', 'i');
        if (!$icon) {
            throw new \Exception('icon not found, icon-'.$icon.' wanted ');
        }
        $icon = $icon->getAttribute('class');
        if ($icon != 'icon-'.$iconClass) {
            throw new \Exception($icon.' is not expected, icon-'.$iconClass.' wanted ');
        }
    }

    protected function assertElementContainsNoIcon($element)
    {
        $icon = $element->find('css', "i[class^='icon-']");
        if ($icon) {
            throw new \Exception('icon found, none wanted');
        }
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
     * @Then /^I should not see a link to "([^"]*)"$/
     */
    public function iShouldNotSeeALinkTo($url)
    {
        return $this->assertElementNotOnPage("a[href$='".$url."']");
    }

    /**
     * @Then /^I should see a link to "([^"]*)" in "([^"]*)" area$/
     */
    public function iShouldSeeALinkToInArea($url, $area)
    {
        $this->assertElementOnPage("#".$area."-area a[href$='".$url."']");
        $this->lastLink  = $this->getMink()
                                ->getSession()
                                ->getPage()
                                ->find('css', "#".$area."-area a[href$='".$url."']")
                                ->getAttribute('href');
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
     * @When /^I follow the last link$/
     */
    public function iFollowTheLastLink()
    {
        return $this->iFollowThisLink();
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

    /**
     * @Then /^I should see the following breadcrumbs:$/
     */
    public function iShouldSeeTheFollowingBreadcrumbs(TableNode $table)
    {
        // | icon | label | link |
        $hash = $table->getHash();
        $lis = $this->getMainContext()->getMink()
                                ->getSession()
                                ->getPage()
                                ->findAll('css', ".breadcrumb li");
        if (count($lis) != count($hash)) {
            throw new \Exception(count($lis).' breadcrumbs is not expected, '.count($hash).' wanted ');
        }
        foreach ($hash as $index => $row) {
            if ($row['icon']) {
                $this->assertElementContainsIcon($lis[$index], $row['icon']);
            } else {
                $this->assertElementContainsNoIcon($lis[$index]);
            }
            // $row['label'] = ucfirst($row['label']);
            $label = trim($lis[$index]->find('css', 'span.breadcrumb-label')->getHtml());
            if ($row['label'] != $label) {
                throw new \Exception('"'.$label.'" is not expected, "'.$row['label'].'" wanted ');
            }
            if ($row['link']) {
                $link = $lis[$index]->find('css', 'a')->getAttribute('href');
                if (null === $lis[$index]->find('css', "a[href$='".$row['link']."']")) {
                    throw new \Exception($link.' is not expected, '.$row['link'].' wanted ');
                }
            }
        }
    }

    /**
     * @Then /^I should see the following actions:$/
     */
    public function iShouldSeeTheFollowingActions(TableNode $table)
    {
        // | type    | icon      | label     | link                |
        $hash = $table->getHash();
        $as = $this->getMainContext()->getMink()
                                ->getSession()
                                ->getPage()
                                ->findAll('css', "#actions-area a");
        if (count($as) != count($hash)) {
            throw new \Exception(count($as).' actions is not expected, '.count($hash).' wanted ');
        } else {
            foreach ($hash as $index => $row) {
                if ($row['type']) {
                    $classes = explode(' ', $as[$index]->getAttribute('class'));
                    if (!in_array('btn-'.$row['type'], $classes)) {
                        throw new \Exception('action type is not '.$row['type']);
                    }
                }
                if ($row['icon']) {
                    $this->assertElementContainsIcon($as[$index], $row['icon']);
                } else {
                    $this->assertElementContainsNoIcon($as[$index]);
                }
                // $row['label'] = ucfirst($row['label']);
                $label = trim($as[$index]->getText());
                if ($row['label'] != $label) {
                    throw new \Exception('"'.$label.'" is not expected, "'.$row['label'].'" wanted ');
                }
                if ($row['link']) {
                    $link = $as[$index]->find('css', 'a')->getAttribute('href');
                    if (null === $as[$index]->find('css', "a[href$='".$row['link']."']")) {
                        throw new \Exception($link.' is not expected, '.$row['link'].' wanted ');
                    }
                }
            }
        }
    }
}
