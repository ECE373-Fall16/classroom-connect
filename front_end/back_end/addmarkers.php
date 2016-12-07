<?php
header("Location: ../front_end/student.html"); //redirects page back to index.html as blunt refresh
session_start();
/*
add markers to db
*/
  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'CLASSROOMCONNECT');

  $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
  }

	$stmt = $mysqli->prepare("INSERT INTO POLL(marker_id,email,class_id) VALUES (?,?,?) ON DUPLICATE KEY UPDATE marker_id=?,class_id=?");
  $stmt->bind_param("isiii",$_POST['MARKERVAL'],$_SESSION["STUDENTEMAIL"],$_SESSION["STUDENTCLASSNUMBER"],$_POST['MARKERVAL'],$_SESSION["STUDENTCLASSNUMBER"]);
  $stmt->execute();
  

  	$mysqli->close();
?>
