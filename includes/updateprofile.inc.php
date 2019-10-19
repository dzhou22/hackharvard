<?php
session_start();

if (isset($_POST['update-submit'])) {
    
    if (isset($_SESSION['userId'])) { //if user is logged in
        
        require 'dbh.inc.php';

        $username = $_POST['username'];
        $email = $_POST['mail'];
        $role = $_POST['role'];
        $oldPassword = $_POST['oldPwd'];
        $password = $_POST['newPwd'];
        $passwordRepeat = $_POST['newPwd2'];

        //Update username
        if (!empty($username)) {

            if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
                header("Location: ../profile.php?error=invalidusername");
                exit();

            } else {

                $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
                $stmt = mysqli_stmt_init($conn);
                //check if sql statement is valid
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../profile.php?error=sqlerror");
                    exit();
                } else { //statement is valid
                    //check if username is already being used
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    if ($resultCheck > 0) {
                        header("Location: ../profile.php?error=usernametaken");
                        exit();
                    } else { //username is not being used, so we can update user info
                        $sql  = "UPDATE users SET uidUsers = ? WHERE idUsers = ?";
                        $stmt = mysqli_stmt_init($conn);
                        //check if sql statement is valid
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../profile.php?error=sqlerror");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "ss", $username, $_SESSION['userId']);
                            mysqli_stmt_execute($stmt);
                            header("Location: ../profile.php?update=username");
                            exit();
                        }
                    }
                }
            }
        } 
        //Update email
        else if (!empty($email)) {

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

                header("Location: ../profile.php?error=invalidemail");
                exit();

            } else {

                $sql = "SELECT uidUsers FROM users WHERE emailUsers=?";
                $stmt = mysqli_stmt_init($conn);
                //check if sql statement is valid
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../profile.php?error=sqlerror");
                    exit();
                } else { //statement is valid
                    //check if username is already being used
                    mysqli_stmt_bind_param($stmt, "s", $email);
                    mysqli_stmt_execute($stmt);
                    mysqli_stmt_store_result($stmt);
                    $resultCheck = mysqli_stmt_num_rows($stmt);
                    if ($resultCheck > 0) {
                        header("Location: ../profile.php?error=emailtaken");
                        exit();
                    } else { //username is not being used, so we can update user info
                        $sql  = "UPDATE users SET emailUsers = ? WHERE idUsers = ?";
                        $stmt = mysqli_stmt_init($conn);
                        //check if sql statement is valid
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../profile.php?error=sqlerror");
                            exit();
                        } else {
                            mysqli_stmt_bind_param($stmt, "ss", $email, $_SESSION['userId']);
                            mysqli_stmt_execute($stmt);
                            header("Location: ../profile.php?update=email");
                            exit();
                        }
                    }
                }
            }
        }
        //Update role
        else if (!empty($role)) {

            $sql  = "UPDATE users SET uidUsers = ? WHERE idUsers = ?";
            $stmt = mysqli_stmt_init($conn);
            //check if sql statement is valid
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../profile.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "ss", $username, $_SESSION['userId']);
                mysqli_stmt_execute($stmt);
                header("Location: ../profile.php?update=role");
                exit();
            }
        }
        //Update password
        else if (!empty($oldPassword) && !empty($password) && !empty($passwordRepeat)) {
            //check if retyped password is the same:
            if ($passwordRepeat !== $password) {
                header("Location: ../signup.php?error=passwordcheck");
                exit();
            }
            //check old password:
            $sql = "SELECT * FROM users WHERE idUsers=?";
            $stmt = mysqli_stmt_init($conn);
            if (!mysqli_stmt_prepare($stmt, $sql)) {
                header("Location: ../index.php?error=sqlerror");
                exit();
            } else {
                mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($row = mysqli_fetch_assoc($result)) {
                    $pwdCheck = password_verify($password, $row['pwdUsers']);
                    if ($pwdCheck == false) {
                        header("Location: ../profile.php?error=wrongpwd");
                        exit();
                    } else if ($pwdCheck == true) { //password is correct, can update password
                        
                        $sql  = "UPDATE users SET pwdUsers = ? WHERE idUsers = ?";
                        $stmt = mysqli_stmt_init($conn);
                        //check if sql statement is valid
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../profile.php?error=sqlerror");
                            exit();
                        } else {
                            $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                            mysqli_stmt_bind_param($stmt, "ss", $hashedPwd, $_SESSION['userId']);
                            mysqli_stmt_execute($stmt);
                            header("Location: ../profile.php?update=pwd");
                            exit();
                        }

                    } else {

                        header("Location: ../profile.php?error=wrongpwd");
                    }
                } else {
                    header("Location: ../profile.php?error=nouser");
                    exit();
                }
            }
        } else {
            header("Location: ../profile.php?error=emptyfields");
            exit();
        }

        mysqli_stmt_close($stmt);
        mysqli_close($conn);


    } else { //user is not logged in
        header("Location: ../index.php");
        exit();
    }

} else {
    header("Location: ../index.php");
    exit();
}