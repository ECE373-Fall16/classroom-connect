<?php
header("Location: http://localhost:8888/classroom-connect/front_end/student.html"); //redirects page back to index.html as blunt refresh
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
	
	$stmt = $mysqli->prepare("INSERT INTO MARKER(marker_id) VALUES (?)");
  if(isset($_POST['one'])){
    $value = 1;
  }elseif(isset($_POST['two'])){
    $value = 2;
  }elseif(isset($_POST['three'])){
    $value = 3;
  }elseif(isset($_POST['four'])){
    $value = 4;
  }else{
    $value = 10; //arbitrary value
  }
	
  	$stmt->bind_param("i", $value);
  	$stmt->execute();
  
  	$mysqli->close();
?>