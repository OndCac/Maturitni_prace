<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

$sql1 = "DELETE FROM TeacherDigitalAgency.lecturer WHERE UUID = " . $_COOKIE['uuid'] . ";";
$sql2 = "DELETE FROM TeacherDigitalAgency.lecturerTag WHERE LecturerUUID = " . $_COOKIE['uuid'] . ";";

$con->query($sql2);
$con->query($sql1);

header("Location: admin.php");