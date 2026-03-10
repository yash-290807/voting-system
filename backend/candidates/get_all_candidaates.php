<?php

header("Content-Type: application/json");

$conn = new mysqli("localhost","root","","voting_system");

$result = $conn->query("
SELECT id,name,party 
FROM candidates
");

$data=[];

while($row=$result->fetch_assoc()){
$data[]=$row;
}

echo json_encode($data);

?>