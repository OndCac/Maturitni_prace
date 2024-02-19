<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

$sql = "DELETE FROM TeacherDigitalAgency.Tag WHERE UUID = " . $_COOKIE['tag_uuid'] . ";";
$sql2 = "DELETE FROM TeacherDigitalAgency.lecturerTag WHERE TagUUID = " . $_COOKIE['tag_uuid'] . ";";

$con->query($sql);

header("Location: admin.php");