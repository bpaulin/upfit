Feature: session management
  In order to practice
  As an member
  I need to follow exercises

Background:
  Given I am member

Scenario: Member can only manage their own sessions
  Then I should not have access to other users session

Scenario: Member can begin a session from program list
  Given I am on "member" homepage
  Then I should see a link to "/member/program" in "actions" area
  When I follow this link
  Then I should see a link to begin session following "program" "program1"
  When I follow this link
  And I do the followings workouts:
    | exercise  | action  | difficulty  |
    | exercise1 | Abandon | 0           |
    | exercise2 | Pass    | 0           |
    | exercise3 | Done    | 0           |
    | exercise4 | Done    | 0           |
    | exercise5 | Done    | 0           |
    | exercise2 | Done    | 0           |
  # Then I should be on "/member/session/edit"
  And I should see a "success" message "session finished"
    And I fill in session form with the following:
    | name       | session1 |
    | comment    | comment1 |
    | difficulty | 1        |
  And I press "Edit"
  Then I should be on "/member/session"
  And I should see a "success" message "session1 updated"
  And I should see a link to session "session1"

Scenario: Member can begin a session from session list
  Given I am on "member" homepage
  Then I should see a link to "/member/session" in "actions" area
  When I follow this link
  Then I should see a link to begin session following "session" "session1"
  When I follow this link
  And I do the followings workouts:
    | exercise  | action  | difficulty  |
    | exercise3 | Done    | 0           |
    | exercise4 | Done    | 0           |
    | exercise5 | Done    | 0           |
    | exercise2 | Done    | 0           |
  # Then I should be on "/member/session/save"
  And I should see a "success" message "session finished"
    And I fill in session form with the following:
    | name       | session-copy |
    | comment    | comment1     |
    | difficulty | 1            |
  And I press "Edit"
  Then I should be on "/member/session"
  And I should see a "success" message "session-copy updated"
  And I should see a link to session "session1"
  And I should see a link to session "session-copy"
