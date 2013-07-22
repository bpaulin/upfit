Feature: Authentification
  In order to use upfit
  As a visitor
  I need to authenticate myself

Scenario Outline: Visitor should be able to login and logout to access member section
  Given I am on homepage
  Then I should see a link to "/login" in "connection" area
  When I follow this link
  Then I should see the following breadcrumbs:
    | icon | label | link |
    | home |       | /    |
    |      | Login |      |
  When I fill in the following:
    | username | <user> |
    | password | <user> |
  And I press "Login"
  Then I should be on "<user>" homepage
  And I should see "<user>" in "connection" area
  And I should see the following breadcrumbs:
    | icon    | label    | link |
    | home    |          | /    |
    |         | <role>   |      |
  When I go to homepage
  Then I should see a link to "/member"
  When I follow this link
  And I should see the following actions:
    | type    | icon      | label       | link                |
    | primary | tasks     | Programs    | /member/program     |
    |         | trophy    | Sessions    | /member/session     |
    |         | user      | Objectives  | /member/objectives  |

  And I should see a link to "/logout" in "connection" area
  When I follow this link
  Then I should be on homepage
  Examples:
    | user   | role   |
    | member | Member |
    | admin  | Admin  |

Scenario: Administator should be able to access administration section
  Given I am "admin"
   When I go to homepage
   Then I should see a link to "/admin"
   When I follow this link
   Then I should be on "admin" homepage

@wip
Scenario Outline: Member should be able to login and logout in several language
  Given I am on "<prefix>"
  Then I should see a link to "<prefix>login" in "connection" area
  When I follow this link
  # When I fill in the following:
  #   | username | member |
  #   | password | wrong! |
  # And I press "<login>"
  # Then I should be on "<prefix>login"
  When I fill in the following:
    | username | member |
    | password | member |
  And I press "<login>"
  Then I should be on "<prefix>member"
  And I should see a link to "/logout" in "connection" area
  When I follow this link
  Then I should be on "<prefix>"
  Examples:
    | lang   | prefix | login |
    | en  | /   | Login |
    | fr  | fr/ | Connexion |
    | de  | de/ | Anmelden |
    | es  | es/ | Entrar |
