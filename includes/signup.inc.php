<?php
if (isset($_POST['signup-submit'])) {

    require 'dbh.inc.php';

    $username = $_POST['username'];
    $email = $_POST['mail'];
    $role = $_POST['role'];
    $password = $_POST['pwd'];
    $passwordRepeat = $_POST['pwd2'];

    //Error 1: empty fields
    if (empty($username) || empty($email) || empty($password) || empty($passwordRepeat)) {
        header("Location: ../signup.php?error=emptyfields&username=".$username."&mail=".$email."&role=".$role);
        exit();
    } 
    //Error 2: invalid email AND invalid username
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invalidmailusername");
        exit();
    }
    //Error 3: invalid email
    else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../signup.php?error=invalidmail&username=".$username);
        exit();
    }
    //Error 4: invalid username
    else if (!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        header("Location: ../signup.php?error=invalidusername&mail=".$email);
        exit();
    }
    //Error 5: user typed 2 different passwords
    else if ($passwordRepeat !== $password) {
        header("Location: ../signup.php?error=passwordcheck&username=".$username."&mail=".$email."&role=".$role);
        exit();
    }
    //Error 6: no role selected
    else if (empty($role)) {
        header("Location: ../signup.php?error=invalidrole&username=".$username."&mail=".$email."&role=".$role);
        exit();
    }
    //Error 7: user already exists in database
    else {
        
        $sql = "SELECT uidUsers FROM users WHERE uidUsers=? OR emailUsers=?";
        $stmt = mysqli_stmt_init($conn);
        //check if sql statement is valid
        if (!mysqli_stmt_prepare($stmt, $sql)) {
            header("Location: ../signup.php?error=sqlerror");
            exit();
        } else { //statement is valid
            //check if username or email is already being used
            mysqli_stmt_bind_param($stmt, "ss", $username, $email);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_store_result($stmt);
            $resultCheck = mysqli_stmt_num_rows($stmt);
            if ($resultCheck > 0) {
                header("Location: ../signup.php?error=usernametaken&mail=".$email."&role=".$role);
                exit();
            } else { //username is not being used, so we can add a new user to database

                $sql  = "INSERT INTO users (uidUsers, emailUsers, pwdUsers, userType) VALUES (?, ?, ?, ?)";
                $stmt = mysqli_stmt_init($conn);
                //check if sql statement is valid
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../signup.php?error=sqlerror");
                    exit();
                } else {
                    $hashedPwd = password_hash($password, PASSWORD_DEFAULT);

                    mysqli_stmt_bind_param($stmt, "ssss", $username, $email, $hashedPwd, $role);
                    mysqli_stmt_execute($stmt);
                    //header("Location: ../signup.php?signup=success");
                    //exit();
                }

                //update profileimg database with new user
                $sql = "SELECT * FROM users WHERE uidUsers=?";
                $stmt = mysqli_stmt_init($conn);
                //check if sql statement is valid
                if (!mysqli_stmt_prepare($stmt, $sql)) {
                    header("Location: ../profile.php?error=sqlerror");
                    exit();
                } else {
                    mysqli_stmt_bind_param($stmt, "s", $username);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $userid = $row['idUsers'];
                            $sql  = "INSERT INTO profileimg (idUsers, status) VALUES (?, 1)";
                            $stmt = mysqli_stmt_init($conn);
                            if (!mysqli_stmt_prepare($stmt, $sql)) {
                                header("Location: ../signup.php?error=sqlerror");
                                exit();
                            } else {
                                mysqli_stmt_bind_param($stmt, 's', $userid);
                                mysqli_stmt_execute($stmt);
                                header("Location: ../signup.php?signup=success");
                                exit();
                            }
                            
                        }
                    }
                }
            }
        }
    }

    mysqli_stmt_close($stmt);
    mysqli_close($conn);

} else {

    header("Location: ../signup.php");
    exit();

}
