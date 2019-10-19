<?php
    require "header.php";
    require "includes/dbh.inc.php";

    mysqli_select_db($conn, 'loginsystem');

    $sql="SELECT * FROM uidUsers";

    $results=mysqli_query($conn, $sql);

?>

    <main>
        <head>
            <title>Tutors</title>
        </head>
        <body>
            <table width="600" border="1" cellpadding="1" cellspacing="1">
                <tr>
                    <th>Username<th>
                    <th>Email<th>
                </tr>

                <?php

                    while($tutor=mysqli_fetch_assoc($results)) {
                        
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