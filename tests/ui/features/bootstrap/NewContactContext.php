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

    /**
     * NewContactContext constructor.
     *
     * @param NewContactPage $page
     */
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
     * @Given /^I set contact position to (.*)$/
     */
    public function iSetContactPositionTo($text)
    {
        $this->newContactPage->setPosition($text);
    }

    /**
     * @Given /^I set contact address first line to (.*)$/
     */
    public function iSetContactAddress1To($text)
    {
        $this->newContactPage->setAddress1($text);
    }

    /**
     * @Given /^I set contact address second line to (.*)$/
     */
    public function iSetContactAddress2To($text)
    {
        $this->newContactPage->setAddress2($text);
    }

    /**
     * @Given /^I set contact city to (.*)$/
     */
    public function iSetContactCityTo($text)
    {
        $this->newContactPage->setCity($text);
    }

    /**
     * @Given /^I set contact state to (.*)$/
     */
    public function iSetContactStateTo($text)
    {
        $this->newContactPage->selectState($text);
    }

    /**
     * @Given /^I set contact country to (.*)$/
     */
    public function iSetContactCountryTo($text)
    {
        $this->newContactPage->selectCountry($text);
    }

    /**
     * @Given /^I apply the contact changes$/
     */
    public function iApplyTheContactChanges()
    {
        $this->newContactPage->applyChanges($this->getSession());
        $this->newContactPage->waitTillPageIsLoaded($this->getSession());
    }

    /**
     * @Then /^the contact title is (.*)$/
     */
    public function theContactTitleIs($title)
    {
        // For some titles like "Mr" the UI makes it "Mr."
        // So for now here we just compare without any "."
        PHPUnit_Framework_Assert::assertEquals(
            trim($title, '.'),
            trim($this->newContactPage->getTitle(), '.')
        );
    }

    /**
     * @Then /^the contact first name is (.*)$/
     */
    public function theContactFirstNameIs($firstName)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $firstName,
            $this->newContactPage->getFirstName()
        );
    }

    /**
     * @Then /^the contact last name is (.*)$/
     */
    public function theContactLastNameIs($lastName)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $lastName,
            $this->newContactPage->getLastName()
        );
    }

    /**
     * @Then /^the contact email is (.*)$/
     */
    public function theContactEmailIs($email)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $email,
            $this->newContactPage->getEmail()
        );
    }

    /**
     * @Then /^the contact position is (.*)$/
     */
    public function theContactPositionIs($text)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $text,
            $this->newContactPage->getPosition()
        );
    }

    /**
     * @Then /^the contact address first line is (.*)$/
     */
    public function theContactAddress1Is($text)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $text,
            $this->newContactPage->getAddress1()
        );
    }

    /**
     * @Then /^the contact address second line is (.*)$/
     */
    public function theContactAddress2Is($text)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $text,
            $this->newContactPage->getAddress2()
        );
    }

    /**
     * @Then /^the contact state is (.*)$/
     */
    public function theContactStateIs($text)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $text,
            $this->newContactPage->getState()
        );
    }

    /**
     * @Then /^the contact city is (.*)$/
     */
    public function theContactCityIs($text)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $text,
            $this->newContactPage->getCity()
        );
    }

    /**
     * @Then /^the contact country is (.*)$/
     */
    public function theAccountLanguageIs($text)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $text,
            $this->newContactPage->getCountry()
        );
    }
}
