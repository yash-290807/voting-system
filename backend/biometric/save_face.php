<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data["user_id"];
$image = $data["image"];

$image = str_replace("data:image/png;base64,", "", $image);
$image = base64_decode($image);

$filename = "../../uploads/face_" . $user_id . ".png";

file_put_contents($filename, $image);

$sql = "UPDATE users SET photo='$filename' WHERE id='$user_id'";

mysqli_query($conn,$sql);

echo json_encode([
"message"=>"Face saved"
]);

?>