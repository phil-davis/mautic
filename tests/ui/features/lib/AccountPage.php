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

use SensioLabs\Behat\PageObjectExtension\PageObject\Exception\ElementNotFoundException;
use WebDriver\Exception\ElementNotVisible;

class AccountPage extends MauticPage
{
    /**
     * @var string
     */
    protected $path                   = '/s/account';
    protected $firstNameInputId       = 'user_firstName';
    protected $lastNameInputId        = 'user_lastName';
    protected $languageTitleXpath     = "//label[@for='user_locale']";
    protected $languageChosenId       = 'user_locale_chosen';
    protected $languageResultsXpath   = "//ul[@class='chosen-results']";
    protected $languageListItemXpath  = "//li[contains(text(), '%s')]";
    protected $passwordInputId        = 'user_plainPassword_password';
    protected $confirmPasswordInputId = 'user_plainPassword_confirm';
    protected $passwordMessageXpath   = "//*[@id='app-content']//div[@class='help-block']";
    protected $applyButtonNormalId    = 'user_buttons_save_toolbar';
    protected $applyButtonMobileId    = 'user_buttons_save_toolbar_mobile';

    public function setFirstName($firstName)
    {
        $this->fillField($this->firstNameInputId, $firstName);
    }

    public function setLastName($lastName)
    {
        $this->fillField($this->lastNameInputId, $lastName);
    }

    public function selectLanguage($language)
    {
        // We have to click on the language chosen because that is what is displayed
        // on top and is clickable.
        $languageChosenElement = $this->findById($this->languageChosenId);

        if ($languageChosenElement === null) {
            throw new ElementNotFoundException(
                'selectLanguage:could not find language chosen element'
            );
        }

        $languageChosenElement->click();

        $selectLanguageElement = $languageChosenElement->find('xpath', $this->languageResultsXpath);

        if ($selectLanguageElement === null) {
            throw new ElementNotFoundException(
                'selectLanguage:could not find language results element'
            );
        }

        $selectOption = $selectLanguageElement->find(
            'xpath',
            sprintf($this->languageListItemXpath, $language)
        );

        if ($selectOption === null) {
            throw new ElementNotFoundException(
                'selectLanguage:could not find language list item '.$language
            );
        }

        $selectOption->click();
    }

    public function setPassword($pwd)
    {
        $this->fillField($this->passwordInputId, $pwd);
    }

    public function setConfirmPassword($pwd)
    {
        $this->fillField($this->confirmPasswordInputId, $pwd);
    }

    /**
     * @return string
     */
    public function getPasswordMessage()
    {
        $this->waitTillElementIsNotNull($this->passwordMessageXpath);
        $passwordMessageElement = $this->find('xpath', $this->passwordMessageXpath);

        if ($passwordMessageElement === null) {
            throw new ElementNotFoundException(
                'getPasswordMessage:could not find password message element'
            );
        }

        return $passwordMessageElement->getText();
    }

    /**
     * @return string
     */
    public function getLanguageTitle()
    {
        $languageTitleElement = $this->find('xpath', $this->languageTitleXpath);

        if ($languageTitleElement === null) {
            throw new ElementNotFoundException(
                'getLanguage:could not find language title element'
            );
        }

        return $languageTitleElement->getText();
    }

    /**
     * @return string
     */
    public function getLanguage()
    {
        $languageChosenElement = $this->findById($this->languageChosenId);

        if ($languageChosenElement === null) {
            throw new ElementNotFoundException(
                'getLanguage:could not find language chosen element'
            );
        }

        return $languageChosenElement->getText();
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

    public function applyChanges()
    {
        $applyButton = $this->findById($this->applyButtonNormalId);

        if ($applyButton === null) {
            throw new ElementNotFoundException('could not find normal account apply button');
        }

        if (!$applyButton->isVisible()) {
            $applyButton = $this->findById($this->applyButtonMobileId);

            if ($applyButton === null) {
                throw new ElementNotFoundException('could not find mobile account apply button');
            }
        }

        if (!$applyButton->isVisible()) {
            throw new ElementNotVisible('could not find any visible account apply button');
        }

        $applyButton->click();
    }
}
