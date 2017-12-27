Feature: Navigate using the top bar
  In order to access Mautic account and system settings
  As a user
  I want to be able to navigate to the relevant UI pages

  Scenario: navigate to the personal account settings
    Given I am logged in as admin
    And I am on the dashboard page
    When I select the Account topbar entry
    Then I should be redirected to a page with the title "Account | Mautic"

  Scenario: navigate the entries in the settings panel
    Given I am logged in as admin
    When I open the settings panel
    And I select the Webhooks settings entry
    Then I should be redirected to a page with the title "Webhooks | Mautic"
    When I open the settings panel
    And I select the Users settings entry
    Then I should be redirected to a page with the title "Users | Mautic"
    When I open the settings panel
    And I select the Themes settings entry
    Then I should be redirected to a page with the title "Themes | Mautic"
    When I open the settings panel
    And I select the "System Info" settings entry
    Then I should be redirected to a page with the title "System Info | Mautic"
    When I open the settings panel
    And I select the Categories settings entry
    Then I should be redirected to a page with the title "Categories | Mautic"
    When I open the settings panel
    And I select the Roles settings entry
    Then I should be redirected to a page with the title "Roles | Mautic"
    When I open the settings panel
    And I select the "Custom Fields" settings entry
    Then I should be redirected to a page with the title "Custom Fields | Mautic"
    When I open the settings panel
    And I select the Plugins settings entry
    Then I should be redirected to a page with the title "Manage Plugins | Mautic"

  Scenario: navigate to the configuration settings page
    Given I am logged in as admin
    When I open the settings panel
    And I select the Configuration settings entry
    Then I should be redirected to a page with the title "Configuration | Mautic" within 60 seconds
