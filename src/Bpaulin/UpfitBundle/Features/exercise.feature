Feature: Exercise management
  In order to manage exercises
  As an administator
  I need to perform crud operations to exercises

Background:
  Given I am admin

Scenario: Administrator can read exercises
  Given I am on "admin" homepage
  Then I should see a link to "/admin/exercise" in "actions" area
  When I follow this link
  Then I should see a link to following exercises:
    | exercise  |
    | exercise1 |
    | exercise2 |
    | exercise3 |
    | exercise4 |
    | exercise5 |
  When I follow this link
  Then I should see a link to "/admin/exercise"
  And I should see "exercise5" as "name"

Scenario: Administrator can update exercises
  Given I am on exercise "exercise1" page
  Then I should see a link to edit exercise "exercise1"
  When I follow this link
  And I fill in "exercise" form with the following:
    | name | exercise6 |
  And I press "Edit"
  Then I should be on "/admin/exercise"
  And I should see a "success" message "Exercise exercise6 updated"
  And I should not see a link to exercise "exercise1"
  And I should see a link to exercise "exercise6"
  When I follow this link
  Then I should see "exercise6" as "name"

Scenario: Administrator can create exercises
  Given I am on "/admin/exercise"
  Then I should see a link to create exercise
  When I follow this link
  And I fill in "exercise" form with the following:
    | name |  |
  And I press "Create"
  And I fill in "exercise" form with the following:
    | name | exercise7 |
  And I press "Create"
  Then I should be on "/admin/exercise"
  And I should see a "success" message "Exercise exercise7 created"
  And I should see a link to exercise "exercise7"
  When I follow this link
  Then I should see "exercise7" as "name"

Scenario: Administrator can delete exercises
  Given I am on exercise "exercise2" page
  Then I should see a link to delete exercise "exercise2"
  When I follow this link
  And I press "Delete"
  Then I should be on "/admin/exercise"
  And I should see a "success" message "Exercise exercise2 deleted"
  And I should not see a link to exercise "exercise2"



