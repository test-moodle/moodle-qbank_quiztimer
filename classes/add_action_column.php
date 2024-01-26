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
namespace qbank_quiztimer;

use core_question\local\bank\column_base;
use moodle_url;
use stdClass;

/**
 * Class to add an action column to the question table.
 *
 * @package    qbank_editquestion
 */
class add_action_column extends column_base {

    public function get_name(): string {
        return 'questionstatus';
    }

    public function get_title(): string {
        return get_string('questionstatus', 'qbank_quiztimer');
    }

    /**
     * Display the content of the column.
     *
     * @param object $question The question object.
     * @param array  $rowclasses The row classes.
     */
    protected function display_content($question, $rowclasses): void {
        global $PAGE, $DB, $questionId, $timequestion;
        $timequestion = $DB->get_records('question_timer');
        $attributes = [];



        // Check if a POST request has been submitted
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['time']) && isset($_POST['questionId']) && $_POST['questionId'] === $question->id) {
                $questionId = $question->id;
                $existingData = $DB->get_record('question_timer', ['questionid' => $questionId]);
                $data = new stdClass;
                $data->id = $existingData->id;
                $data->questionid = $questionId;
                $data->time = $_POST['time'];
                $data->unit_time = $_POST['dropdown_option'];
                $DB->update_record('question_timer', $data);
                return;
            }
        }

        // Get the question ID to use it as the index
        $questionId = $question->id;
        $existingData = $DB->get_record('question_timer', ['questionid' => $questionId]);

        if ($existingData) {
            if (is_object($existingData)) {
                $data = new stdClass;
                $data->id = $existingData->id;
                $id = $data->id;
                $number = intval($id);
            } else {
                $data = null;
                $number = 0; // Assign a default value to $number
            }
        } else {
            $data = new stdClass;
            $data->questionid = $questionId;
            $number = $questionId;
            if (isset($_POST['time'])) {
                $data->time = $_POST['time'];
            } else {
                $data->time = 0; // Default value for "time"
            }
            if (isset($_POST['dropdown_option'])) {
                $data->unit_time = $_POST['dropdown_option'];
            } else {
                $data->unit_time = 'd'; // Default value for "unit_time"
            }
            $DB->insert_record('question_timer', $data);
        }


        // Obtén la URL actual.
        $currenturl = $_SERVER['REQUEST_URI'];

        // URL en la que deseas que funcione el código.
        $allowedurl = '/question/edit.php';

        if (strpos($currenturl, $allowedurl) !== false) {
            if (question_has_capability_on($question, 'edit')) {
                $html = '<div style="display: flex; align-items: center;">';
                if (isset($timequestion[intval($number)])) {
                    if ($timequestion[intval($number)]->unit_time === 's') {
                        // Already seconds.
                        $html .= '<input type="number" value="' . $timequestion[intval($number)]->time . '" name="time" id="text-' .
                        $question->id.
                        '" class="form-control" style="width: 100px; margin-right: 5px;" oninput="guardarDatos(this)">';
                    } else if ($timequestion[intval($number)]->unit_time === 'm') {
                        // To minutes.
                        $time = $timequestion[intval($number)]->time / 60;
                        $html .= '<input type="number" value="' . $time . '" name="time" id="text-' .
                        $question->id .
                        '" class="form-control" style="width: 100px; margin-right: 5px;" oninput="guardarDatos(this)">';
                    } else if ($timequestion[intval($number)]->unit_time === 'h') {
                        // To hours.
                        $time = $timequestion[intval($number)]->time / 3600;
                        $html .= '<input type="number" value="' . $time . '" name="time" id="text-' .
                        $question->id .
                        '" class="form-control" style="width: 100px; margin-right: 5px;" oninput="guardarDatos(this)">';
                    } else if ($timequestion[intval($number)]->unit_time === 'd') {
                        // Default.
                        $html .= '<input type="number  name="time" id="text-' .
                        $question->id .
                        '" class="form-control" style="width: 100px; margin-right: 5px;" oninput="guardarDatos(this)">';
                    }
                } else {
                    $html .= '<input type="number  name="time" id="text-' .
                    $question->id .
                    '" class="form-control" style="width: 100px; margin-right: 5px;" oninput="guardarDatos(this)">';
                }

                // Dropdown menu.
                $options = [
                    [
                        'name' => '',
                        'value' => 'd',
                    ],
                    [
                        'name' => 'segundos',
                        'value' => 's',
                    ],
                    [
                        'name' => 'minutos',
                        'value' => 'm',
                    ],
                    [
                        'name' => 'horas',
                        'value' => 'h',
                    ],
                ];

                $dropdown = '<select name="dropdown_option" class="custom-select my-2" id="timedropdown-' . $question->id .
                '" onchange="guardarDatos(this)" style="margin-left: 5px;">';

                foreach ($options as $option) {
                    $name = $option['name'];
                    $value = $option['value'];
                    if (isset($timequestion[intval($number)]) && $timequestion[intval($number)] != null) {
                        $selected = ($value === $timequestion[intval($number)]->unit_time) ? 'selected' : '';
                        $dropdown .= "<option value=\"$value\" $selected>$name</option>";
                    } else {
                        // Check if $value is 'default' to set it as selected.
                        $selected = ($value === 'default') ? 'selected' : '';
                        $dropdown .= "<option value=\"$value\" $selected>$name</option>";
                    }
                }
                $dropdown .= '</select>';

                $html .= $dropdown;
                $html .= '</div>';

                // Display the HTML.
                echo $html;

                // Include JavaScript file.
                echo "<script src=\"/question/bank/quiztimer/classes/guardar_datos.js\"></script>";
            }
        }
    }

    public function get_extra_classes(): array {
        return ['pr-3'];
    }
}
