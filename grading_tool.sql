CREATE DATABASE grading_tool;

USE grading_tool;

-- Table for storing student information
CREATE TABLE students (
    student_id INT AUTO_INCREMENT PRIMARY KEY,
    student_name VARCHAR(100) NOT NULL
);

-- Table for storing grades
CREATE TABLE grades (
    grade_id INT AUTO_INCREMENT PRIMARY KEY,
    student_id INT,
    homework_1 INT,
    homework_2 INT,
    homework_3 INT,
    homework_4 INT,
    homework_5 INT,
    quiz_1 INT,
    quiz_2 INT,
    quiz_3 INT,
    quiz_4 INT,
    quiz_5 INT,
    midterm INT,
    final_project INT,
    final_grade INT,
    FOREIGN KEY (student_id) REFERENCES students(student_id)
);

-- Insert 10 students into the students table
INSERT INTO students (student_name) VALUES 
('Meherap Hossain'),
('Arafat Riyad'),
('Irfan Hossain'),
('Danielle Speedone'),
('Malissa Liu'),
('Ronald Lee'),
('Bryan Terrazas'),
('Jason V'),
('Hose M'),
('Kimberly Gua');
