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
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

// Project implemented by the "Recovery, Transformation and Resilience Plan.
// Funded by the European Union - Next GenerationEU".
//
// Produced by the UNIMOODLE University Group: Universities of
// Valladolid, Complutense de Madrid, UPV/EHU, León, Salamanca,
// Illes Balears, Valencia, Rey Juan Carlos, La Laguna, Zaragoza, Málaga,
// Córdoba, Extremadura, Vigo, Las Palmas de Gran Canaria y Burgos.

/**
 * The testing class.
 *
 * @package     qbank_quiztimer
 * @copyright   2023 Proyecto UNIMOODLE
 * @author      UNIMOODLE Group (Coordinator) <direccion.area.estrategia.digital@uva.es>
 * @author      ISYC <soporte@isyc.com>
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
global $CFG;
require_once($CFG->dirroot . "/config.php");
require_once($CFG->dirroot . "/lib/adminlib.php");

use qbank_quiztimer\helper;
use qbank_quiztimer\add_action_column;

class quiztimer_manage_test extends \advanced_testcase {

    // Write the tests here as public funcions.
    // Please refer to {@link https://docs.moodle.org/dev/PHPUnit} for more details on PHPUnit tests in Moodle.
    private static $course;
    private static $context;
    private static $coursecontext;

    private static $quiz;
    private static $user;
    private const COURSE_START = 1706009000;
    private const COURSE_END = 1906009000;

    public function setUp(): void {
        global $USER, $PAGE;
        parent::setUp();
        $this->resetAfterTest(true);
        self::setAdminUser();
        self::$course = self::getDataGenerator()->create_course(
            ['startdate' => self::COURSE_START, 'enddate' => self::COURSE_END]
        );
        self::$coursecontext = \context_course::instance(self::$course->id);
        self::$user = $USER;
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['time'] = 19999999;

    }

    /**
     * Add column
     *
     * Add column
     *
     * @package    qbank_quiztimer
     * @copyright  2023 Proyecto UNIMOODLE
     * @covers \quiztimer_manage::manage
     * @param string $param
     * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
     */
    public function test_manage() {
        global $DB;

        $quizgenerator = self::getDataGenerator()->get_plugin_generator('mod_quiz');
        // Generate quiz.
        self::$quiz = $quizgenerator->create_instance(['course' => self::$course->id,
            'seb_program_autocomplete_program_quiz' => [1],
            'grade' => 100.0,
            'sumgrades' => 2,
            'layout' => '1,0',
            ]);

        $cm = get_coursemodule_from_instance('quiz', self::$quiz->id, self::$course->id);
        $this->assertNotNull($cm);

        $questiongenerator = $this->getDataGenerator()->get_plugin_generator('core_question');
        $cat = $questiongenerator->create_question_category();
        $questions = [];
        // Generate question.
        for ($i = 0; $i < 4; $i++) {
            $truefalse = $questiongenerator->create_question('truefalse', null, ['category' => $cat->id]);
            $questions[] = $truefalse;
            quiz_add_quiz_question($truefalse->id, self::$quiz);
            $DB->insert_record('question_timer', ['questionid' => $truefalse->id, 'time' => 200, 'unit_time' => 'h']);
        }

        $_POST['questionId'] = $truefalse->id;
        $newview = new \core_question\local\bank\view(new \question_edit_contexts(self::$coursecontext),
        new \moodle_url('/question/bank/quiztimer/settings.php'), self::$course);
        $addactioncolumn = new add_action_column($newview);
        // Get name.
        $this->assertNotNull($addactioncolumn->get_name());
        // Get title.
        $this->assertNotNull($addactioncolumn->get_title());
        // Get extra classes.
        $this->assertNotNull($addactioncolumn->get_extra_classes());
        // Display content.
        $reflectionmethod = new ReflectionMethod(add_action_column::class, 'display_content');
        $reflectionmethod->setAccessible(true);
        $startsectionlist = $reflectionmethod->invoke($addactioncolumn, $truefalse, '');

    }

}
