<?php

header("Content-Type: application/json");

$conn = new mysqli("localhost","root","","voting_system");

$election_id = $_GET["election_id"];
$user_id = $_GET["user_id"];

$sql = "
SELECT 
c.id,
c.name,
c.party,

CASE 
WHEN v.id IS NULL THEN 0
ELSE 1
END AS voted

FROM candidates c

LEFT JOIN votes v
ON v.candidate_id = c.id
AND v.user_id = '$user_id'
AND v.election_id = '$election_id'

WHERE c.election_id = '$election_id'
";

$result = $conn->query($sql);

$data = [];

while($row = $result->fetch_assoc()){
$data[] = $row;
}

echo json_encode($data);

?>