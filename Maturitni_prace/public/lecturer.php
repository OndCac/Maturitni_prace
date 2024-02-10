<?php
// def. odradkovani v HTML
define("BR", "<br/>\n");
session_start();

$lecturerId = $_COOKIE["uuid"];

$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

// tabulka uzivatele z DB jako JSON
$sql1 = "SELECT * FROM TeacherDigitalAgency.Lecturer where UUID = '" . $lecturerId . "';"; // . $_SESSION["lecturerId"] . "'";
$sql2 = "select t.*, lt.taguuid
from lecturertag lt left join tag t on lt.taguuid = t.uuid
where lt.lectureruuid = '" . $lecturerId . "';";
//$sql3 = "SELECT * FROM TeacherDigitalAgency.Tag;";
// $sql4 = "SELECT * FROM TeacherDigitalAgency.LecturerTag where LecturerUUID = '1';";

$result = $con->query($sql1);
$profileData = mysqli_fetch_assoc($result);

$result = $con->query($sql2);
while($row = mysqli_fetch_assoc($result)) {
    // skladame objekt pro zaznam z DB
    $tags[] = $row;
}

?>

<!DOCTYPE html> 
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link href="css/bootstrap.css" rel="stylesheet"> -->
    <link rel="stylesheet" href="styles.css" type="text/css" />
    <!-- <script src="js/bootstrap.js"></script> -->
    <title>TdA: Lecturer</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Homepage</a></li>
                <?php
                if ($_SESSION["role"] == "admin") {
                    echo "<li><a href='admin.php'>Administration</a></li>";
                }
                ?>
                <li><a href="lec_list.php">Lecturers</a></li>
                <li class='logout-button'><a href='logout.php'>Log out</a></li>
            </ul>
        </nav>
    </header>

    <article>
        <h1>Profile Information</h1>
        <div class="flex-container">
            <!-- Display Profile Information -->
            <img class="prof-img" src="<?php echo $profileData['PictureURL']; ?>" alt="Profile Picture">
            <div class="prof-info">
                <h2><?php echo $profileData['TitleBefore'] . ' ' . $profileData['FirstName'] . ' ' . $profileData['MiddleName'] . ' ' . $profileData['LastName'] . ' ' . $profileData['TitleAfter']; ?></h2>
                <p><?php echo $profileData['Claim']; ?></p>
                <p><?php echo $profileData['Bio']; ?></p>
            </div>

            <!-- Display Tags -->
            <div class="prof-tc">
                <h3>Tags:</h3>
                <ul>
                    <?php foreach ($tags as $tag): ?>
                        <li><span><?php echo $tag["Name"]; ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Display Contact Information -->
            <div class="prof-tc">
                <h3>Contact:</h3>
                <ul>
                    <li>Telephone: <?php echo $profileData['TelephoneNumber']; ?></p>
                    <li>Email: <?php echo $profileData['Email']; ?></p>
                </ul>
            </div>

        </div>
    </article>
    <footer>

    </footer>   
</body>
</html>