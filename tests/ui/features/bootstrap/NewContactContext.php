<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\RawMinkContext;
use Page\NewContactPage;

require_once 'bootstrap.php';

/**
 * New Contact context.
 */
class NewContactContext extends RawMinkContext implements Context
{
    private $newContactPage;

    public function __construct(NewContactPage $page)
    {
        $this->newContactPage = $page;
    }

    /**
     * @Given I am on the new contact page
     */
    public function iAmOnTheNewContactPage()
    {
        $this->newContactPage->open();
    }

    /**
     * @Given I go to the new contact page
     */
    public function iGoToTheNewContactPage()
    {
        $this->visitPath($this->newContactPage->getPagePath());
        $this->newContactPage->waitForOutstandingAjaxCalls($this->getSession());
    }

    /**
     * @When /^I set contact title to (.*)$/
     */
    public function iSetContactTitleTo($title)
    {
        $this->newContactPage->setTitle($title);
    }

    /**
     * @Given /^I set contact first name to (.*)$/
     */
    public function iSetContactFirstNameTo($firstName)
    {
        $this->newContactPage->setFirstName($firstName);
    }

    /**
     * @Given /^I set contact last name to (.*)$/
     */
    public function iSetContactLastNameTo($lastName)
    {
        $this->newContactPage->setLastName($lastName);
    }

    /**
     * @Given /^I set contact email to (.*)$/
     */
    public function iSetContactEmailTo($email)
    {
        $this->newContactPage->setEmail($email);
    }

    /**
     * @Given /^I apply the contact changes$/
     */
    public function iApplyTheContactChanges()
    {
        $this->newContactPage->applyChanges();
        $this->newContactPage->waitTillPageIsLoaded($this->getSession());
    }

    /**
     * @Then /^the contact title is (.*)$/
     */
    public function theContactTitleIs($title)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $title,
            $this->newContactPage->getTitle()
        );
    }

    /**
     * @Given /^the contact first name is (.*)$/
     */
    public function theContactFirstNameIs($firstName)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $firstName,
            $this->newContactPage->getFirstName()
        );
    }

    /**
     * @Given /^the contact last name is (.*)$/
     */
    public function theContactLastNameIs($lastName)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $lastName,
            $this->newContactPage->getLastName()
        );
    }

    /**
     * @Given /^the contact email is (.*)$/
     */
    public function theContactEmailIs($email)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $email,
            $this->newContactPage->getEmail()
        );
    }
}
