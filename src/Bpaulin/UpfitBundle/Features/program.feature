@wip
Feature: program management
  In order to manage programs
  As an administator
  I need to perform crud operations to programs

Background:
  Given I am admin

Scenario: Administrator can read programs
  Given I am on "admin" homepage
  Then I should see a link to "/admin/program" in "actions" area
  When I follow this link
  Then I should see a link to following programs:
    | program  |
    | program1 |
    | program2 |
    | program3 |
    | program4 |
    | program5 |
  When I follow this link
  Then I should see "program5" as "name"
  And I should see the following stages:
  | stages |
    | exercise1 (1*1 1 with 1 1) |
    | exercise2 (2*2 2 with 2 2) |
    | exercise3 (3*3 3 with 3 3) |
    | exercise4 (4*4 4 with 4 4) |
    | exercise5 (5*5 5 with 5 5) |
  Then I should see a link to "/admin/program"

Scenario: Administrator can update programs
  Given I am on program "program1" page
  Then I should see a link to edit program "program1"
  When I follow this link
  And I fill in "program" form with the following:
    | name | program6 |
  And I press "Edit"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program6 updated"
  And I should not see a link to program "program1"
  And I should see a link to program "program6"
  When I follow this link
  Then I should see "program6" as "name"

@javascript
Scenario: Administrator can create programs
  Given I am on "/admin/program"
  Then I should see a link to create program
  When I follow this link
  And I fill in "program" form with the following:
    | name | program7 |
  And I follow "Add a stage"
  And I fill in last stage form with the following:
    | exercise       | exercise1   |
    | position       | 1           |
    | sets           | 5           |
    | number         | 15          |
    | unit           | repetitions |
    | difficulty     | 5           |
    | difficultyUnit | kilos       |
  And I press "Create"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program7 created"
  And I should see a link to program "program7"
  When I follow this link
  Then I should see "program7" as "name"
  And I should see the following stages:
  | stages |
    | exercise1 (5*15 repetitions with 5 kilos) |

Scenario: Administrator can delete programs
  Given I am on program "program2" page
  Then I should see a link to delete program "program2"
  When I follow this link
  And I press "Delete"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program2 deleted"
  And I should not see a link to program "program2"

Scenario: Administrator can delete stage
  Given I am on program "program3" page
  Then I should see a link to edit program "program3"
  When I follow this link
  And I follow "Delete this stage" for stage "2"
  And I press "Edit"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program3 updated"
  And I should see a link to program "program3"
  When I follow this link
  Then I should see "program3" as "name"
  And I should see the following stages:
  | stages |
    | exercise1 (1*1 1 with 1 1) |
    | exercise2 (2*2 2 with 2 2) |
    | exercise4 (4*4 4 with 4 4) |
    | exercise5 (5*5 5 with 5 5) |
