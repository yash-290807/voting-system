<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"),true);

$name = $data['name'];
$party = $data['party'];

$sql = "INSERT INTO candidates(name,party)
VALUES('$name','$party')";

if(mysqli_query($conn,$sql)){

echo json_encode([
"message"=>"Candidate added"
]);

}else{

echo json_encode([
"message"=>"Error adding candidate"
]);

}

?>