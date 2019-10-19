<?php
    require "header.php";
    require "includes/dbh.inc.php";
?>

	<main>
		<div>
			<section>
                <h1>Profile</h1>

                <?php
                
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
                ?> 
                <h2>Update Personal Info</h2>

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
                </form>
                
			</section>
		</div>
	</main>
