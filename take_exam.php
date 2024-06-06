<?php
session_start();

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION["username"];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Take Exam</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding: 20px;
            background-color: #f0f0f0;
        }

        .red-text {
            color: red;
        }

        .question-container {
            margin-bottom: 30px;
            background: linear-gradient(to bottom right, #ffffff, #e0e0e0);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 70%;
            display: inline-block;
            vertical-align: top;
        }

        .summary-box {
            display: inline-block;
            vertical-align: top;
            margin-left: 20px;
            width: 25%;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 10px;
            padding: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .summary-box div {
            margin-bottom: 10px;
        }

        .summary-box .count-box {
            display: inline-block;
            width: 30px;
            height: 30px;
            line-height: 30px;
            border-radius: 50%;
            text-align: center;
            color: #fff;
        }

        .summary-box .green {
            background-color: green;
        }

        .summary-box .red {
            background-color: red;
        }

        .summary-box .orange {
            background-color: orange;
        }

        .palette {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .palette-item {
            width: 30px;
            height: 30px;
            border: 1px solid #ccc;
            margin: 0 5px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background-color: #ccc;
        }

        .palette-item.answered {
            background-color: green !important;
        }

        .palette-item.unanswered {
            background-color: red !important;
        }

        .palette-item.yet-to-visit {
            background-color: orange !important;
        }

        .palette-item:hover {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        }

        .timer {
            margin-top: 20px;
            font-size: 1.5em;
        }

        .question-container p {
            font-size: 1.2em;
        }

        .options-list input[type="radio"] {
            margin-right: 10px;
        }
        .camera-feed {
            width: 100%;
            height: auto;
            border: 10px solid transparent; /* Initial border color */
            border-radius: 10px;
        }
    </style>
</head>
<body>
<div class="container">
    <h1 class="mb-4">All The Best! <?php echo $username; ?></h1>
    <?php
    if (isset($_GET['exam_title'])) {
        $examTitle = $_GET['exam_title'];
        echo '<input type="hidden" id="examTitleInput" name="exam_title" value="' . $examTitle . '">';
    }
    ?>
    <div class="text-center mb-4">
        <button id="markAttendanceBtn" class="btn btn-primary">Mark Attendance</button>
    </div>
    <div class="question-container">
    <form id="examForm" action="submit_action.php" method="POST" style="display: none;">
            <input type="hidden" name="username" value="<?php echo $username; ?>">
            <input type="hidden" name="exam_title" value="<?php echo $examTitle; ?>">
            <?php
            $servername = "localhost";
            $database = "id22126747_myproject";
            $dbusername = "root";
            $dbpassword = "1234";

            $conn = new mysqli($servername, $dbusername, $dbpassword, $database);
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            if (isset($_GET['exam_title']) && isset($_GET['difficulty'])) {
                $examTitle = $_GET['exam_title'];
                $examDifficulty = $_GET['difficulty'];

                $fetch_time_limit_sql = "SELECT time_limit FROM exams WHERE exam_title='$examTitle' AND difficulty='$examDifficulty'";
                $time_limit_result = $conn->query($fetch_time_limit_sql);

                if ($time_limit_result && $time_limit_result->num_rows > 0) {
                    $row = $time_limit_result->fetch_assoc();
                    $timeLimitMinutes = $row['time_limit'];
                } else {
                    $timeLimitMinutes = 30;
                }

                $fetch_question_limit_sql = "SELECT question_limit FROM exams WHERE exam_title='$examTitle' AND difficulty='$examDifficulty'";
                $question_limit_result = $conn->query($fetch_question_limit_sql);

                if ($question_limit_result && $question_limit_result->num_rows > 0) {
                    $row = $question_limit_result->fetch_assoc();
                    $questionLimit = $row['question_limit'];
                } else {
                    $questionLimit = 5;
                }

                $fetch_questions_sql = "SELECT * FROM questions WHERE topic='$examTitle' AND difficulty='$examDifficulty' ORDER BY RAND() LIMIT $questionLimit";
                $result = $conn->query($fetch_questions_sql);

                $questionNumber = 1;

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<div class='mb-3 question' data-question-id='{$row['id']}' id='question$questionNumber'>";
                        echo "<p><strong>Question $questionNumber:</strong> " . $row["question_text"] . "</p>";
                        $question_id = $row["id"];
                        $fetch_options_sql = "SELECT * FROM options WHERE question_id='$question_id'";
                        $options_result = $conn->query($fetch_options_sql);

                        echo "<ul class='options-list' style='list-style: none; padding: 0;'>";
                        while ($option_row = $options_result->fetch_assoc()) {
                            echo "<li><input type='radio' name='answer_$question_id' value='{$option_row['id']}' required> {$option_row['option_text']}</li>";
                        }
                        echo "</ul>";
                        echo "<button type='button' class='btn btn-warning' onclick='clearResponse($question_id)'>Clear Response</button>";
                        echo "</div>";
                        
                        $questionNumber++;
                    }
                    echo "<button type='submit' id='submitExam' class='btn btn-success' style='display: none;'>Submit Exam</button>";
                } else {
                    echo "No questions available for the selected topic and difficulty.";
                }
            }
            ?>
        </form>
        <div class="text-center">
            <button type="button" class="btn btn-secondary" id="prevQuestionBtn" onclick="prevQuestion()">Previous</button>
            <button type="button" class="btn btn-secondary" id="nextQuestionBtn" onclick="nextQuestion()">Next</button>
        </div>
    </div>
    <div class="summary-box">
        <div>
            <span>Answered</span>
            <span class="count-box green" id="answeredCount">0</span>
        </div>
        <div>
            <span>Unanswered</span>
            <span class="count-box red" id="unansweredCount">0</span>
        </div>
        <div class="camera-section">
                <h2></h2>
                <video id="cameraFeed" class="camera-feed" autoplay></video>
            </div>
    </div>
    <div class="palette" id="palette"></div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const cameraFeed = document.getElementById('cameraFeed');

// Access the camera and start streaming
async function startCamera() {
    try {
        const stream = await navigator.mediaDevices.getUserMedia({ video: true });
        cameraFeed.srcObject = stream;
    } catch (err) {
        console.error('Error accessing camera:', err);
    }
}

// Function to capture face from camera feed and send to Flask server
function captureAndSendFace() {
    const canvas = document.createElement('canvas');
    const ctx = canvas.getContext('2d');
    const video = document.getElementById('cameraFeed');

    // Draw the current frame from video onto canvas
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert canvas image to base64 string
    const imageData = canvas.toDataURL('image/jpeg');

    // Send image data along with username to Flask server
    sendFaceToServer(imageData, "<?php echo $username; ?>");

    // Repeat the process recursively
    setTimeout(captureAndSendFace, 10000); // Change the interval as needed
}

// Function to send captured face to Flask server
function sendFaceToServer(imageData, username) {
    // Send image data along with username to Flask server
    fetch("https://192.168.123.225:5000/mark-attendance", {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({ "username": username, "image": imageData })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Attendance marked successfully
            document.getElementById('cameraFeed').style.borderColor = 'green'; // Change border color to green
        } else {
            // Attendance marking failed
            document.getElementById('cameraFeed').style.borderColor = 'red'; // Change border color to red
            Swal.fire({
                icon: 'error',
                title: 'Face Alignment Error',
                text: 'Please align your face properly.'
            });
        }
    })
    .catch(error => {
        console.error("Error sending face for user: " + username + ". Error: ", error);
    });
}

// Call the function to start the camera when the page loads
window.addEventListener('load', function() {
    startCamera();
    setTimeout(captureAndSendFace, 10000); // Start capturing face after 10 seconds
});
    let tabSwitchCount = 0;

    $(document).ready(function() {
        $('#markAttendanceBtn').click(function() {
            captureImage();
            toggleFullScreen();
        });

        $('input[type="radio"]').change(function() {
            updatePalette();
            updateSummary();
        });

        updatePalette();
        updateSummary();
        generatePalette();
        $('form .mb-3').hide();
        $('#question1').show();
        handleNavigationButtons();

        document.addEventListener('visibilitychange', handleVisibilityChange);
    });

    function captureImage() {
        const video = document.createElement('video');
        const canvas = document.createElement('canvas');
        const ctx = canvas.getContext('2d');

        navigator.mediaDevices.getUserMedia({ video: true })
            .then(stream => {
                video.srcObject = stream;
                video.onloadedmetadata = () => {
                    video.play();
                    setTimeout(() => {
                        canvas.width = video.videoWidth;
                        canvas.height = video.videoHeight;
                        ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

                        stream.getTracks().forEach(track => track.stop());
                        const imageData = canvas.toDataURL('image/png');
                        markAttendance(imageData);
                    }, 2000);
                };
            })
            .catch(error => {
                console.error('Error accessing camera:', error);
                Swal.fire({
                    title: "Error",
                    text: "Unable to access camera. Please check your camera settings.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            });
    }

    function markAttendance(imageData) {
        $.ajax({
            type: "POST",
            url: "https://192.168.123.225:5000/mark-attendance",
            contentType: "application/json",
            data: JSON.stringify({ "username": "<?php echo $_SESSION['username']; ?>", "image": imageData }),
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        title: "Attendance Marked Successfully",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "OK"
                    });
                    $('#examForm').show();
                    $('#markAttendanceBtn').hide();
                    startTimer(<?php echo $timeLimitMinutes; ?>);
                } else {
                    Swal.fire({
                        title: "Attendance Marking Failed",
                        text: response.message,
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                }
            },
            error: function(error) {
                console.error('Attendance marking error:', error);
                Swal.fire({
                    title: "Error",
                    text: "Failed to mark attendance. Please try again.",
                    icon: "error",
                    confirmButtonText: "OK"
                });
            }
        });
    }

    function toggleFullScreen() {
        if (!document.fullscreenElement) {
            document.documentElement.requestFullscreen().catch(err => {
                console.error(`Error attempting to enable full-screen mode: ${err.message} (${err.name})`);
            });
        }
    }

    function handleVisibilityChange() {
        if (document.hidden) {
            tabSwitchCount++;
            if (tabSwitchCount > 1) {
                window.location.href = 'student_dashboard.php';
            } else {
                Swal.fire({
                    title: "Warning",
                    text: "You have switched tabs. Please stay on the exam page.",
                    icon: "warning",
                    confirmButtonText: "OK"
                });
            }
        }
    }

    function startTimer(minutes) {
        let remainingTime = minutes * 60;
        const timerInterval = setInterval(() => {
            const minutes = Math.floor(remainingTime / 60);
            const seconds = remainingTime % 60;
            $('#timer').text(`${minutes}:${seconds < 10 ? '0' + seconds : seconds}`);
            remainingTime--;

            if (remainingTime < 0) {
                clearInterval(timerInterval);
                $('#examForm').submit();
            }
        }, 1000);
    }

    let currentQuestion = 1;
    const totalQuestions = <?php echo $questionNumber - 1; ?>;
    const timeLimitMinutes = <?php echo $timeLimitMinutes; ?>;
    const palette = document.getElementById('palette');
    let answeredCount = 0;
    let unansweredCount = totalQuestions;

    document.getElementById('question' + currentQuestion).style.display = 'block';

updatePalette();
updateSummary();

function nextQuestion() {
    if (currentQuestion < totalQuestions) {
        document.getElementById('question' + currentQuestion).style.display = 'none';
        currentQuestion++;
        document.getElementById('question' + currentQuestion).style.display = 'block';
        if (currentQuestion === totalQuestions) {
            document.getElementById('submitExam').style.display = 'block'; // Show submit button
        } else {
            document.getElementById('submitExam').style.display = 'none'; // Hide submit button
        }
        updatePalette();
    }
}

function prevQuestion() {
    if (currentQuestion > 1) {
        document.getElementById('question' + currentQuestion).style.display = 'none';
        currentQuestion--;
        document.getElementById('question' + currentQuestion).style.display = 'block';
        if (currentQuestion === totalQuestions) {
            document.getElementById('submitExam').style.display = 'block'; // Show submit button
        } else {
            document.getElementById('submitExam').style.display = 'none'; // Hide submit button
        }
        updatePalette();
    }
}


    function clearResponse(questionId) {
        const options = document.getElementsByName('answer_' + questionId);
        options.forEach(option => {
            option.checked = false;
        });
        updatePalette();
    }

    function updatePalette() {
        palette.innerHTML = '';
        for (let i = 1; i <= totalQuestions; i++) {
            const questionDiv = document.getElementById('question' + i);
            const inputs = questionDiv.querySelectorAll('input[type="radio"]');
            let isAnswered = false;
            inputs.forEach(input => {
                if (input.checked) {
                    isAnswered = true;
                }
            });

            const paletteItem = document.createElement('div');
            paletteItem.classList.add('palette-item');
            paletteItem.textContent = i;

            if (i === currentQuestion) {
                paletteItem.style.border = '2px solid black';
            }

            if (isAnswered) {
                paletteItem.classList.add('answered');
            } else if (questionDiv.style.display === 'none') {
                paletteItem.classList.add('yet-to-visit');
            } else {
                paletteItem.classList.add('unanswered');
            }

            paletteItem.addEventListener('click', () => {
                document.getElementById('question' + currentQuestion).style.display = 'none';
                currentQuestion = i;
                document.getElementById('question' + currentQuestion).style.display = 'block';
                updatePalette();
            });

            palette.appendChild(paletteItem);
        }
        updateSummary();
    }

    function updateSummary() {
        answeredCount = document.querySelectorAll('.palette-item.answered').length;
        unansweredCount = totalQuestions - answeredCount;
        document.getElementById('answeredCount').textContent = answeredCount;
        document.getElementById('unansweredCount').textContent = unansweredCount;
    }
    </script>
</body>
</html>
