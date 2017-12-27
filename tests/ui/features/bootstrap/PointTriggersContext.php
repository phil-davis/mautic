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
use Page\PointTriggersPage;

require_once 'bootstrap.php';

/**
 * Point Triggers context.
 */
class PointTriggersContext extends RawMinkContext implements Context
{
    private $pointTriggersPage;

    /**
     * PointTriggersContext constructor.
     *
     * @param PointTriggersPage $page
     */
    public function __construct(PointTriggersPage $page)
    {
        $this->pointTriggersPage = $page;
    }

    /**
     * @Given I am on the point triggers page
     */
    public function iAmOnThePointTriggersPage()
    {
        $this->pointTriggersPage->open();
    }

    /**
     * @Given I go to the point triggers page
     */
    public function iGoToThePointTriggersPage()
    {
        $this->visitPath($this->pointTriggersPage->getPagePath());
        $this->pointTriggersPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
