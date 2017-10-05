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
     *
     * @var string $path
     */
    protected $path = '/s/account';
    protected $firstNameInputId = "user_firstName";
    protected $lastNameInputId = "user_lastName";
    protected $passwordInputId = "user_plainPassword_password";
    protected $confirmPasswordInputId = "user_plainPassword_confirm";
    protected $applyButtonNormalId = "user_buttons_save_toolbar";
    protected $applyButtonMobileId = "user_buttons_save_toolbar_mobile";

    public function setFirstName($firstname)
    {
        $this->fillField($this->firstNameInputId, $firstname);
    }

    public function setLastName($lastname)
    {
        $this->fillField($this->lastNameInputId, $lastname);
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
     *
     * @return string
     */
    public function getFirstName()
    {
        $firstNameElement = $this->findById($this->firstNameInputId);

        if ($firstNameElement === null) {
            throw new ElementNotFoundException(
                "getFirstName:could not find element"
            );
        }

        return $firstNameElement->getValue();
    }

    /**
     *
     * @return string
     */
    public function getLastName()
    {
        $lastNameElement = $this->findById($this->lastNameInputId);

        if ($lastNameElement === null) {
            throw new ElementNotFoundException(
                "getLastName:could not find element"
            );
        }

        return $lastNameElement->getValue();
    }

    public function applyAccountChanges()
    {
        $applyButton = $this->findById($this->applyButtonNormalId);

        if ($applyButton === null) {
            throw new ElementNotFoundException("could not find normal account apply button");
        }

        if (!$applyButton->isVisible()) {
            $applyButton = $this->findById($this->applyButtonMobileId);

            if ($applyButton === null) {
                throw new ElementNotFoundException("could not find mobile account apply button");
            }
        }

        if (!$applyButton->isVisible()) {
            throw new ElementNotVisible("could not find any visible account apply button");
        }

        $applyButton->click();
    }
}
