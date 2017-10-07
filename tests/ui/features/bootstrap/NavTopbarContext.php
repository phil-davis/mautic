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
use Page\NavTopbarPage;

require_once 'bootstrap.php';

/**
 * Nav Topbar context.
 */
class NavTopbarContext extends RawMinkContext implements Context
{
    private $navTopbarPage;

    /**
     * NavTopbarContext constructor.
     *
     * @param NavTopbarPage $page
     */
    public function __construct(NavTopbarPage $page)
    {
        $this->navTopbarPage = $page;
    }

    /**
     * @When I logout
     */
    public function iLogout()
    {
        $this->navTopbarPage->selectNavTopbarMenuEntry('logout');
    }

    /**
     * @When I select the :entry topbar entry
     */
    public function iSelectTheTopbarEntry($entry)
    {
        $this->navTopbarPage->selectNavTopbarMenuEntry($entry);
    }

    /**
     * @When I open/close the settings panel
     */
    public function iOpenCloseTheSettingsPanel()
    {
        $this->navTopbarPage->clickTheSettingsGear();
    }

    /**
     * @When I select the :entry settings entry
     */
    public function iSelectTheSettingsEntry($entry)
    {
        $this->navTopbarPage->selectSettingsPanelEntry($entry);
    }

    /**
     * @Then the user display name is :fullName
     */
    public function theUserDisplayNameIs($fullName)
    {
        PHPUnit_Framework_Assert::assertEquals(
            $fullName,
            $this->navTopbarPage->getNavTopbarText()
        );
    }
}
