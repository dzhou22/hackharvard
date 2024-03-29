<?php
    require "includes/dbh.inc.php";
	require "includes/util.inc.php";
	session_start();

	if (isset($_SESSION['userId'])) {
        $sql_enroll = "SELECT * FROM enrollments WHERE uidUsers=?";
        $stmt = mysqli_stmt_init($conn);
        if (!mysqli_stmt_prepare($stmt, $sql_enroll)) {
            header("Location: ./index.php?error=sqlerror");
            exit();
        } else {
            mysqli_stmt_bind_param($stmt, "s", $_SESSION['userUid']);
            mysqli_stmt_execute($stmt);
            $result_enroll = mysqli_stmt_get_result($stmt);
		}

		$result_classes = get_all_classes($conn);
    }

	require "header.php";
?>

	<main>
		<div>
			<section>
	    		    <?php
	    			    if (isset($_SESSION['userId'])) {
						   	echo '<h2 class="header2Centered">Add Classes</h2>';
							// Form to add a class
							echo '<form class="formCentered2" action="includes/addclass.inc.php" method="post">';
	            			echo '<select name="classid">';
	            			echo '<option disabled selected value="none">- Select Class -</option>';
							while ($res = mysqli_fetch_assoc($result_classes)) {
							    echo '<option value='.$res['idClasses'].'>'.$res['nameClasses'].'</option>';
							}
	            			echo '</select>';
							echo '<select name="role">
						        <option disabled selected value="none">- Select Role -</option>';
							if ($_SESSION['userType'] == 'student' || $_SESSION['userType'] == 'both') {
								echo '<option value="student">Student</option>';
							}
							if ($_SESSION['userType'] == 'tutor' || $_SESSION['userType'] == 'both') {
								echo '<option value="tutor">Tutor</option>';
							}
							echo '</select>';
							echo '<button  class="buttonRed" type="submit" name="addclass-submit">Add</button>';
							echo '</form>';

							// Form to create new class in database
							echo '<form class="formCentered2" action="includes/createclass.inc.php" method="post">
							    <input class="inputRed" type="text" name="classname" placeholder="New Class Name...">
								<button class="buttonRed" type="submit" name="createclass-submit">Create</button>
								</form>';

						    if ($_SESSION['userType'] == 'student' || $_SESSION['userType'] == 'both') {
							    echo '<h2 class="header2Centered">My Enrolled Classes</h2>';
								echo '<table cellpadding="1" cellspacing="1">
                                    <tr>
                                        <th style="width: 200px; font-family: \'TruenoBold\'; font-size: 18px;">Class</th>
                                        <th></th>
                                    </tr>';
                                while($res=mysqli_fetch_assoc($result_enroll)) {
                                    if ($res['userType']=='student') {
                                        echo "<tr>";
                                        echo "<td>".$res['nameClasses']."</td>";
                                        echo '<td><form action="includes/removeclass.inc.php" method="post">';
										echo '<input type="hidden" name="classid" value='
											.class_name_to_id($res['nameClasses'], $conn).'>';
										echo '<input type="hidden" name="role" value="student">';
    			                        echo '<button  class="buttonRed" type="submit" name="removeclass-submit">Remove</button>
    			            				</form></td>';
                                        echo "</tr>";
                                    }   
                                }
								echo '</table>';
							}
							if ($_SESSION['userType'] == 'tutor' || $_SESSION['userType'] == 'both') {
							    echo '<h2 class="header2Centered">My Tutor Classes</h2>';
								echo '<table cellpadding="1" cellspacing="1">
                                    <tr>
                                        <th style="width: 200px; font-family: \'TruenoBold\'; font-size: 18px;">Class</th>
                                        <th></th>
                                    </tr>';
								mysqli_data_seek($result_enroll, 0);
                                while($res=mysqli_fetch_assoc($result_enroll)) {
                                    if ($res['userType']=='tutor') {
                                        echo "<tr>";
                                        echo "<td>".$res['nameClasses']."</td>";
                                        echo '<td><form action="includes/removeclass.inc.php" method="post">';
										echo '<input type="hidden" name="classid" value='
											.class_name_to_id($res['nameClasses'], $conn).'>';
										echo '<input type="hidden" name="role" value="tutor">';
    			                        echo '<button  class="buttonRed" type="submit" name="removeclass-submit">Remove</button>
    			            				</form></td>';
                                        echo "</tr>";
                                    }   
                                }
								echo '</table>';
							}
	    			    } else {
						  	echo '<p class="loggedOut">Oops! You are not signed in!</p>';
	    				}
	    			?>
			</section>
		</div>
	</main>
