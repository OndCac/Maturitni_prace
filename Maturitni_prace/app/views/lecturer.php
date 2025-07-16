<?php
$con = ConnectDB();
$lecturerId = $_GET["lec"];
$sql2 = "select t.*, lt.taguuid
from lecturertag lt left join tag t on lt.taguuid = t.uuid
where lt.lectureruuid = '" . $lecturerId . "';";
$sql3 = "SELECT name FROM TeacherDigitalAgency.ProfPic where LecturerUUID = '" . $lecturerId . "';";

$profileData = GetLecturer($con, $lecturerId);
$tags = GetLecturersTags($con, $lecturerId);
$PicName = '';
$ProfPic = (GetLecPic($con, $lecturerId, $PicName) &&
            file_exists("../database/images/$PicName")) ?
            "../database/images/$PicName" :
            "../database/images/default_profpic.jpg";
?>


<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btn-back").addEventListener("click", () => {
        window.location.href = "index.php?page=lec_list";
    });
});
</script>


<button class="button" type="button" id="btn-back">
    Zpět na seznam lektorů
</button>

<h1>Profil lektora</h1>

<div class="flex-container">
    <!-- Display Profile Information -->
    <div class="img">
        <img class="prof-img" src="<?= $ProfPic ?>" alt="Profile Picture">
    </div>

    <div class="prof-info">
        <h2>
            <?= $profileData["TitleBefore"] . ' ' .
                $profileData["FirstName"] . ' ' .
                $profileData["MiddleName"] . ' ' .
                $profileData["LastName"] . ' ' .
                $profileData["TitleAfter"]
            ?>
        </h2>
        <p><?= $profileData['Claim'] ?></p>
        <p><?= $profileData['Bio'] ?></p>
    </div>

    <!-- Display Tags -->
    <div>
        <h3>Tagy:</h3>
        <ul>
            <?php foreach ($tags as $tag): ?>
            <?php if (!is_array($tag)) continue; ?>
                <li><span><?= $tag["Name"]; ?></span></li>
            <?php endforeach; ?>
        </ul>
    </div>

    <!-- Display Contact Information -->
    <div>
        <h3>Kontakty:</h3>
        <ul>
            <li>Telefon: <?= $profileData['TelephoneNumber'] ?></p>
            <li>Email: <?= $profileData['Email'] ?></p>
        </ul>
    </div>
</div>