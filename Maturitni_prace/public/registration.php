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
    <title>TdA: Registration</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li><a href="index.php">Homepage</a></li>
                <li class="aktivni"><a href="registration.php">Registration</a></li>
                <?php 
                    if ($_SESSION["logged_in"]) {
                        echo "<li><a href='lec_list.php'>Lecturers</a></li>";
                    } else {
                        echo '<li><a href="login.php">Login</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header>

    <article>
        <?php
        if (isset($_POST["email"])) {
            echo "formular odeslan".BR;
            /* echo "user:".$_POST["user"].BR;
            echo "email:".$_POST["email"].BR;
            echo "password:".$_POST["password"].BR;
            echo BR.BR; */

            $hash = hash('sha256', $_POST["password"]);

            $sql = "insert into User(UserName, Email, Password, role)\n"
            ."values('".$_POST["user"]."', '".$_POST["email"]
                ."', '".$hash."', 'host')";
            
            echo $sql.BR;
            
            $host="localhost";
            $port=3306;
            $socket="";
            $user="root";
            $password="root"; // nutne spravne heslo
            $dbname="TeacherDigitalAgency";

            $con = new mysqli($host, $user, $password, $dbname, $port, $socket)
                or die ('Could not connect to the database server' . mysqli_connect_error());

            // vykonani insertu
            if(mysqli_query($con, $sql)) {
                echo "success".BR;
                $_SESSION["logged_in"] = true;
                $_SESSION["role"] = "host";
                header("Location: index.php");
            } else {
                echo "error:".mysqli_error($con).BR;
            }

            $con->close();

            exit();
        }
        ?>

        <form method="POST"><!-- action="neco.php", method="GET" -->
            <input type="hidden" name="action" value="submited"/>
            <!-- id -- nutne mit sekvenci -->

            <label for="email">Email:</label>
            <input id="email" type="email" name="email" required />
            <br/>

            <label for="password">Password:</label>
            <input id="password" type="password" name="password" required />
            <br/>

            <input class="button" type="submit" value="Registrate">
        </form>
    </article>
    
    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>    
</body>
</html>