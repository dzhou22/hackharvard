<?php
	require "header.php"
?>

	<main>
        <head>
            <title>Home</title>
        </head>
        <body>
			<div>
   	    		<?php
   	    		    if (isset($_SESSION['userId'])) {
   	    			    echo '<p class="loggedOut">You are logged in!<p>';
   	    			} else {
   	    			    echo '<p class="loggedOut">Oops! You are not signed in!<p>';
   	    			}
   	    		?>
			</div>
		</body>
	</main>