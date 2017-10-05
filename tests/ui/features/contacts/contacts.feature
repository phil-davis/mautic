Feature: contacts
  In order to send marketing information to people
  As an authorised user
  I need to record and update contact details

  Scenario: directly access the new contact page when not logged in
    Given I go to the new contact page
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "admin" and password "mautic" after a redirect from the "newContact" page
    Then I should be redirected to a page with the title "New Contact | Mautic"

  Scenario: add new contact
    Given I am logged in as sales
    And I go to the contacts page
    And I am redirected to a page with the title "Contacts | Mautic"
    And I select the new contact button
    Then I am redirected to a page with the title "New Contact | Mautic"
