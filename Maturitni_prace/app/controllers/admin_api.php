<?php
require "../../src/database.php";

$con = ConnectDB() or die('Could not connect to the database server' . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["action"])) {
    header('Content-Type: application/json');
    $action = $_POST["action"];
    $id = $_POST["id"];

    switch ($action) {
        case 'deleteLec':
            DeleteLec($con, $id);
            http_response_code(200);
            echo json_encode(['success' => true]);
            break;

        case 'deleteTag':
            DeleteTag($con, $id);
            http_response_code(200);
            echo json_encode(['success' => true]);
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
    exit;
}