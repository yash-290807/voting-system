<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$status = $data["status"];

$sql = "UPDATE elections SET status='$status' WHERE id=1";

mysqli_query($conn,$sql);

echo json_encode([
"message"=>"Election status updated"
]);

?>