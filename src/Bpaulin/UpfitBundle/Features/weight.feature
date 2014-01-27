Feature: weight tracker
  In order to stay motivated
  As an member
  I need to track my weight

Background:
  Given I am member
  And I filled weights:
    | weight | days ago|
    |  86   |  3  |
    |  88   |  5  |
    |  90   |  12  |
    |  92   |  18  |

Scenario: Members can access to weight tracker
  Given I am on "/member"
  Then I should see a link to "/member/weight" in "actions" area
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon    | label          | link    |
    | home    |                | /       |
    | gamepad | Member         | /member |
    |         | Weight Tracker |         |

Scenario: Members can see average weight of current week & month
  Given I am on "/member/weight"
  Then I should see "Last (3 days ago): 86 kg"
  And I should see "Average (week): 87 kg"
  And I should see "Average (month): 89 kg"

Scenario: Members can store and update their weight
  Given I am on "/member/weight"
  # storing weight
  And the "weight" field in "weight" form should contain ""
  When I fill in "weight" form with the following:
    | weight | 84 |
  And I press "Save"
  Then I should see a "success" message "weight stored"
  And I should see "Last (today): 84 kg"
  And I should see "Average (week): 86 kg"
  And I should see "Average (month): 88 kg"
  And the "weight" field in "weight" form should contain "84"
  # updating weight
  When I fill in "weight" form with the following:
    | weight | 80 |
  And I press "Save"
  Then I should see a "success" message "weight stored"
  And I should see "Last (today): 80 kg"
  And I should see "Average (week): 85 kg"
  And I should see "Average (month): 87 kg"
  And the "weight" field in "weight" form should contain "80"

Scenario: Members can set their objective
  Given I am on "/member/weight"
  When I fill in "weightobjective" form with the following:
    | weightObjective | 60 |
    | weightTolerance | 5  |
  When I press "Set Objective"
  Then I should see a "success" message "Objective set"
  And the "weightObjective" field in "weightobjective" form should contain "60"
  And the "weightTolerance" field in "weightobjective" form should contain "5"

