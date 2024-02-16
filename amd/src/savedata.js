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
/**
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
function save(element) {


    var questionId = element.id.split('-')[1];
    var timeValue = document.getElementById('text-' + questionId);
    var dropdownValue = document.getElementById('timedropdown-' + questionId);


    if (timeValue) {
        timeValue = timeValue.value;

    }
    if (dropdownValue) {
        dropdownValue = dropdownValue.value;
        if (dropdownValue === 's') {
        } else if (dropdownValue === 'm') {
            timeValue = parseInt(timeValue) * 60;
        } else if (dropdownValue === 'h') {
            timeValue = parseInt(timeValue) * 3600;
        }

    }


        var xhr = new XMLHttpRequest();
        xhr.open('POST', '', true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // The request has been fulfilled, and the server's response is ready.
            }
        };
        xhr.send('time=' + encodeURIComponent(timeValue) + '&questionId=' + encodeURIComponent(questionId) + '&dropdown_option=' + encodeURIComponent(dropdownValue));

}