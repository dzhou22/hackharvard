<?php
	if (session_status() == PHP_SESSION_NONE) {
        session_start();
	}

	function header_entry($pagename, $pagelabel) {
	    $currentpage = basename($_SERVER['SCRIPT_FILENAME']);
	    if ($currentpage == $pagename) {
	        $classname = 'active';
	    } else {
	        $classname = '';
	    }
	    return '<li class="'.$classname.'"><a href="'.$pagename.'">'.$pagelabel.'</a></li>';
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="description" content="Connecting students with tutors">
		<meta name=viewport content="width-device-width, initial-scale=1">
		<title></title>
		<link rel="stylesheet" href="style.css">
		<link rel="stylesheet" media="screen" href="https://fontlibrary.org/face/trueno" type="text/css"/>
	</head>
	<body>
        <header style="width: 100%">
        	<nav class="nav-header-main">
        		<a class="header-logo" href="index.php">
        			<img src="img/logo.jpeg" alt="logo">
        		</a>
        		<ul>
					<?php
						echo header_entry("index.php", "Home");
						echo header_entry("tutors.php", "Tutors");
						echo header_entry("students.php", "Students");
						echo header_entry("myclasses.php", "My Classes");
						echo header_entry("profile.php", "Profile");
					?>
        		</ul>
			    <?php
				    if (isset($_SESSION['userId'])) {
				        echo '<form class="header-form" action="includes/logout.inc.php" method="post">
				            <button class="button" type="submit" name="logout-submit">Logout</button>
				            </form>';
				    } else {
				        echo '<a class="header-signup" href="signup.php">Signup</a>';
				        echo '<form class="header-form" action="includes/login.inc.php" method="post">
							<input class="input" type="text" name="mailuid" placeholder="Username/E-mail...">
				  			<input class="input" type="password" name="pwd" placeholder="Password...">
				  			<button class="button" type="submit" name="login-submit">Login</button>
				            </form>';
					}
				?>
        	</nav>
			<p class="top-whitespace"></p>
        </header>
	</body>
</html>
