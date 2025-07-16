<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();

    require "../src/constants.php";
    require "../src/database.php";

    $logged_in = empty($_SESSION["logged_in"]) ? false : $_SESSION["logged_in"];
    $role = empty($_SESSION["role"]) ? "guest" : $_SESSION["role"];
    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['action']))
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/styles.css" type="text/css"/>
    <link rel="shortcut icon" href="assets/icons/favicon.ico" type="image/x-icon">
    <script src="assets/vendor/jquery-3.7.1.min.js"></script>
    <script src="assets/js/ajax.js"></script>
    <title>TDA</title>
</head>

<body>
    <header>
        <nav>
            <ul>
                <li>
                    <a href="index.php?page=home_page">Domovská stránka</a>
                </li>
                <?php if ($logged_in):
                    if ($role == "admin"): ?>
                        <li>
                            <a href='index.php?page=admin'>Administrace</a>
                        </li>
                    <?php endif; ?>

                    <li>
                        <a href='index.php?page=lec_list'>Lektoři</a>
                    </li>
                    <li>
                        <a class='logout-button' href='index.php?page=logout'>Odhlásit se</a>
                    </li>
                <?php else: ?>
                    <li>
                        <a href="index.php?page=registration">Registrace</a>
                    </li>
                    <li>
                        <a href="index.php?page=login">Přihlásit se</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    
    <article>
        <?php
            $page = $_GET["page"] ?? 'home_page';
            if (!preg_match('/^[a-z0-9_]+$/', $page))
                $page = 'home_page';

            $public_pages = ['home_page', 'login', 'registration'];
            $user_pages   = ['home_page', 'lec_list', 'lecturer', 'logout'];
            $admin_pages  = ['admin', 'edit_lec', 'create_tag', 'add_lec',
                             'edit_pic', 'edit_tag'];
            // Check access permissions
            if (in_array($page, $public_pages)) {
                // everyone can access
            } elseif (in_array($page, $user_pages)) {
                if (!$logged_in) {
                    $page = 'home_page';
                }
            } elseif (in_array($page, $admin_pages)) {
                if (!$logged_in || $role != 'admin') {
                    $page = 'home_page';
                }
            } else {
                // Page not recognized at all
                $page = 'home_page';
            }

            // Safely include the page
            $path = "../app/views/$page.php";
            if (file_exists($path)) {
                include $path;
            } else {
                echo 'Podstránka nenalezena';
            }
        ?>
    </article>

    <footer>
        Vytvořil Ondřej Cacek 2024
    </footer>
</body>
</html>