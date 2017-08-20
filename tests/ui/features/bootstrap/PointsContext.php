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
use Page\PointsPage;

require_once 'bootstrap.php';

/**
 * Points context.
 */
class PointsContext extends RawMinkContext implements Context
{
    private $pointsPage;

    public function __construct(PointsPage $page)
    {
        $this->pointsPage = $page;
    }

    /**
     * @Given I am on the points page
     */
    public function iAmOnThePointsPage()
    {
        $this->pointsPage->open();
    }

    /**
     * @Given I go to the points page
     */
    public function iGoToThePointsPage()
    {
        $this->visitPath($this->pointsPage->getPagePath());
        $this->pointsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
