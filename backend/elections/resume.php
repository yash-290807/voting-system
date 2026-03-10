<?php

$conn = new mysqli("localhost","root","","voting_system");

$conn->query("UPDATE elections SET status='active'");

echo json_encode(["message"=>"Election resumed"]);

?>