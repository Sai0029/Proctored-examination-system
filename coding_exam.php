<?php
session_start(); // Start the PHP session

// Check if username is set in session, if not, redirect to login page
if (!isset($_SESSION['username'])) {
    header("Location: stu_login.php"); // Change "login.php" to the actual login page URL
    exit();
}

// Retrieve username from session
$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Website</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script> <!-- Include SweetAlert2 library -->
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: linear-gradient(45deg, #47e1dc, #556270);
        }

        .container {
            max-width: 1200px;
            margin: 100px auto;
            padding: 20px;
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: linear-gradient(45deg, #ffffff, #ffffff);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
        }

        .question {
            display: none;
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 5px;
            background: linear-gradient(45deg, #ffffff, #ffffff);;
        }

        .palette {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .palette-item {
            width: 30px;
            height: 30px;
            background-color: #ccc;
            border: 1px solid #aaa;
            border-radius: 50%;
            text-align: center;
            line-height: 30px;
            margin: 0 5px;
            cursor: pointer;
        }

        .palette-item.attempted {
            background-color: orange;
        }

        .palette-item.correct {
            background-color: green;
            color: #fff;
        }

        .palette-item.review {
            background-color: violet;
            color: #fff;
        }

        .question-container .btn {
            margin-top: 20px;
        }

        .legend {
            background-color: #f9f9f9;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        .legend h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            margin-bottom: 10px;
        }

        .legend-color {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            margin-right: 10px;
        }

        .legend-label {
            font-size: 14px;
        }

        .summary-box {
            margin-top: 60px;
            text-align: center;
        }

        .summary-box div {
            margin-bottom: 10px;
        }

        .count-box {
            display: block;
            width: 50px;
            height: 50px;
            border: 2px solid #ccc;
            border-radius: 10px;
            margin: 0 auto;
            margin-top: 5px;
            line-height: 50px;
            font-size: 18px;
        }
        .count-box.green {
            background-color: green;
        }

        .count-box.red {
            background-color: red;
        }

        .count-box.orange {
            background-color: orange;
        }

        .camera-feed {
            width: 100%;
            height: auto;
            border: 10px solid transparent; /* Initial border color */
            border-radius: 10px;
        }

        .timer-box {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 400px;
            font-size: 50px;
        }
    </style>
</head>
<body>
    
        <!-- Content goes here -->
    
    <div class="container rounded-lg shadow-lg p-4 bg-white">
    <div class="row">
        <div class="col-md-9">
            <h1>Welcome, <span id="username"><?php echo $username; ?></span>!</h1> <!-- Display username --> 
            <div class="timer">Time Remaining: <span id="timer">10:00</span></div>
            <!-- Quiz content -->
            <div class="question-container">
                <div class="question" id="question1">
                    <h2>Question 1</h2>
                    <p>Which of the following is the correct way to open a file in Python for reading?</p>
                    <div class="options">
                        <label><input type="radio" name="q1" value="open('file.txt', 'r')"> open('file.txt', 'r')</label><br>
                        <label><input type="radio" name="q1" value="open('file.txt', 'w')"> open('file.txt', 'w')</label><br>
                        <label><input type="radio" name="q1" value="open('file.txt', 'c')"> open('file.txt', 'c')</label><br>
                        <label><input type="radio" name="q1" value="open('file.txt', 'f')"> open('file.txt', 'f')</label><br>
                    </div>
                    <button class="btn btn-primary" onclick="saveAndNext(1)">Save and Next</button>
                    <!--<button class="btn btn-warning" onclick="markForReview(1)">Mark for Review</button>-->
                    <button class="btn btn-danger" onclick="clearResponse(1)">Clear Response</button>
                </div>
                <div class="question" id="question2">
                    <h2>Question 2</h2>
                    <p>Which data type is used to store a sequence of characters in Python?</p>
                    <div class="options">
                        <label><input type="radio" name="q2" value="Integer"> Integer</label><br>
                        <label><input type="radio" name="q2" value="String"> String</label><br>
                        <label><input type="radio" name="q2" value="Float"> Float</label><br>
                        <label><input type="radio" name="q2" value="None"> None</label><br>
                    </div>
                    <button class="btn btn-primary" onclick="saveAndNext(2)">Save and Next</button>
                    <!--<button class="btn btn-warning" onclick="markForReview(2)">Mark for Review</button> -->
                    <button class="btn btn-danger" onclick="clearResponse(2)">Clear Response</button>
                </div>
                <!-- Add more questions here -->
                <div class="question" id="question3">
                    <h2>Question 3</h2>
                    <p>Which method is used to remove an element from a list in Python?</p>
                    <div class="options">
                        <label><input type="radio" name="q3" value="pop()"> pop()</label><br>
                        <label><input type="radio" name="q3" value="remove()"> remove()</label><br>
                        <label><input type="radio" name="q3" value="delete()"> delete()</label><br>
                        <label><input type="radio" name="q3" value="None"> None</label><br>
                    </div>
                    <button class="btn btn-primary" onclick="saveAndNext(3)">Save and Next</button>
                    <!--<button class="btn btn-warning" onclick="markForReview(3)">Mark for Review</button> -->
                    <button class="btn btn-danger" onclick="clearResponse(3)">Clear Response</button>
                </div>
                <!-- Add more questions here -->
                <!-- Continue adding questions up to question 30 -->
            </div>
            <div class="palette" id="palette">
                <!-- Palette circles will be added dynamically using JavaScript -->
            </div>
            <button id="submitExam" class="btn btn-primary" style="display: none;" onclick="showResults()">Submit Exam</button>
        </div>
        <div class="col-md-3">
            <!-- Summary Box -->
            <div class="summary-box">
                <div>
                    <span>Answered</span>
                    <span class="count-box green" id="answeredCount">0</span>
                </div>
                <div>
                    <span>Unanswered</span>
                    <span class="count-box red" id="unansweredCount">0</span>
                </div>
                <div>
                    <span>Yet to Visit</span>
                    <span class="count-box orange" id="yetToVisitCount">30</span>
                </div>
            </div>
            <!-- Camera Section -->
            <div class="camera-section">
                <h2></h2>
                <video id="cameraFeed" class="camera-feed" autoplay></video>
            </div>
        </div>
    </div>
</div>

<div id="timerBox" class="timer-box" style="display:none;">
    <span id="timerDisplay"></span>
</div>

<script>
    function updateTimer() {
        let timeLeft = 600; // 10 minutes in seconds
        const timerElement = document.getElementById('timer');

        const timerInterval = setInterval(() => {
            const minutes = Math.floor(timeLeft / 60);
            let seconds = timeLeft % 60;

            // Add leading zero to seconds if less than 10
            seconds = seconds < 10 ? '0' + seconds : seconds;

            // Update the timer display
            timerElement.innerText = `${minutes}:${seconds}`;

            // Check if time has run out
            if (timeLeft === 0) {
                clearInterval(timerInterval);
                // You can add code here to handle what happens when the time runs out
            }

            // Decrement timeLeft
            timeLeft--;

        }, 1000); // Update every second
    }

    // Call the function to start the timer
    updateTimer();
    const totalQuestions = 3; // Total number of questions, change as per your requirement
    let currentQuestion = 1; // Current question number
    let answeredCount = 0; // Count of answered questions

    // Function to save answer and navigate to next question
    function saveAndNext(questionNumber) {
        const answer = document.querySelector(`input[name="q${questionNumber}"]:checked`);
        const paletteItem = document.getElementById(`palette-item-${questionNumber}`);

        if (answer) {
            paletteItem.classList.remove('attempted', 'review');
            paletteItem.classList.add('correct');
            answeredCount++;
        } else {
            paletteItem.classList.add('attempted');
        }

        if (currentQuestion < totalQuestions) {
            document.getElementById(`question${questionNumber}`).style.display = 'none';
            document.getElementById(`question${questionNumber + 1}`).style.display = 'block';
            currentQuestion++;
        } else {
            document.getElementById('submitExam').style.display = 'block';
        }
        updatePalette();
        updateSummary();
    }

    // Function to mark question for review
    function markForReview(questionNumber) {
        const paletteItem = document.getElementById(`palette-item-${questionNumber}`);
        paletteItem.classList.remove('attempted', 'correct');
        paletteItem.classList.toggle('review');
        updatePalette();
    }

    // Function to clear response of a question
    function clearResponse(questionNumber) {
        const answer = document.querySelector(`input[name="q${questionNumber}"]:checked`);
        if (answer) {
            answer.checked = false;
            answeredCount--;
        }
        const paletteItem = document.getElementById(`palette-item-${questionNumber}`);
        paletteItem.classList.remove('correct', 'attempted', 'review');
        updatePalette();
        updateSummary();
    }

    // Function to update summary box
    function updateSummary() {
        document.getElementById('answeredCount').innerText = answeredCount;
        document.getElementById('unansweredCount').innerText = totalQuestions - answeredCount;
        document.getElementById('yetToVisitCount').innerText = Math.max(totalQuestions - answeredCount - currentQuestion + 1, 0);
    }

    // Function to update palette colors based on question status
    function updatePalette() {
        for (let i = 1; i <= totalQuestions; i++) {
            const paletteItem = document.getElementById(`palette-item-${i}`);
            if (paletteItem) {
                if (paletteItem.classList.contains('review')) {
                    paletteItem.style.backgroundColor = 'violet';
                } else if (paletteItem.classList.contains('correct')) {
                    paletteItem.style.backgroundColor = 'green';
                } else if (paletteItem.classList.contains('attempted')) {
                    paletteItem.style.backgroundColor = 'orange';
                } else {
                    paletteItem.style.backgroundColor = '#ccc';
                }
            }
        }
    }

    // Function to generate palette circles dynamically
    function generatePalette() {
        const palette = document.getElementById('palette');
        for (let i = 1; i <= totalQuestions; i++) {
            const paletteItem = document.createElement('div');
            paletteItem.classList.add('palette-item');
            paletteItem.id = `palette-item-${i}`;
            paletteItem.innerText = i;
            paletteItem.setAttribute('onclick', `goToQuestion(${i})`);
            palette.appendChild(paletteItem);
        }
    }

    // Function to navigate to specific question using palette
    function goToQuestion(questionNumber) {
        for (let i = 1; i <= totalQuestions; i++) {
            const question = document.getElementById(`question${i}`);
            if (question) {
                if (i === questionNumber) {
                    question.style.display = 'block';
                } else {
                    question.style.display = 'none';
                }
            }
        }
        currentQuestion = questionNumber;
        if (currentQuestion === totalQuestions) {
            document.getElementById('submitExam').style.display = 'block';
        } else {
            document.getElementById('submitExam').style.display = 'none';
        }
        updatePalette();
        updateSummary();
    }

    // Initialize the quiz
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('question1').style.display = 'block'; // Show first question
        generatePalette(); // Generate palette circles
        updatePalette();
        updateSummary();
    });

    // Function to evaluate answers and show results
    function showResults() {
        let score = 0;
        // Example: Mapping answers to questions
        const correctAnswers = {
            "q1": "open('file.txt', 'r')",
            "q2": "String",
            "q3": "remove()"
            // Add more answers as needed
        };
        for (let i = 1; i <= totalQuestions; i++) {
            const answer = document.querySelector(`input[name="q${i}"]:checked`);
            if (answer && correctAnswers[`q${i}`] === answer.value) {
                score++;
            }
        }
        // Display results using SweetAlert2
        Swal.fire({
            title: 'Quiz Results',
            text: `Your score: ${score} out of ${totalQuestions}`,
            icon: 'info',
            confirmButtonText: 'Close'
        }).then((result) => {
            if (result.isConfirmed) {
                // Show timer box after submission
                document.getElementById('timerBox').style.display = 'flex';
                // Start a timer for one minute
                const resultTimer = 60; // 1 minute in seconds
                let timeLeft = resultTimer;
                const timerDisplay = document.getElementById('timerDisplay');
                const timerInterval = setInterval(() => {
                    timerDisplay.innerText = `Time Left: ${timeLeft} seconds`;
                    if (timeLeft === 0) {
                        clearInterval(timerInterval);
                        // Time's up, display final result
                        timerDisplay.innerText = "Time's up!";
                        // You can add any additional actions here
                    }
                    timeLeft--;
                }, 1000);
            }
        });
    }

    // Access the camera feed
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
</script>
</body>
</html>