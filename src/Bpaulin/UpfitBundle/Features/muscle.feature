Feature: Muscle management
  In order to choose an exercise
  As an member
  I need to consult exercises by muscles

Background:
  Given I am member

Scenario: Members can list muscles
  Given I am on "member" homepage
  Then I should see a link to "/member/muscle" in "actions" area
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon    | label    | link    |
    | home    |          | /       |
    | gamepad | Member   | /member |
    |         | Muscles  |         |
  And I should see a link to following muscles:
    | muscle  |
    | muscle1 |
    | muscle2 |
  When I follow the last link
  Then I should see the following breadcrumbs:
    | icon     | label   | link           |
    | home     |         | /              |
    | gamepad  | Member  | /member        |
    | list     | Muscles | /member/muscle |
    |          | muscle2 |                |
  And I should see "muscle2" as "name"
