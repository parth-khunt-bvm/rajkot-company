$('body').on('change', '.breadcrumb-branch', function () {
    // document.cookie = "branch=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
    document.cookie = "branch=" + $(this).val();
    location.reload();
});

// time tracker js

// let startTime;
// let timerInterval;
// let elapsedTime = 0;
// let isPaused = false;
// let isStopped = true;

// function toggleTimer() {
//     if (isStopped) {
//         startTimer();
//         $('#toggle').css('background-color','green');
//     } else {
//         stopTimer();
//         $('#toggle').css('background-color','red');
//     }
// }

// $('#toggle').on('click', function () {
//     toggleTimer();
// });

// function startTimer() {
//     // $('#start').hide();
//     $('#fulltime').hide();
//     var data = { _token: $('#_token').val() };
//     $.ajax({
//         type: "POST",
//         headers: {
//             'X-CSRF-TOKEN': $('input[name="_token"]').val(),
//         },
//         url: baseurl + "employee/store-start-time",
//         data: { 'data': data },
//         success: function (data) {
//             if (!localStorage.getItem("timerStarted")) { // Check if timer was just started
//                 showToster("success", "I am back");
//                 localStorage.setItem("timerStarted", true); // Set flag indicating timer was started
//             }

//             if (isStopped) {
//                 startTime = Date.now() - elapsedTime;
//                 isStopped = false;
//                 localStorage.setItem("isStopped", "false");
//             }
//             if (!timerInterval) {
//                 timerInterval = setInterval(updateTimer, 1000);
//             }
//         }
//     });

// }

// $('body').on('click', '#start', function () {
//     startTimer();
// });

// function updateTimer() {
//     elapsedTime = Date.now() - startTime;
//     displayTime(elapsedTime);
// }

// function stopTimer() {
//     var data = { _token: $('#_token').val() };
//     $.ajax({
//         type: "POST",
//         headers: {
//             'X-CSRF-TOKEN': $('input[name="_token"]').val(),
//         },
//         url: baseurl + "employee/store-stop-time",
//         data: { 'data': data },
//         success: function (data) {
//             clearInterval(timerInterval);
//             timerInterval = null;
//             isStopped = true;
//             localStorage.setItem("isStopped", "true");

//             // Calculate hours, minutes, and seconds
//             let hours = Math.floor(elapsedTime / (1000 * 60 * 60));
//             let minutes = Math.floor((elapsedTime % (1000 * 60 * 60)) / (1000 * 60));
//             let seconds = Math.floor((elapsedTime % (1000 * 60)) / 1000);

//             // Format time
//             let formattedTime = (hours < 10 ? "0" + hours : hours) + ":" +
//                 (minutes < 10 ? "0" + minutes : minutes) + ":" +
//                 (seconds < 10 ? "0" + seconds : seconds);

//             // Display the recorded time
//             // var fulltime = document.getElementById("fulltime");
//             // fulltime.style.display = "block";
//             // fulltime.style.color = "#ff4500";
//             // fulltime.innerHTML = "Time Recorded is " + formattedTime;

//             // Reset elapsed time
//             elapsedTime = 0;

//             showToster("success", "I am going");

//             $('#start').show();
//             $('#continue').hide();

//             // Remove timerStarted flag
//             localStorage.removeItem("timerStarted");
//         }
//     });
// }

// $('body').on('click', '#stop', function () {
//     $('#continue').hide();
//     stopTimer();
// });

// function displayTime(time) {
//     let hours = Math.floor(time / (1000 * 60 * 60));
//     let minutes = Math.floor((time % (1000 * 60 * 60)) / (1000 * 60));
//     let seconds = Math.floor((time % (1000 * 60)) / 1000);

//     hours = (hours < 10) ? "0" + hours : hours;
//     minutes = (minutes < 10) ? "0" + minutes : minutes;
//     seconds = (seconds < 10) ? "0" + seconds : seconds;

//     document.getElementById("timer").innerText = hours + ":" + minutes + ":" + seconds;
// }

// // Restore timer state on page refresh
// // window.onload = function () {
// //     let storedTime = localStorage.getItem("timerElapsed");
// //     let storedPaused = localStorage.getItem("isPaused");
// //     let storedStopped = localStorage.getItem("isStopped");

// //     if (storedTime) {
// //         elapsedTime = parseInt(storedTime);
// //         if (!isNaN(elapsedTime)) {
// //             if (storedStopped === "false" && storedPaused === "true") {
// //                 // $('#start').hide();
// //                 $('#continue').show();
// //                 displayTime(elapsedTime);
// //             } else if (storedStopped === "false" && storedPaused === "false") {
// //                 // startTimer();
// //                 // $('#start').hide();
// //                 $('#continue').show();


// //                 if (!localStorage.getItem("timerStarted")) { // Check if timer was just started
// //                     showToster("success", "I am back");
// //                     localStorage.setItem("timerStarted", true); // Set flag indicating timer was started
// //                 }

// //                 if (isStopped) {
// //                     startTime = Date.now() - elapsedTime;
// //                     isStopped = false;
// //                     localStorage.setItem("isStopped", "false");
// //                 }
// //                 if (!timerInterval) {
// //                     timerInterval = setInterval(updateTimer, 1000);
// //                 }
// //             }
// //         }
// //     }
// //     // Show "Stop" button if timer is running
// //     if (storedStopped === "false" && storedPaused === "false") {
// //         // $('#stop').show();
// //         $('#toggle').css('background-color','green');
// //     }
// // };

// // // Save timer state before page refresh
// // window.onbeforeunload = function () {
// //     localStorage.setItem("timerElapsed", elapsedTime.toString());
// // };

// window.onload = function () {
//     let storedTime = localStorage.getItem("timerElapsed");
//     let storedPaused = localStorage.getItem("isPaused");
//     let storedStopped = localStorage.getItem("isStopped");

//     if (storedTime) {
//         elapsedTime = parseInt(storedTime);
//         if (!isNaN(elapsedTime)) {
//             if (storedStopped === "false" && storedPaused === "true") {
//                 // Timer was paused
//                 // Show appropriate UI
//                 $('#toggle').css('background-color','red');
//             } else if (storedStopped === "false" && storedPaused === "false") {
//                 // Timer was running
//                 // Resume timer and show appropriate UI
//                 $('#toggle').css('background-color','green');

//                 startTime = Date.now() - elapsedTime;
//                 isStopped = false;
//                 if (!timerInterval) {
//                     timerInterval = setInterval(updateTimer, 1000);
//                 }
//             }
//         }
//     }
// };

// window.onbeforeunload = function () {
//     localStorage.setItem("timerElapsed", elapsedTime.toString());
//     localStorage.setItem("isPaused", isPaused.toString());
//     localStorage.setItem("isStopped", isStopped.toString());
// };

