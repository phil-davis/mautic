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
use Page\AssetsPage;

require_once 'bootstrap.php';

/**
 * Assets context.
 */
class AssetsContext extends RawMinkContext implements Context
{
    private $assetsPage;

    public function __construct(AssetsPage $page)
    {
        $this->assetsPage = $page;
    }

    /**
     * @Given I am on the assets page
     */
    public function iAmOnTheAssetsPage()
    {
        $this->assetsPage->open();
    }

    /**
     * @Given I go to the assets page
     */
    public function iGoToTheAssetsPage()
    {
        $this->visitPath($this->assetsPage->getPagePath());
        $this->assetsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
