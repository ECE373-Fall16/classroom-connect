<?php
DEFINE('DB_USERNAME', 'root');
  DEFINE('DB_PASSWORD', 'root');
  DEFINE('DB_HOST', 'localhost');
  DEFINE('DB_DATABASE', 'CLASSROOMCONNECT');

  $mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

  if (mysqli_connect_error()) {
    die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
  }
   $stmt = $mysqli->prepare("SELECT COUNT(*) FROM CLASSES WHERE poll_id = (?)");
          $stmt->bind_param("s", $_GET['classNumber']);
          $stmt->execute();
          $stmt->bind_result($inTable);
          while ($stmt->fetch()) {
               //echo $resultONE; 
           }
          
  echo "Query Finished and provided value: " . $inTable . "<";
?>