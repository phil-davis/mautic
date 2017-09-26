Feature: Navigate using the top bar
  In order to access Mautic account and system settings
  As a user
  I want to be able to navigate to the relevant UI pages

  Scenario: navigate to the personal account settings
    Given I am logged in as admin
    And I am on the dashboard page
    When I select the Account topbar entry
    Then I should be redirected to a page with the title "Account | Mautic"
