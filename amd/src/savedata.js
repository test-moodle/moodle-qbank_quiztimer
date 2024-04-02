define(function() {
    "use strict";

    function save(textElementId, dropdownElementId) {
        var textElement = document.getElementById(textElementId);
        var dropdownElement = document.getElementById(dropdownElementId);

        textElement.oninput = function() {

            handleInput(textElement, dropdownElement);
        };

        dropdownElement.onchange = function() {

            handleInput(textElement, dropdownElement);
        };


        function handleInput(textElement, dropdownElement) {
            var timeValue = textElement.value;
            var dropdownValue = dropdownElement.value;

            if (dropdownValue === 'm') {
                timeValue *= 60;
            } else if (dropdownValue === 'h') {
                timeValue *= 3600;
            }

            var questionId = textElementId.split('-')[1];

            var xhr = new XMLHttpRequest();
            xhr.open('POST', '', true);
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                }
            };
            xhr.send('time=' + encodeURIComponent(timeValue) + '&questionId=' +
                encodeURIComponent(questionId) + '&dropdown_option=' + encodeURIComponent(dropdownValue));
        }
    }

    return {
        save: save
    };
});
