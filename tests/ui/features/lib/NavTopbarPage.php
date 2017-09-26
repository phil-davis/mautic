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
     * @var string $path
     */
    protected $path = '/s/login';

    protected $navTopbarDropdownXpath = "//*[@id='app-header']//a[@class='dropdown-toggle']";
    protected $navTopbarFullNameXpath = "//span[contains(@class,'text')]";
    protected $navTopbarDropdownMenuXpath = "//*[@id='app-header']//*[@class='dropdown-menu dropdown-menu-right']";
    protected $navTopbarDropdownMenuMatchXpath = "//*[@href='%s']";

    protected $navTopbarMenuHref = [
        'account' => '/s/account',
        'logout' => '/s/logout',
    ];

    protected $navTopbarPages = [
        'account' => 'AccountPage',
        'logout' => 'LoginPage',
    ];

    /**
     * Find and click the entry in the topbar dropdown menu.
     *
     * @param $entry
     * @return \SensioLabs\Behat\PageObjectExtension\PageObject\Page
     */
    public function selectNavTopbarMenuEntry($entry)
    {
        $entry = strtolower($entry);

        if (!array_key_exists($entry, $this->navTopbarMenuHref)) {
            throw new InvalidArgumentException(
                "selectNavTopbarEntry:no such nav topbar menu entry " . $entry
            );
        }

        $dropdownElement = $this->find('xpath', $this->navTopbarDropdownXpath);

        if ($dropdownElement === null) {
            throw new ElementNotFoundException(
                "selectNavTopbarEntry:could not find nav topbar dropdown element"
            );
        }

        $dropdownElement->click();

        $dropdownMenuElement = $this->find('xpath', $this->navTopbarDropdownMenuXpath);

        if ($dropdownMenuElement === null) {
            throw new ElementNotFoundException(
                "selectNavTopbarEntry:could not find nav topbar dropdown menu element"
            );
        }

        $dropdownMenuItemElement = $dropdownMenuElement->find(
            'xpath',
            sprintf($this->navTopbarDropdownMenuMatchXpath, $this->navTopbarMenuHref[$entry])
        );

        if ($dropdownMenuItemElement === null) {
            throw new ElementNotFoundException(
                "selectNavTopbarEntry:could not find nav topbar dropdown menu item " . $entry
            );
        }

        $dropdownMenuItemElement->click();

        return $this->getPage($this->navTopbarPages[$entry]);
    }

    /**
     * Get the text in the topbar dropdown (which has the user display name)
     *
     * @return string
     */
    public function getNavTopbarText()
    {
        $dropdownElement = $this->find('xpath', $this->navTopbarDropdownXpath);

        if ($dropdownElement === null) {
            throw new ElementNotFoundException(
                "getNavTopbarText:could not find nav topbar dropdown element"
            );
        }

        $fullNameElement = $dropdownElement->find('xpath', $this->navTopbarFullNameXpath);

        if ($fullNameElement === null) {
            throw new ElementNotFoundException(
                "getNavTopbarText:could not find nav topbar fullname element"
            );
        }

        return $fullNameElement->getText();
    }
}
