<?php
$con = ConnectDB() or die ('Could not connect to the database server' .
                           mysqli_connect_error());
$lecturerId = $_GET["lec"];
$profileData = GetLecturer($con, $lecturerId);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["FirstName"])) {
    $lec_data = array_map('trim', 
                              array_intersect_key(
                                        $_POST, 
                                        array_flip([
                    "TitleBefore",
                    "FirstName",
                    "MiddleName",
                    "LastName",
                    "TitleAfter",
                    "Location",
                    "Claim",
                    "Bio",
                    "PricePerHour",
                    "Email",
                    "TelephoneNumber"
    ])));
    
    if (!UpdateLec($con, $lecturerId, $lec_data)) {
        echo "error:".mysqli_error($con).BR;
    } else {
        $_SESSION['LecId'] = GetLecByEmail($con, $lec_data['Email']);
        header("Location: index.php?page=edit_tag");
    }
    $con->close();
    exit();
}
?>


<script>
document.addEventListener("DOMContentLoaded", () => {
    document.getElementById("btn-back").addEventListener("click", () => {
        window.location.href = "index.php?page=admin";
    });
});
</script>


<button class="button" type="button" id="btn-back">Zpět na seznam lektorů</button>

<br><br><br>
<form method="POST" class="flex-container">
    <input type="hidden" name="action" value="submited"/>
    <!-- id -- nutne mit sekvenci -->

    <label for="TitleBefore">Titul před jménem:</label>
    <input id="TitleBefore" name="TitleBefore" value="<?= $profileData["TitleBefore"] ?>" />
    <br/>

    <label for="FirstName">Křestní jméno:</label>
    <input id="FirstName" name="FirstName" value="<?= $profileData["FirstName"] ?>" required />
    <br/>

    <label for="MiddleName">Další jméno:</label>
    <input id="MiddleName" name="MiddleName" value="<?= $profileData["MiddleName"] ?>" />
    <br/>

    <label for="LastName">Příjmení:</label>
    <input id="LastName" name="LastName" value="<?= $profileData["LastName"] ?>" required />
    <br/>

    <label for="TitleAfter">Titul za jménem:</label>
    <input id="TitleAfter" name="TitleAfter" value="<?= $profileData["TitleAfter"] ?>" />
    <br/>

    <label for="Location">Poloha:</label>
    <input id="Location" name="Location" value="<?= $profileData["Location"] ?>" required />
    <br/>

    <label for="Claim">Claim:</label>
    <textarea id="Claim" name="Claim" rows="4" cols="50" required>
        <?= $profileData["Claim"] ?>
    </textarea>
    <br/>

    <label for="Bio">Bio:</label>
    <textarea id="Bio" name="Bio" rows="4" cols="50" required>
        <?= $profileData["Bio"] ?>
    </textarea>
    <br/>

    <label for="PricePerHour">Cena Za Hodinu (CZK):</label>
    <input id="PricePerHour" name="PricePerHour" type="number" value="<?= htmlspecialchars($profileData["PricePerHour"]) ?>" required />
    <br/>

    <label for="TelephoneNumber">Telefonní číslo:</label>
    <input id="TelephoneNumber" name="TelephoneNumber" value="<?= htmlspecialchars($profileData["TelephoneNumber"]) ?>" />
    <br/>

    <label for="Email">Email:</label>
    <input id="Email" name="Email" value="<?= $profileData["Email"] ?>" required />
    <br/>

    <div>(Povinné údaje označeny *)</div>
    <br/>

    <input class="button" type="submit" value="Pokračovat">
    
</form>
