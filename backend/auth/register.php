<?php

header("Content-Type: application/json");

/* DATABASE CONNECTION */

$conn = new mysqli("localhost","root","","voting_system");

if ($conn->connect_error) {
    echo json_encode([
        "status"=>"error",
        "message"=>"Database connection failed"
    ]);
    exit;
}


/* GET JSON DATA */

$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode([
        "status"=>"error",
        "message"=>"Invalid JSON request"
    ]);
    exit;
}


/* INPUT VALUES */

$email = $data["email"] ?? "";
$password = $data["password"] ?? "";
$phone = $data["phone"] ?? "";
$aadhar = $data["aadhar"] ?? "";
$voter = $data["voter_id"] ?? "";


/* VALIDATION */

if(!$email || !$password || !$phone || !$aadhar || !$voter){
    echo json_encode([
        "status"=>"error",
        "message"=>"Missing fields"
    ]);
    exit;
}


/* PASSWORD HASH */

$hashed = password_hash($password, PASSWORD_DEFAULT);


/* CHECK DUPLICATES */

$check = $conn->prepare("SELECT id FROM users WHERE email=? OR aadhar=? OR voter_id=?");
$check->bind_param("sss",$email,$aadhar,$voter);
$check->execute();
$result = $check->get_result();

if($result->num_rows > 0){
    echo json_encode([
        "status"=>"error",
        "message"=>"User already registered"
    ]);
    exit;
}


/* INSERT USER */

$stmt = $conn->prepare(
    "INSERT INTO users(email,password,phone,aadhar,voter_id) 
     VALUES(?,?,?,?,?)"
);

$stmt->bind_param("sssss",$email,$hashed,$phone,$aadhar,$voter);

if($stmt->execute()){

    echo json_encode([
        "status"=>"success",
        "message"=>"Registration successful"
    ]);

}else{

    echo json_encode([
        "status"=>"error",
        "message"=>"Registration failed"
    ]);

}


$conn->close();

?>