@wip
Feature: session management
  In order to practice
  As an member
  I need to follow exercises

Background:
  Given I am member

Scenario: Member can begin a session from program list
  Given I am on "/member/program"
  Then I should see a link to begin session following "program" "program1"
  When I follow this link
  Then I should be on "exercise1" workout page
  When I follow "Abandon"
  Then I should see a "info" message "exercise1 abandonned"
  And I should be on "exercise2" workout page
  When I follow "Pass"
  Then I should see a "info" message "exercise2 passed"
  And I should be on "exercise3" workout page
  When I follow "Done"
  Then I should be on "exercise4" workout page
  When I follow "Done"
  Then I should be on "exercise5" workout page
  When I follow "Done"
  Then I should be on "exercise2" workout page
  When I follow "Done"
  # Then I should be on "/member/session/edit"
  And I should see a "success" message "session finished"
    And I fill in session form with the following:
    | name       | session1   |
    | comment    | comment1   |
    | difficulty | 1          |
  And I press "Edit"
  Then I should be on "/member/session"
  And I should see a "success" message "session1 updated"
  And I should see a link to session "session1"

Scenario: Member can only manage their own sessions
  Then I should not have access to other users session

# Scenario: Member can begin a session from session list
#   Given I am on "/member/session"
#   Then I should see a link to begin session following "session" "session1"
#   When I follow this link
#   Then I should be on "exercise3" workout page
#   When I follow "Done"
#   Then I should be on "exercise4" workout page
#   When I follow "Done"
#   Then I should be on "exercise5" workout page
#   When I follow "Done"
#   Then I should be on "exercise2" workout page
#   When I follow "Done"
#   Then I should be on "/member/session/save"
#   And I should see a "success" message "session finished"
#     And I fill in session form with the following:
#     | name       | session1   |
#     | comment    | comment1   |
#     | difficulty | 1          |
#   And I press "Save"
#   Then I should be on "/member/session"
#   Then I should see a "success" message "session finished"
