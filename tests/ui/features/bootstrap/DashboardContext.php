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
use Page\DashboardPage;

require_once 'bootstrap.php';

/**
 * Dashboard context.
 */
class DashboardContext extends RawMinkContext implements Context
{
    private $dashboardPage;

    public function __construct(DashboardPage $page)
    {
        $this->dashboardPage = $page;
    }

    /**
     * @Given I am on the dashboard page
     */
    public function iAmOnTheDashboardPage()
    {
        $this->dashboardPage->open();
    }

    /**
     * @Given I go to the dashboard page
     */
    public function iGoToTheDashboardPage()
    {
        $this->visitPath($this->dashboardPage->getPagePath());
        $this->dashboardPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
