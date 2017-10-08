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

class ContactsPage extends MauticPage
{
    /**
     * @var string
     */
    protected $path                  = '/s/contacts';
    protected $newContactButtonXpath = '//*[@href=\'/s/contacts/new\']';

    /**
     * Find and click the new contact button.
     *
     * @throws ElementNotFoundException
     */
    public function selectNewContactButton()
    {
        $newContactElement = $this->find('xpath', $this->newContactButtonXpath);

        if ($newContactElement === null) {
            throw new ElementNotFoundException(
                'selectNewContactButton:could not find new contact button'
            );
        }

        $newContactElement->click();
    }
}
