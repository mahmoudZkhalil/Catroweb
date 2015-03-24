@homepage
Feature: Pocketcode homepage
  In order to access and browse the programs
  As a visitor
  I want to be able to see the homepage

  Background:
    Given I am on homepage
    And there are users:
      | name     | password | token      |
      | Catrobat | 123456    | cccccccccc |
      | User1    | 654321    | cccccccccc |
    And there are programs:
      | id | name      | description | owned by | downloads | views | upload time      | version |
      | 1  | program 1 | p1          | Catrobat | 3         | 12    | 01.01.2013 12:00 | 0.8.5   |
      | 2  | program 2 |             | Catrobat | 333       | 9     | 22.04.2014 13:00 | 0.8.5   |
      | 3  | program 3 |             | User1    | 133       | 33    | 01.01.2012 13:00 | 0.8.5   |

  Scenario: Viewing the homepage at website root
    Then I should see the featured slider
    And I should see newest programs
    And I should see most downloaded programs
    And I should see most viewed programs

  Scenario: Login and logout
    Given I am on homepage
    Then I should see an "#btn-login" element
    When I click the "login" button
    Then I should be on "login"
    And I should see an "#header-logo" element
    And I fill in "username" with "Catrobat"
    And I fill in "password" with "123456"
    Then I press "Login"
    Then I should be logged in