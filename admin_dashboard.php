<?php
    session_start();
    // Check if admin is logged in
    if (!isset($_SESSION["valid"])) {
        header("Location: adminlogin.php");
        exit();
    }
    $username = $_SESSION["username"];
    // Set timezone to India/Kolkata
    date_default_timezone_set('Asia/Kolkata');

    // Connect to your MySQL database
    $servername = "localhost"; // Replace with your server name
    $database = "id22126747_myproject"; // Replace with your database name
    $username = "root"; // Default MySQL username for XAMPP
    $password = "1234"; // Default MySQL password for XAMPP is empty

    // Create connection
    $conn = new mysqli($servername, $username, $password, $database);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Query to get the total number of registered students
    $sql = "SELECT COUNT(*) AS total_students FROM student_users";
    $result = $conn->query($sql);

    $total_students = 0; // Initialize the variable

    if ($result && $result->num_rows > 0) {
        // Fetch the total number of registered students
        $row = $result->fetch_assoc();
        $total_students = $row["total_students"];
    }

    // Close the connection
    $conn->close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/9457119745.js" crossorigin="anonymous"></script>
    <title>Admin Dashboard</title>
    <!-- Add Bootstrap CSS link -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* CSS styles for course cards */
        
        .course-card {
            justify-content: center; 
            width: 200px; /* Adjust width to fit 4 cards per row */
            margin: 30px;
            padding: 0px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: #fff;
            display: inline-block;
            vertical-align: top;
            cursor: pointer; /* Add cursor pointer for clickable effect */
            transition: transform 0.2s ease; /* Add transition for smooth animation */
        }

        .course-card:hover {
            transform: translateY(-5px); /* Move the container up by 5 pixels on hover */
        }

        .course-thumbnail {
            width: 95%;
            height: 180px;
            object-fit: cover;
            border-radius: 4px;
        }

        .course-title {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0;
            text-align: center; /* Center align the course title */
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            display: flex;
            align-items: flex-start; /* Align items to the top */
            flex-direction: column; /* Stack children vertically */
        }

        .menu-bar {
            width: 100%; /* Full width */
            background-color: #333;
            color: #fff;
            overflow-y: auto;
            padding: 5px;
            display: flex;
            justify-content: space-between; /* Align items to the top */
            align-items: center; /* Align items to the center */
        }

        .menu-header {
            display: flex;
            flex-direction: column; /* Stack children vertically */
        }

        .menu-header h2 {
            margin-bottom: 5px; /* Add margin below the name */
        }

        .dashboard-body {
            display: flex;
            flex-direction: row; /* Display sidebar and content side by side */
        }

        .sidebar {
            width: 200px;
            background-color: #555;
            height: 100vh;
            padding: 20px 0;
            text-align: center;
        }

        .sidebar-toggle {
            color: #fff;
            cursor: pointer;
            margin-bottom: 20px;
            margin-left:160px;
            font-size: 24px;
        }

        .section {
            margin-top: 20px;
            width: 100%; /* Adjust as needed */
            padding: 0 15px; /* Add padding to center content */
        }

        .section h2 {
            margin-bottom: 10px;
            font-size: 20px; /* Decrease the font size */
            font-family: 'Times New Roman'; /* Change the font */
            color: orange; /* Change the color */
        }

        /* Custom styling for carousel arrows */
        .carousel-control-prev,
        .carousel-control-next {
            width: 2%;
            background-color: rgba(0, 0, 0, 0.3);
            border-radius: 5px;
            color: white;
            top: 50%;
            transform: translateY(-50%);
        }

        .carousel-control-prev {
            left: 0;
        }

        .carousel-control-next {
            right: 0;
        }

        .carousel-control-prev-icon,
        .carousel-control-next-icon {
            font-size: 24px;
        }

        .carousel-control-prev:hover,
        .carousel-control-next:hover {
            background-color: rgba(0, 0, 0, 0.5);
        }
        .logout-icon {
            margin-left: auto; /* Push the icon to the right */
            margin-right: 20px; /* Adjust as needed */
        }

        .logout-icon i {
            font-size: 24px; /* Adjust icon size */
            color: #fff; /* Set icon color */
            cursor: pointer; /* Add cursor pointer for clickable effect */
        }
        .rectangular-box {
            width: 200px; /* Adjust width as needed */
            height: 100px; /* Adjust height as needed */
            border-radius: 10px; /* Adjust border radius for curved corners */
            background-color: #808080; /* Background color */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            margin-left: 280px; /* Adjust margin as needed */
            margin-top: 0px; /* Adjust margin as needed */
            font-family: Arial, sans-serif; /* Adjust font family */
            font-size: 14px; /* Adjust font size */
            color: white; /* Adjust text color */
            padding: 10px; /* Adjust padding */
        }
        .rectangular-box:hover{
            background-color: #666; /* Change background color on hover */
            color: #fff; /* Change text color on hover */
            border-color: #555; /* Change border color on hover */
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3); /* Add box shadow on hover */
            transform: scale(1.05); /* Scale up the box slightly on hover */
        }


        /* Sidebar styles */
        .sidebar {
            margin-top:93px;
            width: 250px;
            background-color: #333;
            color: #fff;
            padding-top: 20px;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .sidebar a {
            padding: 10px;
            display: block;
            color: #fff;
            text-decoration: none;
        }

        .sidebar a:hover {
            background-color: #555;
        }

        .sidebar-heading {
            padding: 10px 10px;
            font-size: 1.2rem;
        }

        /* Main content styles */
        .main-content {
            margin-left: 250px;
            padding: 20px;
        }

        /* Course card styles */
        .course-card {
            width: 200px;
            margin: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #fff;
            text-align: center;
        }

        .course-card img {
            width: 100%;
            border-radius: 5px;
        }

        .course-title {
            margin-top: 10px;
            font-weight: bold;
        }

        /* Responsive styles */
        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                position: relative;
                height: auto;
            }
            .main-content {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>
<div class="menu-bar">
    <div class="menu-header">
        <h2><i class="fa-regular fa-user"></i> Welcome, <?php echo $_SESSION["username"]; ?></h2>
        <p><span id="current-time"></span></p> <!-- Date and time below the name -->
    </div>
    <div class="logout-icon">
    <a href="php/logout.php" onclick="return confirmLogout()"><i class="fas fa-sign-out-alt"></i></a>
    </div>
</div>


<div class="sidebar">
    <h2 class="sidebar-heading">Dashboard</h2>
    <a href="#"><i class="fas fa-home"></i> Home</a>
    <div class="sidebar-heading">
        <a href="#" class="sidebar-dropdown" id="manageCourseDropdown">
            <i class="fas fa-book"></i> Manage Course <i class="fas fa-caret-down"></i>
        </a>
    </div>
    <div class="sidebar-submenu" id="courseSubMenu" style="display: none;">
        <a href="#" data-toggle="modal" data-target="#modalForAddCourse"><i class="fas fa-plus"></i> Add Course</a>
        
    </div>
    <div class="sidebar-heading">
        <a href="#" class="sidebar-dropdown" id="manageExamDropdown">
            <i class="fas fa-pencil-alt"></i> Manage Exam <i class="fas fa-caret-down"></i>
        </a>
    </div>
    <div class="sidebar-submenu" id="examSubMenu" style="display: none;">
        <a href="#" id="addExamLink" data-toggle="modal" data-target="#modalForAddExam"><i class="fas fa-plus"></i> Add Exam</a>
        <a href="manage.php"><i class="fas fa-cog"></i> Manage Exam</a>

    </div>
   <!-- <a href="#"><i class="fas fa-users"></i> Manage Examinee</a>
    <a href="#"><i class="fas fa-trophy"></i> Ranking</a>-->
    <a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a>
    <a href="http://localhost:8000/SKILLNESTCHATROOM/"> <i class='far fa-comment-dots' style='font-size:24px'></i> Mentor Chat</a>
    <a href="ques.php"><i class="fas fa-comments"></i>Manage Questions</a> 
    <a href="https://ee00-2409-40f0-300b-416f-f599-66b-4320-bc7a.ngrok-free.app"> <i class='fas fa-video' style='font-size:24px'></i> Sessions</a>
</div>
<div class="modal fade" id="modalForAddCourse" tabindex="-1" role="dialog" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Course Form Fields -->
                <form id="addCourseForm" onsubmit="sendEmail(); reset(); return false;" >
                    <div class="form-group">
                        <label for="courseName">Course Name</label>
                        <input type="text" class="form-control" id="courseName" required>
                    </div>
                    <div class="form-group">
                        <label for="courseLevel">Course Level</label>
                        <select class="form-control" id="courseLevel">
                            <option value="beginner">Beginner</option>
                            <option value="intermediate">Intermediate</option>
                            <option value="advanced">Advanced</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="mobileNumber">Mobile Number</label>
                        <input type="text" class="form-control" id="mobileNumber" required>
                    </div>
                    <div class="form-group">
                        <label for="expectedDate">Expected Date</label>
                        <input type="text" class="form-control" id="expectedDate" placeholder="DD/MM/YYYY" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Add Exam -->
<div class="modal fade" id="modalForAddExam" tabindex="-1" role="dialog" aria-labelledby="addExamModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addExamModalLabel">Add Exam</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <!-- Exam Form Fields -->
                    <form id="addExamForm" action="process-form.php" method="POST" onsubmit="return validateDateTime()">
                        <div class="form-group">
                            <label for="selectCourse">Select Course</label>
                            <select class="form-control" id="selectCourse" name="selectCourse" required>
                                <option value="">Select Course</option>
                                <option value="C Programming">C Programming</option>
                                <option value="Python Programming">Python Programming</option>
                                <option value="Data Structures">Data Structures</option>
                                <option value="R programming">R programming</option>
                                <option value="DBMS">DBMS</option>
                                <option value="Operating system">Operating system</option>
                                <option value="Computer Networks">Computer Networks</option>
                                <option value="Software Engineering">Software Engineering</option>
                                <option value="Aptitude">Aptitude</option>
                                <option value="Aptitude">CodingExam</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="examTimeLimit">Exam Time Limit</label>
                            <select class="form-control" id="examTimeLimit" name="examTimeLimit" required>
                                <option value="">Select Exam Time Limit</option>
                                <option value="15">15 mins</option>
                                <option value="30">30 mins</option>
                                <option value="60">60 mins</option>
                                <option value="120">120 mins</option>
                                <option value="180">180 mins</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="questionLimit">Question Limit to Display</label>
                            <input type="number" class="form-control" id="questionLimit" name="questionLimit" required>
                        </div>
                        <div class="form-group">
                            <label for="examTitle">Exam Title</label>
                            <input type="text" class="form-control" id="examTitle"name="examTitle" required>
                        </div>
                        <div class="form-group">
                            
                            <label for="difficulty">Difficulty:</label>
        <select id="difficulty" name="difficulty" required>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select><br><br>
                        </div>
                        <div class="form-group">
                    <label for="start_date_time">Start Date and Time:</label>
                    <input type="datetime-local" class="form-control" id="start_date_time" name="start_date_time" required>
                </div>
                <div class="form-group">
                    <label for="end_date_time">End Date and Time:</label>
                    <input type="datetime-local" class="form-control" id="end_date_time" name="end_date_time" required>
                </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    

    <!-- Main Content -->
    <div class="main-content">
        <div class="section">
            <h2 style="font-size: 30px;"><strong>Courses</strong></h2>
            
            <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="row">
                            <?php
                            // Sample data for courses (replace with data from your database)
                            $courses = array(
                                array(
                                    'id' => 1,
                                    'title' => 'PSP',
                                    'thumbnail' => 'Assets/course1.jpg'
                                ),
                                array(
                                    'id' => 2,
                                    'title' => 'Python',
                                    'thumbnail' => 'Assets/course2.jpg'
                                ),
                                array(
                                    'id' => 3,
                                    'title' => 'DSA',
                                    'thumbnail' => 'Assets/course3.jpg'
                                ),
                                array(
                                    'id' => 4,
                                    'title' => 'R',
                                    'thumbnail' => 'Assets/course4.jpg'
                                ),
                                // Add more courses as needed
                            );

                            // Loop through courses and display them as cards
                            foreach ($courses as $index => $course) {
                                if ($index % 4 === 0 && $index !== 0) {
                                    echo '</div></div><div class="carousel-item"><div class="row">';
                                }
                                echo '<div class="col-sm-3">';
                                echo '<div class="course-card" onclick="viewCourse(' . $course['id'] . ')">';
                                echo '<img class="course-thumbnail" src="' . $course['thumbnail'] . '" alt="' . $course['title'] . '">';
                                echo '<div class="course-info">';
                                echo '<h2 class="course-title">' . $course['title'] . '</h2>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="rectangular-box">
    <p><strong>Total Students Registered <?php echo $total_students; ?></strong></p>
</div>

<script>
function validateDateTime() {
    const startDateTime = document.getElementById('start_date_time').value;
    const endDateTime = document.getElementById('end_date_time').value;
    const now = new Date().toISOString().slice(0, 16);

    if (startDateTime < now) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Date',
            text: 'The start date and time cannot be in the past.',
            confirmButtonText: 'OK'
        });
        return false;
    }

    if (startDateTime >= endDateTime) {
        Swal.fire({
            icon: 'error',
            title: 'Invalid Date',
            text: 'The end date and time must be after the start date and time.',
            confirmButtonText: 'OK'
        });
        return false;
    }

    return true;
}

function startExam(examId, examTitle, examDifficulty, startDateTime, endDateTime) {
    const now = new Date();
    const examStartDate = new Date(startDateTime);
    const examEndDate = new Date(endDateTime);

    if (now < examStartDate) {
        Swal.fire({
            icon: 'error',
            title: 'Cannot Start Exam',
            text: 'The exam cannot be started before the scheduled date and time.',
            confirmButtonText: 'OK'
        });
        return;
    }
}
    function viewCourse(courseId) {
        // Redirect to the detailed view page for the selected course
        window.location.href = 'course_details.php?id=' + courseId;
    }

    // Function to update date and time
    function updateDateTime() {
        var currentTime = new Date();
        var hours = currentTime.getHours();
        var minutes = currentTime.getMinutes();
        var seconds = currentTime.getSeconds();
        var day = currentTime.getDate();
        var month = currentTime.getMonth() + 1; // January is 0!
        var year = currentTime.getFullYear();

        // Add leading zeros if necessary
        hours = (hours < 10 ? "0" : "") + hours;
        minutes = (minutes < 10 ? "0" : "") + minutes;
        seconds = (seconds < 10 ? "0" : "") + seconds;
        month = (month < 10 ? "0" : "") + month;

        // Get the day of the week
        var days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        var dayName = days[currentTime.getDay()];

        // Display the date and time
        document.getElementById("current-time").innerHTML = day + '(' + dayName + ')-' + month + '-' + year + ' ' + hours + ':' + minutes + ':' + seconds;
    }

    // Call the function initially
    updateDateTime();
    // Update date and time every second
    setInterval(updateDateTime, 1000);

    // Function to confirm logout
    function confirmLogout() {
    // Show the confirmation dialog and store the result in a variable
    var confirmed = confirm("Are you sure you want to sign out?");
    
    // Check if the user confirmed logout
    if (confirmed) {
        // Redirect to logout page only if confirmed
        window.location.href = 'php/logout.php';
    }
    // Return false to prevent the default action if canceled
    return confirmed;
}



    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.sidebar-dropdown').forEach(function(item) {
            item.addEventListener('click', function() {
                var submenu = this.nextElementSibling;
                if (submenu) {
                    if (submenu.style.display === 'none' || submenu.style.display === '') {
                        submenu.style.display = 'block';
                    } else {
                        submenu.style.display = 'none';
                    }
                }
            });
        });

        // Show/hide course submenu options when the "Manage Course" dropdown is clicked
        var manageCourseDropdown = document.getElementById('manageCourseDropdown');
        if (manageCourseDropdown) {
            manageCourseDropdown.addEventListener('click', function() {
                var courseSubMenu = document.getElementById('courseSubMenu');
                if (courseSubMenu) {
                    if (courseSubMenu.style.display === 'none' || courseSubMenu.style.display === '') {
                        courseSubMenu.style.display = 'block';
                    } else {
                        courseSubMenu.style.display = 'none';
                    }
                }
            });
        }

        // Show/hide exam submenu options when the "Manage Exam" dropdown is clicked
        var manageExamDropdown = document.getElementById('manageExamDropdown');
        if (manageExamDropdown) {
            manageExamDropdown.addEventListener('click', function() {
                var examSubMenu = document.getElementById('examSubMenu');
                if (examSubMenu) {
                    if (examSubMenu.style.display === 'none' || examSubMenu.style.display === '') {
                        examSubMenu.style.display = 'block';
                    } else {
                        examSubMenu.style.display = 'none';
                    }
                }
            });
        }
    });
    document.addEventListener('DOMContentLoaded', function() {
        // Your existing JavaScript code

        // Show modal for adding exam when the "Add Exam" link is clicked
        var addExamLink = document.getElementById('addExamLink');
        if (addExamLink) {
            addExamLink.addEventListener('click', function() {
                $('#modalForAddExam').modal('show'); // Show the modal
            });
        }
    });

// Function to send email
function sendEmail() {
    // Retrieve form values
    var courseName = document.getElementById('courseName').value;
    var courseLevel = document.getElementById('courseLevel').value;
    var mobileNumber = document.getElementById('mobileNumber').value;
    var expectedDate = document.getElementById('expectedDate').value;

    // Compose email message with form data
    var emailMessage = "Course Name: " + courseName + "<br>" +
                       "Course Level: " + courseLevel + "<br>" +
                       "Mobile Number: " + mobileNumber + "<br>" +
                       "Expected Date: " + expectedDate;

    // Send email
    Email.send({
        Host: "smtp.elasticemail.com",
        Username: "sainagineni2002@gmail.com",
        Password: "A81BF252C0FF93DE331B3F3BC01F1F9E1EB8",
        To: 'sainagineni2002@gmail.com',
        From: "sainagineni2002@gmail.com",
        Subject: "New Course Registration",
        Body: emailMessage
    }).then(
        message =>{
            if(message=="OK"){
                Swal.fire({
                title: "Success!",
                text: "Message Sent Successfully!",
                icon: "success"
});
            }
        }
    ).catch(
        error => alert("Failed to send email: " + error)
    );
}


</script>
    <!-- Add Bootstrap JavaScript link -->
    <script src="https://smtpjs.com/v3/smtp.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
