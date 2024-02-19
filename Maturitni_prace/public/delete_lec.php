<?php
$host="localhost";
$port=3306;
$socket="";
$user="root";
$password="root"; // nutne spravne heslo
$dbname="TeacherDigitalAgency";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
    or die ('Could not connect to the database server' . mysqli_connect_error());

$sql3 = "SELECT name FROM TeacherDigitalAgency.ProfPic WHERE LecturerUUID = " . $_COOKIE['uuid'] . ";";

if ($con->query($sql3)) {
$file_name = mysqli_fetch_assoc($con->query($sql3));
}

unlink("../database/images/" . $file_name["name"]);

$sql1 = "DELETE FROM TeacherDigitalAgency.lecturer WHERE UUID = " . $_COOKIE['uuid'] . ";";
$sql2 = "DELETE FROM TeacherDigitalAgency.lecturerTag WHERE LecturerUUID = " . $_COOKIE['uuid'] . ";";
$sql4 = "DELETE FROM TeacherDigitalAgency.ProfPic WHERE LecturerUUID = " . $_COOKIE['uuid'] . ";";

$con->query($sql4);
$con->query($sql2);
$con->query($sql1);

header("Location: admin.php");