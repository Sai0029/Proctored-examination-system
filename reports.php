<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Reports Dashboard</title>
<!-- Include Bootstrap CSS -->
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<style>
    /* Custom styles */
    body {
        font-family: Arial, sans-serif;
        background-color: #f8f9fa;
    }
    .container {
        margin-top: 50px;
    }
    .card {
        margin-bottom: 20px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }
    .card-header {
        background-color: #007bff;
        color: #fff;
        display: flex;
        justify-content: space-between; /* Align items horizontally */
        align-items: center; /* Align items vertically */
    }
    .home-icon {
        font-size: 24px;
        color: #fff;
        text-decoration: none;
    }
    .home-icon:hover {
        color: #ccc; /* Change color on hover */
    }
    .card-body table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 0;
    }
    .card-body table th,
    .card-body table td {
        padding: 10px;
        text-align: left;
        border-bottom: 1px solid #dee2e6;
    }
    .search-form {
        margin-bottom: 20px;
    }
</style>
</head>
<body>
<div class="container">
    <div class="card">
        <div class="card-header">
            <h3 class="mb-0">Exam Results</h3>
            <a href="admin_dashboard.php" class="home-icon">&nbsp;&#8962;</a>
        </div>
        <div class="card-body">
            <!-- Search form -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="GET" class="search-form">
                <div class="form-group">
                    <label for="searchTerm">Search by Username or Student ID:</label>
                    <input type="text" id="searchTerm" name="searchTerm" class="form-control" placeholder="Enter username or student ID">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <!-- Display search results -->
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Exam Title</th>
                            <th>Username</th>
                            <th>Student ID</th>
                            <th>Score</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Database connection parameters
                        $servername = "localhost";
                        $username = "root";
                        $password = "1234";
                        $database = "id22126747_myproject";

                        // Create connection
                        $conn = new mysqli($servername, $username, $password, $database);

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Handle search query
                        if(isset($_GET['searchTerm'])) {
                            $searchTerm = $_GET['searchTerm'];
                            $sql = "SELECT * FROM exam_results WHERE username LIKE '%$searchTerm%' OR student_id LIKE '%$searchTerm%'";
                            $result = $conn->query($sql);

                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>".$row["exam_title"]."</td>";
                                    echo "<td>".$row["username"]."</td>";
                                    echo "<td>".$row["student_id"]."</td>";
                                    echo "<td>".$row["score"]."</td>";
                                    echo "<td>".$row["exam_datetime"]."</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No exam results found for '$searchTerm'.</td></tr>";
                            }
                        }

                        $conn->close(); // Close the database connection
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    // Function to redirect to admin dashboard when home icon is clicked
    document.querySelector('.home-icon').addEventListener('click', function() {
        window.location.href = 'admin_dashboard.php'; // Change URL to your admin dashboard page
    });
</script>
</body>
</html>
