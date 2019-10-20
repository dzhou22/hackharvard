<?php
session_start();
if (isset($_POST['searchstudents-submit'])) {
    $classid = $_POST['classid'];
    header("Location: ../students.php?classid=".$classid);
    exit();
} else {
    header("Location: ../students.php");
    exit();
}

