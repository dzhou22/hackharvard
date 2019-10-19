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

?>

    <main>
        <head>
            <title>Tutors</title>
        </head>
        <body>
            <table width="600" border="1" cellpadding="1" cellspacing="1">
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                </tr>

                <?php

                    
                        while($tutor=mysqli_fetch_assoc($result)) {
                            
                            if ($tutor['userType']=='tutor') {
                                echo "<tr>";
                                echo "<td>".$tutor['uidUsers']."</td>";
                                echo "<td>".$tutor['emailUsers']."</td>";
                                echo "</tr>";
                            }   
                        }
                    

                ?>
            </table>
        </body>

    </main>