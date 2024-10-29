# CSC350_HW5

# Grading Tool for Teachers

This grading tool helps teachers calculate final grades for students based on weighted scores from homeworks, quizzes, midterm, and final project. This tool simplifies grade entry, automatically applies the grading rubric, and saves all grades for future reference.

## Features
- Simple interface for selecting students and entering grades.
- Automatic calculation of final grades based on the given grading rubric.
- Ability to save grades in a database for easy retrieval and review.
- Display of all final grades for easy reference.

## Setup Instructions

### Step 1: Database Setup
1. Ensure you have MySQL installed.
2. Run the `setup.sql` file in your MySQL database to create necessary tables and insert sample students.
3. Update the `db_connect.php` file with your MySQL credentials.

### Step 2: Deploy the Tool
1. Place all project files, including `grade_tool.php`, `db_connect.php`, and `styles_reduced.css`, on your PHP-enabled server.
2. Make sure the database connection file (`db_connect.php`) points to the correct database.

### Step 3: Using the Tool
1. Open `grade_tool.php` in your web browser.
2. Use the form to:
   - Select a student from the dropdown.
   - Enter their scores for each homework, quiz, midterm, and final project.
   - Submit the form to calculate and save the student’s final grade.
3. View all students’ final grades in the “Final Grades” section below the form.

## Grading Rubric
This tool follows the grading rubric specified:
- **Homework**: 20% (average of all homeworks)
- **Quizzes**: 10% (average of quizzes after dropping the lowest)
- **Midterm**: 30%
- **Final Project**: 40%
- **Final Grade**: Rounded to the nearest whole number.

## Additional Notes
- Once grades are entered, they cannot be modified. 
- The tool only supports a fixed number of homeworks (5) and quizzes (5) based on the requirements.
- In case of any issues, refer to error messages displayed within the tool for guidance.
