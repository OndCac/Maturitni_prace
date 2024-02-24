<?php
session_start();

if (!($_SESSION["role"] == "admin")) {
    header("Location: index.php");
}

// def. odradkovani v HTML
define("BR", "<br/>\n");

if (isset($_POST["NewTag"])) {
    $host="localhost";
    $port=3306;
    $socket="";
    $user="root";
    $password="root"; // nutne spravne heslo
    $dbname="TeacherDigitalAgency";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());

    $sql = "INSERT INTO Tag (Name) Values ('" . $_POST['NewTag'] . ")')";

    if ($con->query($sql)) {
        $con->close();

        header("Location: admin.php");
    } else {
        echo "error:".mysqli_error($con);
    }
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

                    <label for="NewTag">Tag:</label>
                    <input id="NewTag" name="NewTag" />
                    <br/>

                    <input class="button" type="submit" value="Create">
                    
                    </form>';
        ?>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>