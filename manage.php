<?php 
require_once 'config/db.php';
require_once 'config/functions.php';
$result = dispaly_data();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Scheduled Exams</title>
  <!-- Add Bootstrap CSS link -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Add SweetAlert CSS and JS links -->
  <link href="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.css" rel="stylesheet">
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
              <td>
                <!-- "Delete" button in the "Actions" column -->
                <button class="btn btn-sm btn-danger delete-exam" data-exam-id="<?php echo $row['id']; ?>">Delete</button>
              </td>  
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Add Bootstrap JavaScript link -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<!-- Add SweetAlert2 JS link -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10.16.0/dist/sweetalert2.min.js"></script>
<!-- Add this script at the end of your HTML body or in a separate JavaScript file -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Select all elements with the class 'delete-exam'
    const deleteButtons = document.querySelectorAll('.delete-exam');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const examId = this.getAttribute('data-exam-id');
            
            // Show SweetAlert confirmation dialog
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    // Make an AJAX request to delete.php with the exam ID
                    fetch('delete.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `exam_id=${encodeURIComponent(examId)}`,
                    })
                    .then(response => {
                        if (response.ok) {
                            // Show success message using SweetAlert
                            Swal.fire({
                                title: "Deleted!",
                                text: "Your file has been deleted.",
                                icon: "success"
                            }).then(() => {
                                // Reload the page after successful deletion
                                location.reload();
                            });
                        } else {
                            throw new Error('Network response was not ok');
                        }
                    })
                    .catch(error => {
                        console.error('There was a problem with your fetch operation:', error);
                    });
                }
            });
        });
    });
});
</script>

</body>
</html>
