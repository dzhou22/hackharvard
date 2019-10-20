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
            <title>Students</title>
        </head>
        <body>

            <?php
				echo '<form action="includes/searchstudents.inc.php" method="post">';
       			echo '<select name="classid">';
				$selectedstr = selected_option('any', $search_classid);
       			echo '<option '.$selectedstr.' value="any">Any</option>';
				while ($res = mysqli_fetch_assoc($result_classes)) {
					$selectedstr = selected_option($res['idClasses'], $search_classid);
				    echo '<option '.$selectedstr.' value='.$res['idClasses'].'>'.$res['nameClasses'].'</option>';
				}
       			echo '</select>';
				echo '<button type="submit" name="searchstudents-submit">Select</button>';
				echo '</form>';

                
                while($student=mysqli_fetch_assoc($result)) {
					if ($search_classid !== 'any') {
					    $is_in_class = user_in_class($search_classid, $student['uidUsers'], 'student', $conn);
						if (!$is_in_class) {
						    continue;
						}
					}
                    
                    if ($student['userType']=='student' || $student['userType']=='both') {
/*                                 echo "<tr>";
                        echo "<td>".$student['uidUsers']."</td>";
                        echo "<td>".$student['emailUsers']."</td>";
                        echo "</tr>";
*/                             
                        $profile_picture = get_profile_picture($conn);
						$classstr = get_classes($student['uidUsers'], 'student', $conn);
                        
                        echo '<div class="card">';
                            echo '<img src='.$profile_picture.' alt="Avatar" style="width:100%">';
                            echo '<div class="container">';
                                echo '<h4 class="cardName"><b>'.$student['uidUsers'].'</b></h4>';
                                echo '<p class="cardEmail">'.$student['emailUsers'].'</p>';
								echo '<p class="cardClasses"> Classes: '.$classstr.'</p>';
                            echo '</div>';
                        echo '</div>';
                        
                    }   
                }
                

            ?>
        </body>

    </main>
