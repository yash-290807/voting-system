<?php

include("../config/database.php");

$election_id = $_GET['election_id'];

$sql = "
SELECT 
c.id,
c.name,
c.party,
COUNT(v.id) as votes

FROM candidates c

LEFT JOIN votes v 
ON c.id = v.candidate_id

WHERE c.election_id = ?

GROUP BY c.id
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$election_id);
$stmt->execute();

$result = $stmt->get_result();

$data = [];

while($row = $result->fetch_assoc()){
$data[] = $row;
}

echo json_encode($data);

?>