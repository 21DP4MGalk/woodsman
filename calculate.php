
<?php
include "config.php";

$token = $_COOKIE["token"];

$stmnt = $connection->prepare("SELECT id FROM users WHERE token = ?");
$stmnt->bind_params("s", $token);
$stmnt->execute();
$result = $stmnt->get_result();

if(!$result->num_rows){
    echo "Invalid token! Try logging out and back in";
    http_response_code(400);
    exit();
}

$result->fetch_object();

$stmnt = $connection->prepare("SELECT id FROM licenses where userID = ?");
$stmnt->bind_params("i", $result->id);
$stmnt->execute();
$result = $stmnt->get_result();

if(!$result->num_rows){
    echo "Buy a license first!";
    http_response_code(400);
    exit();
}

$L = $_POST["L"];
$B = $_POST["B"];
$H = $_POST["H"];
$f = $_POST["f"];

$W = ($B*$H*$H)/6;
$q = 8*$W*$f / ($L*$L);

$output = new stdClass();
$output->W = $W;
$outpur->q = $q;

$stmnt = $connection->prepare("INSERT INTO calculations VALUES(?, ?, ?, ?, ?, ?)");
$stmnt->bind_params("iiiiii", $W, $q, $L, $B, $H, $f);
$stmnt->execute();

if($connection->error){
    echo "Internal server error";
    http_response_code(500);
    exit();
}

echo json_encode($output);
?>