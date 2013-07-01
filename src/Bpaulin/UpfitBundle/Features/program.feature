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
  When I follow the last link
  Then I should see "program1" as "name"
  And I should see the following stages:
    | stages |
    | exercise1 (1*1 1 with 1 1) |
    | exercise2 (2*2 2 with 2 2) |
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
  And I click on add a stage
  And I fill in last stage form with the following:
    | exercise       | exercise1   |
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
  Given I am on program "program1" page
  Then I should see a link to delete program "program1"
  When I follow this link
  And I press "Delete"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program1 deleted"
  And I should not see a link to program "program1"

@javascript
Scenario: Administrator can delete stage
  Given I am on program "program1" page
  Then I should see a link to edit program "program1"
  When I follow this link
  And I click delete on stage "1"
  And I press "Edit"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program1 updated"
  And I should see a link to program "program1"
  When I follow this link
  Then I should see "program1" as "name"
  And I should see the following stages:
    | stages |
    | exercise1 (1*1 1 with 1 1) |
  And I should not see the following stages:
    | stages |
    | exercise2 (2*2 2 with 2 2) |

@javascript
Scenario: Administrator can sort stages
  Given I am on program "program1" page
  Then I should see a link to edit program "program1"
  When I follow this link
  And I drag stage "0" down "2" position
  And I press "Edit"
  Then I should be on "/admin/program"
  And I should see a "success" message "program program1 updated"
  And I should see a link to program "program1"
  When I follow this link
  Then I should see "program1" as "name"
  And I should see the following stages:
    | stages |
    | exercise2 (2*2 2 with 2 2) |
    | exercise1 (1*1 1 with 1 1) |
