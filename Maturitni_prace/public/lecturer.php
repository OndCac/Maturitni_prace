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
$sql = "SELECT * FROM TeacherDigitalAgency.Lecturer where UUID = '" . $_SESSION["lecturerId"] . "'";
$result = $con->query($sql);

// Fetch and convert to JSON
$profileData = json_decode($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"
    <link href="css/bootstrap.css" rel="stylesheet">
    <link rel="stylesheet" href="styl.css" type="text/css" />
    <script src="js/bootstrap.js"></script>
    <title>TdA: Lecturer</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Homepage</a></li>
                <li><a href="lec_list.php">Lecturers</a></li>
            </ul>
        </nav>
    </header>
    <article>
        <div class="container mt-5">
            <h1>Profile Information</h1>

            <!-- Display Profile Information -->
            <div class="card">
                <img src="<?php echo $profileData['picture_url']; ?>" class="card-img-top" alt="Profile Picture">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $profileData['title_before'] . ' ' . $profileData['first_name'] . ' ' . $profileData['middle_name'] . ' ' . $profileData['last_name'] . ' ' . $profileData['title_after']; ?></h5>
                    <p class="card-text"><?php echo $profileData['claim']; ?></p>
                    <p class="card-text"><?php echo $profileData['bio']; ?></p>
                </div>
            </div>

            <!-- Display Tags -->
            <div class="mt-3">
                <h5>Tags:</h5>
                <ul class="list-inline">
                    <?php foreach ($profileData['tags'] as $tag): ?>
                        <li class="list-inline-item"><span class="badge badge-primary"><?php echo $tag['name']; ?></span></li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <!-- Display Contact Information -->
            <div class="mt-3">
                <h5>Contact:</h5>
                <ul class="list-unstyled">
                    <?php foreach ($profileData['contact']['telephone_numbers'] as $telephone): ?>
                        <li>Telephone: <?php echo $telephone; ?></li>
                    <?php endforeach; ?>
                    <?php foreach ($profileData['contact']['emails'] as $email): ?>
                        <li>Email: <?php echo $email; ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>

        </div>
    </article>
</body>
</html>