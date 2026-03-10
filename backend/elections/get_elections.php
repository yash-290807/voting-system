<?php

include("../config/database.php");

$sql = "SELECT * FROM elections";
$result = mysqli_query($conn,$sql);

$elections = [];

while($row = mysqli_fetch_assoc($result)){
    $elections[] = $row;
}

echo json_encode($elections);

?>