<?php

header("Content-Type: application/json");

$conn = new mysqli("localhost","root","","voting_system");

$result = $conn->query("
SELECT 
c.name,
COUNT(v.id) as votes

FROM candidates c
LEFT JOIN votes v ON v.candidate_id = c.id

GROUP BY c.id
");

$data=[];

while($row=$result->fetch_assoc()){
$data[]=$row;
}

echo json_encode($data);

?>