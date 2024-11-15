<?php
function connectToDatabase() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "grading_tool";
    
    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    return $conn;
}

function checkDuplicateGrade($conn, $student_id) {
    $sql = "SELECT * FROM grades WHERE student_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

function calculateFinalGrade($homeworks, $quizzes, $midterm, $final_project) {
    $homework_avg = array_sum($homeworks) / count($homeworks);
    sort($quizzes);
    array_shift($quizzes);
    $quiz_avg = array_sum($quizzes) / count($quizzes);
    return round(($homework_avg * 0.2) + ($quiz_avg * 0.1) + ($midterm * 0.3) + ($final_project * 0.4));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn = connectToDatabase();
    $student_id = $_POST['student_id'];
    
    if (checkDuplicateGrade($conn, $student_id)) {
        echo "Error: Duplicate grade entry for student ID $student_id.";
    } else {
        $homeworks = [
            $_POST['homework_1'], $_POST['homework_2'], $_POST['homework_3'], 
            $_POST['homework_4'], $_POST['homework_5']
        ];
        $quizzes = [
            $_POST['quiz_1'], $_POST['quiz_2'], $_POST['quiz_3'], 
            $_POST['quiz_4'], $_POST['quiz_5']
        ];
        
        $final_grade = calculateFinalGrade($homeworks, $quizzes, $_POST['midterm'], $_POST['final_project']);
        
        $sql = "INSERT INTO grades (student_id, homework_1, homework_2, homework_3, homework_4, homework_5, quiz_1, quiz_2, quiz_3, quiz_4, quiz_5, midterm, final_project, final_grade) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iiiiiiiiiiiiii", $student_id, ...$homeworks, ...$quizzes, $_POST['midterm'], $_POST['final_project'], $final_grade);
        
        if ($stmt->execute()) {
            echo "Grades successfully added! Final Grade: $final_grade";
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $conn->close();
}
?>
