<?php
/*
runs querry to obtain all markers from the querry
*/

//NEW QUERY:
/*
  SELECT marker_id
  FROM MARKERS
  WHERE MARKERS.class_id == (?)
*/
/*
  
*/
  DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'CLASSROOMCONNECT');

  $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
  }
  
  $stmt = $mysqli->prepare("SELECT COUNT(*) FROM MARKER WHERE marker_id = 4");
    $stmt->execute();
    /* bind result variables */
    $stmt->bind_result($resultFOUR);
    /* fetch values */
     while ($stmt->fetch()) {
         echo $resultFOUR; 
     }
////////////////////
  $stmt = $mysqli->prepare("SELECT COUNT(*) FROM MARKER WHERE marker_id = 3");
    $stmt->execute();
    /* bind result variables */
    $stmt->bind_result($resultTHREE);
    /* fetch values */
     while ($stmt->fetch()) {
         echo $resultTHREE; 
     }
////////////////////
  $stmt = $mysqli->prepare("SELECT COUNT(*) FROM MARKER WHERE marker_id = 2");
    $stmt->execute();
    /* bind result variables */
    $stmt->bind_result($resultTWO);
    /* fetch values */
     while ($stmt->fetch()) {
         echo $resultTWO; 
     }
////////////////////
     $stmt = $mysqli->prepare("SELECT COUNT(*) FROM MARKER WHERE marker_id = 1");
    $stmt->execute();
    /* bind result variables */
    $stmt->bind_result($resultONE);
    /* fetch values */
     while ($stmt->fetch()) {
         echo $resultONE; 
     }

    $mysqli->close();
?>
