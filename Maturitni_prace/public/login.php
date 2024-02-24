<?php
    // def. odradkovani v HTML
    define("BR", "<br/>\n");

    session_start();

    if (isset($_POST["email"])) {
    $host="localhost";
    $port=3306;
    $socket="";
    $user="root";
    $password="root"; // nutne spravne heslo
    $dbname="TeacherDigitalAgency";

    $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
        or die ('Could not connect to the database server' . mysqli_connect_error());

    $sql = "SELECT * FROM TeacherDigitalAgency.User where Email = '" . $_POST["email"] . "'";

    if (!$con->query($sql)) {
        echo "error:".mysqli_error($con).BR;
    } else {
        $result = mysqli_fetch_assoc($con->query($sql));
        
        $hash = hash('sha256', $_POST["password"]);

        if($result["Password"] == $hash) {
            echo "successful login".BR;
            $_SESSION["logged_in"] = true;

            $_SESSION["role"] = $result["role"];
            echo $_SESSION["role"];
            header("Location: index.php");
        } else {
            echo "wrong password".BR;
            header("Location: login.php");
        }
    }

    $con->close();

    exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css" />
    <title>TeacherDigitalAgency: Login</title>
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Homepage</a></li>
                <?php 
                    if ($_SESSION["logged_in"]) {
                        echo "<li><a href='lec_list.php'>Lecturers</a></li>";
                        echo "<li><input class='logout-button' type='submit' value='Log out'>Log out</li>";
                    } else {
                        echo '<li><a href="registration.php">Registration</a></li>';
                    }
                ?>
                <li class="aktivni"><a href="login.php">Login</a></li>
            </ul>
        </nav>
    </header>
    
    <article>
        <form method="POST"><!-- action="neco.php", method="GET" -->
            <input type="hidden" name="action" value="submited"/>
            <!-- id -- nutne mit sekvenci -->

            <label for="email">Email:</label>
            <input class="flex-container" id="email" type="email" name="email" required />
            <br/>

            <label for="password">Password:</label>
            <input class="flex-container" id="password" type="password" name="password" required />
            <br/>

            <input class="button" type="submit" value="Log In">
        </form>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>