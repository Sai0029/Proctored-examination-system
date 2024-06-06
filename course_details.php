<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course Details</title>
    <style>
        /* CSS styles for layout */
        .container {
            display: flex;
            justify-content: space-between; /* Distribute space between the two frames */
        }
        .course-details {
            flex: 1; /* Let the course details frame take up remaining space */
            margin-right: 10px; /* Add some spacing between frames */
            position: relative; /* Position the button relative to this div */
        }
        .compiler {
            flex: 1; /* Let the compiler frame take up remaining space */
            margin-left: 10px; /* Add some spacing between frames */
        }
        .course-thumbnail {
            width: 20%;
            height: auto;
            border-radius: 50px;
        }
        .course-title {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .course-description {
            margin-bottom: 20px;
        }
        .course-content {
            line-height: 1.6;
        }
        .compiler {
            flex: 1;
            margin-left: 10px;
            display: flex;
            flex-direction: column;
            height: 200%; /* Make the compiler container fill the entire height */
        }

        .editor-container {
            flex: 1; /* Take up remaining space vertically */
        }

        .editor-container div {
            height: 100%; /* Ensure the embedded compiler fills the container */
        }
        
        .navigation {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .navigation button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .navigation button:hover {
            background-color: #0056b3;
        }
        .extra-content {
            display: none; /* Hide extra content initially */
        }
        .next-button {
            position: absolute;
            bottom: 10px;
            right: 10px;
        }
        .read-aloud-button {
            position: absolute; /* Position the play button absolutely */
            top: 10px; /* Adjust top position */
            right: 10px; /* Adjust right position */
            z-index: 1; /* Ensure it's above other content */
            font-size: 24px;
            cursor: pointer;
        }
        .read-aloud-symbol::before {
            content: "\1F50A"; /* Unicode character for speaker icon */
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="course-details">
        <button class="read-aloud-button read-aloud-symbol" onclick="toggleReadAloud()"></button>
            <?php
            $course_id = isset($_GET['id']) ? $_GET['id'] : 1; // Default to first course if ID not provided
            // Use $course_id to fetch course details from the database and display them
            // Example:
            // Connect to database and fetch course details
            // Display course details
            $courses = array(
                array(
                    'id' => 1,
                    'title' => 'Problem Solving And Programming using C',
                    'content' => ' <h2>Problem Solving and Programming Concepts</h2>
                    <p>Problem-solving is a systematic approach aimed at identifying and resolving issues. Computers, functioning as symbol manipulation devices, execute sets of instructions known as programs.</p>

                    <h3>Program:</h3>
                    <p>A program comprises instructions executed by a computer to accomplish specific tasks. The process of creating programs is termed programming.</p>

                    <h3>Problem-solving Technique:</h3>
                    <p>Problem-solving extends beyond merely managing problems; it entails resolving them effectively. Individuals encounter problems during routine tasks or decision-making. The following are fundamental steps for problem-solving:</p>

                    <ol>
                        <li>Identify and Define the Problem</li>
                        <li>Generate Possible Solutions</li>
                        <li>Evaluate Alternatives</li>
                        <li>Decide on a Solution</li>
                        <li>Implement the Solution</li>
                        <li>Evaluate the Result</li>
                    </ol>

                    <h3>Algorithm:</h3>
                    <p>An algorithm comprises rules defining how a specific problem can be solved in a finite number of steps. Essential characteristics of a good algorithm include:</p>

                    <ul>
                        <li>Input</li>
                        <li>Output</li>
                        <li>Definiteness</li>
                        <li>Effectiveness</li>
                        <li>Finiteness</li>
                        <li>Correctness</li>
                    </ul>


                        ',
                    'extra_content' => 'This is additional content for the "Problem Solving And Programming using C" course.',
                    'thumbnail' => 'Assets/course1.jpg'
                ),
                array(
                    'id' => 2,
                    'title' => 'Python',
                    'content' => '<p>Course 2 content goes here...</p>',
                    'extra_content' => '',
                    'thumbnail' => 'Assets/course2.jpg'
                ),
                array(
                    'id' => 3,
                    'title' => 'DSA',
                    'content' => '<p>Course 1 content goes here...</p>',
                    'extra_content' => '',
                    'thumbnail' => 'Assets/course3.jpg'
                ),
                array(
                    'id' => 4,
                    'title' => 'R',
                    'content' => '<p>Course 2 content goes here...</p>',
                    'extra_content' => '',
                    'thumbnail' => 'Assets/course4.jpg'
                ),
                // Add more courses as needed
            );

            foreach ($courses as $course) {
                if ($course['id'] == $course_id) {
                    echo '<div class="course-details">';
                    echo '<img class="course-thumbnail" src="' . $course['thumbnail'] . '" alt="' . $course['title'] . '">';
                    echo '<h2 class="course-title">' . $course['title'] . '</h2>';
                    echo '<div class="course-content">' . $course['content'] . '</div>';
                    echo '<div class="extra-content">' . $course['extra_content'] . '</div>'; // Display extra content
                    echo '</div>';
                    break;
                }
            }
            ?>
             <button class="next-button" onclick="handleNextButtonClick()">Next</button>
             <button class="back-button" onclick="window.location.href = 'admin_dashboard.php'">Back</button>
             
        </div>
        <div class="compiler">
            <!-- Right part content: Embed the code editor here -->
            <div class="editor-container active">
                <div data-pym-src="https://www.jdoodle.com/embed/v1/4f59f386bdfa2b8b"></div>
            </div>
        </div>
    </div>
    <script src="https://www.jdoodle.com/assets/jdoodle-pym.min.js" type="text/javascript"></script>
    <script>
        // Function to handle next button click
        function handleNextButtonClick() {
            // Determine the next page URL based on the current course ID
            var nextPageUrl = '';
            switch (<?php echo $course_id; ?>) {
                case 1:
                    nextPageUrl = 'C2.php';
                    break;
                case 2:
                    nextPageUrl = 'next_page_for_c2.php';
                    break;
                case 3:
                    nextPageUrl = 'next_page_for_c3.php';
                    break;
                case 4:
                    nextPageUrl = 'next_page_for_c4.php';
                    break;
                default:
                    // If no matching course ID, go to a default page
                    nextPageUrl = 'default_next_page.php';
            }
            // Redirect to the next page
            window.location.href = nextPageUrl;
        }

    
    </script>
    <script>
        let isSpeaking = false; // Variable to track if speech synthesis is speaking

        function toggleReadAloud() {
            if (isSpeaking) {
                stopSpeech(); // Stop speech if already speaking
            } else {
                startSpeech(); // Start speech if not already speaking
            }
        }

        function startSpeech() {
            var courseContent = document.querySelector('.course-details').innerText;
            var speech = new SpeechSynthesisUtterance(courseContent);
            window.speechSynthesis.speak(speech);
            isSpeaking = true; // Set speaking status to true
        }

        function stopSpeech() {
            window.speechSynthesis.cancel(); // Cancel speech
            isSpeaking = false; // Set speaking status to false
        }
    </script>
</body>
</html>
