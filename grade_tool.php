<?php
// Database connection file inclusion
include 'db_connect.php';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $student_id = $_POST['student_id'];
    $homework = array_map('intval', [$_POST['homework1'], $_POST['homework2'], $_POST['homework3'], $_POST['homework4'], $_POST['homework5']]);
    $quizzes = array_map('intval', [$_POST['quiz1'], $_POST['quiz2'], $_POST['quiz3'], $_POST['quiz4'], $_POST['quiz5']]);
    $midterm = intval($_POST['midterm']);
    $final_project = intval($_POST['final_project']);

    // Calculate averages and final grade based on provided rubric
    $homework_avg = array_sum($homework) / count($homework);
    sort($quizzes);
    array_shift($quizzes); // Drop the lowest quiz score
    $quiz_avg = array_sum($quizzes) / count($quizzes);
    $final_grade = round(($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($midterm * 0.3) + ($final_project * 0.4));

    // Prepare and execute SQL query for grades insertion
    $stmt = $pdo->prepare("
        INSERT INTO grades (
            student_id, homework1, homework2, homework3, homework4, homework5,
            quiz1, quiz2, quiz3, quiz4, quiz5, midterm, final_project
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");
    $stmt->execute([
        $student_id,
        $homework[0], $homework[1], $homework[2], $homework[3], $homework[4],
        $quizzes[0], $quizzes[1], $quizzes[2], $quizzes[3], $quizzes[4],
        $midterm,
        $final_project
    ]);

    // Insert or update the final grade in the final_scores table
    $stmt = $pdo->prepare("REPLACE INTO final_scores (student_id, final_grade) VALUES (?, ?)");
    $stmt->execute([$student_id, $final_grade]);

    // Success message for grade submission
    $message = "Final grade for student ID $student_id: $final_grade";
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Grading Tool</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="instructions-box">
    <h2>Grading Tool for Teachers</h2>
    <h3>Welcome to the Grading Tool! Follow these steps:</h3>
    <ul class="instructions">
        <li>1. Choose a student from the dropdown menu.</li>
        <li>2. Enter scores for each homework, quiz, the midterm, and the final project.</li>
        <li>3. Press "Submit Grades" to calculate and save the student's final grade.</li>
        <li>4. Review all students' final grades in the table below.</li>
    </ul>
    <p class="note">Note: You can enter grades for a student only once. After submission, grades are saved permanently.</p>
</div>


    <?php if (isset($message)): ?>
        <p class="success-message"><?php echo $message; ?></p>
    <?php endif; ?>

    <form action="grade_tool.php" method="POST" onsubmit="return validateForm()">
        <label for="student_id">Select Student:</label>
        <select name="student_id" id="student_id" required>
            <option value="">--Select a student--</option>
            <?php foreach ($students as $student): ?>
                <option value="<?php echo $student['student_id']; ?>"><?php echo $student['name']; ?></option>
            <?php endforeach; ?>
        </select>

        <h3>Homework Scores</h3>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <label for="homework<?= $i ?>">Homework <?= $i ?>:</label>
            <input type="number" name="homework<?= $i ?>" id="homework<?= $i ?>" placeholder="0-100" min="0" max="100" required>
        <?php endfor; ?>

        <h3>Quiz Scores</h3>
        <?php for ($i = 1; $i <= 5; $i++): ?>
            <label for="quiz<?= $i ?>">Quiz <?= $i ?>:</label>
            <input type="number" name="quiz<?= $i ?>" id="quiz<?= $i ?>" placeholder="0-100" min="0" max="100" required>
        <?php endfor; ?>

        <h3>Midterm</h3>
        <label for="midterm">Midterm Score:</label>
        <input type="number" name="midterm" id="midterm" placeholder="0-100" min="0" max="100" required>

        <h3>Final Project</h3>
        <label for="final_project">Final Project Score:</label>
        <input type="number" name="final_project" id="final_project" placeholder="0-100" min="0" max="100" required>

        <button type="submit">Submit Grades</button>
    </form>

    <script>
    function validateForm() {
        const inputs = document.querySelectorAll('input[type="number"]');
        for (const input of inputs) {
            const value = parseInt(input.value);
            if (isNaN(value) || value < 0 || value > 100) {
                alert("Please enter a valid score between 0 and 100 for " + input.name);
                input.focus();
                return false;
            }
        }
        return true;
    }
    </script>

<div class="final-grades-box">
    <h2>Final Grades</h2>
    <table class="grades-table">
        <tr>
            <th>Student Name</th>
            <th>Final Grade</th>
        </tr>
        <?php
        $stmt = $pdo->query("SELECT students.name, final_scores.final_grade FROM final_scores
                             JOIN students ON final_scores.student_id = students.student_id");
        foreach ($stmt as $row) {
            echo "<tr><td>{$row['name']}</td><td>{$row['final_grade']}</td></tr>";
        }
        ?>
    </table>
</div>
</body>
</html>
