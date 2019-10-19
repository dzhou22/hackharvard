<?php
session_start();

if (isset($_POST['removeclass-submit'])) {
    require 'dbh.inc.php';
	require 'util.inc.php';

    if (isset($_SESSION['userId'])) {
	    $classid = $_POST['classid'];
		$role = $_POST['role'];
		if (empty($classid)) { // empty classid
        	header("Location: ../myclasses.php?error=emptyclassid");
        	exit();
		} else if (empty($role)) { // empty role
		    header("Location: ../myclasses.php?error=emptyrole");
			exit();
		} else {
			$classname = class_id_to_name($classid, $conn);

			$sql = "DELETE FROM enrollments WHERE uidUsers=? AND userType=? AND nameClasses=?";
    		$stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../myclasses.php?error=sqlerror");
                exit();
            } else { // statement is valid, so run delete query
                mysqli_stmt_bind_param($stmt, "sss", $_SESSION['userUid'], $role, $classname);
                mysqli_stmt_execute($stmt);
                header("Location: ../myclasses.php?removeclass=success");
                exit();
			}
		}
	} else {
	    header("Location: ../index.php&error=notloggedin");
	}
} else {
    header("Location: ../myclasses.php");
    exit();
}
