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
use Page\CampaignsPage;

require_once 'bootstrap.php';

/**
 * Campaigns context.
 */
class CampaignsContext extends RawMinkContext implements Context
{
    private $campaignsPage;

    /**
     * CampaignsContext constructor.
     *
     * @param CampaignsPage $page
     */
    public function __construct(CampaignsPage $page)
    {
        $this->campaignsPage = $page;
    }

    /**
     * @Given I am on the campaigns page
     */
    public function iAmOnTheCampaignsPage()
    {
        $this->campaignsPage->open();
    }

    /**
     * @Given I go to the campaigns page
     */
    public function iGoToTheCampaignsPage()
    {
        $this->visitPath($this->campaignsPage->getPagePath());
        $this->campaignsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
