<?php

include("../config/database.php");

$data = json_decode(file_get_contents("php://input"), true);

$user_id = $data['user_id'];
$candidate_id = $data['candidate_id'];

/* find election of the candidate */

$sql = "SELECT election_id FROM candidates WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$candidate_id);
$stmt->execute();
$result = $stmt->get_result();

$row = $result->fetch_assoc();
$election_id = $row['election_id'];

/* check if user already voted in this election */

$sql = "SELECT * FROM votes WHERE user_id=? AND election_id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii",$user_id,$election_id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){

echo json_encode([
"message"=>"You already voted in this election"
]);

exit();

}

/* insert vote */

$sql = "INSERT INTO votes(user_id,election_id,candidate_id) VALUES (?,?,?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iii",$user_id,$election_id,$candidate_id);
$stmt->execute();

echo json_encode([
"message"=>"Vote submitted successfully"
]);

?>