Feature: Navigate using the sidebar
  In order to access Mautic application settings
  As a user
  I want to be able to navigate between pages

  Scenario: navigate through the sidebar pages
    Given I am logged in as admin
    And I am on the dashboard page
    When I select the Calendar sidebar entry
    Then I should be redirected to a page with the title "Calendar | Mautic"
    When I select the Contacts sidebar entry
    Then I should be redirected to a page with the title "Contacts | Mautic"
    When I select the Companies sidebar entry
    Then I should be redirected to a page with the title "Companies | Mautic"
    When I select the Segments sidebar entry
    Then I should be redirected to a page with the title "Contact Segments | Mautic"
    When I select the Components sidebar entry and Assets sub-entry
    Then I should be redirected to a page with the title "Assets | Mautic"
    When I select the Forms sidebar sub-entry of the Components sidebar entry
    Then I should be redirected to a page with the title "Forms | Mautic"
    When I select the "Landing Pages" sidebar sub-entry of the Components sidebar entry
    Then I should be redirected to a page with the title "Landing Pages | Mautic"
    When I select the "Dynamic Content" sidebar sub-entry of the Components sidebar entry
    Then I should be redirected to a page with the title "Dynamic Content | Mautic"
    When I select the Campaigns sidebar entry
    Then I should be redirected to a page with the title "Campaigns | Mautic"
    When I select the Channels sidebar entry and "Marketing Messages" sub-entry
    Then I should be redirected to a page with the title "Marketing Messages | Mautic"
    When I select the Emails sidebar sub-entry of the Channels sidebar entry
    Then I should be redirected to a page with the title "Emails | Mautic"
    When I select the "Focus Items" sidebar sub-entry of the Channels sidebar entry
    Then I should be redirected to a page with the title "Focus Items | Mautic"
    When I select the "Social Monitoring" sidebar sub-entry of the Channels sidebar entry
    Then I should be redirected to a page with the title "Social Monitoring | Mautic"
    When I select the Points sidebar entry and "Manage Actions" sub-entry
    Then I should be redirected to a page with the title "Points | Mautic"
    When I select the "Manage Triggers" sidebar sub-entry of the Points sidebar entry
    Then I should be redirected to a page with the title "Point Triggers | Mautic"
    When I select the Stages sidebar entry
    Then I should be redirected to a page with the title "Stages | Mautic"
    When I select the Reports sidebar entry
    Then I should be redirected to a page with the title "Reports | Mautic"
    When I select the Dashboard sidebar entry
    Then I should be redirected to a page with the title "Dashboard | Mautic"

  Scenario: start at a different main page and navigate from there
    Given I go to the calendar page
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "mauticadmin" and password "admin123" after a redirect from the "contacts" page
    Then I should be redirected to a page with the title "Calendar | Mautic"
    When I select the Components sidebar entry and Forms sub-entry
    Then I should be redirected to a page with the title "Forms | Mautic"
    When I select the Reports sidebar entry
    Then I should be redirected to a page with the title "Reports | Mautic"

  Scenario: start at a sub-entry page and navigate from there
    Given I go to the social monitoring page
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "mauticadmin" and password "admin123" after a redirect from the "social monitoring" page
    Then I should be redirected to a page with the title "Social Monitoring | Mautic"
    When I select the Components sidebar entry and "Landing Pages" sub-entry
    Then I should be redirected to a page with the title "Landing Pages | Mautic"
    When I select the Companies sidebar entry
    Then I should be redirected to a page with the title "Companies | Mautic"
