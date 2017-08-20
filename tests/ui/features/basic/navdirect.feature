Feature: Navigate directly using the page URLs
  In order to access particular Mautic application settings directly from browser bookmarks or history
  As a user
  I want to be able to navigate to Mautic pages directly from the URL bar

  Background:
    Given I am logged in as admin

  Scenario: navigate to the Calendar and then Social Monitoring pages directly using the URL
    When I go to the calendar page
    Then I should be redirected to a page with the title "Calendar | Mautic"
    When I go to the social monitoring page
    Then I should be redirected to a page with the title "Social Monitoring | Mautic"

  Scenario: navigate to the Point Triggers and then Forms pages directly using the URL
    When I go to the point triggers page
    Then I should be redirected to a page with the title "Point Triggers | Mautic"
    When I go to the forms page
    Then I should be redirected to a page with the title "Forms | Mautic"

  Scenario: navigate to the other pages directly using the URL
    When I go to the assets page
    Then I should be redirected to a page with the title "Assets | Mautic"
    When I go to the campaigns page
    Then I should be redirected to a page with the title "Campaigns | Mautic"
    When I go to the companies page
    Then I should be redirected to a page with the title "Companies | Mautic"
    When I go to the contacts page
    Then I should be redirected to a page with the title "Contacts | Mautic"
    When I go to the dashboard page
    Then I should be redirected to a page with the title "Dashboard | Mautic"
    When I go to the dynamic content page
    Then I should be redirected to a page with the title "Dynamic Content | Mautic"
    When I go to the emails page
    Then I should be redirected to a page with the title "Emails | Mautic"
    When I go to the focus items page
    Then I should be redirected to a page with the title "Focus Items | Mautic"
    When I go to the landing pages page
    Then I should be redirected to a page with the title "Landing Pages | Mautic"
    When I go to the marketing messages page
    Then I should be redirected to a page with the title "Marketing Messages | Mautic"
    When I go to the points page
    Then I should be redirected to a page with the title "Points | Mautic"
    When I go to the reports page
    Then I should be redirected to a page with the title "Reports | Mautic"
    When I go to the segments page
    Then I should be redirected to a page with the title "Contact Segments | Mautic"
    When I go to the stages page
    Then I should be redirected to a page with the title "Stages | Mautic"

