<?php
    session_start();

    $_SESSION["logged_in"] = false;
    unset($_SESSION["role"]);
    header("Location: index.php");
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
                <li><a href="index.php">Domovská stránka</a></li>
                <li class='logout-button'><a href='logout.php'>Odhlásit se</a></li>
            </ul>
        </nav>
    </header>
    
    <article>
        <header>
            <h1>Odhlásit se</h1>
        </header>
        <section>
            <p>
                Úspěšně jste se odhlásili. Vraťte se na <a href="index.php">Domovskou stránku</a>.
            </p>
        </section>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>