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
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\MinkExtension\Context\RawMinkContext;
use Page\LoginPage;

require_once 'bootstrap.php';

/**
 * Login context.
 */
class LoginContext extends RawMinkContext implements Context
{
    private $loginPage;
    private $dashboardPage;
    private $expectedPage;
    private $featureContext;

    public function __construct(LoginPage $page)
    {
        $this->loginPage = $page;
    }

    /**
     * @Given I am on the login page
     */
    public function iAmOnTheLoginPage()
    {
        $this->loginPage->open();
    }

    /**
     * @When I login with username :username and password :password
     */
    public function iLoginWithUsernameAndPassword($username, $password)
    {
        $this->dashboardPage = $this->loginPage->loginAs($username, $password);
        $this->dashboardPage->waitTillPageIsLoaded($this->getSession());
    }

    /**
     * @When I login with username :username and invalid password :password
     */
    public function iLoginWithUsernameAndInvalidPassword($username, $password)
    {
        $this->loginPage->loginAs($username, $password, 'LoginPage');
        $this->loginPage->waitTillPageIsLoaded($this->getSession());
    }

    /**
     * @When I login with username :username and password :password after a redirect from the :page page
     */
    public function iLoginWithUsernameAndPasswordAfterRedirectFromThePage($username, $password, $page)
    {
        $this->expectedPage = $this->loginPage->loginAs($username, $password, str_replace(' ', '', ucwords($page)).'Page');
        $this->expectedPage->waitTillPageIsLoaded($this->getSession());
    }

    /**
     * @When I login as a regular user with a correct password
     */
    public function iLoginAsARegularUserWithACorrectPassword()
    {
        $this->dashboardPage = $this->loginPage->loginAs(
            $this->featureContext->getRegularUserName(),
            $this->featureContext->getRegularUserPassword());
        $this->dashboardPage->waitTillPageIsLoaded($this->getSession());
    }

    /** @BeforeScenario
     * This will run before EVERY scenario. It will set the properties for this object.
     */
    public function before(BeforeScenarioScope $scope)
    {
        // Get the environment
        $environment = $scope->getEnvironment();
        // Get all the contexts you need in this context
        $this->featureContext = $environment->getContext('FeatureContext');
    }
}
