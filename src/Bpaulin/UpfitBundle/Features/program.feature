@wip
Feature: program management
  In order to manage programs
  As an administator
  I need to perform crud operations to programs

Background:
  Given I am admin
  And a program named "program1" with following stages:
    | exercise    | sets | number  | unit        | difficulty | unit  |
    | pushup      | 1    | 30      | seconds     |            |       |
    | pushup      | 2    | 15      | repetitions |            |       |
    | pull        | 2    | 15      | repetitions | 5          | kilos |
    | bike        | 1    | 30      | kilometers  |            |       |
    | bike        | 2    | 60      | minutes     |            |       |

Scenario: Administrator can read programs
  Given I am on "admin" homepage
  Then I should see a link to "/admin/program" in "actions" area
  When I follow this link
  Then I should see a link to program "program1"
  When I follow this link
  Then I should see a link to "/admin/program"

Scenario: Administrator can update programs
  Given I am on program "program1" page
  Then I should see a link to edit program "program1"
  When I follow this link
  And I fill in "program" form with the following:
    | name |  |
  And I press "Edit"
  And I fill in "program" form with the following:
    | name | program3 |
  And I press "Edit"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program3 updated"
  And I should see a link to program "program3"
  And I should not see a link to program "program1"

Scenario: Administrator can create programs
  Given I am on "/admin/program"
  Then I should see a link to create program
  When I follow this link
  And I fill in "program" form with the following:
    | name |  |
  And I press "Create"
  And I fill in "program" form with the following:
    | name | program4 |
  And I press "Create"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program4 created"
  And I should see a link to program "program4"

Scenario: Administrator can delete programs
  Given I am on program "program1" page
  Then I should see a link to delete program "program1"
  When I follow this link
  And I press "Delete"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program1 deleted"
  And I should not see a link to program "program1"



