Feature: account
  In order to identify myself within Mautic
  As an authorised user
  I want to be able to supply details for my user

  @fixtures
  Scenario: change passwword
    Given I am logged in as sales
    And I select the Account topbar entry
    And I am redirected to a page with the title "Account | Mautic"
    When I set account password to "qwe@478!"
    And I apply the account changes
    And I logout
    When I login with username "sales" and invalid password "mautic"
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "sales" and password "qwe@478!"
    Then I should be redirected to a page with the title "Dashboard | Mautic"

  Scenario: input too short a password
    Given I am logged in as sales
    And I select the Account topbar entry
    And I am redirected to a page with the title "Account | Mautic"
    When I set account password to "short"
    And I apply the account changes
    Then near the password field a message should be displayed "Password must be at least 6 characters"

  Scenario: input non-matching password and confirm password
    Given I am logged in as sales
    And I select the Account topbar entry
    And I am redirected to a page with the title "Account | Mautic"
    When I set account password to "something" and confirm password to "different"
    And I apply the account changes
    Then near the password field a message should be displayed "Passwords do not match"

  @fixtures
  Scenario Outline: modify display name of a user
    Given I am logged in as sales
    And I select the Account topbar entry
    And I am redirected to a page with the title "Account | Mautic"
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

  @fixtures
  Scenario: modify locale-language
    Given I am logged in as sales
    And I select the Account topbar entry
    Then I should be redirected to a page with the title "Account | Mautic"
    When I set account language to "German"
    And I apply the account changes
    And I go to the account page
    Then the account language is "German"
    And the account language title is "Sprache"
