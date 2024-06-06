<?php require 'config.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Questions and Options</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h2 class="text-center">Add Question and Options</h2>
            </div>
            <div class="card-body">
                <form id="question-form" action="insert.php" method="post">
                    <div class="form-group">
                        <label for="question">Question:</label>
                        <input type="text" class="form-control" id="question" name="question" required>
                    </div>

                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="topic">Topic:</label>
                            <select class="form-control" id="topic" name="topic">
                                <option value="Python">Python</option>
                                <option value="C">C</option>
                                <option value="Java">Java</option>
                                <option value="Data Structures">Data Structures</option>
                                <option value="Technical">Technical</option>
                                <option value="Aptitude">Aptitude</option>
                            </select>
                        </div>
                        <div class="form-group col-md-6">
                            <label for="difficulty">Difficulty:</label>
                            <select class="form-control" id="difficulty" name="difficulty">
                                <option value="Easy">Easy</option>
                                <option value="Medium">Medium</option>
                                <option value="Hard">Hard</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="options">Options:</label>
                        <div id="options-container">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="options[]" placeholder="Option 1" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="options[]" placeholder="Option 2" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="options[]" placeholder="Option 3" required>
                            </div>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control" name="options[]" placeholder="Option 4" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="correct_option">Correct Option:</label>
                        <input type="text" class="form-control" id="correct_option" name="correct_option" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

                <div class="mt-4">
                    <h3>Or Upload Excel File</h3>
                    <form id="upload-form">
                        <div class="form-group">
                            <label for="fileUpload">Choose Excel file:</label>
                            <input type="file" class="form-control-file" id="fileUpload" name="fileUpload" accept=".xlsx, .xls" required>
                        </div>
                        <button type="submit" class="btn btn-secondary">Upload</button>
                    </form>
                </div>
                <div class="mt-4">
                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#clearDataModal">Clear Data</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Clear Data Modal -->
    <div class="modal fade" id="clearDataModal" tabindex="-1" role="dialog" aria-labelledby="clearDataModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="clearDataModalLabel">Clear Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="clear-data-form">
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="clear_topic">Topic:</label>
                                <select class="form-control" id="clear_topic" name="topic">
                                    <option value="Python">Python</option>
                                    <option value="C">C</option>
                                    <option value="Java">Java</option>
                                    <option value="Data Structures">Data Structures</option>
                                    <option value="Technical">Technical</option>
                                    <option value="Aptitude">Aptitude</option>
                                </select>
                            </div>
                            <div class="form-group col-md-6">
                                <label for="clear_difficulty">Difficulty:</label>
                                <select class="form-control" id="clear_difficulty" name="difficulty">
                                    <option value="easy">Easy</option>
                                    <option value="medium">Medium</option>
                                    <option value="hard">Hard</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" id="clearDataButton">Clear Data</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.9/xlsx.full.min.js"></script>
    <script>
        document.getElementById('question-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var formData = new FormData(this);
            fetch('insert.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    swal("Success", "Question and options added successfully.", "success");
                    document.getElementById('question-form').reset();
                } else {
                    swal("Error", "Failed to add question and options: " + data, "error");
                }
            })
            .catch(error => {
                swal("Error", "Failed to add question and options.", "error");
            });
        });

        document.getElementById('upload-form').addEventListener('submit', function(event) {
            event.preventDefault();
            var fileInput = document.getElementById('fileUpload');
            var file = fileInput.files[0];

            if (!file) {
                swal("Error", "Please select a file to upload.", "error");
                return;
            }

            var reader = new FileReader();
            reader.onload = function(event) {
                var data = new Uint8Array(event.target.result);
                var workbook = XLSX.read(data, { type: 'array' });
                var firstSheet = workbook.Sheets[workbook.SheetNames[0]];
                var jsonData = XLSX.utils.sheet_to_json(firstSheet, { header: 1 });

                fetch('process_upload.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(jsonData)
                })
                .then(response => response.text())
                .then(data => {
                    if (data.trim() === 'success') {
                        swal("Success", "File uploaded and data processed successfully.", "success");
                        document.getElementById('upload-form').reset();
                    } else {
                        swal("Error", "Failed to process the file: " + data, "error");
                    }
                })
                .catch(error => {
                    swal("Error", "Failed to process the file.", "error");
                });
            };
            reader.readAsArrayBuffer(file);
        });

        document.getElementById('clearDataButton').addEventListener('click', function() {
            var formData = new FormData(document.getElementById('clear-data-form'));
            fetch('clear_data.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                if (data.trim() === 'success') {
                    swal("Success", "Data cleared successfully.", "success");
                    $('#clearDataModal').modal('hide');
                    document.getElementById('clear-data-form').reset();
                } else {
                    swal("Error", "Failed to clear data: " + data, "error");
                }
            })
            .catch(error => {
                swal("Error", "Failed to clear data.", "error");
            });
        });
    </script>
</body>
</html>
