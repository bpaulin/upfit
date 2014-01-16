Feature: workout management
  In order to stay motivated
  As an member
  I need to track my weight

Background:
  Given I am member

Scenario: Members can store their weight
  Given I am on "/member"
  Then I should see a link to "/member/weight" in "actions" area
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon      | label    | link    |
    | home      |          | /       |
    | gamepad   | Member   | /member |
    |           | Weight Tracker |         |
  When I fill in "weight" form with the following:
    | weight | 80 |
  When I press "Create"
  Then I should see a "success" message "weight stored"
  And I should see "Last record: 80 kg"

