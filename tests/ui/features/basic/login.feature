Feature: login
  In order to access Mautic
  As an authorised user
  I want to be able to authenticate myself with a username and password

  @skip @to-be-implemented
  Scenario: simple user login
    Given a regular user exists
    And I am on the login page
    When I login as a regular user with a correct password
    Then I should be redirected to a page with the title "Dashboard | Mautic"

  Scenario: admin login
    Given I am on the login page
    When I login with username "admin" and password "mautic"
    Then I should be redirected to a page with the title "Dashboard | Mautic"

  Scenario: admin login with invalid password
    Given I am on the login page
    When I login with username "admin" and invalid password "invalidpassword"
    Then I should be redirected to a page with the title "Mautic"

  Scenario: access the contacts page when not logged in
    Given I go to the contacts page
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "admin" and password "mautic" after a redirect from the "contacts" page
    Then I should be redirected to a page with the title "Contacts | Mautic"

  Scenario: access the contacts page when not logged in using incorrect then correct password
    Given I go to the contacts page
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "admin" and invalid password "qwerty"
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "admin" and password "mautic" after a redirect from the "contacts" page
    Then I should be redirected to a page with the title "Contacts | Mautic"