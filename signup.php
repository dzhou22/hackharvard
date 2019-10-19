<?php
	require "header.php"
?>

	<main>
		<div>
			<section>
                <h1>Signup</h1>
				<form action="includes/signup.inc.php" method = "post">
                    <input type="text" name="username" placeholder="Username">
                    <input type="text" name="mail" placeholder="E-mail">
					<select name="role">
						<option disabled selected value="none">- Select -</option>
						<option value="student">Student</option>
						<option value="tutor">Tutor</option>
						<option value="Both">Both</option>
					</select>
                    <input type="password" name="pwd" placeholder="Password">
                    <input type="password" name="pwd2" placeholder="Retype Password">
                    <button type="submit" name="signup-submit">Signup</button>
                </form>
			</section>
		</div>
	</main>
