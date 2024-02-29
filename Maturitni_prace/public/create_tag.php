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

    $sql2 = "SELECT Name FROM Tag WHERE Name = '" . $_POST['NewTag'] . "'";

    $tagcheck = mysqli_fetch_assoc($con->query($sql2));
    //$tagcheck['TagUUID'] != $lecTag
    if (!isset($tagcheck['Name'])){
        $sql = "INSERT INTO Tag (Name) Values ('" . $_POST['NewTag'] . "')";

        $con->query($sql)
            or die ("error:".mysqli_error($con));

        header("Location: admin.php");
    } else {
        echo "<script>alert('Tento tag již existuje')</script>";
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
    <title>TdA: Nový Tag</title>
    <script>
        function back() {
            window.location.href = "admin.php";
        }
    </script>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Domovská stránka</a></li>
                <li class="aktivni"><a href='admin.php'>Administrace</a></li>
                <li><a href="lec_list.php">Lektoři</a></li>
                <li class='logout-button'><a href='logout.php'>Log out</a></li>
            </ul>
        </nav>
    </header>
    <article>
        <?php
            echo '  <button class="button" type="button" onclick="back()">Zpět na seznam lektorů</button><br><br><br>

                    <form method="POST" class="flex-container">
                    <input type="hidden" name="action" value="submited"/>
                    <!-- id -- nutne mit sekvenci -->

                    <label for="NewTag">Tag:</label>
                    <input id="NewTag" name="NewTag" />
                    <br/>

                    <input class="button" type="submit" value="Vytvořit">
                    
                    </form>';
        ?>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>