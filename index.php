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
   	    			    echo '<p>You are logged in!<p>';
   	    			} else {
   	    			    echo '<p>You are logged out!<p>';
   	    			}
   	    		?>
			</div>
		</body>
	</main>