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
use Page\ContactsPage;

require_once 'bootstrap.php';

/**
 * Contacts context.
 */
class ContactsContext extends RawMinkContext implements Context
{
    private $contactsPage;

    public function __construct(ContactsPage $page)
    {
        $this->contactsPage = $page;
    }

    /**
     * @Given I am on the contacts page
     */
    public function iAmOnTheContactsPage()
    {
        $this->contactsPage->open();
    }

    /**
     * @Given I go to the contacts page
     */
    public function iGoToTheContactsPage()
    {
        $this->visitPath($this->contactsPage->getPagePath());
        $this->contactsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
