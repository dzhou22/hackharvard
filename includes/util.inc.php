<?php

function class_id_to_name($classid, $conn) {
  	$sql = "SELECT nameClasses FROM classes WHERE idClasses=?";
	$stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    } else { // statement is valid
        mysqli_stmt_bind_param($stmt, "s", $classid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
	}
	$res = mysqli_fetch_assoc($result);
	$classname = $res['nameClasses'];
	return $classname;
}

function class_name_to_id($classname, $conn) {
  	$sql = "SELECT idClasses FROM classes WHERE nameClasses=?";
	$stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ../index.php?error=sqlerror");
        exit();
    } else { // statement is valid
        mysqli_stmt_bind_param($stmt, "s", $classname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
	}
	$res = mysqli_fetch_assoc($result);
	$classid = $res['idClasses'];
	return $classid;
}
