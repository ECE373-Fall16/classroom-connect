<?php

include 'dbh.php';

$email = $_POST['email'];
$class = $_POST['class'];

$sql = "INSERT INTO user (email, class)
VALUES ('$email', '$class')";
$result = mysqli_query($conn,$sql);

header("Location: index.php");

?php> 