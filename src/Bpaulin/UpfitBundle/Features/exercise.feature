Feature: Exercise management
  In order to manage exercises
  As an administator
  I need to perform crud operations to exercises

Background:
  Given I am admin
  And an exercise named "exercise1"
  And an exercise named "exercise2"

Scenario: Administrator can read exercises
  Given I am on "admin" homepage
  Then I should see a link to "/admin/exercise" in "actions" area
  When I follow this link
  Then I should see a link to following exercises
    | exercise |
    | exercise1 |
    | exercise2 |
  When I follow this link
  Then I should see a link to "/admin/exercise"

Scenario: Administrator can update exercises
  Given I am on exercise "exercise1" page
  Then I should see a link to edit exercise "exercise1"
  When I follow this link
  And I fill in "exercise" form with the following:
    | name |  |
  And I press "Edit"
  And print last response
  And I fill in "exercise" form with the following:
    | name | exercise3 |
  And I press "Edit"
  Then I should be on "/admin/exercise"
  And I should see a "success" message "Exercise exercise3 updated"
  And I should see a link to exercise "exercise3"
  And I should not see a link to exercise "exercise1"

Scenario: Administrator can create exercises
  Given I am on "/admin/exercise"
  Then I should see a link to create exercise
  When I follow this link
  And I fill in "exercise" form with the following:
    | name |  |
  And I press "Create"
  And I fill in "exercise" form with the following:
    | name | exercise4 |
  And I press "Create"
  Then I should be on "/admin/exercise"
  And I should see a "success" message "Exercise exercise4 created"
  And I should see a link to exercise "exercise4"

Scenario: Administrator can delete exercises
  Given I am on exercise "exercise1" page
  Then I should see a link to delete exercise "exercise1"
  When I follow this link
  And I press "Delete"
  Then I should be on "/admin/exercise"
  And I should see a "success" message "Exercise exercise1 deleted"
  And I should not see a link to exercise "exercise1"



