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
  Then I should see the following breadcrumbs:
    | icon      | label     | link    |
    | home      |           | /       |
    | briefcase | Admin     | /admin  |
    |           | Exercises |         |
  And I should see the following actions:
    | type    | icon      | label     | link                |
    |         | plus      | Add       | /admin/exercise/new |
  And I should see a link to following exercises:
    | exercise  |
    | exercise2 |
    | exercise1 |
  When I follow the last link
  Then I should see the following breadcrumbs:
    | icon      | label     | link            |
    | home      |           | /               |
    | briefcase | Admin     | /admin          |
    | list      | Exercises | /admin/exercise |
    |           | exercise1 |                 |
  And I should see the following actions:
    | type    | icon      | label     | link                     |
    | primary | edit      | Edit      | /admin/exercise/1/edit   |
    | danger  | minus     | Delete    | /admin/exercise/1/delete |
  Then I should see a link to "/admin/exercise"
  And I should see "exercise1" as "name"
  And I should see the following intensities:
    | muscle | intensity |
    | muscle1 | 1 |

Scenario: Administrator can update exercises
  Given I am on exercise "exercise1" page
  Then I should see a link to edit exercise "exercise1"
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon      | label     | link              |
    | home      |           | /                 |
    | briefcase | Admin     | /admin            |
    | list      | Exercises | /admin/exercise   |
    |           | exercise1 | /admin/exercise/1 |
    |           | Edit      |                   |
  When I fill in "exercise" form with the following:
    | name | exercise6 |
  When I fill in intensities form with the following:
    | muscle  | will  |
    | muscle1 | 0     |
    | muscle2 | -1    |
  And I press "Edit"
  Then I should be on "/admin/exercise"
  And I should see a "success" message "Exercise exercise6 updated"
  And I should not see a link to exercise "exercise1"
  And I should see a link to exercise "exercise6"
  When I follow this link
  Then I should see "exercise6" as "name"
  And I should see the following intensities:
    | muscle | intensity |
    | muscle2 | -1 |

Scenario: Administrator can create exercises
  Given I am on "/admin/exercise"
  Then I should see a link to create exercise
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon      | label     | link            |
    | home      |           | /               |
    | briefcase | Admin     | /admin          |
    | list      | Exercises | /admin/exercise |
    |           | New       |                 |
  When  I fill in "exercise" form with the following:
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
  Given I am on exercise "exercise1" page
  Then I should see a link to delete exercise "exercise1"
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon      | label     | link              |
    | home      |           | /                 |
    | briefcase | Admin     | /admin            |
    | list      | Exercises | /admin/exercise   |
    |           | exercise1 | /admin/exercise/1 |
    |           | Delete    |                   |
  When I press "Delete"
  Then I should be on "/admin/exercise"
  And I should see a "success" message "Exercise exercise1 deleted"
  And I should not see a link to exercise "exercise1"



