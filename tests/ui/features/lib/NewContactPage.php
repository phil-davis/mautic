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

class NewContactPage extends MauticPage
{
    /**
     * @var string
     */
    protected $path                = '/s/contacts/new';
    protected $titleInputId        = 'lead_title';
    protected $firstNameInputId    = 'lead_firstname';
    protected $lastNameInputId     = 'lead_lastname';
    protected $emailInputId        = 'lead_email';
    protected $applyButtonNormalId = 'lead_buttons_apply_toolbar';
    protected $applyButtonMobileId = 'lead_buttons_apply_toolbar_mobile';

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

    public function applyChanges()
    {
        $applyButton = $this->findById($this->applyButtonNormalId);

        if ($applyButton === null) {
            throw new ElementNotFoundException('could not find normal contact apply button');
        }

        if (!$applyButton->isVisible()) {
            $applyButton = $this->findById($this->applyButtonMobileId);

            if ($applyButton === null) {
                throw new ElementNotFoundException('could not find mobile contact apply button');
            }
        }

        if (!$applyButton->isVisible()) {
            throw new ElementNotVisible('could not find any visible contact apply button');
        }

        $applyButton->click();
    }
}
