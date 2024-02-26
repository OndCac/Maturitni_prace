<?php
    // def. odradkovani v HTML
    define("BR", "<br/>\n");

    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css" />
    <title>TdA: Registrace</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Domovská stránka</a></li>
                <li class="aktivni"><a href="registration.php">Registrace</a></li>
                <?php 
                    if ($_SESSION["logged_in"]) {
                        echo "<li><a href='lec_list.php'>Lektoři</a></li>";
                    } else {
                        echo '<li><a href="login.php">Přihlásit se</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header>

    <article>
        <?php
        if (isset($_POST["email"]) && $_POST["password1"] == $_POST["password2"]) {
            /* echo "user:".$_POST["user"].BR;
            echo "email:".$_POST["email"].BR;
            echo "password:".$_POST["password"].BR;
            echo BR.BR; */

            $hash = hash('sha256', $_POST["password1"]);

            $sql1 = "insert into User(Email, Password, role)\n"
            ."values('".$_POST["email"]
                ."', '".$hash."', 'host')";

            $sql2 = "select email from user where email = '" . $_POST['email'] . "'";
            
            $host="localhost";
            $port=3306;
            $socket="";
            $user="root";
            $password="root"; // nutne spravne heslo
            $dbname="TeacherDigitalAgency";

            $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
                or die ('Could not connect to the database server' . mysqli_connect_error());

            $result = mysqli_fetch_assoc($con->query($sql2));

            // vykonani insertu
            if($result["email"] == $_POST['email']) {
                echo "Účet s tímto emailem již existuje.";
            } else {
                if(mysqli_query($con, $sql1)) {
                    echo "success".BR;
                    $_SESSION["logged_in"] = true;
                    $_SESSION["role"] = "host";
                    header("Location: index.php");
                } else {
                    echo "error:".mysqli_error($con).BR;
                }
            }

            $con->close();

            exit();
        } elseif (isset($_POST["email"]) && $_POST["password1"] != $_POST["password2"]) {
            echo "Nezopakovali jste heslo správně";
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
    </article>
    
    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>    
</body>
</html>