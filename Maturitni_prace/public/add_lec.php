<?php
session_start();

if (!($_SESSION["role"] == "admin")) {
    header("Location: index.php");
}

// def. odradkovani v HTML
define("BR", "<br/>\n");

if (isset($_POST["FirstName"])) {
    $host="localhost";
    $port=3306;
    $socket="";
    $user="root";
    $password="root"; // nutne spravne heslo
    $dbname="TeacherDigitalAgency";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());

    $sql = "INSERT INTO Lecturer (TitleBefore, FirstName, MiddleName, LastName, TitleAfter, PictureURL, Location, Claim, Bio, PricePerHour) VALUES (
        '" . $_POST['TitleBefore'] . "', 
        '" . $_POST['FirstName'] . "', 
        '" . $_POST['MiddleName'] . "', 
        '" . $_POST['LastName'] . "', 
        '" . $_POST['TitleAfter'] . "', 
        '" . $_POST['PictureURL'] . "', 
        '" . $_POST['Location'] . "', 
        '" . $_POST['Claim'] . "', 
        '" . $_POST['Bio'] . "', 
        " . $_POST['PricePerHour'] . ")";

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

function addEm() {
    echo '<br/><label for="Email">Email:</label>
            <input id="Email" type="email" name="Email" required /> <button onclick="addEm()" type="button">Another Email</button>';
}

function addPh() {
    echo '<br/><label for="Phone">Phone number:</label>
            <input id="Phone" type="number" max="20" name="Phone" required /> <button onclick="addPh()" type="button">Another Number</button>';
}

echo '<form method="POST">
        <input type="hidden" name="action" value="submited"/>
        <!-- id -- nutne mit sekvenci -->

        <label for="TitleBefore">Title before:</label>
        <input id="TitleBefore" name="TitleBefore" />
        <br/>

        <label for="FirstName">First Name:</label>
        <input id="FirstName" name="FirstName" required />
        <br/>

        <label for="MiddleName">Middle Name:</label>
        <input id="MiddleName" name="MiddleName" />
        <br/>

        <label for="LastName">Last Name:</label>
        <input id="LastName" name="LastName" required />
        <br/>

        <label for="TitleAfter">Title After:</label>
        <input id="TitleAfter" name="TitleAfter" />
        <br/>

        <label for="PictureURL">Picture URL:</label>
        <input id="PictureURL" name="PictureURL" />
        <br/>

        <label for="Location">Location:</label>
        <input id="Location" name="Location" required />
        <br/>

        <label for="Claim">Claim:</label>
        <textarea id="Claim" name="Claim" rows="4" cols="50" required>
        </textarea>
        <br/>

        <label for="Bio">Bio:</label>
        <textarea id="Bio" name="Bio" rows="4" cols="50" required>
        </textarea>
        <br/>

        <label for="PricePerHour">Price Per Hour (CZK):</label>
        <input id="PricePerHour" name="PricePerHour" type="number" required />
        <br/>

        <label for="Email">Email:</label>
        <input id="Email" type="email" name="Email" required />
        <br/>

        <label for="Phone">Phone number:</label>
        <input id="Phone" type="number" max="20" name="Phone" required />
        <br/>
        
        <input class="button" type="submit" value="Create">';
?>