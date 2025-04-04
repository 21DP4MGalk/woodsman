
<?php
include "config.php";

$token = $_COOKIE["token"];

$stmnt = $connection->prepare("SELECT id FROM users WHERE token = ?");
$stmnt->bind_params("s", $token);
$stmnt->execute();
$result = $stmnt->get_result();

if($result->num_rows){
    echo "Invalid token! Might need to log out and back in!");
    http_response_code(400);
    exit();
}

$stmnt = $connection->prepare("INSERT INTO licenses(userID) VALUES("?");
$stmnt->bind_params("i", $userID");
$stmnt->execute();

if($connection->error){
    echo "Internal server error";
    http_respone_code(500);
    exit();
}
echo "Success!";
?>