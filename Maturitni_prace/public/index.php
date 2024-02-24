<?php
    // def. odradkovani v HTML
    define("BR", "<br/>\n");

    session_start();
    if (empty($_SESSION["logged_in"])) {
        $_SESSION["logged_in"] = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css" type="text/css"/>
    <title>TdA</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li class="aktivni"><a href="index.php">Homepage</a></li>
                <?php 
                    if ($_SESSION["logged_in"]) {
                        if ($_SESSION["role"] == "admin") {
                            echo "<li><a href='admin.php'>Administration</a></li>";
                        }
                        
                        echo "<li><a href='lec_list.php'>Lecturers</a></li>"
                        . "<li class='logout-button'><a href='logout.php'>Log out</a></li>";
                    } else {
                        echo '<li><a href="registration.php">Registration</a></li>' 
                        . '<li><a href="login.php">Login</a></li>';
                    }
                ?>
            </ul>
        </nav>
    </header>
    
    <article>
        <header>
            <h1>Homepage</h1>
        </header>
        <section>
            <h2>
                O nás
            </h2>
            <p>
                Teacher digital Agency je mladá společnost zaměřená na vyhledávání špičkových odborníků z řad učitelů, lektorů a tutorů. 
                Sestavujeme exkluzivní databázi těchto specialistů, abychom mohli efektivně propojovat klienty s ideálními odborníky dle jejich přání a specifických potřeb. 
                Vaše vzdělávání je u nás v dobrých rukou.
            </p>
        </section>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>