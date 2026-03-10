 <?php

header("Content-Type: application/json");

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

if(!isset($data['phone']) || empty($data['phone'])){
    echo json_encode([
        "status"=>"error",
        "message"=>"Phone number required"
    ]);
    exit;
}

$phone = $data['phone'];

/* Generate OTP */
$otp = rand(100000,999999);

/* Expiry time (5 minutes) */
$expiry = date("Y-m-d H:i:s", strtotime("+5 minutes"));

/* Remove old OTP for this phone */
$delete = $conn->prepare("DELETE FROM otp_verifications WHERE phone=?");
$delete->bind_param("s",$phone);
$delete->execute();

/* Insert new OTP */
$stmt = $conn->prepare("INSERT INTO otp_verifications(phone,otp,expiry) VALUES(?,?,?)");

$stmt->bind_param("sss",$phone,$otp,$expiry);

if($stmt->execute()){

    echo json_encode([
        "status"=>"success",
        "message"=>"OTP sent successfully",
        "otp"=>$otp   // remove in production
    ]);

}else{

    echo json_encode([
        "status"=>"error",
        "message"=>"Failed to send OTP"
    ]);

}

?>