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

$sql1 = "SELECT uuid FROM Lecturer where Email = '" . $_SESSION['LecEmail'] . "'";

if (!$con->query($sql1)) {
    echo "error:".mysqli_error($con).BR;
} else {
    $uuid = mysqli_fetch_assoc($con->query($sql1));
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
                <li class="aktivni"><a href='admin.php'>Administration</a></li>
                <li><a href="lec_list.php">Lecturers</a></li>
                <li class='logout-button'><a href='logout.php'>Log out</a></li>
            </ul>
        </nav>
    </header>

    <article>
    <a href="admin.php">Skip</a>
    </article>

    <article>
        <form method="post" enctype="multipart/form-data">
            <label for="img">Select file (name: firstname_secondname.img)</label>
            <input id="img" type="file" name="image" />
            <input type="submit" name="submit" value="Upload" />
        </form>

        <?php
            // check if an image file was uploaded
            if(isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
                $name = $_FILES['image']['name'];
                $data = file_get_contents($_FILES['image']['tmp_name']);

                $sql2 = "INSERT INTO ProfPic (data) VALUES ($data);";
                if ($con->query($sql2)) {
                    /*$sql3 = "SELECT UUID FROM ProfPic where name = '" . $name . "'";

                    if (!$con->query($sql3)) {
                        echo "error:".mysqli_error($con).BR;
                    } else {*/
                        $profId = $con->insert_id; // mysqli_fetch_assoc($con->query($sql3));

                        $sql4 = "INSERT INTO PicLec (LecturerUUID, ProfPicUUID), VALUES ($uuid, $profId);";
                        if ($con->query($sql4)) {
                            echo "success".BR;
                            echo '<a href="admin.php">Finish</a>';
                        } else {
                        echo "error:".mysqli_error($con);
                        }
                    //}

                } else {
                    echo "error:".mysqli_error($con);
                }

            }
        ?>
    </article>

    <footer>

    </footer>
</body>
</html>