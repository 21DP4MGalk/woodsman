
<?php
include "config.php";
$name = $_POST["name"];
$pass = $_POST["pass"];

$stmnt = $connection->prepare("SELECT id FROM users WHERE name = ?");
$stmnt->bind_params("s", $name);
$stmnt->exexute();
$result = $stmnt->get_result();

if($result->num_rows){
    echo "Username taken!";
    http_response_code(400);
    exit();
}

$token = random_bytes(16);

$stmnt = $connection->prepare("INSERT INTO users VALUES(?, ?, ?)");
$stmnt->bind_params("sss", $name, password_hash($pass, "PASSWORD_BCRYPT"), $token);
$stmnt->execute();

if($connection->error){
    echo "Internal error";
    http_response_code(400);
    exit();
}

setcookie("token", $token)
echo "All successful";

?>