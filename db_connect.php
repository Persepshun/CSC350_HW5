<?php
class DBConnect {
    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=your_db_name", "username", "password");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    public function getStudents() {
        try {
            $stmt = $this->conn->query("SELECT * FROM students");
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching students: " . $e->getMessage();
            return [];
        }
    }

    public function fetchGrades($studentId) {
        try {
            $stmt = $this->conn->prepare("SELECT * FROM grades WHERE student_id = :studentId");
            $stmt->bindParam(':studentId', $studentId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Error fetching grades: " . $e->getMessage();
            return [];
        }
    }

    public function insertOrUpdateGrade($studentId, $assignmentType, $assignmentNumber, $score) {
        try {
            $stmt = $this->conn->prepare("REPLACE INTO grades (student_id, assignment_type, assignment_number, score) VALUES (:studentId, :type, :number, :score)");
            $stmt->bindParam(':studentId', $studentId);
            $stmt->bindParam(':type', $assignmentType);
            $stmt->bindParam(':number', $assignmentNumber);
            $stmt->bindParam(':score', $score);
            return $stmt->execute();
        } catch (PDOException $e) {
            echo "Error inserting or updating grade: " . $e->getMessage();
            return false;
        }
    }
}