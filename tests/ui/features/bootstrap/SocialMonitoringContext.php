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
use Page\SocialMonitoringPage;

require_once 'bootstrap.php';

/**
 * Social Monitoring context.
 */
class SocialMonitoringContext extends RawMinkContext implements Context
{
    private $socialMonitoringPage;

    public function __construct(SocialMonitoringPage $page)
    {
        $this->socialMonitoringPage = $page;
    }

    /**
     * @Given I am on the social monitoring page
     */
    public function iAmOnTheSocialMonitoringPage()
    {
        $this->socialMonitoringPage->open();
    }

    /**
     * @Given I go to the social monitoring page
     */
    public function iGoToTheSocialMonitoringPage()
    {
        $this->visitPath($this->socialMonitoringPage->getPagePath());
        $this->socialMonitoringPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
