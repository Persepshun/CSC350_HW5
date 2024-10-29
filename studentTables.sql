-- setup.sql

-- Create the students table
CREATE TABLE students (
    student_id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL
);

-- Insert sample students
INSERT INTO students (name) VALUES ('John Doe'), ('Jane Smith'), ('Emily Davis');

-- Create the grades table to store individual scores
CREATE TABLE grades (
    grade_id INT PRIMARY KEY AUTO_INCREMENT,
    student_id INT,
    homework1 INT,
    homework2 INT,
    homework3 INT,
    homework4 INT,
    homework5 INT,
    quiz1 INT,
    quiz2 INT,
    quiz3 INT,
    quiz4 INT,
    quiz5 INT,
    midterm INT,
    final_project INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Create a final_scores table for storing the final calculated grade
CREATE TABLE final_scores (
    student_id INT PRIMARY KEY,
    final_grade INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);
