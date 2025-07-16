<?php
function ConnectDB(): mysqli {
    $host="localhost";
    $port=3306;
    $socket="";
    $user="root";
    $password="root"; // nutne spravne heslo
    $dbname="TeacherDigitalAgency";

    return new mysqli($host, $user, $password,
                    $dbname, $port, $socket);
}

function Registration($con, $User, &$status): bool {
    $email = $User['email'];
    $password = $User['password'];

    $sql = "SELECT Email FROM TeacherDigitalAgency.User WHERE Email = '$email'";
    $result = mysqli_fetch_assoc($con->query($sql));

    if(!empty($result))
    {
        $status = 1;
        return false;
    }

    $hash = hash('sha256', $password);
    $sql = "INSERT INTO TeacherDigitalAgency.User(Email, Password, role) 
                VALUES('$email', '$hash', 'host')";
    
    if (!$con->query($sql))
    {
        $status = 2;
        return false;
    }
    return true;
}

function AddLec($con, $LecData) {
    $sql = "INSERT INTO TeacherDigitalAgency.Lecturer 
            (TitleBefore, FirstName, MiddleName, LastName, TitleAfter,
            Location, Claim, Bio, PricePerHour, TelephoneNumber, Email)
            VALUES (
                    '" . $LecData['TitleBefore'] . "', 
                    '" . $LecData['FirstName'] . "', 
                    '" . $LecData['MiddleName'] . "', 
                    '" . $LecData['LastName'] . "', 
                    '" . $LecData['TitleAfter'] . "', 
                    '" . $LecData['Location'] . "', 
                    '" . $LecData['Claim'] . "', 
                    '" . $LecData['Bio'] . "', 
                    " . $LecData['PricePerHour'] . ",
                    '" . $LecData['TelephoneNumber'] . "',
                    '" . $LecData['Email'] . "')";

    return $con->query($sql);
}

function GetLecByEmail($con, $email): string {
    $sql = "SELECT UUID FROM TeacherDigitalAgency.Lecturer where Email = '$email'";
    $lec = mysqli_fetch_assoc($con->query($sql));
    return $lec ? $lec['uuid'] : '';
}

function UpdateLec($con, $uuid, $lecturer): bool {
    $sql = "UPDATE TeacherDigitalAgency.Lecturer SET
            TitleBefore = '" . $lecturer['TitleBefore'] . "', 
            FirstName = '" . $lecturer['FirstName'] . "', 
            MiddleName = '" . $lecturer['MiddleName'] . "', 
            LastName = '" . $lecturer['LastName'] . "', 
            TitleAfter = '" . $lecturer['TitleAfter'] . "',
            Location = '" . $lecturer['Location'] . "', 
            Claim = '" . $lecturer['Claim'] . "', 
            Bio = '" . $lecturer['Bio'] . "', 
            PricePerHour = " . $lecturer['PricePerHour'] . ", 
            TelephoneNumber = '" . $lecturer['TelephoneNumber'] . "', 
            Email = '" . $lecturer['Email'] . "'
            WHERE UUID = $uuid";
    return $con->query($sql);
}

function DeleteLec($con, $uuid): void {
    $sql1 = "SELECT name FROM TeacherDigitalAgency.ProfPic WHERE LecturerUUID = $uuid;";
    if ($file_name = mysqli_fetch_assoc($con->query($sql1)))
        @unlink("../../database/images/" . $file_name["name"]);

    $queries = ["DELETE FROM TeacherDigitalAgency.ProfPic WHERE LecturerUUID = $uuid;",
                "DELETE FROM TeacherDigitalAgency.LecturerTag WHERE LecturerUUID = $uuid;",
                "DELETE FROM TeacherDigitalAgency.Lecturer WHERE UUID = $uuid;"];

    foreach ($queries as $query)
        $con->query($query);
}

function AddLecPic($con, $uuid, $pic): bool {
    $sql = "INSERT INTO ProfPic (name, LecturerUUID) VALUES ('$pic', $uuid)";
    return $con->query($sql);
}


function GetLecPic($con, $uuid, &$pic): bool {
    $sql = "SELECT name FROM ProfPic WHERE LecturerUUID = $uuid";
    if ($pic = mysqli_fetch_column($con->query($sql)))
        return true;
    return false;
}


function DeleteLecPic($con, $name) {
    $sql = "DELETE FROM TeacherDigitalAgency.ProfPic WHERE Name = '$name';";
    $con->query($sql);
}


function CreateTag($con, $tag_name): bool {
    $sql = "INSERT INTO Tag (Name) Values ('$tag_name')";
    return $con->query($sql);
}


// link a tag to lecturer
function LinkTag($con, $tagId, $uuid): bool {
    $sql1 = "SELECT TagUUID FROM LecturerTag WHERE LecturerUUID = $uuid AND TagUUID = $tagId";
    $tagcheck = mysqli_fetch_assoc($con->query($sql1));

    // check whether the link doesn't already exist
    if (!isset($tagcheck['TagUUID'])){
        $sql2 = "INSERT INTO LecturerTag (LecturerUUID, TagUUID)
                VALUES ($uuid, $tagId)";
        return $con->query($sql2);
    }
    return true;
}

function UnlinkTag($con, $tagId, $uuid): bool {
    $sql = "DELETE FROM LecturerTag WHERE LecturerUUID = $uuid AND TagUUID = $tagId";
    return $con->query($sql);
}

function GetTags($con): array {
    $sql = "SELECT * FROM TeacherDigitalAgency.Tag";

    $Tags = [];
    if ($result = $con->query($sql))
        while($Tags[] = mysqli_fetch_assoc($result));

    return $Tags;
}

function GetLecturersTags($con, $uuid): array {
    $sql = "SELECT t.*, lt.TagUUID
            FROM LecturerTag lt LEFT JOIN Tag t ON lt.TagUUID = t.UUID
            WHERE lt.LecturerUUID = $uuid;";

    $Tags = [];
    if ($result = $con->query($sql))
        while($Tags[] = mysqli_fetch_assoc($result));

    return $Tags;
}

function DeleteTag($con, $tagId): void {
    $sql = [
        "DELETE FROM TeacherDigitalAgency.LecturerTag WHERE TagUUID = $tagId;",
        "DELETE FROM TeacherDigitalAgency.Tag WHERE UUID = $tagId;"
    ];

    $con->query($sql[0]);
    $con->query($sql[1]);
}

function GetLecturer($con, $uuid): array {
    $sql = "SELECT * FROM TeacherDigitalAgency.Lecturer WHERE UUID = $uuid";
    return mysqli_fetch_assoc($con->query($sql));
}

function GetLecturers($con): array {
    $sql = "SELECT
                UUID,
                TitleBefore,
                FirstName,
                MiddleName,
                LastName,
                TitleAfter,
                Location,
                PricePerHour
            FROM
                TeacherDigitalAgency.Lecturer";
    $result = $con->query($sql);

    $profileData = [];
    while($row = mysqli_fetch_assoc($result)) {
        $profileData[] = $row;
    }
    return $profileData;
}


// USER

function GetUser($con, $email, &$user): bool{
    $sql = "SELECT * FROM TeacherDigitalAgency.User where Email = '$email'";

    if ($user = mysqli_fetch_assoc($con->query($sql)))
        return true;
    return false;
}