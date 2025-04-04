
<?php
include "config.php";

$name = $_POST["name"];
$pass = $_POST["pass"];

$stmnt = $connection->prepare("SELECT id, pass FROM users WHERE name = ?");
$stmnt->bind_params("s", $name);
$stmnt->execute();
$result = $stmnt->get_result();

if(!$result->num_rows){
    echo "No such user found, check how you typed the username!";
    http_response_code(400);
    exit();
}

$result = $result->fetch_object();

if(!password_verify($pass, $result->pass)){
    echo "Invalid password!";
    http_response_code(400);
    exit();
}

$token = random_bytes(16);

$stmnt = $connection->prepare("UPDATE TABLE users SET token = ? WHERE id = ?");
$stmnt->bind_params("si", $token, $result->id);
$stmnt->execute();

if($connection->error){
    echo "Internal server error";
    http_response_code(500);
    exit();
}

setcookie("token", $token);
echo "Success!";

?>