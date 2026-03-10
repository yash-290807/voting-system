<?php

include("../config/database.php");

// total users
$userQuery = "SELECT COUNT(*) as total_users FROM users WHERE role='user'";
$userResult = mysqli_query($conn,$userQuery);
$userData = mysqli_fetch_assoc($userResult);

$total_users = $userData["total_users"];

// total votes
$voteQuery = "SELECT COUNT(*) as total_votes FROM votes";
$voteResult = mysqli_query($conn,$voteQuery);
$voteData = mysqli_fetch_assoc($voteResult);

$total_votes = $voteData["total_votes"];

// turnout %
$turnout = 0;

if($total_users > 0){
$turnout = ($total_votes / $total_users) * 100;
}

echo json_encode([
"total_users"=>$total_users,
"total_votes"=>$total_votes,
"turnout"=>round($turnout,2)
]);

?>