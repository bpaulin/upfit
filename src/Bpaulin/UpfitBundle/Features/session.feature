@wip
Feature: session management
  In order to practice
  As an member
  I need to follow exercises

Background:
  Given I am member

Scenario: Member can only manage their sessions
  Then I should not have access to other users session

Scenario: Members can read their old sessions
  Given I am on "member" homepage
  Then I should see a link to "/member/session" in "actions" area
  When I follow this link
  Then I should see a link to following sessions:
    | session             |
    | session1            |
    | session unfinished  |
  When I follow the last link
  Then I should see following workouts:
    | exercise  | status     | grade |
    | exercise1 | Todo       | 0     |
    | exercise2 | Todo       | 0     |
    | exercise3 | Todo       | 0     |
    | exercise4 | Todo       | 0     |
    | exercise5 | Todo       | 0     |

Scenario: Members can update sessions
  Given I am on session "session1" page
  Then I should see a link to edit session "session1"
  When I follow this link
  And I fill in "session" form with the following:
    | name | session6 |
  And I press "Edit"
  Then I should be on "/member/session"
  And I should see a "success" message "Session session6 updated"
  And I should not see a link to session "session1"
  And I should see a link to session "session6"
  When I follow this link
  Then I should see "session6" as "name"

Scenario: Members can delete sessions
  Given I am on session "session1" page
  Then I should see a link to delete session "session1"
  When I follow this link
  And I press "Delete"
  Then I should be on "/member/session"
  And I should see a "success" message "Session session1 deleted"
  And I should not see a link to session "session1"
