<?php

$conn = new mysqli("localhost","root","","voting_system");

$conn->query("UPDATE elections SET status='paused'");

echo json_encode(["message"=>"Election paused"]);

?>