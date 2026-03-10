<?php

$conn = new mysqli("localhost","root","","voting_system");

$data = json_decode(file_get_contents("php://input"), true);

$id = $data["id"];

$stmt = $conn->prepare("DELETE FROM candidates WHERE id=?");
$stmt->bind_param("i",$id);
$stmt->execute();

echo json_encode(["message"=>"Candidate deleted"]);

?>