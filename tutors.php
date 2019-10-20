<?php
	if (isset($_GET['classid'])) {
	    $search_classid = $_GET['classid'];
	} else {
		$search_classid = 'any';
	}

	function selected_option($classid, $currentid) {
	    if ($classid == $currentid) {
		    return 'selected';
		} else {
		    return '';
		}
	}
	
    require "includes/dbh.inc.php";
    require "includes/util.inc.php";

    $sql="SELECT * FROM users";
    $stmt = mysqli_stmt_init($conn);
    if (!mysqli_stmt_prepare($stmt, $sql)) {
        header("Location: ./index.php?error=sqlerror");
        exit();
    } else {
        //mysqli_stmt_bind_param($stmt, "ss", $mailuid, $mailuid);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
    }

	$result_classes = get_all_classes($conn);

    require "header.php";

?>

    <main>
        <head>
            <title>Tutors</title>
        </head>
        <body>
		
            <?php
        		if (isset($_SESSION['userId'])) {
					echo '<form class="formCentered2" action="includes/searchtutors.inc.php" method="post">';
           			echo '<select class="selectRed" name="classid">';
					$selectedstr = selected_option('any', $search_classid);
           			echo '<option '.$selectedstr.' value="any">Any</option>';
					while ($res = mysqli_fetch_assoc($result_classes)) {
						$selectedstr = selected_option($res['idClasses'], $search_classid);
					    echo '<option '.$selectedstr.' value='.$res['idClasses'].'>'.$res['nameClasses'].'</option>';
					}
           			echo '</select>';
					echo '<button class="buttonRed" type="submit" name="searchtutors-submit">Select</button>';
					echo '</form>';

                    
                        while($tutor=mysqli_fetch_assoc($result)) {
							if ($search_classid !== 'any') {
							    $is_in_class = user_in_class($search_classid, $tutor['uidUsers'], 'tutor', $conn);
								if (!$is_in_class) {
								    continue;
								}
							}
                            if ($tutor['userType']=='tutor' || $tutor['userType']=='both') {
                                $profile_picture = get_profile_picture($conn);
								$classstr = get_classes($tutor['uidUsers'], 'tutor', $conn);
                                
                                echo '<div class="card">';
                                    echo '<img src='.$profile_picture.' alt="Avatar" style="width:100%">';
                                    echo '<div class="container">';
                                        echo '<h4 class="cardName"><b>'.$tutor['uidUsers'].'</b></h4>';
                                        echo '<p class="cardEmail">'.$tutor['emailUsers'].'</p>';
										echo '<p class="cardClasses"> Classes: '.$classstr.'</p>';
                                    echo '</div>';
                                echo '</div>';
                            }   
                        }
                } else {
    			    echo '<p class="loggedOut">Oops! You are not signed in!<p>';
				}
                    

            ?>
        </body>

    </main>
