<?php
    // def. odradkovani v HTML
    define("BR", "<br/>\n");

    session_start();
?>

<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

// tabulka uzivatele z DB jako JSON
$sql = "SELECT * FROM TeacherDigitalAgency.lecturer";
$result = $con->query($sql);

//$result = mysqli_fetch_assoc($result);
$profileData = json_decode($result);
/*
while($row = mysqli_fetch_assoc($result)) {
    // skladame objekt pro zaznam z DB
    $profileData[] = $row;
}
*/

// Fetch and convert to JSON
//$profileData = json_decode($result);

function lecturerId($id) {
    $_SESSION["lecturerId"] = $id;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <title>TdA: List of Lecturers</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Homepage</a></li>
                <li class="aktivni"><a href="lec_list.php">Lecturers</a></li>
                <li class='logout-button'><a href='logout.php'>Log out</a></li>
            </ul>
        </nav>
    </header>
    <article>
        <?php
            foreach ($profileData as $row) {
                echo '<div><a href="lecturer.php" onclick="lecturerId(' . $row["UUID"] . ')">' . $row["FirstName"] . $row["SecondName"] . '</a></div>';
                
                //echo $row["FirstName"] . $row["SecondName"] . BR;
            }
        ?>
    </article>
    
    <footer>

    </footer>
</body>
</html>