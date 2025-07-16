<?php
require "../../src/database.php";
const UPLOAD_DIR = "../../database/images/";
$con = ConnectDB();


if ($_SERVER["REQUEST_METHOD"] == "POST")
{
    header('Content-Type: application/json');

    // delete the pic
    if (isset($_POST["name"]))
    {
        $pic = $_POST["name"];
        unlink(UPLOAD_DIR . $pic);
        DeleteLecPic($con, $pic);
        http_response_code(200);
        echo json_encode(['success' => true]);
    }
    else
    {
        http_response_code(400);
        echo json_encode(['error' => 'Invalid action']);
    }

    exit;
}
