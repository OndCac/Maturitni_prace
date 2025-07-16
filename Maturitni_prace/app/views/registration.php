<?php
function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST["email"]))
{
    $con = ConnectDB();
    if ($_POST["password1"] == $_POST["password2"])
    {
        $status = 0;
        $User = [
            'password' => $_POST["password2"],
            'email' => $_POST["email"]
        ];

        if (Registration($con, $User, $status))
        {
            $_SESSION["logged_in"] = true;
            $_SESSION["role"] = "host";
            header("Location: index.php?page=home_page");
            exit;
        }
        else
        {
            if ($status == 1)
                alert('Account under this email already exists.');
            else
                alert('Error: ' . mysqli_error($con));
        }
    }
    else
        echo "Nezopakovali jste heslo správně";
    $con->close();
}

?>

<form method="POST"><!-- action="neco.php", method="GET" -->
    <input type="hidden" name="action" value="submited"/>
    <!-- id -- nutne mit sekvenci -->

    <label for="email">Email:</label>
    <input class="flex-container" id="email" type="email" name="email" required />
    <br/>

    <label for="password1">Heslo:</label>
    <input class="flex-container" id="password1" type="password" name="password1" required />
    <br/>

    <label for="password2">Heslo znovu:</label>
    <input class="flex-container" id="password2" type="password" name="password2" required />
    <br/>

    <input class="button" type="submit" value="Zaregistrovat">
</form>
