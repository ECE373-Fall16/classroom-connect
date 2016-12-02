<?php

header('Content-Type: application/json'); //required to send JSON
session_start();
  /*
    Execute querry based on specific POST key
  */

  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'CLASSROOMCONNECT');

  $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
  }

  	if($_GET['CHECK'] == 'check') {
         //check if exists first
      
          $stmt = $mysqli->prepare("SELECT COUNT(*) FROM CLASSES WHERE poll_id = (?)");
          $stmt->bind_param("s", $_GET['classNumber']);
          $stmt->execute();
          $stmt->bind_result($inTable);
          while ($stmt->fetch()) {
               //echo $resultONE; 
           }
          $jsonArray['one']= $inTable;
      }
  
	$mysqli->close();
   echo json_encode($jsonArray);
?>