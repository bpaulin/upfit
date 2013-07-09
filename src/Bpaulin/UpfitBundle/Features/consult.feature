Feature: members can consult programs
  In order to choose a program
  As an member
  I need to list and display programs

Background:
  Given I am member

Scenario: Member can read programs
  Given I am on "member" homepage
  Then I should see a link to "/member/program" in "actions" area
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon    | label    | link    |
    | home    |          | /       |
    | gamepad | Member   | /member |
    |         | Programs |         |
  And I should not see a link to any page for "admin"
  And I should see a link to consult following programs:
    | program  |
    | program1 |
  When I follow the last link
  Then I should see the following breadcrumbs:
    | icon    | label    | link            |
    | home    |          | /               |
    | gamepad | Member   | /member         |
    | list    | Programs | /member/program |
    |         | program1 |                 |
  And I should see the following actions:
    | type    | icon      | label  | link                          |
    | primary | play      | Follow | /member/session/new/program/1 |
  And I should see "program1" as "name"
  And I should not see a link to any page for "admin"
  And I should see the following stages:
    | stages |
    | exercise1 (1*1 1 with 1 1) |
    | exercise2 (2*2 2 with 2 2) |
  And I should see a link to "/member/program"
