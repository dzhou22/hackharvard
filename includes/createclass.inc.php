<?php
session_start();

if (isset($_POST['createclass-submit'])) {
    require 'dbh.inc.php';

    $classname = $_POST['classname'];

	// Empty classname
    if (empty($classname)) {
        header("Location: ../myclasses.php?error=emptyclassname");
        exit();
    } else {
	    $sql = "SELECT * FROM classes WHERE nameClasses=?";
		$stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        } else { // statement is valid
            // check if classname already exists
            mysqli_stmt_bind_param($stmt, "s", $classname);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../myclasses.php?error=classnametaken");
            exit();
            } else { // classname is not taken, so add to database
                $sql  = "INSERT INTO classes (nameClasses) VALUES (?)";
                $stmt = mysqli_stmt_init($conn);
                // check if sql statement is valid
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../myclasses.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $classname);
                    mysqli_stmt_execute($stmt);
                    header("Location: ../myclasses.php?createclass=success");
                    exit();
                }
			}
		}
	}

} else {
    header("Location: ../myclasses.php");
    exit();
}