<?php
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

if (isset($_POST["email"])) {
    $con = ConnectDB();
    $user = [];
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!GetUser($con, $email, $user)) {
        alert("Account not found: check your email or create new account.");
    } else {
        $hash = hash('sha256', $password);

        if($user["Password"] == $hash) {
            $_SESSION["logged_in"] = true;
            $_SESSION["role"] = $user["role"];

            header("Location: index.php");
        } else {
            alert("Wrong password.");
        }
    }

    $con->close();
    exit();
}
?>

<form method="POST"><!-- action="neco.php", method="GET" -->
    <input type="hidden" name="action" value="submited"/>
    <!-- id -- nutne mit sekvenci -->

    <label for="email">Email:</label>
    <input class="flex-container" id="email" type="email" name="email" required />
    <br/>

    <label for="password">Heslo:</label>
    <input class="flex-container" id="password" type="password" name="password" required />
    <br/>

    <input class="button" type="submit" value="Přihlásit se">
</form>