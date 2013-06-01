Feature: Product Category Relationship
  In order to test
  As a developer
  I need behat to access site

Scenario: Homepage should be accessible
  Given I am on homepage
   Then the response status code should be 200
