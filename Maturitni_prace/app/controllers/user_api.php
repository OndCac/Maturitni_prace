<?php
require "../../src/database.php";

$con = ConnectDB() or die('Could not connect to the database server' . mysqli_connect_error());

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["action"]))
{
    header('Content-Type: application/json');
    $tagId = $_POST['id'];
    $action = $_POST['action'];
    $uuid = $_POST['uuid'];
    switch ($action) {
        case 'linkTag':
            if (!LinkTag($con, $tagId, $uuid))
            {
                http_response_code(500);
                echo json_encode(['error' => mysqli_error($con)]);
            } else
            {
                http_response_code(200);
                echo json_encode(['success' => true]);
            }
            break;

        case 'unlinkTag':
            if (!UnlinkTag($con, $tagId, $uuid))
            {
                http_response_code(500);
                echo json_encode(['error' => mysqli_error($con)]);
            } else
            {
                http_response_code(200);
                echo json_encode(['success' => true]);
            }
            break;

        default:
            http_response_code(400);
            echo json_encode(['error' => 'Invalid action']);
            break;
    }
    exit;
}