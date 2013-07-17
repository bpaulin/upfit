Feature: Muscle management
  In order to choose an exercise
  As an member
  I need to consult exercises by muscles

Background:
  Given I am member

Scenario: Members can update objectives
  Given I am on "member" homepage
  Then I should see a link to "/member/objectives" in "actions" area
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon    | label    | link    |
    | home    |          | /       |
    | gamepad | Member   | /member |
    |         | Objectives  |         |
  When I fill in objectives form with the following:
    | muscle  | will  |
    | muscle1 | 1     |
    | muscle2 | -1    |
  And I press "Edit"
  Then I should see a "success" message "Objectives updated"
  And objectives form should be filled with the following:
    | muscle  | will  |
    | muscle1 | 1     |
    | muscle2 | -1    |
