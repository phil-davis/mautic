@fixtures
Feature: account
  In order to identify myself within Mautic
  As an authorised user
  I want to be able to supply details for my user

  Scenario: modify display name of a user using European names
    Given I am logged in as sales
    And I select the Account topbar entry
    Then I should be redirected to a page with the title "Account | Mautic"
    When I set account first name to "Kovačević"
    And I set account last name to "Müller"
    And I apply the account changes
    And I go to the account page
    Then the account first name is "Kovačević"
    And the account last name is "Müller"
    And the user display name is "Kovačević Müller"

  Scenario: modify display name of a user using other unicode names
    Given I am logged in as sales
    And I select the Account topbar entry
    Then I should be redirected to a page with the title "Account | Mautic"
    When I set account first name to "लोरेम lorem"
    And I set account last name to "नेपाल"
    And I apply the account changes
    And I go to the account page
    Then the account first name is "लोरेम lorem"
    And the account last name is "नेपाल"
    And the user display name is "लोरेम lorem नेपाल"
