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
  Then I should not see a link to any page for "admin"
  And I should see a link to consult following programs:
    | program  |
    | program1 |
    | program2 |
    | program3 |
    | program4 |
    | program5 |
  When I follow this link
  Then I should see "program5" as "name"
  And I should not see a link to any page for "admin"
  And I should see the following stages:
  | stages |
    | exercise1 (1*1 1 with 1 1) |
    | exercise2 (2*2 2 with 2 2) |
    | exercise3 (3*3 3 with 3 3) |
    | exercise4 (4*4 4 with 4 4) |
    | exercise5 (5*5 5 with 5 5) |
  Then I should see a link to "/member/program"
