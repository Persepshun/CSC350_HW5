<?php
include 'grade_tool.php';
include 'db_connect.php';

$db = new DBConnect();
$gradeTool = new GradeTool($db);

public function testCalculateFinalGrade() {
    $homeworkScores = [75, 89, 103, 55, 100];
    $quizScores = [65, 78, 99, 76, 69];
    $midterm = 86;
    $finalProject = 90;

    $expected = 87;
    $result = $this->gradeTool->calculateFinalGrade($homeworkScores, $quizScores, $midterm, $finalProject);

    $this->assertEquals($expected, $result, "Failed final grade calculation.");
}

public function testInsertOrUpdateGrade() {
    $result = $this->dbConnect->insertOrUpdateGrade(1, 'quiz', 1, 85);
    $this->assertTrue($result, "Failed to insert or update grade.");
}

function testSaveGradesNoDuplicates() {
    global $gradeTool, $db;
    $studentId = 1;
    $grades = [
        'homework' => [85, 88, 95, 90, 87],
        'quiz' => [75, 80, 85, 90, 95],
        'midterm' => [85],
        'final_project' => [92]
    ];

    // First save should succeed
    $gradeTool->saveGrades($studentId, $grades);
    $existingGrades = $db->fetchGrades($studentId);
    $initialCount = count($existingGrades);

    // Second save should not create duplicates due to REPLACE query
    $gradeTool->saveGrades($studentId, $grades);
    $newGrades = $db->fetchGrades($studentId);
    $newCount = count($newGrades);

    echo ($initialCount === $newCount) ? "testSaveGradesNoDuplicates: Pass\n" : "testSaveGradesNoDuplicates: Fail\n";
}

// Run tests
testCalculateFinalGrade();
testSaveGradesNoDuplicates();
?>
