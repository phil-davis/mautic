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
use Page\LandingPagesPage;

require_once 'bootstrap.php';

/**
 * Landing Pages context.
 */
class LandingPagesContext extends RawMinkContext implements Context
{
    private $landingPagesPage;

    /**
     * LandingPagesContext constructor.
     *
     * @param LandingPagesPage $page
     */
    public function __construct(LandingPagesPage $page)
    {
        $this->landingPagesPage = $page;
    }

    /**
     * @Given I am on the landing pages page
     */
    public function iAmOnTheLandingPagesPage()
    {
        $this->landingPagesPage->open();
    }

    /**
     * @Given I go to the landing pages page
     */
    public function iGoToTheLandingPagesPage()
    {
        $this->visitPath($this->landingPagesPage->getPagePath());
        $this->landingPagesPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
