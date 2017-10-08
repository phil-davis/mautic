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
use WebDriver\Exception\ElementNotVisible;

class NewContactPage extends MauticPage
{
    /**
     * @var string
     */
    protected $path                       = '/s/contacts/new';
    protected $titleInputId               = 'lead_title';
    protected $firstNameInputId           = 'lead_firstname';
    protected $lastNameInputId            = 'lead_lastname';
    protected $emailInputId               = 'lead_email';
    protected $positionInputId            = 'lead_position';
    protected $address1InputId            = 'lead_address1';
    protected $address2InputId            = 'lead_address2';
    protected $cityInputId                = 'lead_city';
    protected $stateChosenId              = 'lead_state_chosen';
    protected $countryChosenId            = 'lead_country_chosen';
    protected $applyButtonNormalId        = 'lead_buttons_apply_toolbar';
    protected $applyButtonMobileId        = 'lead_buttons_apply_toolbar_mobile';

    /**
     * @param string $text
     */
    public function setTitle($text)
    {
        $this->fillField($this->titleInputId, $text);
    }

    /**
     * @param string $text
     */
    public function setFirstName($text)
    {
        $this->fillField($this->firstNameInputId, $text);
    }

    /**
     * @param string $text
     */
    public function setLastName($text)
    {
        $this->fillField($this->lastNameInputId, $text);
    }

    /**
     * @param string $text
     */
    public function setEmail($text)
    {
        $this->fillField($this->emailInputId, $text);
    }

    /**
     * @param string $text
     */
    public function setPosition($text)
    {
        $this->fillField($this->positionInputId, $text);
    }

    /**
     * @param string $text
     */
    public function setAddress1($text)
    {
        $this->fillField($this->address1InputId, $text);
    }

    /**
     * @param string $text
     */
    public function setAddress2($text)
    {
        $this->fillField($this->address2InputId, $text);
    }

    /**
     * @param string $text
     */
    public function setCity($text)
    {
        $this->fillField($this->cityInputId, $text);
    }

    /**
     * @param Session $session
     * @param string $text
     */
    public function selectState(Session $session, $text)
    {
        $this->scrollIntoView($session, '#'.$this->stateChosenId);
        $this->selectFromChooser($this->stateChosenId, $text);
    }

    /**
     * @param Session $session
     * @param string $text
     */
    public function selectCountry(Session $session, $text)
    {
        $this->scrollIntoView($session, '#'.$this->countryChosenId);
        $this->selectFromChooser($this->countryChosenId, $text);
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        $titleElement = $this->findById($this->titleInputId);

        if ($titleElement === null) {
            throw new ElementNotFoundException(
                'getTitle:could not find element'
            );
        }

        return $titleElement->getValue();
    }

    /**
     * @return string
     */
    public function getFirstName()
    {
        $firstNameElement = $this->findById($this->firstNameInputId);

        if ($firstNameElement === null) {
            throw new ElementNotFoundException(
                'getFirstName:could not find element'
            );
        }

        return $firstNameElement->getValue();
    }

    /**
     * @return string
     */
    public function getLastName()
    {
        $lastNameElement = $this->findById($this->lastNameInputId);

        if ($lastNameElement === null) {
            throw new ElementNotFoundException(
                'getLastName:could not find element'
            );
        }

        return $lastNameElement->getValue();
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        $emailElement = $this->findById($this->emailInputId);

        if ($emailElement === null) {
            throw new ElementNotFoundException(
                'getEmail:could not find element'
            );
        }

        return $emailElement->getValue();
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        $pageElement = $this->findById($this->positionInputId);

        if ($pageElement === null) {
            throw new ElementNotFoundException(
                'getPosition:could not find element'
            );
        }

        return $pageElement->getValue();
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        $pageElement = $this->findById($this->address1InputId);

        if ($pageElement === null) {
            throw new ElementNotFoundException(
                'getAddress1:could not find element'
            );
        }

        return $pageElement->getValue();
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        $pageElement = $this->findById($this->address2InputId);

        if ($pageElement === null) {
            throw new ElementNotFoundException(
                'getAddress2:could not find element'
            );
        }

        return $pageElement->getValue();
    }

    /**
     * @return string
     */
    public function getCity()
    {
        $pageElement = $this->findById($this->cityInputId);

        if ($pageElement === null) {
            throw new ElementNotFoundException(
                'getCity:could not find element'
            );
        }

        return $pageElement->getValue();
    }

    /**
     * @return string
     */
    public function getState()
    {
        $chosenElement = $this->findById($this->stateChosenId);

        if ($chosenElement === null) {
            throw new ElementNotFoundException(
                'getState:could not find state chosen element'
            );
        }

        return $chosenElement->getText();
    }

    /**
     * @return string
     */
    public function getCountry()
    {
        $chosenElement = $this->findById($this->countryChosenId);

        if ($chosenElement === null) {
            throw new ElementNotFoundException(
                'getCountry:could not find country chosen element'
            );
        }

        return $chosenElement->getText();
    }

    /**
     * @param Session $session
     * @throws ElementNotVisible
     */
    public function applyChanges(Session $session)
    {
        $applyButtonId = $this->applyButtonNormalId;
        $applyButton   = $this->findById($applyButtonId);

        if ($applyButton === null) {
            throw new ElementNotFoundException('could not find normal contact apply button');
        }

        if (!$applyButton->isVisible()) {
            $applyButtonId = $this->applyButtonMobileId;

            $applyButton = $this->findById($applyButtonId);

            if ($applyButton === null) {
                throw new ElementNotFoundException('could not find mobile contact apply button');
            }
        }

        if (!$applyButton->isVisible()) {
            throw new ElementNotVisible('could not find any visible contact apply button');
        }

        $this->scrollIntoView($session, '#'.$applyButtonId);
        $this->clickWithTimeout($applyButton, 'new contact apply button');
    }
}
