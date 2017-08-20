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
use Page\CompaniesPage;

require_once 'bootstrap.php';

/**
 * Companies context.
 */
class CompaniesContext extends RawMinkContext implements Context
{
    private $companiesPage;

    public function __construct(CompaniesPage $page)
    {
        $this->companiesPage = $page;
    }

    /**
     * @Given I am on the companies page
     */
    public function iAmOnTheCompaniesPage()
    {
        $this->companiesPage->open();
    }

    /**
     * @Given I go to the companies page
     */
    public function iGoToTheCompaniesPage()
    {
        $this->visitPath($this->companiesPage->getPagePath());
        $this->companiesPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
