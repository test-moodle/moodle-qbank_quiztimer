define(function () {
    "use strict";

     var save =  function(element) {
            console.log(element); // eslint-disable-line no-console
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
            xhr.send('time=' + encodeURIComponent(timeValue) + '&questionId=' +
            encodeURIComponent(questionId) + '&dropdown_option=' + encodeURIComponent(dropdownValue));
        };

return {
    save: save,
    };
});
