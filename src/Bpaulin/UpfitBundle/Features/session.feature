Feature: session management
  In order to practice
  As an member
  I need to follow exercises

Background:
  Given I am member

Scenario: Members can list their old sessions
  Given I am on "member" homepage
  Then I should see a link to "/member/session" in "actions" area
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon    | label    | link    |
    | home    |          | /       |
    | gamepad | Member   | /member |
    |         | Sessions |         |
  And I should see a link to following sessions:
    | session             |
    | session1            |
    | session unfinished  |

Scenario: Members can read a session
  Given I am on session "session unfinished" page
  Then I should see the following breadcrumbs:
    | icon    | label              | link            |
    | home    |                    | /               |
    | gamepad | Member             | /member         |
    | list    | Sessions           | /member/session |
    |         | session unfinished |                 |
  And I should see the following actions:
    | type    | icon      | label  | link                          |
    | primary | play      | Resume | /member/session/3/workout     |
    |         | edit      | Edit   | /member/session/3/edit        |
    | danger  | minus     | Delete | /member/session/3/delete      |
  And I should see following workouts:
    | exercise  | status  | grade |
    | exercise1 | Current |       |
    | exercise2 | Todo    |       |
  Given I am on session "session1" page
  And I should see the following actions:
    | type    | icon      | label  | link                          |
    | primary | edit      | Edit   | /member/session/1/edit        |
    |         | repeat    | Follow | /member/session/new/session/1 |
    | danger  | minus     | Delete | /member/session/1/delete      |

Scenario: Members can update sessions
  Given I am on session "session1" page
  Then I should see a link to edit session "session1"
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon    | label              | link              |
    | home    |                    | /                 |
    | gamepad | Member             | /member           |
    | list    | Sessions           | /member/session   |
    |         | session1           | /member/session/1 |
    |         | Edit               |                   |
  When I fill in "session" form with the following:
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
  Then I should see the following breadcrumbs:
    | icon    | label              | link              |
    | home    |                    | /                 |
    | gamepad | Member             | /member           |
    | list    | Sessions           | /member/session   |
    |         | session1           | /member/session/1 |
    |         | Delete             |                   |
  When I press "Delete"
  Then I should be on "/member/session"
  And I should see a "success" message "Session session1 deleted"
  And I should not see a link to session "session1"

Scenario: Members should be warned if they have unfinished sessions
  Given I am on "member" homepage
  Then I should see a link to session "session unfinished" in "message" area
  Given I am on "member/program"
  Then I should see a link to session "session unfinished" in "message" area
  Given I am on "member/session"
  Then I should see a link to session "session unfinished" in "message" area

Scenario: Member can only manage their sessions
  Then I should not have access to other users session
