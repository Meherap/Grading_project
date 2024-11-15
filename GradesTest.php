<?php
use PHPUnit\Framework\TestCase;

class GradesTest extends TestCase {
    
    public function testCalculateFinalGrade() {
        $homeworks = [80, 90, 70, 60, 100];
        $quizzes = [75, 85, 65, 55, 95];
        $midterm = 88;
        $final_project = 92;
        
        $expectedFinalGrade = 84;
        $this->assertEquals($expectedFinalGrade, calculateFinalGrade($homeworks, $quizzes, $midterm, $final_project));
    }

    public function testDuplicateGradeCheck() {
        $conn = $this->createMock(mysqli::class);
        $stmtMock = $this->createMock(mysqli_stmt::class);
        $resultMock = $this->createMock(mysqli_result::class);
        
        $conn->method('prepare')->willReturn($stmtMock);
        $stmtMock->method('get_result')->willReturn($resultMock);
        $resultMock->method('num_rows')->willReturn(1);
        
        $student_id = 1;
        $this->assertTrue(checkDuplicateGrade($conn, $student_id));
    }

    public function testNoDuplicateGradeCheck() {
        $conn = $this->createMock(mysqli::class);
        $stmtMock = $this->createMock(mysqli_stmt::class);
        $resultMock = $this->createMock(mysqli_result::class);
        
        $conn->method('prepare')->willReturn($stmtMock);
        $stmtMock->method('get_result')->willReturn($resultMock);
        $resultMock->method('num_rows')->willReturn(0);
        
        $student_id = 2;
        $this->assertFalse(checkDuplicateGrade($conn, $student_id));
    }
}
?>
