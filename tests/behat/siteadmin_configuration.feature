@qbank_quiztimer @javascript
Feature: Configure qbank_quiztimer time values in site administration
  In order to configure and check time values in the site administration
  As an admin
  I should be able to configure and manage the values of the qbank_quiztimer plugin.

  Background:
    Given the following "course" exists:
      | fullname  | Test qbankquiztimer |
      | shortname | testqbankquiztimer |
      | format    | topics|
    And the following "users" exist:
      | username | firstname | lastname | email |
      | student1 | Student   | One      | student1@example.com |
    And the following "course enrolments" exist:
      | user     |       course       | role |
      | student1 | testqbankquiztimer | student |
    And I log in as "admin"
    And I wait "2" seconds
    Given I click on "Site administration" "link"
    And I wait "1" seconds
    And I click on "Plugins" "link"
    And I wait "1" seconds
    And I click on "Quiz Timer" "link"
    And I set the following fields to these values:
      | Time | 90 |
    And I click on "Save changes" "button"
    And I should see "Changes saved"
    And I wait "1" seconds
    And I am on "testqbankquiztimer" course homepage
    And I turn editing mode on

  Scenario: Admin configure qbank_quiztimer time values in the site administration page
    Given I click on "Add an activity or resource" "button" in the "General" "section"
    And I click on "Add a new Quiz" "link" in the "Add an activity or resource" "dialogue"
    And I should see "Adding a new Quiz"
    And I set the following fields to these values:
      | Name | Quiz example1 |
    And I press "Save and display"
    And I wait "2" seconds
    And I click on "More" if it exists otherwise "Question bank"
    And I wait "2" seconds
    And I click on "Create a new question ..." "button"
    And I click on "item_qtype_truefalse" "radio"
    And I press tab
    And I press the enter key
    And I wait "1" seconds
    And I set the following fields to these values:
      | Question name | question example1 |
      | Question text  | question example1 |
    When I click on "id_submitbutton" "button"
    And I wait "1" seconds
    And I turn editing mode off
    And I wait "1" seconds
    Then I should see an input element with name "time" and value "90"
    And I should see "time"
    And I wait "2" seconds

  Scenario: Admin add a question from the questionbank and visualize the preconfigured time value in quiztimer
    Given I click on "More" if it exists otherwise "Question bank"
    And I wait "2" seconds
    And I click on "Create a new question ..." "button"
    And I click on "item_qtype_truefalse" "radio"
    And I press tab
    And I press the enter key
    And I wait "1" seconds
    And I set the following fields to these values:
      | Question name | question example1 |
      | Question text  | question example1 |
    When I click on "id_submitbutton" "button"
    And I wait "1" seconds
    And I click on "Create a new question ..." "button"
    And I click on "item_qtype_truefalse" "radio"
    And I press tab
    And I press the enter key
    And I wait "1" seconds
    And I set the following fields to these values:
      | Question name | question example2 |
      | Question text  | question example2 |
    When I click on "id_submitbutton" "button"
    And I wait "1" seconds
    And I turn editing mode off
    And I wait "1" seconds
    Then I should see an input element with name "time" and value "90"
    And I should see "time"
    And I wait "1" seconds
    And I am on "testqbankquiztimer" course homepage
    And I turn editing mode on
    And I click on "Add an activity or resource" "button" in the "General" "section"
    And I click on "Add a new Quiz" "link" in the "Add an activity or resource" "dialogue"
    And I should see "Adding a new Quiz"
    And I set the following fields to these values:
      | Name | Quiz example1 |
    And I press "Save and display"
    And I wait "1" seconds
    And I click on "Questions" "link"
    And I wait "1" seconds
    And I turn editing mode off
    And I wait "1" seconds
    And I click on "Add" "link"
    And I click on "from question bank" "link"
    And I click on "qbheadercheckbox" "checkbox"
    And I click on "Add selected questions to the quiz" "button"
    And I wait "2" seconds
    And I should see "question example1"
    And I wait "1" seconds
    And I select "Adjust questions times" from the "id_quiztimer_editviewselector" singleselect
    And I wait "1" seconds
    And I select "Time for question" from the "id_quiztimer_quizmodeselector" singleselect
    And I should see "Total section time:"
    And I should see "90"
    And I should see "seconds"
    And I wait "2" seconds
