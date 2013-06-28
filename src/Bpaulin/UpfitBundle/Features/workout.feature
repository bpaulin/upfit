Feature: workout management
  In order to practice
  As an member
  I need to follow exercises

Background:
  Given I am member

Scenario: Member can begin a session from program list
  Given I am on "member" homepage
  Then I should see a link to "/member/program" in "actions" area
  When I follow this link
  Then I should see a link to begin session following "program" "program1"
  When I follow this link
  Then I should be on "exercise1" workout page
  When I press "Abandon"
  Then I should see a "info" message "exercise1 abandoned"
  And I should be on "exercise2" workout page
  When I press "Pass"
  Then I should see a "info" message "exercise2 passed"
  And I should be on "exercise3" workout page
  When I fill in workout form with the following:
    | grade | 1 |
  And I press "Done"
  Then I should be on "exercise4" workout page
  And I should see following workouts:
    | exercise  | status      | grade |
    | exercise1 | Abandoned   | 0     |
    | exercise3 | Done        | 1     |
    | exercise4 | Current     | 0     |
    | exercise5 | Todo        | 0     |
    | exercise2 | Todo        | 0     |
  When I press "Done"
  Then I should be on "exercise5" workout page
  And I should see following workouts:
    | exercise  | status      | grade |
    | exercise1 | Abandoned   | 0     |
    | exercise3 | Done        | 1     |
    | exercise4 | Done        | 0     |
    | exercise5 | Current     | 0     |
    | exercise2 | Todo        | 0     |
  When I fill in workout form with the following:
    | grade | -1 |
  And I press "Done"
  Then I should be on "exercise2" workout page
  And I should see following workouts:
    | exercise  | status      | grade |
    | exercise1 | Abandoned   | 0     |
    | exercise3 | Done        | 1     |
    | exercise4 | Done        | 0     |
    | exercise5 | Done        | -1    |
    | exercise2 | Current     | 0     |
  When I fill in workout form with the following:
    | grade | 2 |
  And I press "Done"
  Then I should see a "success" message "session finished"
  And I should see following workouts:
    | exercise  | status      | grade |
    | exercise1 | Abandoned   | 0     |
    | exercise3 | Done        | 1     |
    | exercise4 | Done        | 0     |
    | exercise5 | Done        | -1    |
    | exercise2 | Done        | 2     |
  Then the "bpaulin_upfitbundle_sessiontype_name" field should contain "following program1"
  Then the "bpaulin_upfitbundle_sessiontype_grade" field should contain "1"
  When I fill in session form with the following:
    | name    | session new |
    | comment | comment new |
    | grade   | 1           |
  And I press "Edit"
  Then I should be on "/member/session"
  And I should see a "success" message "session new updated"
  And I should see a link to session "session new"

Scenario: Member can begin a session from session list
  Given I am on "member" homepage
  Then I should see a link to "/member/session" in "actions" area
  When I follow this link
  Then I should see a link to begin session following "session" "session1"
  When I follow this link
  And I do the followings workouts:
    | exercise  | action  | grade  |
    | exercise1 | Abandon | -1     |
    | exercise2 | Pass    | -1     |
    | exercise3 | Done    | -1     |
    | exercise4 | Done    | -1     |
    | exercise5 | Done    | -1     |
    | exercise2 | Done    | -1     |
  And I should see a "success" message "session finished"
  And I should see following workouts:
    | exercise  | status     | grade |
    | exercise1 | Abandoned  | -1    |
    | exercise3 | Done       | -1    |
    | exercise4 | Done       | -1    |
    | exercise5 | Done       | -1    |
    | exercise2 | Done       | -1    |
  Then the "bpaulin_upfitbundle_sessiontype_name" field should contain "following session1"
  Then the "bpaulin_upfitbundle_sessiontype_grade" field should contain "-1"
  And I fill in session form with the following:
    | name    | session-copy |
    | comment | comment1     |
    | grade   | 1            |
  And I press "Edit"
  Then I should be on "/member/session"
  And I should see a "success" message "session-copy updated"
  And I should see a link to session "session1"
  And I should see a link to session "session-copy"

Scenario: Member cant begin a session from an unfinished session
  Given I am on "member" homepage
  Then I should see a link to "/member/session" in "actions" area
  When I follow this link
  Then I should not see a link to begin session following "session" "session unfinished"

@wip
Scenario: Members can resume sessions
  Given I am on "/member/session"
  Then I should see a link to resume session "session unfinished"
  When I follow this link
  And I do the followings workouts:
    | exercise  | action  | grade  |
    | exercise1 | Done    | -1     |
    | exercise2 | Done    | -1     |
    | exercise3 | Done    | -1     |
    | exercise4 | Done    | -1     |
    | exercise5 | Done    | -1     |
  And I should see a "success" message "session finished"
  And I fill in session form with the following:
    | name    | session-finished |
    | comment | comment1         |
    | grade   | 1                |
  And I press "Edit"
  Then I should be on "/member/session"
  And I should see a "success" message "session-finished updated"
  And I should see a link to session "session-finished"
