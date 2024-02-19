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

define ("UPLOAD_DIR", "../database/images");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <title>TdA: List of Lecturers</title>
    <script>
        function finish() {
            window.location.href = "admin.php";
        }
    </script>
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
        <button class="button" type="button" onclick="finish()">Finish</button>

        <form method="post" enctype="multipart/form-data">
            <label for="img">Select file (name: firstname_secondname.img)</label>
            <input id="img" type="file" name="image" />
            <input type="submit" name="submit" value="Upload" />
        </form>

        <?php
            if (isset($_FILES['image'])) {
                $upload_file = $_FILES['image'];
                $upload_file_name = $_FILES['image']['name'];
                // presun souboru z docasneho uloziste
                if (!move_uploaded_file($upload_file['tmp_name'], UPLOAD_DIR."/$upload_file_name"))
                {
                    die("cannot move uploaded file to ".UPLOAD_DIR);
                }

                $sql1 = "INSERT INTO ProfPic (name, LecturerUUID) VALUES ('$upload_file_name', " . $uuid['uuid'] . ")";
                if (!$con->query($sql1)) {
                    echo "error:".mysqli_error($con).BR;
                }

                unset($_SESSION["LecEmail"]);
                header("Location: admin.php");
            }
        ?>
    </article>

    <footer>

    </footer>
</body>
</html>