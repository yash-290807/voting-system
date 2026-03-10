<?php

include("../config/database.php");

$user_id = $_GET["user_id"];
$election_id = 1;

$stmt = $conn->prepare("SELECT * FROM votes WHERE user_id=? AND election_id=?");
$stmt->bind_param("ii",$user_id,$election_id);
$stmt->execute();

$result = $stmt->get_result();

if($result->num_rows > 0){

echo json_encode([
"voted"=>true
]);

}else{

echo json_encode([
"voted"=>false
]);

}

?>