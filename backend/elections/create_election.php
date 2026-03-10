<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$title = $data['title'];
$start = $data['start'];
$end = $data['end'];

$sql = "INSERT INTO elections(title,start_time,end_time)
VALUES('$title','$start','$end')";

if(mysqli_query($conn,$sql)){
echo json_encode(["message"=>"Election created successfully"]);
}else{
echo json_encode(["message"=>"Database error"]);
}

?>