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
            bottom: -5px;
            right: 10px;
        }
        .back-button {
            position: absolute;
            bottom: -5px;
            left: 10px; /* Adjusted left position for the "Back" button */
        }
        .flowchart-image {
            max-width: 50%;
            height: auto;
            margin-top: 20px;
            margin-left:100px;
            overflow: hidden
        }
        
    </style>
</head>
<body>
    <div class="container">
        <div class="course-details">
            <?php
            $course_id = isset($_GET['id']) ? $_GET['id'] : 1; // Default to first course if ID not provided
            // Use $course_id to fetch course details from the database and display them
            // Example:
            // Connect to database and fetch course details
            // Display course details
            $courses = array(
                array(
                    'id' => 1,
                    'title' => 'Elements Of C',
                    'content' => 
                    '<h2>Character Set</h2>
                    <p>The set of characters that are used to words, numbers and expression in C is called c character set. The combination of these characters form words, numbers and expression in C. The characters in C are grouped into the following four categories:</p>
                    
                    <h3>1. letters or alphabets</h3>
                    <p>
                        Uppercase alphabets – A…Z<br>
                        Lowercase alphabets – a…z
                    </p>
                    
                    <h3>2. Digits</h3>
                    <p>All decimal digits – 0 1 2 3 4 5 6 7 8 9</p>
                    
                    <h3>3. Special Characters</h3>
                    <table>
                        <tr>
                            <th>Symbol</th>
                            <th>Meaning</th>
                            <th>Symbol</th>
                            <th>Meaning</th>
                        </tr>
                        <tr>
                            <td>,</td>
                            <td>comma</td>
                            <td>&</td>
                            <td>ampersand</td>
                        </tr>
                        <tr>
                            <td>.</td>
                            <td>period</td>
                            <td>^</td>
                            <td>caret</td>
                        </tr>
                        <tr>
                            <td>;</td>
                            <td>semicolon</td>
                            <td>*</td>
                            <td>asterisk</td>
                        </tr>
                        <!-- Add more rows as needed -->
                    </table>
                    
                    <h3>4. White Spaces</h3>
                    <p>
                        Blank space<br>
                        Horizontal tab<br>
                        Vertical tab<br>
                        Carriage return<br>
                        New line or line feed<br>
                        Form feed
                    </p>
                    
                    <h2>Keywords</h2>
                    <p>
                        Keywords are predefined words for a C programming language. All keywords have fixed meaning and these meanings cannot be changed. They serve as basic building blocks for program statements. ANSIC keywords are listed below:
                    </p>
                    <p>
                        auto, double, int, struct, break, else, long switch, case, enum, register, typedef, char, extern, return, union, const, float, short, unsigned, continue, signed, void, for, default, goto, sizeof, volatile, do, if, static, while.
                    </p>
                    
                    <h2>Identifiers</h2>
                    <p>
                        Every word used in C program to identify the name of variables, functions, arrays, pointers and symbolic constants are known as identifiers. They are names given by the user and consist of a sequence of letters and digits, with a letters as the first character. The underscore character can also be used to link between two words in long identifiers.
                    </p>
                    '
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
                    echo '<h2 class="course-title">' . $course['title'] . '</h2>';
                    echo '<div class="course-content">' . $course['content'] . '</div>';
                    echo '</div>';
                    break;
                }
            }
            ?>
            <button class="next-button" onclick="window.location.href = 'C4.php'">Next</button>
            <button class="back-button" onclick="window.location.href = 'C2.php'">Back</button>


        </div>
        <div class="compiler">
            <!-- Right part content: Embed the code editor here -->
            <div class="editor-container active">
                <div data-pym-src="https://www.jdoodle.com/embed/v1/4f59f386bdfa2b8b"></div>
            </div>
        </div>
    </div>
    <script src="https://www.jdoodle.com/assets/jdoodle-pym.min.js" type="text/javascript"></script>
</body>
</html>
