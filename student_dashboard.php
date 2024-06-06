<?php
    session_start();
    // Check if admin is logged in
    if (!isset($_SESSION["valid"])) {
        header("Location: stu_login.php");
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
    <title>Student Dashboard</title>
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
        .sidebar a {
            display: block;
            padding: 10px 0;
            color: #fff;
            text-decoration: none;
            transition: background-color 0.3s ease;
            font-size: 24px; /* Increase font size */
        }

        .sidebar a:hover {
            background-color: #444;
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

    <div class="dashboard-body">
        <!-- Sidebar -->
        <div class="sidebar">
        <a href="student_exam.php"><i class="fas fa-graduation-cap"></i> Exams</a>
        <a href="http://localhost:8000/SKILLNESTCHATROOM/"> <i class='far fa-comment-dots' style='font-size:24px'></i> Mentor Chat</a>
        <a href="https://ee00-2409-40f0-300b-416f-f599-66b-4320-bc7a.ngrok-free.app"> <i class='fas fa-video' style='font-size:24px'></i> Sessions</a>
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
    <script>
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
        function confirmLogout() {
        if (confirm("Are you sure you want to sign out?")) {
            window.location.href = 'php/logout.php';
        }
    }
    function confirmLogout() {
    if (confirm("Are you sure you want to sign out?")) {
        return true; // Allow logout if user clicks OK
    } else {
        return false; // Prevent logout if user clicks Cancel
    }
}

    </script>

    <!-- Add Bootstrap JavaScript link -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
