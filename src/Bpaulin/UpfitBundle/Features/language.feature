Feature: translate
  In order to use upfit
  As a visitor
  I need to select my language

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
    | lang | prefix | login     |
    | en   | /      | Login     |
    | fr   | fr/    | Connexion |
    | de   | de/    | Anmelden  |
    | es   | es/    | Entrar    |

Scenario: Visitor should be able to select language
  Given I am on "/"
  Then I should see a link to "/fr/"
  When I follow this link
  Then  I should see a link to "/de/"
  When I follow this link
  Then I should see a link to "/es/"
  When I follow this link
  Then I should see a link to "/"
