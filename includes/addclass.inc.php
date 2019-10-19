<?php
session_start();

if (isset($_POST['addclass-submit'])) {
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

			// Add class or throw error
    	    $sql = "SELECT * FROM enrollments WHERE uidUsers=? AND userType=? AND nameClasses=?";
    		$stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../myclasses.php?error=sqlerror");
                exit();
            } else { // statement is valid
                // check if this user already has this role for this class
                mysqli_stmt_bind_param($stmt, "sss", $_SESSION['userUid'], $role, $classname);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_store_result($stmt);
                $resultCheck = mysqli_stmt_num_rows($stmt);
                if ($resultCheck > 0) {
                    header("Location: ../myclasses.php?error=duplicateenrollment");
                exit();
                } else { // enrollment does not already exist, so add to database
                    $sql  = "INSERT INTO enrollments (uidUsers, userType, nameClasses) VALUES (?, ?, ?)";
                    $stmt = mysqli_stmt_init($conn);
                    // check if sql statement is valid
                    if (!mysqli_stmt_prepare($stmt, $sql)) {
                        header("Location: ../myclasses.php?error=sqlerror");
                        exit();
                    } else {
                        mysqli_stmt_bind_param($stmt, "sss", $_SESSION['userUid'], $role, $classname);
                        mysqli_stmt_execute($stmt);
                        header("Location: ../myclasses.php?createclass=success");
                        exit();
                    }
	    		}
	    	}
		}
	} else {
	    header("Location: ../index.php&error=notloggedin");
	}
} else {
    header("Location: ../myclasses.php");
    exit();
}
