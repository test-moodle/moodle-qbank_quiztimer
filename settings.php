<?php
// This file is part of Moodle - http://moodle.org/
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
 * @package    local_quiztimer
 * @copyright  2023 Proyecto UNIMOODLE
 * @author     UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author     ISYC <soporte@isyc.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die;

global $ADMIN;

if ($hassiteconfig) {

    $units = ["s" => get_string('seconds', 'qbank_quiztimer'),
    "m" => get_string('minutes', 'qbank_quiztimer'), "h" => get_string('hours', 'qbank_quiztimer'), ];


    $settings->add(new admin_setting_heading(
        'quizaccess_quiztimer/quiztimedsection',
        get_string('setting:title', 'qbank_quiztimer'),
        ''
    ));
    $settings->add(new admin_setting_configtext('qbank_quiztimer/time',
        get_string('setting:time', 'qbank_quiztimer'),
        '',
        60, PARAM_INT));

    $settings->add(new admin_setting_configselect('qbank_quiztimer/time_unit',
    get_string('setting:unitime', 'qbank_quiztimer'), '',
    2, $units));

}
