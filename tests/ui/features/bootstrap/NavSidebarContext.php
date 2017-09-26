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
use Page\NavSidebarPage;

require_once 'bootstrap.php';

/**
 * Nav Sidebar context.
 */
class NavSidebarContext extends RawMinkContext implements Context
{
    private $navSidebarPage;

    public function __construct(NavSidebarPage $page)
    {
        $this->navSidebarPage = $page;
    }

    /**
     * @Given I select the :entry sidebar entry
     */
    public function iSelectTheSidebarEntry($entry)
    {
        $this->navSidebarPage->selectNavSidebarEntry($entry);
    }

    /**
     * @Given I select the :subentry sidebar sub-entry of the :entry sidebar entry
     */
    public function iSelectTheSidebarSubEntry($subentry, $entry)
    {
        $this->navSidebarPage->selectNavSidebarEntry($entry, $subentry, false);
    }

    /**
     * @Given I select the :entry sidebar entry and :subentry sub-entry
     */
    public function iSelectTheSidebarEntryAndSubEntry($entry, $subentry)
    {
        $this->navSidebarPage->selectNavSidebarEntry($entry, $subentry);
    }

    /**
     * @Given I expand/collapse the sidebar menu
     */
    public function iExpandCollapseTheSidebarMenu()
    {
        $this->navSidebarPage->flipNavSidebarMenu();
    }
}
