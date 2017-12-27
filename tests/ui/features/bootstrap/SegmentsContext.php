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
use Page\SegmentsPage;

require_once 'bootstrap.php';

/**
 * Segments context.
 */
class SegmentsContext extends RawMinkContext implements Context
{
    private $segmentsPage;

    /**
     * SegmentsContext constructor.
     *
     * @param SegmentsPage $page
     */
    public function __construct(SegmentsPage $page)
    {
        $this->segmentsPage = $page;
    }

    /**
     * @Given I am on the segments page
     */
    public function iAmOnTheSegmentsPage()
    {
        $this->segmentsPage->open();
    }

    /**
     * @Given I go to the segments page
     */
    public function iGoToTheSegmentsPage()
    {
        $this->visitPath($this->segmentsPage->getPagePath());
        $this->segmentsPage->waitForOutstandingAjaxCalls($this->getSession());
    }
}
