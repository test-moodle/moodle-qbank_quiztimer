<?php
// This file is part of Moodle - https://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.
// Project implemented by the \"Recovery, Transformation and Resilience Plan.
// Funded by the European Union - Next GenerationEU\".
//
// Produced by the UNIMOODLE University Group: Universities of
// Valladolid, Complutense de Madrid, UPV/EHU, León, Salamanca,
// Illes Balears, Valencia, Rey Juan Carlos, La Laguna, Zaragoza, Málaga,
// Córdoba, Extremadura, Vigo, Las Palmas de Gran Canaria y Burgos.

/**
 * Version details
 *
 * @package    qbank_quiztimer
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     ISYC <soporte@isyc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../../../../lib/behat/behat_base.php');

/**
 * qbank_quiztimer-related steps definitions.
 *
 * @package    qbank_quiztimer
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     ISYC <soporte@isyc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class behat_qbank_quiztimer extends behat_base {
    /**
     * @Then /^I should see an input element with name "([^"]*)" and value "([^"]*)"$/
     */
    public function i_should_see_input_element_with_value($name, $value) {
        $inputelement = $this->getSession()->getPage()->find('css', "input[name='$name'][value='$value']");

        if (!$inputelement) {
            throw new \Exception("Input element with name '$name' and value '$value' not found");
        }
    }

    /**
     * Click on the 'More' link if it exists, otherwise click on 'Question bank'.
     *
     * @When /^I click on "More" if it exists otherwise "Question bank"$/
     */
    public function i_click_on_more_if_exists_otherwise_question_bank() {
        $morebutton = $this->getSession()->getPage()->find('css', '.secondary-navigation .moremenu .more-nav .dropdownmoremenu');

        if ($morebutton !== null && $morebutton->isVisible()) {
            $morebutton->click();
        }

        $this->getSession()->getPage()->findLink('Question bank')->click();
    }
}