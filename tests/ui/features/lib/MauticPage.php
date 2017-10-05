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

use SensioLabs\Behat\PageObjectExtension\PageObject\Page;
use Behat\Mink\Session;
use Behat\Mink\Element\NodeElement;
use WebDriver\Exception as WebDriverException;
use WebDriver\Key;

class MauticPage extends Page
{
    protected $userNameDisplayId = "expandDisplayName";

    // TODO: sort out waiting for page loads in Mautic
    public function waitTillPageIsLoaded(Session $session, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $currentTime = microtime(true);
        $end = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            $loadingIndicator = $this->find("css", '.loading');
            if (!is_null($loadingIndicator)) {
                $visibility = $this->elementHasCSSValue(
                    $loadingIndicator, 'visibility', 'visible'
                );
                if ($visibility === FALSE) {
                    break;
                }
            }
            usleep(STANDARD_SLEEP_TIME_MICROSEC);
            $currentTime = microtime(true);
        }
        $this->waitForOutstandingAjaxCalls($session);
    }

    /**
     *
     * @param string $xpath
     * @param int $timeout_msec
     */
    public function waitTillElementIsNull($xpath, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $currentTime = microtime(true);
        $end = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            try {
                $element = $this->find("xpath", $xpath);
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
     *
     * @param string $xpath
     * @param int $timeout_msec
     */
    public function waitTillElementIsNotNull($xpath, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $currentTime = microtime(true);
        $end = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            try {
                $element = $this->find("xpath", $xpath);
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

    // TODO: see if notifications come like this in Mautic
    public function getNotificationText()
    {
        return $this->findById("notification")->getText();
    }

    public function getNotifications()
    {
        $notificationsText = array();
        $notifications = $this->findById("notification");
        foreach ($notifications->findAll("xpath", "div") as $notification) {
            array_push($notificationsText, $notification->getText());
        }
        return $notificationsText;
    }

    /**
     * finds the logged-in username displayed in the top right corner
     * TODO: make something like this work in Mautic
     * @return string
     */
    public function getMyUsername()
    {
        return $this->findById($this->userNameDisplayId)->getText();
    }

    /**
     * return the path to the relevant page
     * @return string
     */
    public function getPagePath()
    {
        return $this->getPath();
    }

    /**
     * Gets the Coordinates of a Mink Element
     *
     * @param Session $session
     * @param NodeElement $element
     * @return String
     */
    public function getCoordinatesOfElement($session, $element)
    {
        return $session->evaluateScript(
            'return document.evaluate( "' .
            $element->getXpath() .
            '",document, null, XPathResult.FIRST_ORDERED_NODE_TYPE, null)' .
            '.singleNodeValue.getBoundingClientRect();'
        );
    }

    /**
     * Gets the Window Height
     *
     * @param Session $session
     * @return String
     */
    public function getWindowHeight($session)
    {
        return $session->evaluateScript(
            'return $(window).height();'
        );
    }

    /**
     * waits till all ajax calls are finished (jQuery.active === 0)
     * @param Session $session
     * @param number $timeout_msec
     * @throws \Exception
     */
    public function waitForOutstandingAjaxCalls (Session $session, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $timeout_msec = (int) $timeout_msec;
        if ($timeout_msec <= 0) {
            throw new \InvalidArgumentException("negative or zero timeout");
        }
        $currentTime = microtime(true);
        $end = $currentTime + ($timeout_msec / 1000);
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
                echo $e->getMessage(). "\n";
            } finally {
                usleep(STANDARD_SLEEP_TIME_MICROSEC);
                $currentTime = microtime(true);
            }
        }
        if ($currentTime > $end) {
            $message = "INFORMATION: timed out waiting for outstanding ajax calls";
            echo $message;
            error_log($message);
        }
    }

    /**
     * waits till at least one Ajax call is active
     * @param Session $session
     * @param int $timeout_msec
     */
    public function waitForAjaxCallsToStart (Session $session, $timeout_msec = 1000)
    {
        $timeout_msec = (int) $timeout_msec;
        if ($timeout_msec <= 0) {
            throw new \InvalidArgumentException("negative or zero timeout");
        }
        $currentTime = microtime(true);
        $end = $currentTime + ($timeout_msec / 1000);
        while ($currentTime <= $end) {
            if ((int) $session->evaluateScript("jQuery.active") > 0) {
                break;
            }
            usleep(STANDARD_SLEEP_TIME_MICROSEC);
            $currentTime = microtime(true);
        }
    }

    /**
     * waits till at least one Ajax call is active and then waits till all outstanding ajax calls finish
     * @param Session $session
     * @param int $timeout_msec
     */
    public function waitForAjaxCallsToStartAndFinish (Session $session, $timeout_msec = STANDARD_UI_WAIT_TIMEOUT_MILLISEC)
    {
        $start = microtime(true);
        $this->waitForAjaxCallsToStart($session);
        $end = microtime(true);
        $timeout_msec = $timeout_msec - (($end - $start) * 1000);
        $this->waitForOutstandingAjaxCalls($session, $timeout_msec);
    }

    /**
     * Determine if a Mink NodeElement contains a specific
     * css rule attribute value.
     *
     * @param NodeElement $element
     *   NodeElement previously selected with
     *   $this->getSession()->getPage()->find().
     * @param string $property
     *   Name of the CSS property, such as "visibility".
     * @param string $value
     *   Value of the specified rule, such as "hidden".
     *
     * @return NodeElement|bool
     *   The NodeElement selected if true, FALSE otherwise.
     */
    protected function elementHasCSSValue($element, $property, $value)
    {
        $exists = FALSE;
        $style = $element->getAttribute('style');
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
     * if the value is not set correctly
     *
     * @param NodeElement $inputField
     * @param string $value
     * @throws \Exception
     */
    protected function cleanInputAndSetValue(NodeElement $inputField, $value)
    {
        $resultValue = $inputField->getValue();
        $existingValueLength = strlen($resultValue);
        $deleteSequence = Key::END . str_repeat(Key::BACKSPACE, $existingValueLength);
        $inputField->setValue($deleteSequence);
        $inputField->setValue($value);
        $resultValue = $inputField->getValue();
        if ($resultValue !== $value) {
            $inputField->keyUp(27); //send escape
            throw new \Exception("value of input field is not what we expect");
        }
    }
}