<?php
    require "includes/dbh.inc.php";

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
    require "header.php";
    require "includes/util.inc.php";

?>

    <main>
        <head>
            <title>Tutors</title>
        </head>
        <body>

                <?php

                    
                        while($tutor=mysqli_fetch_assoc($result)) {
                            
                            if ($tutor['userType']=='tutor' || $tutor['userType']=='both') {
                                $profile_picture = get_profile_picture($conn);
								$classstr = get_classes($tutor['uidUsers'], 'tutor', $conn);
                                
                                echo '<div class="card">';
                                    echo '<img src='.$profile_picture.' alt="Avatar" style="width:100%">';
                                    echo '<div class="container">';
                                        echo '<h4><b> Username: '.$tutor['uidUsers'].'</b></h4>';
                                        echo '<p> Email: '.$tutor['emailUsers'].'</p>';
										echo '<p> Classes: '.$classstr.'</p>';
                                    echo '</div>';
                                echo '</div>';
                            }   
                        }
                    

                ?>
        </body>

    </main>