<?php
	require "header.php"
?>

	<main>
		<div>
			<section>
                <h1 class="header2Centered">Sign Up</h1>
                <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyfields") {
                            echo '<p class="error">Please fill in all the fields.</p>';
                        } else if ($_GET['error'] == "invalidmailusername") {
                            echo '<p class="error">Invalid e-mail address and username. Username must use only alphanumeric characters.</p>';
                        } else if ($_GET['error'] == "invalidmail") {
                            echo '<p class="error">Invalid e-mail.</p>';
                        } else if ($_GET['error'] == "invalidusername") {
                            echo '<p class="error">Username must use only alphanumeric characters.</p>';
                        } else if ($_GET['error'] == "passwordcheck") {
                            echo '<p class="error">Passwords do not match.</p>';
                        } else if ($_GET['error'] == "invalidrole") {
                            echo '<p class="error">Please select your role.</p>';
                        } else if ($_GET['error'] == "usernametaken") {
                            echo '<p class="error">Username/email is taken. Please choose another.</p>';
                        }
                    } else if (isset($_GET["signup"])) {
                        if ($_GET["signup"] == "success") {
                            echo '<p class="success">Signup successful!</p>';
                        }
                    } 
                ?>
				<form class="formCentered" action="includes/signup.inc.php" method = "post">
					<select class="selectRed" name="role">
						<option disabled selected value="none">- Select Role -</option>
						<option value="student">Student</option>
						<option value="tutor">Tutor</option>
						<option value="both">Both</option>
					</select>
                    <input class="inputRed" type="text" name="username" placeholder="Username">
                    <input class="inputRed" type="text" name="mail" placeholder="E-mail">
                    <input class="inputRed" type="password" name="pwd" placeholder="Password">
                    <input class="inputRed" type="password" name="pwd2" placeholder="Retype Password">
                    <button class="buttonRed" type="submit" name="signup-submit">Signup</button>
                </form>
			</section>
		</div>
	</main>
