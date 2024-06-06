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
    $database = "myproject"; // Replace with your database name
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StudentDashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* Custom styles */
       body {
            /*background-color: ; / Use violet color */
                background-image:url('https://i.pinimg.com/564x/3c/8c/0a/3c8c0a7ffd3e0dd67f1b8749a7ac2861.jpg');
    background-color: rgba(101, 116, 205, 0.4); /* Adjust the opacity by changing the last value (0.5 in this case) */
    background-blend-mode: multiply;          color: blue; /* Use white text color */
       }
      

        .ag-format-container {
  width: 1142px;
  margin: 0 auto;
}


body {
  background-color: #000;
}
.ag-courses_box {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-align: start;
  -ms-flex-align: start;
  align-items: flex-start;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;

  padding: 50px 0;
}
.ag-courses_item {
  -ms-flex-preferred-size: calc(33.33333% - 30px);
  flex-basis: calc(33.33333% - 30px);

  margin: 0 15px 30px;

  overflow: hidden;

  border-radius: 28px;
}
.ag-courses-item_link {
  display: block;
  padding: 30px 20px;
  background-color: #121212;

  overflow: hidden;

  position: relative;
}
.ag-courses-item_link:hover,
.ag-courses-item_link:hover .ag-courses-item_date {
  text-decoration: none;
  color: #FFF;
}
.ag-courses-item_link:hover .ag-courses-item_bg {
  -webkit-transform: scale(10);
  -ms-transform: scale(10);
  transform: scale(10);
}
.ag-courses-item_title {
  min-height: 87px;
  margin: 0 0 25px;

  overflow: hidden;

  font-weight: bold;
  font-size: 30px;
  color: #FFF;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date-box {
  font-size: 18px;
  color: #FFF;

  z-index: 2;
  position: relative;
}
.ag-courses-item_date {
  font-weight: bold;
  color: #f9b234;

  -webkit-transition: color .5s ease;
  -o-transition: color .5s ease;
  transition: color .5s ease
}
.ag-courses-item_bg {
  height: 128px;
  width: 128px;
  background-color: #f9b234;

  z-index: 1;
  position: absolute;
  top: -75px;
  right: -75px;

  border-radius: 50%;

  -webkit-transition: all .5s ease;
  -o-transition: all .5s ease;
  transition: all .5s ease;
}
.ag-courses_item:nth-child(2n) .ag-courses-item_bg {
  background-color: #3ecd5e;
}
.ag-courses_item:nth-child(3n) .ag-courses-item_bg {
  background-color: #e44002;
}
.ag-courses_item:nth-child(4n) .ag-courses-item_bg {
  background-color: #952aff;
}
.ag-courses_item:nth-child(5n) .ag-courses-item_bg {
  background-color: #cd3e94;
}
.ag-courses_item:nth-child(6n) .ag-courses-item_bg {
  background-color: #4c49ea;
}



@media only screen and (max-width: 979px) {
  .ag-courses_item {
    -ms-flex-preferred-size: calc(50% - 30px);
    flex-basis: calc(50% - 30px);
  }
  .ag-courses-item_title {
    font-size: 24px;
  }
}

@media only screen and (max-width: 767px) {
  .ag-format-container {
    width: 96%;
  }

}
@media only screen and (max-width: 639px) {
  .ag-courses_item {
    -ms-flex-preferred-size: 100%;
    flex-basis: 100%;
  }
  .ag-courses-item_title {
    min-height: 72px;
    line-height: 1;

    font-size: 24px;
  }
  .ag-courses-item_link {
    padding: 22px 40px;
  }
  .ag-courses-item_date-box {
    font-size: 16px;
  }
}

        /* Adjust card size */
        .card {
            width: 300px; /* Adjust size as needed */
            margin: 0 10px; /* Add some space between cards */
        }

        .navbar {
              /* Use blue color for navbar */
          opacity: 80%  
      }

        .navbar-toggler {
            margin-left: auto; /* Align toggler to the right */
        }

        .navbar-brand {
            margin-right: auto; /* Align brand to the left */
        }

        .collapse.bg-dark {
            background-color: #512da8; /* Use blue color for collapsed navbar */
        }
       /* .bg-dark {
    background-color: #394C85E6 !important;
}*/
.bg-dark {
    background-color: #001a4ee6 !important;
}
.bg-light {
    background-color: #394C85E6  !important;
}
a {
    color: #ffffff;
    text-decoration: none;
    background-color: transparent;
}
        .collapse.bg-dark a {
            color: #ffffff !important; /* Use white text color for links in collapsed navbar */
        }

        .carousel-item {
            text-align: center; /* Center carousel items */
        }

        /* Responsive styles */
        @media (max-width: 576px) {
            .card {
                width: 250px; /* Adjust card size for smaller screens */
            }
        }
      .text-card {
    margin-top: 20px;
    text-align: center;
        color: white;
}

.text-card .card {
    width: 300px; /* Adjust size as needed */
    margin: 0 auto; /* Center the card horizontally */
   background-color: rgba(0, 0, 0, 0.226);
  
}
#session-time {
            position:sticky;
            top: 10px;
            right: 10px;
            color: white;
        }


    </style>
</head>
<body>

<div class="pos-f-t">
  <div class="collapse" id="navbarToggleExternalContent">
    <div class="bg-dark p-4">
    <h2><i class="fa-regular fa-user"></i> Welcome, <?php echo $_SESSION["username"]; ?></h2>
      <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="#">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Exams</a>
            </li>
        <ul class="navbar-nav">
            <li class="nav-item logout-icon">
                <a class="nav-link" href="#">
                    Logout <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
        </ul>    
    </div>
  </div>
  <nav class="navbar navbar-dark bg-light">
    <a class="navbar-brand" href="#" >SkillNest</a> <!-- Move brand to the left -->
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
  </nav>
  <div id="session-time"></div>

  <script>
      // Function to update session time
      function updateSessionTime() {
          var sessionTime = new Date();
          var hours = sessionTime.getHours();
          var minutes = sessionTime.getMinutes();
          var seconds = sessionTime.getSeconds();
          // Add leading zeros if needed
          hours = (hours < 10) ? "0" + hours : hours;
          minutes = (minutes < 10) ? "0" + minutes : minutes;
          seconds = (seconds < 10) ? "0" + seconds : seconds;
          // Update the session time display
          document.getElementById("session-time").innerHTML = "Session Time: " + hours + ":" + minutes + ":" + seconds;
      }
  
      // Update session time every second
      setInterval(updateSessionTime, 1000);
  
      // Initial call to display session time immediately
      updateSessionTime();
  </script>
</div>

<div class="container">
    <div class="ag-format-container">
        <div class="ag-courses_box">
            <div class="ag-courses_item">
                <a href="#" class="ag-courses-item_link">
                  <div class="ag-courses-item_bg"></div>
                  <div class="ag-courses-item_title">
                    C
                  </div>
                </a>
              </div>
      
          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
              <div class="ag-courses-item_title">
                Python
              </div>
            </a>
          </div>
      
          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
              <div class="ag-courses-item_title">
                Java
              </div>
            </a>
          </div>

          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
              <div class="ag-courses-item_title">
                HTML
              </div>
            </a>
          </div>

          <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
              <div class="ag-courses-item_title">
                Java Script
              </div>
            </a>
          </div>

         <div class="ag-courses_item">
            <a href="#" class="ag-courses-item_link">
              <div class="ag-courses-item_bg"></div>
              <div class="ag-courses-item_title">
                C++
              </div>
            </a>
          </div>
          <div class="container">
            <div class="card-carousel">
                <!-- Existing carousel code -->
            </div>
        </div>
      </div>
      
</div>
</div>
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $('.carousel').carousel({
        interval: 2000 // Adjust the interval (in milliseconds) for automatic scrolling
    });
</script>
</body>
</html>