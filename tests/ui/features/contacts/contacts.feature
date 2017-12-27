Feature: contacts
  In order to send marketing information to people
  As an authorised user
  I need to record and update contact details

  Scenario: directly access the new contact page when not logged in
    Given I go to the new contact page
    Then I should be redirected to a page with the title "Mautic"
    When I login with username "admin" and password "mautic" after a redirect from the "newContact" page
    Then I should be redirected to a page with the title "New Contact | Mautic"

  @fixtures @skipOnFirefox @issue-38
  Scenario Outline: add new contact including selecting a state (problem on firefox 47)
    Given I am logged in as sales
    And I go to the contacts page
    And I am redirected to a page with the title "Contacts | Mautic"
    And I select the new contact button
    Then I am redirected to a page with the title "New Contact | Mautic"
    When I set contact title to <title>
    And I set contact first name to <first_name>
    And I set contact last name to <last_name>
    And I set contact email to <email>
    And I set contact position to <position>
    And I set contact address first line to <address1>
    And I set contact address second line to <address2>
    And I set contact city to <city>
    And I set contact state to <state>
    And I set contact country to <country>
    And I apply the contact changes
    Then the contact title is <title>
    And the contact first name is <first_name>
    And the contact last name is <last_name>
    And the contact email is <email>
    And the contact position is <position>
    And the contact address first line is <address1>
    And the contact address second line is <address2>
    And the contact city is <city>
    And the contact state is <displayed_state_text>
    And the contact country is <country>
    Examples:
      |title |first_name |last_name |email            |position      |address1    |address2    |city   |state          |country        |displayed_state_text         |
      |Prof  |Kovačević  |Müller    |kova@example.com |Manager       |18 Grove Rd |            |Berlin |Bayern         |Germany        |GermanyBayern                |
      |Mr    |Aaron      |Anderson  |aa@example.com   |Admin Officer |Unit 11     |12 Smith St |London |Greater London |United Kingdom |United KingdomGreater London |

  @fixtures
  Scenario Outline: add new contact without state
    Given I am logged in as sales
    And I go to the contacts page
    And I am redirected to a page with the title "Contacts | Mautic"
    And I select the new contact button
    Then I am redirected to a page with the title "New Contact | Mautic"
    When I set contact title to <title>
    And I set contact first name to <first_name>
    And I set contact last name to <last_name>
    And I set contact email to <email>
    And I set contact position to <position>
    And I set contact address first line to <address1>
    And I set contact address second line to <address2>
    And I set contact city to <city>
    And I set contact country to <country>
    And I apply the contact changes
    Then the contact title is <title>
    And the contact first name is <first_name>
    And the contact last name is <last_name>
    And the contact email is <email>
    And the contact position is <position>
    And the contact address first line is <address1>
    And the contact address second line is <address2>
    And the contact city is <city>
    And the contact country is <country>
    Examples:
      |title |first_name |last_name |email |position |address1 |address2 |city |country |
      |Sir   |निर्दोष |व्यक्ति |nepal@example.com |अधिकारी |जीवन सडक |मेरो उपनगर |काठमाडौं |Nepal |
