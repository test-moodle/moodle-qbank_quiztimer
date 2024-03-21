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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

// Project implemented by the "Recovery, Transformation and Resilience Plan.
// Funded by the European Union - Next GenerationEU".
//
// Produced by the UNIMOODLE University Group: Universities of
// Valladolid, Complutense de Madrid, UPV/EHU, León, Salamanca,
// Illes Balears, Valencia, Rey Juan Carlos, La Laguna, Zaragoza, Málaga,
// Córdoba, Extremadura, Vigo, Las Palmas de Gran Canaria y Burgos.

/**
 * Display information about all the mod_quiztimer modules in the requested course. *
 * @package qbank_quiztimer
 * @copyright 2023 Proyecto UNIMOODLE
 * @author UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @license http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class backup_qbank_quiztimer_plugin extends \backup_qbank_plugin {

    /**
     * Returns the comment information to attach to question element.
     *
     * @return backup_plugin_element The backup plugin element
     */
    protected function define_question_plugin_structure(): backup_plugin_element {
        global $PAGE;
        // Define the virtual plugin element with the condition to fulfill.
        $plugin = $this->get_plugin_element();

        // Create one standard named plugin element (the visible container).
        $pluginwrapper = new backup_nested_element($this->get_recommended_name());

        $quiztimers = new backup_nested_element('quiztimers');
        $plugin->add_child($pluginwrapper);
        $pluginwrapper->add_child($quiztimers);

        $quiztimer = new backup_nested_element('quiztimer', ['id'], ['questionid', 'time', 'unit_time']);
        $quiztimers->add_child($quiztimer);

        $quiztimer->set_source_sql(
        "SELECT q.*
        FROM {question_timer} q
        JOIN {question_versions} qv ON q.questionid = qv.questionid
        JOIN {question_bank_entries} qbe ON qv.questionbankentryid = qbe.id
        JOIN {question_categories} qc ON qbe.questioncategoryid = qc.id
        WHERE qc.contextid = :contextid AND q.questionid = :questionid",
        [
            'contextid' => backup_helper::is_sqlparam($PAGE->context->id),
            'questionid' => backup::VAR_PARENTID,
        ]);

        return $plugin;
    }
}
