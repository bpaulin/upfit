@wip
Feature: session management
  In order to practice
  As an member
  I need to follow exercises

Background:
  Given I am member

Scenario: Member can only manage their own sessions
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
