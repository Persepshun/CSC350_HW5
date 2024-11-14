-- setup.sql
-- Example of improved schema with row-based grade storage
CREATE TABLE IF NOT EXISTS students (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL
);

CREATE TABLE IF NOT EXISTS grades (
    id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT NOT NULL,
    assignment_type ENUM('homework', 'quiz', 'midterm', 'final_project') NOT NULL,
    assignment_number INT NOT NULL, -- for homework/quiz numbers
    score DECIMAL(5,2) CHECK (score BETWEEN 0 AND 110),
    UNIQUE(student_id, assignment_type, assignment_number),
    FOREIGN KEY (student_id) REFERENCES students(id) ON DELETE CASCADE
);

-- Insert sample students
INSERT INTO students (name) VALUES ('John Doe'), ('Jane Smith'), ('Alice Johnson');

-- Create a final_scores table for storing the final calculated grade
CREATE TABLE final_scores (
    student_id INT PRIMARY KEY,
    final_grade INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);
