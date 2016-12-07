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
        $timeBound = time()-20; 

        //$duration = 'NOW()-5000'; 
        $now = date('Y-m-d H:i:s', time());
        $duration = date('Y-m-d H:i:s', $timeBound);
        $stmt = $mysqli->prepare("SELECT SUM(marker_id) FROM MARKERS WHERE (class_id = ?) AND (time_created > DATE_SUB(NOW(), INTERVAL 1 MINUTE))");
        $stmt->bind_param('i',$_GET['CLASSNUMBER']);
        $stmt->execute();
        $stmt->bind_result($inTable);
          while ($stmt->fetch()) {
               //echo $resultONE; 
           }
           if($inTable == null){
           	$inTable = -1;
           }
          $jsonArray['one']= $inTable;
      }elseif($_GET['CHECK'] == 'getUserData'){
        $jsonArray['email']=$_SESSION['STUDENTEMAIL'];
        $jsonArray['class']=$_SESSION['STUDENTCLASSNUMBER'];
      }
  
	$mysqli->close();
   echo json_encode($jsonArray);
?>