<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proctored Examination System Setup</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            width: 80%;
            margin: auto;
            overflow: hidden;
        }
        header {
            background: #333;
            color: #fff;
            padding-top: 30px;
            min-height: 70px;
            border-bottom: #77a4d3 3px solid;
        }
        header a, footer a {
            color: #fff;
            text-decoration: none;
            text-transform: uppercase;
            font-size: 16px;
        }
        header ul {
            padding: 0;
            list-style: none;
        }
        header ul li {
            display: inline;
            margin: 0 20px;
        }
        header ul li a:hover, footer ul li a:hover {
            color: #77a4d3;
        }
        .content {
            padding: 20px;
            background: #fff;
            margin-top: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        footer {
            background: #333;
            color: #fff;
            text-align: center;
            padding: 20px;
            margin-top: 20px;
            border-top: #77a4d3 3px solid;
        }
        .code {
            background: #f4f4f4;
            border-left: 5px solid #77a4d3;
            padding: 10px;
            margin: 20px 0;
            overflow-x: auto;
        }
    </style>
</head>
<body>
    <header>
        <div class="container">
            <h1>Proctored Examination System Setup</h1>
        </div>
    </header>

    <div class="container content">
        <section>
            <h2>Project Overview</h2>
            <p>The <strong>Proctored Examination System</strong> is designed for college faculty to post exams, monitor student results, and chat with students. Students can attend exams, and their attendance will be marked via facial recognition. Continuous proctoring will ensure no tab switching during the exam.</p>
        </section>

        <section>
            <h2>Database Setup</h2>
            <p>Create the database <code>id22126747_myproject</code> and import the provided SQL file <code>id22126747_myproject.sql</code>. Follow these steps:</p>
            <div class="code">
                <pre>
CREATE DATABASE id22126747_myproject;

-- Import the database schema
mysql -u [username] -p id22126747_myproject < id22126747_myproject.sql
                </pre>
            </div>
        </section>

        <section>
            <h2>Backend Server Setup</h2>
            <p>To set up the backend Flask server:</p>
            <ol>
                <li>Download the necessary files from the provided drive link.</li>
                <li>Activate your Python virtual environment and install the dependencies:</li>
                <div class="code">
                    <pre>
python -m venv venv
source venv/bin/activate  # On Windows use `venv\Scripts\activate`
pip install -r requirements.txt
                    </pre>
                </div>
                <li>Ensure you have the following code in your Flask app:</li>
                <div class="code">
                    <pre>
from flask import Flask, render_template, request, jsonify, session
from sqlalchemy import create_engine
import io
import sys
import os
import cv2
import numpy as np
import mysql.connector
import datetime
from flask_cors import CORS
from flask_sslify import SSLify
import base64
import numpy as np
import io
import cv2
                    </pre>
                </div>
                <li>Run <code>train.py</code> to train the face recognition model with your ID.</li>
                <li>Create the database <code>attendance_db</code> and import the provided Excel file.</li>
                <li>Run the server:</li>
                <div class="code">
                    <pre>
flask run --host=0.0.0.0 --port=5000
                    </pre>
                </div>
                <li>Install mkcert and generate SSL certificates for CORS origin support:</li>
                <div class="code">
                    <pre>
mkcert -install
mkcert localhost
                    </pre>
                </div>
            </ol>
        </section>

        <section>
            <h2>Contact Information</h2>
            <p>If you have any questions or need further assistance, please feel free to reach out:</p>
            <ul>
                <li>Email: <a href="mailto:nsai0029@gmail.com">nsai0029@gmail.com</a></li>
                <li>Phone: <a href="tel:+6301230716">6301230716</a></li>
                <li>WhatsApp: <a href="https://wa.me/6301230716">Chat on WhatsApp</a></li>
            </ul>
        </section>
    </div>

    <footer>
        <div class="container">
            <p>&copy; 2024 Proctored Examination System. All Rights Reserved.</p>
        </div>
    </footer>
</body>
</html>
