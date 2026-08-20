<?php
session_start();
require_once("../includes/db.php");

if(!isset($_SESSION['admin'])){
    header("Location: login.php");
    exit();
}

$id = intval($_GET['id']);

$student = $conn->query("SELECT photo FROM students WHERE id=$id")->fetch_assoc();

if(!empty($student['photo']) && file_exists("../uploads/".$student['photo'])){
    unlink("../uploads/".$student['photo']);
}

$conn->query("DELETE FROM students WHERE id=$id");

header("Location: students.php");
exit();
?>
