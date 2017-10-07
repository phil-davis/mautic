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
use Page\CalendarPage;

require_once 'bootstrap.php';

/**
 * Calendar context.
 */
class CalendarContext extends RawMinkContext implements Context
{
    private $calendarPage;

    /**
     * CalendarContext constructor.
     *
     * @param CalendarPage $page
     */
    public function __construct(CalendarPage $page)
    {
        $this->calendarPage = $page;
    }

    /**
     * @Given I am on the calendar page
     */
    public function iAmOnTheCalendarPage()
    {
        $this->calendarPage->open();
    }

    /**
     * @Given I go to the calendar page
     */
    public function iGoToTheCalendarPage()
    {
        $this->visitPath($this->calendarPage->getPagePath());
        $this->calendarPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
