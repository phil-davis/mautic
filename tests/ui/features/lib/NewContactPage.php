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
    protected $path                 = '/s/contacts/new';
    protected $titleInputId         = 'lead_title';
    protected $firstNameInputId     = 'lead_firstname';
    protected $lastNameInputId      = 'lead_lastname';
    protected $emailInputId         = 'lead_email';
    protected $positionInputId      = 'lead_position';
    protected $address1InputId      = 'lead_address1';
    protected $address2InputId      = 'lead_address2';
    protected $cityInputId          = 'lead_city';
    protected $countryChosenId      = 'lead_country_chosen';
    protected $countryResultsXpath  = "//ul[@class='chosen-results']";
    protected $countryListItemXpath = "//li[contains(text(), '%s')]";
    protected $applyButtonNormalId  = 'lead_buttons_apply_toolbar';
    protected $applyButtonMobileId  = 'lead_buttons_apply_toolbar_mobile';

    public function setTitle($title)
    {
        $this->fillField($this->titleInputId, $title);
    }

    public function setFirstName($firstName)
    {
        $this->fillField($this->firstNameInputId, $firstName);
    }

    public function setLastName($lastName)
    {
        $this->fillField($this->lastNameInputId, $lastName);
    }

    public function setEmail($email)
    {
        $this->fillField($this->emailInputId, $email);
    }

    public function setPosition($text)
    {
        $this->fillField($this->positionInputId, $text);
    }

    public function setAddress1($text)
    {
        $this->fillField($this->address1InputId, $text);
    }

    public function setAddress2($text)
    {
        $this->fillField($this->address2InputId, $text);
    }

    public function setCity($text)
    {
        $this->fillField($this->cityInputId, $text);
    }

    public function selectCountry($country)
    {
        // We have to click on the country chosen because that is what is displayed
        // on top and is clickable.
        $countryChosenElement = $this->findById($this->countryChosenId);

        if ($countryChosenElement === null) {
            throw new ElementNotFoundException(
                'selectCountry:could not find country chosen element'
            );
        }

        $countryChosenElement->click();

        $selectCountryElement = $countryChosenElement->find('xpath', $this->countryResultsXpath);

        if ($selectCountryElement === null) {
            throw new ElementNotFoundException(
                'selectCountry:could not find country results element'
            );
        }

        $selectOption = $selectCountryElement->find(
            'xpath',
            sprintf($this->countryListItemXpath, $country)
        );

        if ($selectOption === null) {
            throw new ElementNotFoundException(
                'selectCountry:could not find country list item '.$country
            );
        }

        $selectOption->click();
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
    public function getCountry()
    {
        $countryChosenElement = $this->findById($this->countryChosenId);

        if ($countryChosenElement === null) {
            throw new ElementNotFoundException(
                'getCountry:could not find country chosen element'
            );
        }

        return $countryChosenElement->getText();
    }

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
