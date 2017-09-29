@fixtures
Feature: account
  In order to identify myself within Mautic
  As an authorised user
  I want to be able to supply details for my user

  Scenario Outline: modify display name of a user
    Given I am logged in as sales
    And I select the Account topbar entry
    Then I should be redirected to a page with the title "Account | Mautic"
    When I set account first name to <first_name>
    And I set account last name to <last_name>
    And I apply the account changes
    And I go to the account page
    Then the account first name is <first_name>
    And the account last name is <last_name>
    And the user display name is <display_name>
    Examples:
    |first_name |last_name |display_name |
    |"Kovačević" |"Müller" |"Kovačević Müller" |
    |"लोरेम lorem" |"नेपाल" |"लोरेम lorem नेपाल" |
    |"أسد" |"حسن" |"أسد حسن" |
    |"hyphen-ated" |"last-name" |"hyphen-ated last-name" |
    |"weird@x.com #! <b>" |"[^*+$]\/ '?'" |"weird@x.com #! <b> [^*+$]\/ '?'" |
