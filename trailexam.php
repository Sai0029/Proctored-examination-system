<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Exam</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f5f5f5;
        }
        .exam-container {
            width: 80%;
            max-width: 600px;
            background-color: white;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            border-radius: 4px;
        }
        .question {
            margin-bottom: 1rem;
        }
        .options {
            list-style: none;
            padding: 0;
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }
        .options li {
            padding: 0.5rem;
            background-color: #f5f5f5;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.2s ease-in-out;
        }
        .options li:hover {
            background-color: #e5e5e5;
        }
        .controls {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 2rem;
        }
    </style>
</head>
<body>
    <div class="exam-container">
        <div class="question">
            <h2>Question 1 of 5</h2>
            <p>What is the capital of France?</p>
        </div>
        <ul class="options">
            <li>A) London</li>
            <li>B) Berlin</li>
            <li>C) Paris</li>
            <li>D) Madrid</li>
        </ul>
        <div class="controls">
            <button>Previous</button>
            <button>Next</button>
        </div>
    </div>
</body>
</html>