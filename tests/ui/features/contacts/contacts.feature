Feature: contacts
  In order to send marketing information to people
  As an authorised user
  I need to record and update contact details

  Scenario: directly access the new contact page when not logged in
    Given I go to the new contact page
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "admin" and password "mautic" after a redirect from the "newContact" page
    Then I should be redirected to a page with the title "New Contact | Mautic"

  @fixtures
  Scenario Outline: add new contact
    Given I am logged in as sales
    And I go to the contacts page
    And I am redirected to a page with the title "Contacts | Mautic"
    And I select the new contact button
    Then I am redirected to a page with the title "New Contact | Mautic"
    When I set contact title to <title>
    And I set contact first name to <first_name>
    And I set contact last name to <last_name>
    And I set contact email to <email>
    And I apply the contact changes
    Then the contact title is <title_out>
    And the contact first name is <first_name>
    And the contact last name is <last_name>
    And the contact email is <email>
    Examples:
      |title |first_name |last_name |email            |title_out |
      |Prof  |Kovačević  |Müller    |kova@example.com |Prof |
      |Mr    |Aaron      |Anderson  |aa@example.com   |Mr.  |
