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
    <title>TdA: List of Lecturers</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Homepage</a></li>
                <li class="aktivni"><a href='admin.php'>Administration</a></li>
                <li><a href="lec_list.php">Lecturers</a></li>
                <li class='logout-button'><a href='logout.php'>Log out</a></li>
            </ul>
        </nav>
    </header>

    <article>
        <?php
            $sql1 = "SELECT * FROM TeacherDigitalAgency.Tag";
            $result = $con->query($sql1);

            while($row = mysqli_fetch_assoc($result)) {
                // skladame objekt pro zaznam z DB
                $Tag[] = $row;
            }

            if (isset($_COOKIE["id"])) {
                    $lecTag = $_COOKIE["id"];
                    $sql2 = "INSERT INTO LecturerTag (LecturerUUID, TagUUID)
                        VALUES (" . $uuid['uuid'] . ", " . $lecTag . " )";
                    
                    $con->query($sql2)
                        or die ("error:".mysqli_error($con));
                    
                }


            echo "<table id='tagTable' class='display'>
                    <thead>
                        <tr>
                            <th>Tag Name</th>
                            <th>Add Tag</th>
                        </tr>
                    </thead>
                    <tbody>";
            for ($i=0; $i < count($Tag); $i++) { 
                echo '<tr>
                        <td>' . $Tag[$i]["Name"] . '</td>
                        <td><button onclick="addTag('.$Tag[$i]["UUID"].')" type="button">Add</button></td>
                        </tr>';
            }
            echo "</tbody>
                    <button onclick='finish()' type='button' class='button'>Continue</button>"; 
        ?>
        <script>
            $(document).ready( function () {
                $('#tagTable').DataTable();
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
                createCookie("id", id, 0.1);
                window.location.href = "add_tag.php";
            }

            function finish() {
                window.location.href = "add_pic.php";
            }
            
        </script>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>