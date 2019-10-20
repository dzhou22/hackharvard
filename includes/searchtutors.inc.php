<?php
session_start();
if (isset($_POST['searchtutors-submit'])) {
    $classid = $_POST['classid'];
    header("Location: ../tutors.php?classid=".$classid);
    exit();
} else {
    header("Location: ../tutors.php");
    exit();
}

