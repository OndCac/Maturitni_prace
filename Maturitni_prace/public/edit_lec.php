<?php
session_start();

if (!($_SESSION["role"] == "admin")) {
    header("Location: index.php");
}

// def. odradkovani v HTML
define("BR", "<br/>\n");

$lecturerId = $_COOKIE["uuid"];

$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

$sql = "SELECT * FROM lecturer WHERE UUID = $lecturerId";
$result = $con->query($sql);
$profileData = mysqli_fetch_assoc($result);

if (isset($_POST["FirstName"])) {
    $sql = "UPDATE Lecturer SET
        TitleBefore = '" . $_POST['TitleBefore'] . "', 
        FirstName = '" . $_POST['FirstName'] . "', 
        MiddleName = '" . $_POST['MiddleName'] . "', 
        LastName = '" . $_POST['LastName'] . "', 
        TitleAfter = '" . $_POST['TitleAfter'] . "', 
        PictureURL = '" . $_POST['PictureURL'] . "', 
        Location = '" . $_POST['Location'] . "', 
        Claim = '" . $_POST['Claim'] . "', 
        Bio = '" . $_POST['Bio'] . "', 
        PricePerHour = " . $_POST['PricePerHour'] . "
        WHERE UUID = $lecturerId";

    if (!$con->query($sql)) {
        echo "error:".mysqli_error($con).BR;
    } else {
        $con->query($sql);

        echo $_POST['TitleBefore'] . BR
            . $_POST['FirstName'] . BR
            . $_POST['MiddleName'] . BR 
            . $_POST['LastName'] . BR 
            . $_POST['TitleAfter'] . BR 
            . $_POST['PictureURL'] . BR 
            . $_POST['Location'] . BR 
            . $_POST['Claim'] . BR 
            . $_POST['Bio'] . BR 
            . $_POST['PricePerHour'] . BR;
    }

    $con->close();

    exit();
}

echo '<form method="POST">
        <input type="hidden" name="action" value="submited"/>
        <!-- id -- nutne mit sekvenci -->

        <label for="TitleBefore">Title before:</label>
        <input id="TitleBefore" name="TitleBefore" value="' . $profileData["TitleBefore"] . '" />
        <br/>

        <label for="FirstName">First Name:</label>
        <input id="FirstName" name="FirstName" value="' . $profileData["FirstName"] . '" required />
        <br/>

        <label for="MiddleName">Middle Name:</label>
        <input id="MiddleName" name="MiddleName" value="' . $profileData["MiddleName"] . '" />
        <br/>

        <label for="LastName">Last Name:</label>
        <input id="LastName" name="LastName" value="' . $profileData["LastName"] . '" required />
        <br/>

        <label for="TitleAfter">Title After:</label>
        <input id="TitleAfter" name="TitleAfter" value="' . $profileData["TitleAfter"] . '" />
        <br/>

        <label for="PictureURL">Picture URL:</label>
        <input id="PictureURL" name="PictureURL" value="' . $profileData["PictureURL"] . '" />
        <br/>

        <label for="Location">Location:</label>
        <input id="Location" name="Location" value="' . $profileData["Location"] . '" required />
        <br/>

        <label for="Claim">Claim:</label>
        <textarea id="Claim" name="Claim" rows="4" cols="50" required>
        ' . $profileData["Claim"] . '
        </textarea>
        <br/>

        <label for="Bio">Bio:</label>
        <textarea id="Bio" name="Bio" rows="4" cols="50" required>
        ' . $profileData["Bio"] . '
        </textarea>
        <br/>

        <label for="PricePerHour">Price Per Hour (CZK):</label>
        <input id="PricePerHour" name="PricePerHour" type="number" value="' . $profileData["PricePerHour"] . '" required />
        <br/>

        <input class="button" type="submit" value="Log In">';
?>