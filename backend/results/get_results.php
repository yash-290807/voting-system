<?php

header("Content-Type: application/json");

$conn = new mysqli("localhost","root","","voting_system");

$result = $conn->query("
SELECT 
e.id as election_id,
e.title,
c.id as candidate_id,
c.name,
c.party,
COUNT(v.id) as votes

FROM elections e
LEFT JOIN candidates c ON c.election_id = e.id
LEFT JOIN votes v ON v.candidate_id = c.id

GROUP BY c.id
ORDER BY e.id
");

$data = [];

while($row = $result->fetch_assoc()){

$eid = $row["election_id"];

if(!isset($data[$eid])){
$data[$eid] = [
"title"=>$row["title"],
"candidates"=>[]
];
}

$data[$eid]["candidates"][] = [
"id"=>$row["candidate_id"],
"name"=>$row["name"],
"party"=>$row["party"],
"votes"=>$row["votes"]
];

}

echo json_encode(array_values($data));

?>