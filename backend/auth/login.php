<?php

header("Content-Type: application/json");

/* DATABASE CONNECTION */

$conn = new mysqli("localhost","root","","voting_system");

if ($conn->connect_error) {
    echo json_encode(["message"=>"Database connection failed"]);
    exit;
}

/* READ JSON INPUT */

$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode(["message"=>"No data received"]);
    exit;
}

/* GET VALUES */

$email = $data["email"] ?? "";
$password = $data["password"] ?? "";

if(!$email || !$password){
    echo json_encode(["message"=>"Missing email or password"]);
    exit;
}

/* CHECK USER */

$stmt = $conn->prepare("SELECT * FROM users WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    echo json_encode(["message"=>"User not found"]);
    exit;
}

$user = $result->fetch_assoc();

/* VERIFY PASSWORD */

if(password_verify($password,$user["password"])){

    echo json_encode([
        "message"=>"Login successful",
        "user_id"=>$user["id"]
    ]);

}else{

    echo json_encode(["message"=>"Wrong password"]);

}

$conn->close();

?>