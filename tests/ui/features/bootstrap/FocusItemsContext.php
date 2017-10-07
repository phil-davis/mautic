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
use Page\FocusItemsPage;

require_once 'bootstrap.php';

/**
 * Focus Items context.
 */
class FocusItemsContext extends RawMinkContext implements Context
{
    private $focusItemsPage;

    /**
     * FocusItemsContext constructor.
     *
     * @param FocusItemsPage $page
     */
    public function __construct(FocusItemsPage $page)
    {
        $this->focusItemsPage = $page;
    }

    /**
     * @Given I am on the focus items page
     */
    public function iAmOnTheFocusItemsPage()
    {
        $this->focusItemsPage->open();
    }

    /**
     * @Given I go to the focus items page
     */
    public function iGoToTheFocusItemsPage()
    {
        $this->visitPath($this->focusItemsPage->getPagePath());
        $this->focusItemsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
