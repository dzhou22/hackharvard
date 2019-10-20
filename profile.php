<?php
    require "header.php";
    require "includes/dbh.inc.php";
?>

	<main>
		<div>
			<section>
                <!-- <h1>Profile</h1> -->
                <?php

                    if (!isset($_SESSION['userId'])) {
                        echo '<p class="loggedOut">Oops! You are not signed in!</p>';
                        
                        /* echo "<form action='upload.php' method='POST' enctype='multipart/form-data'>
                            <input type='file' name='file'>
                            <button type='submit' name='submit-photo'>UPLOAD</button>
                            </form>"; */
                    } else {
                        
                        // display profile picture:
                        $sql = "SELECT uidUsers FROM users WHERE uidUsers=?";
                        $stmt = mysqli_stmt_init($conn);
                        //check if sql statement is valid
                        if (!mysqli_stmt_prepare($stmt, $sql)) {
                            header("Location: ../profile.php?error=sqlerror");
                            exit();
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
                                    header("Location: ../profile.php?error=sqlerror");
                                    exit();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "s", $_SESSION['userId']);
                                    mysqli_stmt_execute($stmt);
                                    $resultImg = mysqli_stmt_get_result($stmt);
                                    while ($rowImg = mysqli_fetch_assoc($resultImg)) {
                                        echo "<div>";
                                            if ($rowImg['status'] == 0) {
                                                echo '<img class="square" src="uploads/profile'.$id.'.jpg?"'.mt_rand().'>';
                                            } else {
                                                echo '<img class="square" src="uploads/profiledefault.jpg">';
                                            }
                                        echo "</div>";
                                    }
                                }
                                echo '<h1 class="header">Welcome, '.$_SESSION['userUid'].'</h1>';
                            } else {
                                echo "Error: User not found.";
                            }
                        }
                        
                        //Error handling:
                        if (isset($_GET["error"])) {
                            if ($_GET['error'] == "invalidusername") {
                                echo '<p class="error">Username must use only alphanumeric characters.</p>';
                            } else if ($_GET['error'] == "invalidmail") {
                                echo '<p class="error">Invalid e-mail.</p>';
                            } else if ($_GET['error'] == "invalidusername") {
                                echo '<p class="error">Username must use only alphanumeric characters.</p>';
                            } else if ($_GET['error'] == "passwordcheck") {
                                echo '<p class="error">Passwords do not match.</p>';
                            } else if ($_GET['error'] == "wrongpwd") {
                                echo '<p class="error">Old password incorrect.</p>';
                            } else if ($_GET['error'] == "usernametaken") {
                                echo '<p class="error">Username/email is taken. Please choose another.</p>';
                            } else if ($_GET['error'] == "nouse") {
                                echo '<p class="error">User does not exist.</p>';
                            }
                        } else if (isset($_GET["update"])) {
                            if ($_GET["update"] == "username") {
                                echo '<p class="success">Username updated!</p>';
                            } else if ($_GET["update"] == "email") {
                                echo '<p  class="success">Email updated!</p>';
                            }
                        } 
                        echo '<h2 class="header3Centered">Update Personal Info</h2>
                
                        <!-- Profile Picture -->
                        <form class="formCentered2" action="upload.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="file">
                            <button class="buttonRed" type="submit" name="submit-photo">Upload</button>
                        </form>
        
                        <form class="formCentered2" action="includes/updateprofile.inc.php" method = "post">
                            <input class="inputRed" type="text" name="username" placeholder="Username">
                            <button class="buttonRed" type="submit" name="update-submit">Update Username</button>
                        </form>
        
                        <form class="formCentered2" action="includes/updateprofile.inc.php" method = "post">
                            <input class="inputRed" type="text" name="mail" placeholder="E-mail">
                            <button class="buttonRed" type="submit" name="update-submit">Update E-mail</button>
                        </form>
        
                        <form class="formCentered2" action="includes/updateprofile.inc.php" method = "post">   
                            <select name="role">
                                <option disabled selected value="none">- Select Role-</option>
                                <option value="student">Student</option>
                                <option value="tutor">Tutor</option>
                                <option value="both">Both</option>
                            </select>
                            <button class="buttonRed" type="submit" name="update-submit">Update Role</button>
                        </form>
        
                        <form class="formCentered2" action="includes/updateprofile.inc.php" method = "post">  
                            <input class="inputRed" type="password" name="oldPwd" placeholder="Old Password">
                            <input class="inputRed" type="password" name="newPwd" placeholder="New Password">
                            <input class="inputRed" type="password" name="newPwd2" placeholder="Re-type Password">
                            <button class="buttonRed" type="submit" name="update-submit">Update Password</button>
                        </form>';
                    }
                    
                ?> 
                </section>
            </div>
        </main>
