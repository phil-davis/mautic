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
use Page\AccountPage;

require_once 'bootstrap.php';

/**
 * Assets context.
 */
class AccountContext extends RawMinkContext implements Context
{
    private $accountPage;

    public function __construct(AccountPage $page)
    {
        $this->accountPage = $page;
    }

    /**
     * @Given I am on the account page
     */
    public function iAmOnTheAccountPage()
    {
        $this->accountPage->open();
    }

    /**
     * @Given I go to the account page
     */
    public function iGoToTheAccountPage()
    {
        $this->visitPath($this->accountPage->getPagePath());
        $this->accountPage->waitForOutstandingAjaxCalls($this->getSession());
    }

    /**
     * @When I set account first name to :firstName
     */
    public function iSetAccountFirstNameTo($firstName)
    {
        $this->accountPage->setFirstName($firstName);
    }

    /**
     * @When I set account last name to :lastName
     */
    public function iSetAccountLastNameTo($lastName)
    {
        $this->accountPage->setLastName($lastName);
    }

    /**
     * @When I set account password to :pwd
     */
    public function iSetAccountPasswordTo($pwd)
    {
        $this->accountPage->setPassword($pwd);
        $this->accountPage->setConfirmPassword($pwd);
    }

    /**
     * @When I set account password to :pwd and confirm password to :confirm
     */
    public function iSetAccountPasswordToConfirmTo($pwd, $confirm)
    {
        $this->accountPage->setPassword($pwd);
        $this->accountPage->setConfirmPassword($confirm);
    }

    /**
     * @When I apply the account changes
     */
    public function iApplyTheAccountChanges()
    {
        $this->accountPage->applyAccountChanges();
    }

    /**
     * @Then near the password field a message should be displayed :message
     */
    public function passwordFieldMessage($message)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $message,
            trim(trim($this->accountPage->getPasswordMessage(), '.'))
        );
    }

    /**
     * @Then the account first name is :firstName
     */
    public function theAccountFirstNameIs($firstName)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $firstName,
            $this->accountPage->getFirstName()
        );
    }

    /**
     * @Then the account last name is :lastName
     */
    public function theAccountLastNameIs($lastName)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $lastName,
            $this->accountPage->getLastName()
        );
    }
}
