Feature: let's try bdd
  In order to test
  As a developer
  I need behat to access site

Scenario: Homepage should be accessible
  Given I am on homepage
   Then the response status code should be 200

@javascript
Scenario: Homepage should be accessible with javascript
  Given I am on homepage
   Then I should be on homepage
