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
use Page\LoginPage;
use Page\MauticPage;

require_once 'bootstrap.php';

/**
 * Features context.
 */
class FeatureContext extends RawMinkContext implements Context
{
    use BasicStructure;

    private $mauticPage;
    private $loginPage;

    /**
     * FeatureContext constructor.
     *
     * @param MauticPage $mauticPage
     * @param LoginPage  $loginPage
     */
    public function __construct(MauticPage $mauticPage, LoginPage $loginPage)
    {
        $this->mauticPage = $mauticPage;
        $this->loginPage  = $loginPage;
    }

    /**
     * @Then /^I (?:should be|am) redirected to a page with the title "([^"]*)"$/
     */
    public function iShouldBeRedirectedToAPageWithTheTitle($title)
    {
        $this->mauticPage->waitForOutstandingAjaxCalls($this->getSession());
        $this->iAmOnAPageWithTheTitle($title);
    }

    /**
     * @Then I should be redirected to a page with the title :title within :sec seconds
     */
    public function iShouldBeRedirectedToAPageWithTheTitleSeconds($title, $sec)
    {
        $this->mauticPage->waitForOutstandingAjaxCalls($this->getSession(), $sec * 1000);
        $this->iAmOnAPageWithTheTitle($title);
    }

    /**
     * @Then I am on a page with the title :title
     */
    public function iAmOnAPageWithTheTitle($title)
    {
        $actualTitle = $this->getSession()->getPage()->find(
            'xpath', './/title'
        )->getHtml();
        $normalizedTitle = preg_replace('/\s+/', ' ', trim($actualTitle));
        PHPUnit_Framework_Assert::assertEquals($title, $normalizedTitle);
    }

    /**
     * @BeforeScenario
     */
    public function setUpSuite()
    {
        $jobId = $this->getSessionId();
        file_put_contents('/tmp/saucelabs_sessionid', $jobId);
    }

    public function getSessionId()
    {
        $url       = $this->getSession()->getDriver()->getWebDriverSession()->getUrl();
        $parts     = explode('/', $url);
        $sessionId = array_pop($parts);

        return $sessionId;
    }
}
