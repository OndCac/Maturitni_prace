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
$sql1 = "SELECT * FROM TeacherDigitalAgency.Lecturer where UUID = '1';"; // . $_SESSION["lecturerId"] . "'";
$sql2 = "SELECT * FROM TeacherDigitalAgency.Contact where LecturerUUID = '1';";
$sql3 = "SELECT * FROM TeacherDigitalAgency.Tag;";
$sql4 = "SELECT * FROM TeacherDigitalAgency.LecturerTag where LecturerUUID = '1';";

$result = $con->query($sql1);
$profileData = mysqli_fetch_assoc($result);

$result = $con->query($sql2);
$contact = mysqli_fetch_assoc($result);
$contact['TelephoneNumbers'] = json_decode($contact['TelephoneNumbers']);
$contact['Emails'] = json_decode($contact['Emails']);

$result = $con->query($sql3);
// $tag = mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)) {
    // skladame objekt pro zaznam z DB
    $tag[] = $row;
}

$result = $con->query($sql4);
// $lecturerTag = mysqli_fetch_assoc($result);
while($row = mysqli_fetch_assoc($result)) {
    // skladame objekt pro zaznam z DB
    $lecturerTag[] = $row;
}

$tags = array();

foreach ($lecturerTag as $key) {
    $tags[] = $tag[$key["TagUUID"]];
}


/*
foreach ($tag as $val) {
    foreach ($lecturerTag as $key) {
        if ($tag["UUID"] == $key["LecturerUUID"]) {
            $tags[] = $val;
        }
    }
}
*/
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
                <li><a href="lec_list.php">Lecturers</a></li>
                <li class='logout-button'><a href='logout.php'>Log out</a></li>
            </ul>
        </nav>
    </header>
    <article>
        <div class="container mt-5">
            <h1>Profile Information</h1>

            <!-- Display Profile Information -->
            <div class="card">
                <img src="<?php echo $profileData['PictureURL']; ?>" alt="Profile Picture">
                <div>
                    <h5><?php echo $profileData['TitleBefore'] . ' ' . $profileData['FirstName'] . ' ' . $profileData['MiddleName'] . ' ' . $profileData['LastName'] . ' ' . $profileData['TitleAfter']; ?></h5>
                    <p><?php echo $profileData['Claim']; ?></p>
                    <p><?php echo $profileData['Bio']; ?></p>
                </div>
            </div>

            <!-- Display Tags -->
            <div>
                <h5>Tags:</h5>
                <ul>
                    <?php foreach ($tags as $tag): ?>
                        <li class="list-inline-item"><span class="badge badge-primary"><?php echo $tag["Name"]; ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Display Contact Information -->
            <div>
                <h5>Contact:</h5>
                <ul>
                    <?php foreach ($contact['TelephoneNumbers'] as $telephone): ?>
                        <li>Telephone: <?php echo $telephone; ?></li>
                    <?php endforeach; ?>
                    <?php foreach ($contact['Emails'] as $email): ?>
                        <li>Email: <?php echo $email; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </article>
    <footer>

    </footer>   
</body>
</html>