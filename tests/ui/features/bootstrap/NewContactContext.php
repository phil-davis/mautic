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
use Page\NewContactPage;

require_once 'bootstrap.php';

/**
 * New Contact context.
 */
class NewContactContext extends RawMinkContext implements Context
{
    private $newContactPage;

    public function __construct(NewContactPage $page)
    {
        $this->newContactPage = $page;
    }

    /**
     * @Given I am on the new contact page
     */
    public function iAmOnTheNewContactPage()
    {
        $this->newContactPage->open();
    }

    /**
     * @Given I go to the new contact page
     */
    public function iGoToTheNewContactPage()
    {
        $this->visitPath($this->newContactPage->getPagePath());
        $this->newContactPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
