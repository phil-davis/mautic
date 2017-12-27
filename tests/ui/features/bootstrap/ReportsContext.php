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
use Page\ReportsPage;

require_once 'bootstrap.php';

/**
 * Reports context.
 */
class ReportsContext extends RawMinkContext implements Context
{
    private $reportsPage;

    /**
     * ReportsContext constructor.
     *
     * @param ReportsPage $page
     */
    public function __construct(ReportsPage $page)
    {
        $this->reportsPage = $page;
    }

    /**
     * @Given I am on the reports page
     */
    public function iAmOnTheReportsPage()
    {
        $this->reportsPage->open();
    }

    /**
     * @Given I go to the reports page
     */
    public function iGoToTheReportsPage()
    {
        $this->visitPath($this->reportsPage->getPagePath());
        $this->reportsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
