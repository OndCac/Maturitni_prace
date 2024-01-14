<?php
    session_start();

    $_SESSION["logged_in"] = false;
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
                <li><a href="index.php">Homepage</a></li>
                <li class='logout-button'><a href='logout.php'>Log out</a></li>
            </ul>
        </nav>
    </header>
    
    <article>
        <header>
            <h1>Log out</h1>
        </header>
        <section>
            <p>
                You have successfully logged out. Return to the <a href="index.php">Homepage</a>.
            </p>
        </section>
    </article>

    <footer>

    </footer>
</body>
</html>