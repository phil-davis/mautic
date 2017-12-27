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
use Page\DynamicContentPage;

require_once 'bootstrap.php';

/**
 * Dynamic Content context.
 */
class DynamicContentContext extends RawMinkContext implements Context
{
    private $dynamicContentPage;

    /**
     * DynamicContentContext constructor.
     *
     * @param DynamicContentPage $page
     */
    public function __construct(DynamicContentPage $page)
    {
        $this->dynamicContentPage = $page;
    }

    /**
     * @Given I am on the dynamic content page
     */
    public function iAmOnTheDynamicContentPage()
    {
        $this->dynamicContentPage->open();
    }

    /**
     * @Given I go to the dynamic content page
     */
    public function iGoToTheDynamicContentPage()
    {
        $this->visitPath($this->dynamicContentPage->getPagePath());
        $this->dynamicContentPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
