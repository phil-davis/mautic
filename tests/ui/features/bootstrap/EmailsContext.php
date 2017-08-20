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
use Page\EmailsPage;

require_once 'bootstrap.php';

/**
 * Emails context.
 */
class EmailsContext extends RawMinkContext implements Context
{
    private $emailsPage;

    public function __construct(EmailsPage $page)
    {
        $this->emailsPage = $page;
    }

    /**
     * @Given I am on the emails page
     */
    public function iAmOnTheEmailsPage()
    {
        $this->emailsPage->open();
    }

    /**
     * @Given I go to the emails page
     */
    public function iGoToTheEmailsPage()
    {
        $this->visitPath($this->emailsPage->getPagePath());
        $this->emailsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
