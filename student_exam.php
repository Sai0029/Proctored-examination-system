<?php
// Database connection details
$host = "localhost";
$dbname = "id22126747_myproject";
$username = "root";
$password = "1234";

// Connect to the database
$conn = mysqli_connect($host, $username, $password, $dbname);

if (mysqli_connect_errno()) {
    die("Connection error: " . mysqli_connect_error());
}

// Function to retrieve exam data
function dispaly_data($conn) {
    $query = "SELECT id, course_name, exam_title, time_limit, question_limit, difficulty, start_date_time, end_date_time FROM exams";
    $result = mysqli_query($conn, $query);
    return $result;
}

$result = dispaly_data($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible"="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scheduled Exams</title>
  <!-- Add Bootstrap CSS link -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Add SweetAlert CSS and JS -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.7/dist/sweetalert2.all.min.js"></script>
</head>
<body class="bg-dark">
<div class="container mt-5">
  <div class="card">
    <div class="card-header bg-dark text-white">
      <h2 class="display-6 text-center">Scheduled Exams</h2>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered table-striped text-center">
          <thead class="thead-dark">
            <tr>
              <th>Course</th>
              <th>Exam Title</th>
              <th>Time Limit (mins)</th>
              <th>Question Limit</th>
              <th>Difficulty</th>
              <th>Start Date and Time</th>
              <th>End Date and Time</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
              while($row = mysqli_fetch_assoc($result)) {
            ?>
            <tr>
              <td><?php echo $row["course_name"]; ?></td>
              <td><?php echo $row['exam_title']; ?></td>
              <td><?php echo $row['time_limit']; ?></td>
              <td><?php echo $row['question_limit']; ?></td>
              <td><?php echo ucfirst($row['difficulty']); ?></td>
              <td><?php echo $row['start_date_time']; ?></td>
              <td><?php echo $row['end_date_time']; ?></td>
              <td>
                <!-- "Start" button in the "Actions" column -->
                <button class="btn btn-sm btn-primary" onclick="startExam(<?php echo $row['id']; ?>, '<?php echo $row['exam_title']; ?>', '<?php echo $row['difficulty']; ?>', '<?php echo $row['start_date_time']; ?>', '<?php echo $row['end_date_time']; ?>')">Start</button>
              </td>  
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
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

    if (now > examEndDate) {
        Swal.fire({
            icon: 'error',
            title: 'Cannot Start Exam',
            text: 'Exam time over.',
            confirmButtonText: 'OK'
        });
        return;
    }

    if (examTitle === "CodingExam") {
        // Redirect to codingexam.php for CodingExam
        window.location.href = 'coding_exam.php';
    } else {
        // Redirect to take_exam.php for other exams
        window.location.href = `take_exam.php?exam_id=${examId}&exam_title=${examTitle}&difficulty=${examDifficulty}`;
    }
}
</script>
</body>
</html>

<?php
// Close the database connection
mysqli_close($conn);
?>
