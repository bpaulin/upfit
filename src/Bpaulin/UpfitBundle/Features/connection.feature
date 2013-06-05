Feature: Authentification
  In order to use upfit
  As a visitor
  I need to authenticate myself

Scenario Outline: Visitor should be able to login and logout to access member section
  Given I am on homepage
   Then I should see a link to "/login" in "connection" area
   When I follow this link
    And I fill in the following:
        | username | <user> |
        | password | <user> |
    And I press "Login"
   Then I should be on "<user>" homepage
    And I should see "<user>" in "connection" area
   When I go to homepage
   Then I should see a link to "/member"
   When I follow this link
   Then I should see a link to "/logout" in "connection" area
   When I follow this link
   Then I should be on homepage
  Examples:
    | user   |
    | member |
    | admin  |

Scenario: Administator should be able to access administration section
  Given I am on homepage
  Given I am "admin"
   When I go to homepage
   Then I should see a link to "/admin"
   When I follow this link
   Then I should be on "admin" homepage
