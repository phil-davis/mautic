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
use Page\FormsPage;

require_once 'bootstrap.php';

/**
 * Forms context.
 */
class FormsContext extends RawMinkContext implements Context
{
    private $formsPage;

    public function __construct(FormsPage $page)
    {
        $this->formsPage = $page;
    }

    /**
     * @Given I am on the forms page
     */
    public function iAmOnTheFormsPage()
    {
        $this->formsPage->open();
    }

    /**
     * @Given I go to the forms page
     */
    public function iGoToTheFormsPage()
    {
        $this->visitPath($this->formsPage->getPagePath());
        $this->formsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
