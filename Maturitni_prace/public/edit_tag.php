<?php
session_start();

// def. odradkovani v HTML
define("BR", "<br/>\n");

$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

$sql = "SELECT uuid FROM Lecturer where Email = '" . $_SESSION['LecEmail'] . "'";

if (!$con->query($sql)) {
    echo "error:".mysqli_error($con).BR;
} else {
    $uuid = mysqli_fetch_assoc($con->query($sql));
}

$sql4 = "select t.*, lt.taguuid
from lecturertag lt left join tag t on lt.taguuid = t.uuid
where lt.lectureruuid = '" . $uuid['uuid'] . "';";

if (!$con->query($sql4)) {
    echo "error:".mysqli_error($con).BR;
} else {
    $result = $con->query($sql4);
    while($row = mysqli_fetch_assoc($result)) {
        // skladame objekt pro zaznam z DB
        $Tag2[] = $row;
    }
}

if (!isset($Tag2)) {
    $Tag2 = array();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <!--<script src="DataTables/dataTables.jqueryui.min.js"></script>-->
    <script src="jquery/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="DataTables/DataTables-1.13.8/css/jquery.dataTables.min.css" />
    <script src="DataTables/DataTables-1.13.8/js/jquery.dataTables.min.js"></script>
    <title>TdA: Připojit Tagy</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Domovská stránka</a></li>
                <li class="aktivni"><a href='admin.php'>Administrace</a></li>
                <li><a href="lec_list.php">Lektoři</a></li>
                <li class='logout-button'><a href='logout.php'>Odhlásit se</a></li>
            </ul>
        </nav>
    </header>

    <article>
        
        <?php
            $sql1 = "SELECT * FROM TeacherDigitalAgency.Tag";
            $result = $con->query($sql1);

            while($row = mysqli_fetch_assoc($result)) {
                // skladame objekt pro zaznam z DB
                $Tag1[] = $row;
            }

            if (isset($_COOKIE["set"])) {
                $lecTag = $_COOKIE["set"];

                $sql5 = "SELECT TagUUID FROM LecturerTag WHERE LecturerUUID = " . $uuid['uuid'] . " AND TagUUID = $lecTag";

                $tagcheck = mysqli_fetch_assoc($con->query($sql5));
                //$tagcheck['TagUUID'] != $lecTag
                if (!isset($tagcheck['TagUUID'])){
                    $sql2 = "INSERT INTO LecturerTag (LecturerUUID, TagUUID)
                        VALUES (" . $uuid['uuid'] . ", " . $lecTag . " )";

                    $con->query($sql2)
                        or die ("error:".mysqli_error($con));
                }
            }

            if (isset($_COOKIE["unset"])) {
                $lecTag = $_COOKIE["unset"];
                $sql3 = "DELETE FROM LecturerTag WHERE LecturerUUID = " . $uuid['uuid'] . " AND TagUUID = $lecTag";
                
                $con->query($sql3)
                    or die ("error:".mysqli_error($con));
            }


            echo "<table id='tagTable1' class='display'>
                    <thead>
                        <tr>
                            <th>Tag</th>
                            <th>Přidat Tag</th>
                        </tr>
                    </thead>
                    <tbody>";
            for ($i=0; $i < count($Tag1); $i++) { 
                echo '<tr>
                        <td>' . $Tag1[$i]["Name"] . '</td>
                        <td><button onclick="addTag('.$Tag1[$i]["UUID"].')" type="button">Přidat</button></td>
                        </tr>';
            }

            echo "</tbody></table>";
                    
            echo "<br><br><br><table id='tagTable2' class='display'>
            <thead>
                <tr>
                    <th>Navolené Tagy</th>
                    <th>Odstranit Tag</th>
                </tr>
            </thead>
            <tbody>";
            for ($i=0; $i < count($Tag2); $i++) { 
                echo '<tr>
                        <td>' . $Tag2[$i]["Name"] . '</td>
                        <td><button onclick="removeTag('.$Tag2[$i]["UUID"].')" type="button">Odstranit</button></td>
                        </tr>';
            }
            echo "</tbody></table><br><br><br>
            <button onclick='finish()' type='button' class='button'>Pokračovat</button>";
        ?>
        <script>
            $(document).ready( function () {
                $('#tagTable1').DataTable();
                $('#tagTable2').DataTable();
                $('article').after("<footer>Vytvořil Ondřej Cacek 2024 </footer>");
            } );

            // Function to create the cookie 
            function createCookie(name, value, minutes) {
                let expires;
            
                if (minutes) {
                    let date = new Date();
                    date.setTime(date.getTime() + (minutes * 60 * 1000));
                    expires = "; expires=" + date.toGMTString();
                }
                else {
                    expires = "";
                }
            
                document.cookie = name + "=" +
                    value + ";" + expires + "; path=/";
            }

            function addTag(id) {
                createCookie("set", id, 0.1);
                window.location.href = "edit_tag.php";
            }

            function removeTag(id) {
                createCookie("unset", id, 0.1);
                window.location.href = "edit_tag.php";
            }

            function finish() {
                window.location.href = "edit_pic.php";
            }
            
        </script>
    </article>
</body>
</html>