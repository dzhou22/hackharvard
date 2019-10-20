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
                        echo "Please sign in.";
                        
                        /* echo "<form action='upload.php' method='POST' enctype='multipart/form-data'>
                            <input type='file' name='file'>
                            <button type='submit' name='submit-photo'>UPLOAD</button>
                            </form>"; */
                    } else {
                        echo "<h1>Welcome, ".$_SESSION['userUid']."</h1>";
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
                                                echo "<img src='uploads/profile".$id.".jpg?'".mt_rand().">";
                                            } else {
                                                echo "<img src='uploads/profiledefault.jpg'>";
                                            }
                                        echo "</div>";
                                    }
                                }
                                
                            } else {
                                echo "Error: User not found.";
                            }
                        }
                        
                        //Error handling:
                        if (isset($_GET["error"])) {
                            if ($_GET['error'] == "invalidusername") {
                                echo '<p>Username must use only alphanumeric characters.</p>';
                            } else if ($_GET['error'] == "invalidmail") {
                                echo '<p>Invalid e-mail.</p>';
                            } else if ($_GET['error'] == "invalidusername") {
                                echo '<p>Username must use only alphanumeric characters.</p>';
                            } else if ($_GET['error'] == "passwordcheck") {
                                echo '<p>Passwords do not match.</p>';
                            } else if ($_GET['error'] == "wrongpwd") {
                                echo '<p>Old password incorrect.</p>';
                            } else if ($_GET['error'] == "usernametaken") {
                                echo '<p>Username/email is taken. Please choose another.</p>';
                            } else if ($_GET['error'] == "nouse") {
                                echo '<p>User does not exist.</p>';
                            }
                        } else if (isset($_GET["update"])) {
                            if ($_GET["update"] == "username") {
                                echo '<p>Username updated!</p>';
                            } else if ($_GET["update"] == "email") {
                                echo '<p>Email updated!</p>';
                            }
                        } 
                        echo '<h2>Update Personal Info</h2>
                
                        <!-- Profile Picture -->
                        <form action="upload.php" method="POST" enctype="multipart/form-data">
                            <input type="file" name="file">
                            <button type="submit" name="submit-photo">UPLOAD</button>
                        </form>
        
                        <form action="includes/updateprofile.inc.php" method = "post">
                            <input type="text" name="username" placeholder="Username">
                            <button type="submit" name="update-submit">Update Username</button>
                        </form>
        
                        <form action="includes/updateprofile.inc.php" method = "post">
                            <input type="text" name="mail" placeholder="E-mail">
                            <button type="submit" name="update-submit">Update E-mail</button>
                        </form>
        
                        <form action="includes/updateprofile.inc.php" method = "post">   
                            <select name="role">
                                <option disabled selected value="none">- Select Role-</option>
                                <option value="student">Student</option>
                                <option value="tutor">Tutor</option>
                                <option value="both">Both</option>
                            </select>
                            <button type="submit" name="update-submit">Update Role</button>
                        </form>
        
                        <form action="includes/updateprofile.inc.php" method = "post">  
                            <input type="password" name="oldPwd" placeholder="Old Password">
                            <input type="password" name="newPwd" placeholder="New Password">
                            <input type="password" name="newPwd2" placeholder="Re-type Password">
                            <button type="submit" name="update-submit">Update Password</button>
                        </form>';
                    }
                    
                ?> 
                </section>
            </div>
        </main>
