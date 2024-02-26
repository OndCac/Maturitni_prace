<?php
    // def. odradkovani v HTML
    define("BR", "<br/>\n");

    session_start();

    if (!$_SESSION["logged_in"]) {
        header("Location: index.php");
    }
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
//$profileData = mysqli_fetch_assoc($result);

while($row = mysqli_fetch_assoc($result)) {
    // skladame objekt pro zaznam z DB
    $profileData[] = $row;
}

// Fetch and convert to JSON
//$profileData = json_decode($result);

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
    <title>TdA: Seznam lektorů</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Domovská stránka</a></li>
                <?php
                if ($_SESSION["role"] == "admin") {
                            echo "<li><a href='admin.php'>Administrace</a></li>";
                        }
                ?>
                <li class="aktivni"><a href="lec_list.php">Lektoři</a></li>
                <li class='logout-button'><a href='logout.php'>Odhlásit se</a></li>
            </ul>
        </nav>
    </header>

    <article>
        <?php
        echo "<table id='lecTable' class='display'>
                <thead>
                    <tr>
                        <th>Jméno</th>
                        <th>Poloha</th>
                        <th>Cena za hodinu (CZK)</th>
                    </tr>
                </thead>
                <tbody>";
        for ($i=0; $i < count($profileData); $i++) { 
            echo '<tr id="' . $profileData[$i]["UUID"] . '">
                    <td>' . $profileData[$i]["TitleBefore"] . ' ' . $profileData[$i]["FirstName"] . ' ' . $profileData[$i]["MiddleName"] . ' ' . $profileData[$i]["LastName"] . ' ' . $profileData[$i]["TitleAfter"] . '</td>
                    <td>' . $profileData[$i]["Location"] . '</td>
                    <td>' . $profileData[$i]["PricePerHour"] . '</td>
                    </tr>';
        }
        echo "</tbody>";
        // echo '<div class=lec-list><a href="lecturer.php" onclick="lecturerId(' . $profileData["UUID"] . ')">' . $profileData["FirstName"] . ' ' . $profileData["MiddleName"] . ' ' . $profileData["LastName"] . '</a></div>';
            
        ?>
        <script>
            $(document).ready( function () {
                $('#lecTable').DataTable();
                $('article').after("<footer>Vytvořil Ondřej Cacek 2024 </footer>");
            } );
                
            $( '#lecTable tbody tr' ).on( 'click', function() {
                createCookie("uuid", this.id, 1)
                window.location.href = "lecturer.php";
            });

            // Function to create the cookie 
            function createCookie(name, value, days) {
                let expires;
            
                if (days) {
                    let date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toGMTString();
                }
                else {
                    expires = "";
                }
            
                document.cookie = name + "=" +
                    value + ";" + expires + "; path=/";
            }
        </script>
    </article>
</body>
</html>