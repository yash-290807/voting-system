<?php

header("Content-Type: application/json");

$conn = new mysqli("localhost","root","","voting_system");

if($conn->connect_error){
    echo json_encode(["message"=>"Database connection failed"]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);

$email = $data["email"];
$password = $data["password"];

$stmt = $conn->prepare("SELECT * FROM election_officers WHERE email=?");
$stmt->bind_param("s",$email);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){
    echo json_encode(["message"=>"Officer not found"]);
    exit;
}

$user = $result->fetch_assoc();

/* Since your password is plain text */

if($password === $user["password"]){

    echo json_encode([
        "message"=>"Login successful",
        "user_id"=>$user["id"]
    ]);

}else{

    echo json_encode(["message"=>"Wrong password"]);

}

$conn->close();

?>