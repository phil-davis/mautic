Feature: contacts
  In order to send marketing information to people
  As an authorised user
  I need to record and update contact details

  Scenario: add new contact
    Given I am logged in as sales
    And I go to the contacts page
    And I am redirected to a page with the title "Contacts | Mautic"
    And I select the new contact button
    Then I am redirected to a page with the title "New Contact | Mautic"
