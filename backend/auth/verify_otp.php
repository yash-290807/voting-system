<?php

header("Content-Type: application/json");
include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$phone = $data['phone'] ?? '';
$otp = $data['otp'] ?? '';

if(!$phone || !$otp){
echo json_encode(["message"=>"Missing data"]);
exit;
}

$stmt = $conn->prepare("SELECT * FROM otp_verifications WHERE phone=? AND otp=? ORDER BY id DESC LIMIT 1");
$stmt->bind_param("ss",$phone,$otp);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows == 0){

echo json_encode(["message"=>"Invalid OTP"]);
exit;

}

$row = $result->fetch_assoc();

if(strtotime($row['expiry']) < time()){

echo json_encode(["message"=>"OTP expired"]);
exit;

}

echo json_encode(["message"=>"OTP verified"]);

?>