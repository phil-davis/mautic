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
use Page\MauticPage;
use Page\LoginPage;

require_once 'bootstrap.php';

/**
 * Features context.
 */
class FeatureContext extends RawMinkContext implements Context
{
    use BasicStructure;

    private $mauticPage;
    private $loginPage;

    public function __construct(MauticPage $mauticPage, LoginPage $loginPage)
    {
        $this->mauticPage = $mauticPage;
        $this->loginPage = $loginPage;
    }

    /**
     * @Then I should be redirected to a page with the title :title
     */
    public function iShouldBeRedirectedToAPageWithTheTitle($title)
    {
        $this->mauticPage->waitForOutstandingAjaxCalls($this->getSession());
        $actualTitle = $this->getSession()->getPage()->find(
            'xpath', './/title'
        )->getHtml();
        $normalizedTitle = preg_replace('/\s+/', ' ',trim($actualTitle));
        PHPUnit_Framework_Assert::assertEquals($title, $normalizedTitle);
    }

    /** @BeforeScenario */
    public function setUpSuite(BeforeScenarioScope $scope)
    {
        $jobId = $this->getSessionId($scope);
        file_put_contents("/tmp/saucelabs_sessionid", $jobId);
    }

    public function getSessionId(BeforeScenarioScope $scope)
    {
        $url = $this->getSession()->getDriver()->getWebDriverSession()->getUrl();
        $parts = explode('/', $url);
        $sessionId = array_pop($parts);
        return $sessionId;
    }
}
