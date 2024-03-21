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
class restore_qbank_quiztimer_plugin extends restore_qbank_plugin {

    /**
     * Returns the paths to be handled by the plugin at question level.
     *
     * @return restore_path_element[] The restore path element array.
     */
    protected function define_question_plugin_structure(): array {
        return [new restore_path_element('quiztimer', $this->get_pathfor('/quiztimers/quiztimer'))];
    }

    /**
     * Process the question custom field element.
     *
     * @param array $data The custom field data to restore.
     */
    public function process_quiztimer($data) {
        global $DB;

            // Insertar el registro solo si no existe un registro con los mismos valores.
            $record = new \stdClass;
            $record->questionid = $this->get_new_parentid('question');
            $record->time = $data["time"];
            $record->unit_time = $data["unit_time"];

            $DB->insert_record('question_timer', $record);

    }


}
