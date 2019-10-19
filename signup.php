<?php
	require "header.php"
?>

	<main>
		<div>
			<section>
                <h1>Signup</h1>
                <?php
                    if (isset($_GET["error"])) {
                        if ($_GET["error"] == "emptyfields") {
                            echo '<p>Please fill in all the fields.</p>';
                        } else if ($_GET['error'] == "invalidmailusername") {
                            echo '<p>Invalid e-mail address and username. Username must use only alphanumeric characters.</p>';
                        } else if ($_GET['error'] == "invalidmail") {
                            echo '<p>Invalid e-mail.</p>';
                        } else if ($_GET['error'] == "invalidusername") {
                            echo '<p>Username must use only alphanumeric characters.</p>';
                        } else if ($_GET['error'] == "passwordcheck") {
                            echo '<p>Passwords do not match.</p>';
                        } else if ($_GET['error'] == "invalidrole") {
                            echo '<p>Please select your role.</p>';
                        } else if ($_GET['error'] == "usernametaken") {
                            echo '<p>Username is taken. Please choose another.</p>';
                        }
                    } else if (isset($_GET["signup"])) {
                        if ($_GET["signup"] == "success") {
                            echo '<p>Signup successful!</p>';
                        }
                    } 
                ?>
				<form action="includes/signup.inc.php" method = "post">
                    <input type="text" name="username" placeholder="Username">
                    <input type="text" name="mail" placeholder="E-mail">
					<select name="role">
						<option disabled selected value="none">- Select -</option>
						<option value="student">Student</option>
						<option value="tutor">Tutor</option>
						<option value="both">Both</option>
					</select>
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd2" placeholder="Retype Password">
                    <button type="submit" name="signup-submit">Signup</button>
                </form>
			</section>
		</div>
	</main>
