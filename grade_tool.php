<?php
include 'db_connect.php';

class GradeTool {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getStudentList() {
        return $this->db->getStudents();
    }

    public function calculateFinalGrade($homeworkScores, $quizScores, $midterm, $finalProject) {
        $homeworkAverage = $this->calculateAverage($homeworkScores);
        $quizAverage = $this->dropLowestAndAverage($quizScores);

        $finalGrade = round(
            ($homeworkAverage * 0.2) +
            ($quizAverage * 0.1) +
            ($midterm * 0.3) +
            ($finalProject * 0.4)
        );

        return $finalGrade;
    }

    public function calculateAverage($scores) {
        return array_sum($scores) / count($scores);
    }

    public function dropLowestAndAverage($scores) {
        sort($scores);
        array_shift($scores); // Drop the lowest score
        return $this->calculateAverage($scores);
    }

    public function saveGrades($studentId, $grades) {
        foreach ($grades as $type => $scores) {
            foreach ($scores as $index => $score) {
                if (!$this->db->insertOrUpdateGrade($studentId, $type, $index + 1, $score)) {
                    echo "Failed to save grade for assignment $type $index.\n";
                }
            }
        }
    }
}
?>
