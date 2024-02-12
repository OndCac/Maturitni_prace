<?php
session_start();

if (!($_SESSION["role"] == "admin")) {
    header("Location: index.php");
}

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

if (isset($_POST["FirstName"])) {
    $sql = "INSERT INTO Lecturer (TitleBefore, FirstName, MiddleName, LastName, TitleAfter, PictureURL, Location, Claim, Bio, PricePerHour, TelephoneNumber, Email) VALUES (
        '" . $_POST['TitleBefore'] . "', 
        '" . $_POST['FirstName'] . "', 
        '" . $_POST['MiddleName'] . "', 
        '" . $_POST['LastName'] . "', 
        '" . $_POST['TitleAfter'] . "', 
        '" . $_POST['PictureURL'] . "', 
        '" . $_POST['Location'] . "', 
        '" . $_POST['Claim'] . "', 
        '" . $_POST['Bio'] . "', 
        " . $_POST['PricePerHour'] . ",
        '" . $_POST['TelephoneNumber'] . "',
        '" . $_POST['Email'] . "')";
    
    if ($con->query($sql)) {
        $con->close();

        $_SESSION['LecEmail'] = $_POST['Email'];

        header("Location: add_tag.php");
    } else {
        echo "error:".mysqli_error($con);
    }

    $_SESSION['Email'] = $_POST['Email'];

    /*echo $_POST['TitleBefore'] . BR
        . $_POST['FirstName'] . BR
        . $_POST['MiddleName'] . BR 
        . $_POST['LastName'] . BR 
        . $_POST['TitleAfter'] . BR 
        . $_POST['PictureURL'] . BR 
        . $_POST['Location'] . BR 
        . $_POST['Claim'] . BR 
        . $_POST['Bio'] . BR 
        . $_POST['PricePerHour'] . BR
        . $_POST['Email'] . BR 
        . $_POST['TelephoneNumber'] . BR
        . "<li><a href='add_tag.php'>Add tags</a></li>";*/

    

    /*$sql = "SELECT uuid FROM Lecturer where Email = '" . $_POST['Email'] . "'";

    if (!$con->query($sql)) {
        echo "error:".mysqli_error($con).BR;
    } else {
        $uuid = mysqli_fetch_assoc($con->query($sql));
    }

    foreach ($lecTags as $lecTag) {
        $sql = "INSERT INTO LecturerTag (LecturerUUID, TagUUID)
            VALUES (" . $uuid['uuid'] . ", " . $lecTag . " )";

        if (!$con->query($sql)) {
            echo "error:".mysqli_error($con).BR;
        } else {
            $con->query($sql);
        }
    }*/
    

    $con->close();

    exit();

    header("Location: add_tag.php");
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
            echo '
                    <form method="POST">
                    <input type="hidden" name="action" value="submited"/>
                    <!-- id -- nutne mit sekvenci -->

                    <label for="TitleBefore">Title before:</label>
                    <input id="TitleBefore" name="TitleBefore" />
                    <br/>

                    <label for="FirstName">First Name:</label>
                    <input id="FirstName" name="FirstName" required />
                    <br/>

                    <label for="MiddleName">Middle Name:</label>
                    <input id="MiddleName" name="MiddleName" />
                    <br/>

                    <label for="LastName">Last Name:</label>
                    <input id="LastName" name="LastName" required />
                    <br/>

                    <label for="TitleAfter">Title After:</label>
                    <input id="TitleAfter" name="TitleAfter" />
                    <br/>

                    <label for="PictureURL">Picture URL:</label>
                    <input id="PictureURL" name="PictureURL" />
                    <br/>

                    <label for="Location">Location:</label>
                    <input id="Location" name="Location" required />
                    <br/>

                    <label for="Claim">Claim:</label>
                    <textarea id="Claim" name="Claim" rows="4" cols="50" required>
                    </textarea>
                    <br/>

                    <label for="Bio">Bio:</label>
                    <textarea id="Bio" name="Bio" rows="4" cols="50" required>
                    </textarea>
                    <br/>

                    <label for="PricePerHour">Price Per Hour (CZK):</label>
                    <input id="PricePerHour" name="PricePerHour" type="number" required />
                    <br/>

                    <label for="Email">Email:</label>
                    <input id="Email" name="Email" required />
                    <br/>

                    <label for="TelephoneNumber">Phone number:</label>
                    <input id="TelephoneNumber" name="TelephoneNumber" />
                    <br/>
                    
                    <input class="button" type="submit" value="Create">
                    
                    </form>';
        ?>
    </article>
<?php /*
    <article>
        <?php
            $sql = "SELECT * FROM TeacherDigitalAgency.Tag";
            $result = $con->query($sql);

            while($row = mysqli_fetch_assoc($result)) {
                // skladame objekt pro zaznam z DB
                $Tag[] = $row;
            }

            if (isset($_COOKIE["id"])) {
                    $lecTags[] = $_COOKIE["id"];
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
            echo "</tbody>"; 
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
            }

            
        </script> 
    </article>
*/ ?>
    <footer>

    </footer>
</body>
</html>