<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8"">
		<meta name="description" content="Connecting students with tutors">
		<meta name=viewport content="width-device-width, initial-scale=1">
		<title></title>
		<!--<link rel="stylesheet" href="style.css">-->
	</head>
	<body>
        	<header>
        		<nav>
        			<a href="#">
        				<img src="img/logo.png" alt="logo">
        			</a>
        			<ul>
        				<li><a href="index.php">Home</a></li>
        				<li><a href="#">Tutors</a></li>
        				<li><a href="#">Students</a></li>
        				<li><a href="#">Settings</a></li>
        			</ul>
				<div>
					<form action="includes/login.inc.php" method="post">
					        <input type="text" name="mailuid" placeholder="Username/E-mail...">
					      	<input type="password" name="pwd" placeholder="Password...">
					      	<button type="submit" name="login-submit">Login</button>
					</form>
					<a href="signup.php">Signup</a>
					<form action=includes/logout.inc.php" method="post">
					        <button type="submit" name="logout-submit">Logout</button>
					</form>
				</div>
        		</nav>
        	</header>
	</body>
</html>