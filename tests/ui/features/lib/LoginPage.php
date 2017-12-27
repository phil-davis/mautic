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

use Behat\Mink\Session;
use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;

class LoginPage extends MauticPage
{
    /**
     * @var string
     */
    protected $path              = '/s/login';
    protected $userInputId       = 'username';
    protected $passwordInputId   = 'password';
    protected $submitButtonXpath = "//button[@type='submit']";

    /**
     * @param string $username
     * @param string $password
     * @param string $target
     *
     * @return MauticPage|\SensioLabs\Behat\PageObjectExtension\PageObject\Page
     */
    public function loginAs($username, $password, $target = 'DashboardPage')
    {
        $this->fillField($this->userInputId, $username);
        $this->fillField($this->passwordInputId, $password);
        $loginButton = $this->find('xpath', $this->submitButtonXpath);

        if ($loginButton === null) {
            throw new ElementNotFoundException('could not find login button');
        }

        $loginButton->click();

        return $this->getPage($target);
    }

    /**
     * There is no reliable loading indicator on the login page, so wait for
     * the user and password to be there.
     *
     * @param Session $session
     * @param int     $timeout_msec
     */
    public function waitTillPageIsLoaded(Session $session, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $currentTime = microtime(true);
        $end         = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            if (($this->findById($this->userInputId) !== null) &&
                ($this->findById($this->passwordInputId) !== null)) {
                break;
            }
            usleep(STANDARD_SLEEP_TIME_MICROSEC);
            $currentTime = microtime(true);
        }
        $this->waitForOutstandingAjaxCalls($session);
    }
}
