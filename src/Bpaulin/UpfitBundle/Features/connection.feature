Feature: Authentification
  In order to use upfit
  As a visitor
  I need to authenticate myself

Background:
  Given a administrator named "admin"
    And a member named "member"


Scenario Outline: Visitor should be able to go to login page
  Given I am on homepage
   Then I should see a link to "/login" in "connection" area
   When I follow this link
    And I fill in the following
    | username | password |
    | <user>   | <user>   |
    And I press "submit"
   Then I should be on "<user>" homepage
    And I should see a "success" in "notification" area
    And I should see "<user>" in "connection" area

  Examples:
    | user   |
    | member |
    | admin  |
