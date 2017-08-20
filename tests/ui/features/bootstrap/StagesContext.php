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
use Page\StagesPage;

require_once 'bootstrap.php';

/**
 * Stages context.
 */
class StagesContext extends RawMinkContext implements Context
{
    private $stagesPage;

    public function __construct(StagesPage $page)
    {
        $this->stagesPage = $page;
    }

    /**
     * @Given I am on the stages page
     */
    public function iAmOnTheStagesPage()
    {
        $this->stagesPage->open();
    }

    /**
     * @Given I go to the stages page
     */
    public function iGoToTheStagesPage()
    {
        $this->visitPath($this->stagesPage->getPagePath());
        $this->stagesPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
