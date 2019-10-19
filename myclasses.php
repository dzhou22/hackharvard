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

		$sql_classes = "SELECT * FROM classes";
		if (!mysqli_stmt_prepare($stmt, $sql_classes)) {
		    header("Location: ./index.php?error=sqlerror");
			exit();
		} else {
		    mysqli_stmt_execute($stmt);
			$result_classes = mysqli_stmt_get_result($stmt);
		}
    }

	require "header.php";
?>

	<main>
		<div>
			<section>
                <h1>My Classes</h1>
	    		    <?php
	    			    if (isset($_SESSION['userId'])) {
						   	echo '<h2>Add Classes</h2>';
							// Form to add a class
							echo '<form action="includes/addclass.inc.php" method="post">
	            				<select name="classid">';
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
							echo '<button type="submit" name="addclass-submit">Add</button>';
							echo '</form>';

							// Form to create new class in database
							echo '<form action="includes/createclass.inc.php" method="post">
							    <input type="text" name="classname" placeholder="New Class Name...">
								<button type="submit" name="createclass-submit">Create</button>
								</form>';

						    if ($_SESSION['userType'] == 'student' || $_SESSION['userType'] == 'both') {
							    echo '<h2>My Enrolled Classes</h2>';
								echo '<table width="600" border="1" cellpadding="1" cellspacing="1">
                                    <tr>
                                        <th>Class</th>
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
    			                        echo '<button type="submit" name="removeclass-submit">Remove</button>
    			            				</form></td>';
                                        echo "</tr>";
                                    }   
                                }
								echo '</table>';
							}
							if ($_SESSION['userType'] == 'tutor' || $_SESSION['userType'] == 'both') {
							    echo '<h2>My Tutor Classes</h2>';
								echo '<table width="600" border="1" cellpadding="1" cellspacing="1">
                                    <tr>
                                        <th>Class</th>
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
    			                        echo '<button type="submit" name="removeclass-submit">Remove</button>
    			            				</form></td>';
                                        echo "</tr>";
                                    }   
                                }
								echo '</table>';
							}
	    			    } else {
						  	echo "Please log in";
	    				}
	    			?>
			</section>
		</div>
	</main>
