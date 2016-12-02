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

	$stmt = $mysqli->prepare("INSERT INTO MARKERS(marker_id,class_id) VALUES (?,?)");
  if($_POST['one']=='on'){
    $value = 1;
    $stmt->bind_param("ii", $value, $_SESSION["STUDENTCLASSNUMBER"]);
    $stmt->execute();
  }elseif($_POST['two']=='on'){
    $value = 2;
    $stmt->bind_param("ii", $value, $_SESSION["STUDENTCLASSNUMBER"]);
    $stmt->execute();
  }elseif($_POST['three']=='on'){
    $value = 3;
    $stmt->bind_param("ii", $value, $_SESSION["STUDENTCLASSNUMBER"]);
    $stmt->execute();
  }elseif($_POST['four']=='on'){
    $value = 4;
    $stmt->bind_param("ii", $value, $_SESSION["STUDENTCLASSNUMBER"]);
    $stmt->execute();
  }
/*  elseif($_POST['LBTN1']=='on'){
    $value = -10;
    $stmt->bind_param("i", $value);
    $stmt->execute();
  }*/

  	$mysqli->close();
?>
