<?php

function class_id_to_name($classid, $conn) {
  	$sql = "SELECT nameClasses FROM classes WHERE idClasses=?";
	$stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
	    return '';
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
	    return '';
    } else { // statement is valid
        mysqli_stmt_bind_param($stmt, "s", $classname);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
	}
	$res = mysqli_fetch_assoc($result);
	$classid = $res['idClasses'];
	return $classid;
}

function get_profile_picture($conn) {
    $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
    $stmt = mysqli_stmt_init($conn);
    //check if sql statement is valid
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        return '';
    } else { //statement is valid
        //check if username is being used
        mysqli_stmt_bind_param($stmt, "s", $_SESSION['userUid']);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_store_result($stmt);
        $resultCheck = mysqli_stmt_num_rows($stmt);
        if ($resultCheck > 0) { //if it is being used...
            $id = $_SESSION['userId'];
            $sqlImg = "SELECT * FROM profileimg WHERE idUsers=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sqlImg)) {
                return '';
            } else {
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
                mysqli_stmt_execute($stmt);
                $resultImg = mysqli_stmt_get_result($stmt);
                while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                    if ($rowImg['status'] == 0) {
                        return 'uploads/profile'.$id.'.jpg?'.mt_rand();
                    } else {
                        return 'uploads/profiledefault.jpg';
                    }
                }
            }
        } else {
            return '';
        }
    }
}

function get_classes($username, $role, $conn) {
  	$sql = "SELECT nameClasses FROM enrollments WHERE uidUsers=? AND userType=?";
	$stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
	    return '';
    } else { // statement is valid
        mysqli_stmt_bind_param($stmt, "ss", $username, $role);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
	}
	$classstr = '';
	while ($res = mysqli_fetch_assoc($result)) {
	    if ($classstr == '') {
		    $classstr = $res['nameClasses'];
		} else {
		    $classstr = $classstr.', '.$res['nameClasses'];
		}
	}
	return $classstr;
}

function user_in_class($classid, $username, $role, $conn) {
	$classname = class_id_to_name($classid, $conn);
  	$sql = "SELECT nameClasses FROM enrollments WHERE uidUsers=? AND userType=?";
	$stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
	    return '';
    } else { // statement is valid
        mysqli_stmt_bind_param($stmt, "ss", $username, $role);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
	}
	while ($res = mysqli_fetch_assoc($result)) {
	    if ($res['nameClasses'] == $classname) {
		    return true;
		}
	}
	return false;
}

function get_all_classes($conn) {
	$sql_classes = "SELECT * FROM classes";
	$stmt = mysqli_stmt_init($conn);
	if (!mysqli_stmt_prepare($stmt, $sql_classes)) {
	    header("Location: ./index.php?error=sqlerror");
		exit();
	} else {
	    mysqli_stmt_execute($stmt);
		$result_classes = mysqli_stmt_get_result($stmt);
	}
	return $result_classes;
}
