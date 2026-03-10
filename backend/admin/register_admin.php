<?php

include("../config/database.php");

$email = "admin@gmail.com";
$password = password_hash("admin123", PASSWORD_DEFAULT);

$sql = "INSERT INTO admins (email,password) VALUES (?,?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss",$email,$password);

if($stmt->execute()){
    echo "Admin created successfully";
}else{
    echo "Error creating admin";
}

?>