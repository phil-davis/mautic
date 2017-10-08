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

use Behat\Mink\Element\NodeElement;
use Behat\Mink\Session;
use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use WebDriver\Exception as WebDriverException;
use WebDriver\Key;

class MauticPage extends Page
{
    protected $userNameDisplayId = 'expandDisplayName';

    // TODO: sort out waiting for page loads in Mautic
    public function waitTillPageIsLoaded(Session $session, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $currentTime = microtime(true);
        $end         = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            $loadingIndicator = $this->find('css', '.loading');
            if (!is_null($loadingIndicator)) {
                $visibility = $this->elementHasCSSValue(
                    $loadingIndicator, 'visibility', 'visible'
                );
                if ($visibility === false) {
                    break;
                }
            }
            usleep(STANDARD_SLEEP_TIME_MICROSEC);
            $currentTime = microtime(true);
        }
        $this->waitForOutstandingAjaxCalls($session);
    }

    /**
     * @param string $xpath
     * @param int    $timeout_msec
     */
    public function waitTillElementIsNull($xpath, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $currentTime = microtime(true);
        $end         = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            try {
                $element = $this->find('xpath', $xpath);
            } catch (WebDriverException $e) {
                break;
            }
            if ($element === null) {
                break;
            }
            usleep(STANDARD_SLEEP_TIME_MICROSEC);
            $currentTime = microtime(true);
        }
    }

    /**
     * @param string $xpath
     * @param int    $timeout_msec
     */
    public function waitTillElementIsNotNull($xpath, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $currentTime = microtime(true);
        $end         = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            try {
                $element = $this->find('xpath', $xpath);
                if ($element === null || !$element->isValid()) {
                    usleep(STANDARD_SLEEP_TIME_MICROSEC);
                } else {
                    break;
                }
            } catch (WebDriverException $e) {
                usleep(STANDARD_SLEEP_TIME_MICROSEC);
            }

            $currentTime = microtime(true);
        }
    }

    /**
     * Keep trying to click until the click works or the time has expired.
     * Boxes can popup, e.g. after doing "Apply" saying things like
     * "Your account has been updated". They can cover buttons/menus that
     * we want to click, and that makes Mink-Selenium complain that the item
     * is not clickable - "Other element would receive the click"
     * These popups go away themselves after a few seconds, so we just wait,
     * rather than trying to find them and close them.
     *
     * @param NodeElement $element
     * @param string      $elementName
     * @param int         $timeout_msec
     *
     * @throws \Exception
     */
    public function clickWithTimeout(NodeElement $element, $elementName, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $currentTime = microtime(true);
        $end         = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            try {
                if ($element->isValid() && $element->isVisible()) {
                    $element->click();

                    return;
                } else {
                    usleep(STANDARD_SLEEP_TIME_MICROSEC);
                }
            } catch (WebDriverException $e) {
                usleep(STANDARD_SLEEP_TIME_MICROSEC);
            }

            $currentTime = microtime(true);
        }

        // The timeout expired and we still cannot click
        throw new \Exception('could not click '.$elementName.' within '.$timeout_msec.'msec');
    }

    /**
     * Find the element correspondding to the given selector and scroll it into view.
     * Acknowledgement to https://gist.github.com/MKorostoff/c94824a467ffa53f4fa9#gistcomment-2095785 nickrealdini.
     *
     * @param Session $session
     * @param string  $selector Allowed selectors: #id, .className, //xpath
     *
     * @throws \Exception
     */
    public function scrollIntoView(Session $session, $selector)
    {
        $locator = substr($selector, 0, 1);

        switch ($locator) {
            case '/': // XPath selector
                $function = <<<JS
(function(){
  var elem = document.evaluate($selector, document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null).singleNodeValue;
  elem.scrollIntoView(false);
})()
JS;
                break;

            case '#': // ID selector
                $selector = substr($selector, 1);
                $function = <<<JS
(function(){
  var elem = document.getElementById("$selector");
  elem.scrollIntoView(false);
})()
JS;
                break;

            case '.': // Class selector
                $selector = substr($selector, 1);
                $function = <<<JS
(function(){
  var elem = document.getElementsByClassName("$selector");
  elem[0].scrollIntoView(false);
})()
JS;
                break;

            default:
                throw new \Exception(__METHOD__.' Couldn\'t find selector: '.$selector.' - Allowed selectors: #id, .className, //xpath');
                break;
        }

        try {
            $session->executeScript($function);
        } catch (\Exception $e) {
            throw new \Exception(__METHOD__.' failed');
        }
    }

    // TODO: see if notifications come like this in Mautic
    public function getNotificationText()
    {
        return $this->findById('notification')->getText();
    }

    public function getNotifications()
    {
        $notificationsText = [];
        $notifications     = $this->findById('notification');
        foreach ($notifications->findAll('xpath', 'div') as $notification) {
            array_push($notificationsText, $notification->getText());
        }

        return $notificationsText;
    }

    /**
     * finds the logged-in username displayed in the top right corner
     * TODO: make something like this work in Mautic.
     *
     * @return string
     */
    public function getMyUsername()
    {
        return $this->findById($this->userNameDisplayId)->getText();
    }

    /**
     * return the path to the relevant page.
     *
     * @return string
     */
    public function getPagePath()
    {
        return $this->getPath();
    }

    /**
     * Gets the Coordinates of a Mink Element.
     *
     * @param Session     $session
     * @param NodeElement $element
     *
     * @return string
     */
    public function getCoordinatesOfElement($session, $element)
    {
        return $session->evaluateScript(
            'return document.evaluate( "'.
            $element->getXpath().
            '",document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null)'.
            '.singleNodeValue.getBoundingClientRect();'
        );
    }

    /**
     * Gets the Window Height.
     *
     * @param Session $session
     *
     * @return string
     */
    public function getWindowHeight($session)
    {
        return $session->evaluateScript(
            'return $(window).height();'
        );
    }

    /**
     * waits till all ajax calls are finished (jQuery.active === 0).
     *
     * @param Session $session
     * @param number  $timeout_msec
     *
     * @throws \Exception
     */
    public function waitForOutstandingAjaxCalls(Session $session, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $timeout_msec = (int) $timeout_msec;
        if ($timeout_msec <= 0) {
            throw new \InvalidArgumentException('negative or zero timeout');
        }
        $currentTime = microtime(true);
        $end         = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            try {
                $waitingResult = $session->wait(
                    STANDARD_SLEEP_TIME_MICROSEC,
                    "(typeof jQuery != 'undefined' && (0 === jQuery.active))"
                );
                if ($waitingResult === true) {
                    break;
                }
            } catch (\Exception $e) {
                //show Exception message, but do not throw it
                echo $e->getMessage()."\n";
            } finally {
                usleep(STANDARD_SLEEP_TIME_MICROSEC);
                $currentTime = microtime(true);
            }
        }
        if ($currentTime > $end) {
            $message = 'INFORMATION: timed out waiting for outstanding ajax calls';
            echo $message;
            error_log($message);
        }
    }

    /**
     * waits till at least one Ajax call is active.
     *
     * @param Session $session
     * @param int     $timeout_msec
     */
    public function waitForAjaxCallsToStart(Session $session, $timeout_msec = 1000)
    {
        $timeout_msec = (int) $timeout_msec;
        if ($timeout_msec <= 0) {
            throw new \InvalidArgumentException('negative or zero timeout');
        }
        $currentTime = microtime(true);
        $end         = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            if ((int) $session->evaluateScript('jQuery.active') > 0) {
                break;
            }
            usleep(STANDARD_SLEEP_TIME_MICROSEC);
            $currentTime = microtime(true);
        }
    }

    /**
     * waits till at least one Ajax call is active and then waits till all outstanding ajax calls finish.
     *
     * @param Session $session
     * @param int     $timeout_msec
     */
    public function waitForAjaxCallsToStartAndFinish(Session $session, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $start = microtime(true);
        $this->waitForAjaxCallsToStart($session);
        $end          = microtime(true);
        $timeout_msec = $timeout_msec - (($end - $start) * 1000);
        $this->waitForOutstandingAjaxCalls($session, $timeout_msec);
    }

    /**
     * Determine if a Mink NodeElement contains a specific
     * css rule attribute value.
     *
     * @param NodeElement $element
     *                              NodeElement previously selected with
     *                              $this->getSession()->getPage()->find()
     * @param string      $property
     *                              Name of the CSS property, such as "visibility"
     * @param string      $value
     *                              Value of the specified rule, such as "hidden"
     *
     * @return NodeElement|bool
     *                          The NodeElement selected if true, FALSE otherwise
     */
    protected function elementHasCSSValue($element, $property, $value)
    {
        $exists = false;
        $style  = $element->getAttribute('style');
        if ($style) {
            if (preg_match(
                "/(^{$property}:|; {$property}:) ([a-z0-9]+);/i",
                $style, $matches
            )) {
                $found = array_pop($matches);
                if ($found == $value) {
                    $exists = $element;
                }
            }
        }

        return $exists;
    }

    /**
     * sends an END key and then BACKSPACEs to delete the current value
     * then sends the new value
     * checks the set value and sends the Escape key + throws an exception
     * if the value is not set correctly.
     *
     * @param NodeElement $inputField
     * @param string      $value
     *
     * @throws \Exception
     */
    protected function cleanInputAndSetValue(NodeElement $inputField, $value)
    {
        $resultValue         = $inputField->getValue();
        $existingValueLength = strlen($resultValue);
        $deleteSequence      = Key::END.str_repeat(Key::BACKSPACE, $existingValueLength);
        $inputField->setValue($deleteSequence);
        $inputField->setValue($value);
        $resultValue = $inputField->getValue();
        if ($resultValue !== $value) {
            $inputField->keyUp(27); //send escape
            throw new \Exception('value of input field is not what we expect');
        }
    }
}
