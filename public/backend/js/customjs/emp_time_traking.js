var EmpTimeTraking = function () {

    // var TimeTracker = function () {
    //     let startTime;
    //     let timerInterval;
    //     let elapsedTime = 0;
    //     let isPaused = false;
    //     let isStopped = true;

    //     function toggleTimer() {
    //         if (isStopped) {
    //             startTimer();
    //             $('#toggle').css('background-color', 'green');
    //         } else {
    //             stopTimer();
    //             $('#toggle').css('background-color', 'red');
    //         }
    //     }

    //     $('#toggle').on('click', function () {
    //         toggleTimer();
    //     });

    //     function startTimer() {
    //         $('#fulltime').hide();
    //         var data = { _token: $('#_token').val() };
    //         $.ajax({
    //             type: "POST",
    //             headers: {
    //                 'X-CSRF-TOKEN': $('input[name="_token"]').val(),
    //             },
    //             url: baseurl + "employee/store-start-time",
    //             data: { 'data': data },
    //             success: function (data) {
    //                 if (!localStorage.getItem("timerStarted")) { // Check if timer was just started
    //                     showToster("success", "I am back");
    //                     localStorage.setItem("timerStarted", true); // Set flag indicating timer was started
    //                 }

    //                 if (isStopped) {
    //                     startTime = Date.now() - elapsedTime;
    //                     isStopped = false;
    //                     localStorage.setItem("isStopped", "false");
    //                 }
    //                 if (!timerInterval) {
    //                     timerInterval = setInterval(updateTimer, 1000);
    //                 }
    //             }
    //         });

    //     }

    //     $('body').on('click', '#start', function () {
    //         startTimer();
    //     });

    //     function updateTimer() {
    //         elapsedTime = Date.now() - startTime;
    //         displayTime(elapsedTime);
    //     }

    //     function stopTimer() {
    //         var data = { _token: $('#_token').val() };
    //         $.ajax({
    //             type: "POST",
    //             headers: {
    //                 'X-CSRF-TOKEN': $('input[name="_token"]').val(),
    //             },
    //             url: baseurl + "employee/store-stop-time",
    //             data: { 'data': data },
    //             success: function (data) {
    //                 clearInterval(timerInterval);
    //                 timerInterval = null;
    //                 isStopped = true;
    //                 localStorage.setItem("isStopped", "true");

    //                 // Calculate hours, minutes, and seconds
    //                 let hours = Math.floor(elapsedTime / (1000 * 60 * 60));
    //                 let minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
    //                 let seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

    //                 // Format time
    //                 let formattedTime = (hours < 10 ? "0" + hours : hours) + ":" +
    //                     (minutes < 10 ? "0" + minutes : minutes) + ":" +
    //                     (seconds < 10 ? "0" + seconds : seconds);

    //                 // Display the recorded time
    //                 // var fulltime = document.getElementById("fulltime");
    //                 // fulltime.style.display = "block";
    //                 // fulltime.style.color = "#ff4500";
    //                 // fulltime.innerHTML = "Time Recorded is " + formattedTime;

    //                 // Reset elapsed time
    //                 elapsedTime = 0;

    //                 showToster("success", "I am going");

    //                 $('#start').show();
    //                 // Remove timerStarted flag
    //                 localStorage.removeItem("timerStarted");
    //             }
    //         });
    //     }

    //     $('body').on('click', '#stop', function () {
    //         stopTimer();
    //     });

    //     function displayTime(time) {
    //         let hours = Math.floor(time / (1000 * 60 * 60));
    //         let minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
    //         let seconds = Math.floor((time % (1000 * 60)) / 1000);

    //         hours = (hours < 10) ? "0" + hours : hours;
    //         minutes = (minutes < 10) ? "0" + minutes : minutes;
    //         seconds = (seconds < 10) ? "0" + seconds : seconds;

    //         console.log(hours, minutes, seconds);

    //         document.getElementById("timer").innerText = hours + ":" + minutes + ":" + seconds;
    //     }

    //     // Restore timer state on page refresh
    //     window.onload = function () {
    //         let storedTime = localStorage.getItem("timerElapsed");
    //         let storedPaused = localStorage.getItem("isPaused");
    //         let storedStopped = localStorage.getItem("isStopped");
    //         let storedStartTime = localStorage.getItem("startTime"); // Retrieve startTime from local storage

    //         if (storedTime && storedStartTime) { // Check if both elapsedTime and startTime are available
    //             elapsedTime = parseInt(storedTime);
    //             if (!isNaN(elapsedTime)) {
    //                 if (storedStopped === "false" && storedPaused === "true") {
    //                     // Timer was stop
    //                     $('#toggle').css('background-color', 'red');
    //                 } else if (storedStopped === "false" && storedPaused === "false") {
    //                     // Timer was running
    //                     $('#toggle').css('background-color', 'green');
    //                     startTime = parseInt(storedStartTime); // Set startTime from local storage
    //                     isStopped = false;
    //                     if (!timerInterval) {
    //                         timerInterval = setInterval(updateTimer, 1000);
    //                     }
    //                 }
    //             }
    //         }
    //     };

    //     // Modify the window.onbeforeunload function to save startTime in local storage:
    //     window.onbeforeunload = function () {
    //         localStorage.setItem("timerElapsed", elapsedTime.toString());
    //         localStorage.setItem("isPaused", isPaused.toString());
    //         localStorage.setItem("isStopped", isStopped.toString());
    //         localStorage.setItem("startTime", startTime.toString()); // Store startTime in local storage
    //     };


    // }

    var list = function () {

        var dataArr = {};
        var columnWidth = { "width": "5%", "targets": 0 };
        var arrList = {
            'tableID': '#employee-tracker-list      ',
            'ajaxURL': baseurl + "employee/time-tracking/ajaxcall",
            'ajaxAction': 'getdatatable',
            'postData': dataArr,
            'hideColumnList': [],
            'noSortingApply': [0, 0],
            'noSearchApply': [0, 0],
            'defaultSortColumn': [0],
            'defaultSortOrder': 'DESC',
            'setColumnWidth': columnWidth
        };
        getDataTable(arrList);
    }

    return {
        init: function () {
            list();
        },
        // time_tracker: function () {
        //     TimeTracker();
        // },
    }
}();
