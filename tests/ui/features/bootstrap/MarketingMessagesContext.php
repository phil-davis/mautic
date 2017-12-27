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
use Page\MarketingMessagesPage;

require_once 'bootstrap.php';

/**
 * Marketing Messages context.
 */
class MarketingMessagesContext extends RawMinkContext implements Context
{
    private $MarketingMessagesPage;

    /**
     * MarketingMessagesContext constructor.
     *
     * @param MarketingMessagesPage $page
     */
    public function __construct(MarketingMessagesPage $page)
    {
        $this->MarketingMessagesPage = $page;
    }

    /**
     * @Given I am on the marketing messages page
     */
    public function iAmOnTheMarketingMessagesPage()
    {
        $this->MarketingMessagesPage->open();
    }

    /**
     * @Given I go to the marketing messages page
     */
    public function iGoToTheMarketingMessagesPage()
    {
        $this->visitPath($this->MarketingMessagesPage->getPagePath());
        $this->MarketingMessagesPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
