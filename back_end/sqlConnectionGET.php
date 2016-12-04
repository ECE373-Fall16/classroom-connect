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
      }elseif ($_GET['CHECK'] == 'getUnderstandingData') {
        //query for values where the time is roughtly 1 minute
        $now = 'NOW()'; 
        $duration = 'NOW()-500'; 
        $stmt = $mysqli->prepare("SELECT SUM(marker_id) FROM MARKERS WHERE (class_id = 373) ");
        $stmt->execute();
        //SELECT SUM(marker_id) FROM MARKERS WHERE (class_id = 373) AND (time_created <= NOW()) AND (time_created >= (NOW()-3600))
        //$stmt->bind_param("iii", $_GET['CLASSNUMBER'], $now, $duration);
        $stmt->bind_result($inTable);
          while ($stmt->fetch()) {
               //echo $resultONE; 
           }
          $jsonArray['one']= $inTable;
      }elseif($_GET['CHECK'] == 'getUserData'){
        $jsonArray['email']=$_SESSION['STUDENTEMAIL'];
        $jsonArray['class']=$_SESSION['STUDENTCLASSNUMBER'];
      }
  
	$mysqli->close();
   echo json_encode($jsonArray);
?>