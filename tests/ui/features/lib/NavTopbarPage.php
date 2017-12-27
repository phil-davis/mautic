<?php

/*
 * @copyright   2014 Mautic Contributors. All rights reserved
 * @author      Mautic
 *
 * @link        http://mautic.org
 *
 * @license     GNU/GPLv3 http://www.gnu.org/licenses/gpl-3.0.html
 */

namespace Page;

use Psr\Log\InvalidArgumentException;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;

class NavTopbarPage extends MauticPage
{
    /**
     * @var string
     */
    protected $path = '/s/login';

    protected $navTopbarDropdownXpath          = "//*[@id='app-header']//a[@class='dropdown-toggle']";
    protected $navTopbarFullNameXpath          = "//span[contains(@class,'text')]";
    protected $navTopbarDropdownMenuXpath      = "//*[@id='app-header']//*[@class='dropdown-menu dropdown-menu-right']";
    protected $navTopbarDropdownMenuMatchXpath = "//*[@href='%s']";
    protected $navTopbarSettingsXpath          = "//*[@id='app-header']//a[@data-toggle='sidebar']//i[contains(@class,'fa-cog')]";

    protected $navTopbarMenuHref = [
        'account' => '/s/account',
        'logout'  => '/s/logout',
    ];

    protected $navTopbarMenuPages = [
        'account' => 'AccountPage',
        'logout'  => 'LoginPage',
    ];

    protected $navSettingsPanelIds = [
        'webhooks'      => 'mautic_webhook_root',
        'users'         => 'mautic_user_index',
        'themes'        => 'mautic_themes_index',
        'system info'   => 'mautic_sysinfo_index',
        'categories'    => 'mautic_category_index',
        'configuration' => 'mautic_config_index',
        'roles'         => 'mautic_role_index',
        'custom fields' => 'mautic_lead_field',
        'plugins'       => 'mautic_plugin_root',
    ];

    protected $navSettingsPanelPages = [
        'webhooks'      => 'WebhooksPage',
        'users'         => 'UsersPage',
        'themes'        => 'ThemesPage',
        'system info'   => 'SystemInfoPage',
        'categories'    => 'CategoriesPage',
        'configuration' => 'ConfigurationPage',
        'roles'         => 'RolesPage',
        'custom fields' => 'CustomFieldsPage',
        'plugins'       => 'PluginsPage',
    ];

    /**
     * Find and click the entry in the topbar dropdown menu.
     *
     * @param $entry
     *
     * @return \SensioLabs\Behat\PageObjectExtension\PageObject\Page
     */
    public function selectNavTopbarMenuEntry($entry)
    {
        $entry = strtolower($entry);

        if (!array_key_exists($entry, $this->navTopbarMenuHref)) {
            throw new InvalidArgumentException(
                'selectNavTopbarEntry:no such nav topbar menu entry '.$entry
            );
        }

        $dropdownElement = $this->find('xpath', $this->navTopbarDropdownXpath);

        if ($dropdownElement === null) {
            throw new ElementNotFoundException(
                'selectNavTopbarEntry:could not find nav topbar dropdown element'
            );
        }

        $this->clickWithTimeout($dropdownElement, 'nav topbar dropdown element');

        $dropdownMenuElement = $this->find('xpath', $this->navTopbarDropdownMenuXpath);

        if ($dropdownMenuElement === null) {
            throw new ElementNotFoundException(
                'selectNavTopbarEntry:could not find nav topbar dropdown menu element'
            );
        }

        $dropdownMenuItemElement = $dropdownMenuElement->find(
            'xpath',
            sprintf($this->navTopbarDropdownMenuMatchXpath, $this->navTopbarMenuHref[$entry])
        );

        if ($dropdownMenuItemElement === null) {
            throw new ElementNotFoundException(
                'selectNavTopbarEntry:could not find nav topbar dropdown menu item '.$entry
            );
        }

        $this->clickWithTimeout($dropdownMenuItemElement, 'nav topbar dropdown menu item '.$entry);

        return $this->getPage($this->navTopbarMenuPages[$entry]);
    }

    /**
     * Get the text in the topbar dropdown (which has the user display name).
     *
     * @return string
     */
    public function getNavTopbarText()
    {
        $dropdownElement = $this->find('xpath', $this->navTopbarDropdownXpath);

        if ($dropdownElement === null) {
            throw new ElementNotFoundException(
                'getNavTopbarText:could not find nav topbar dropdown element'
            );
        }

        $fullNameElement = $dropdownElement->find('xpath', $this->navTopbarFullNameXpath);

        if ($fullNameElement === null) {
            throw new ElementNotFoundException(
                'getNavTopbarText:could not find nav topbar fullname element'
            );
        }

        return $fullNameElement->getText();
    }

    /**
     * Open/close the settings panel.
     */
    public function clickTheSettingsGear()
    {
        $settingsElement = $this->find('xpath', $this->navTopbarSettingsXpath);

        if ($settingsElement === null) {
            throw new ElementNotFoundException(
                'clickTheSettingsGear:could not find nav topbar settings gear element'
            );
        }

        $settingsElement->click();
    }

    /**
     * @param $entry
     *
     * @return \SensioLabs\Behat\PageObjectExtension\PageObject\Page
     */
    public function selectSettingsPanelEntry($entry)
    {
        $entry = strtolower($entry);

        if (!array_key_exists($entry, $this->navSettingsPanelIds)) {
            throw new InvalidArgumentException('no such settings panel entry '.$entry);
        }

        $entryId              = $this->navSettingsPanelIds[$entry];
        $settingsPanelElement = $this->findById($entryId);

        if ($settingsPanelElement === null) {
            throw new ElementNotFoundException('could not find settings panel element '.$entryId);
        }

        $settingsPanelElement->click();

        $page = $this->navSettingsPanelPages[$entry];

        return $this->getPage($page);
    }
}
