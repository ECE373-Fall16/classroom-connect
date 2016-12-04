<?php
session_start();
//header('Content-Type: application/json'); //required to send JSON
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

  	//if($_SERVER['REQUEST_METHOD'] === 'POST'){
  		//Post Request Recieved

  		if($_POST['BUTTONPRESSED'] == 'btnCreateUser'){
  			/*
				CREATE USER
			*/
			$stmt = $mysqli->prepare("INSERT INTO USERS(first_name,last_name,email,user_password) VALUES (?,?,?,?)");
			$stmt->bind_param("ssss", $_POST['fname'], $_POST['lname'], $_POST['email'], $_POST['password']);
			$stmt->execute();

  		}elseif ($_POST['BUTTONPRESSED'] == 'btnCreateClass') {
  			/*
				CREATE CLASS
  			*/
      
         $stmt = $mysqli->prepare("INSERT INTO CLASSES(class_name, poll_id) VALUES (?,?)");
         $stmt->bind_param("si", $_POST['className'], $_POST['classNumber']);
         $stmt->execute();
         $_SESSION["CURRENTCLASS"] = $_POST['classNumber']; //make classnumber in the session
     
  		}elseif ($_POST['CHECK'] == 'check') {
         //check if exists first
      
          $stmt = $mysqli->prepare("SELECT COUNT(*) FROM CLASSES WHERE class_name = '(?)'");
          $stmt->bind_param("s", $_POST['className']);
          $stmt->execute();
          $stmt->bind_result($inTable);
          $jsonArray['checkResult']= $inTable;
          echo json_encode($jsonArray);
          
      	}elseif ($_POST['BUTTONPRESSED'] == 'deleteAll') {
  			/*
				CREATE CLASS
  			*/
			$stmt = $mysqli->prepare("DELETE FROM USERS");
			$stmt->execute();

  		}elseif ($_POST['BUTTONPRESSED'] == 'addOrUpdateUser') {
  			
  			//If email dosn't exist in directory, then create user only based on email and class id.
  			//if email does exist in directory, then update user's class id.
			$stmt = $mysqli->prepare("INSERT INTO USERS(email, poll_id) VALUES(?,?) ON DUPLICATE KEY UPDATE poll_id=?");
			$stmt->bind_param("sii",$_POST['email'],$_POST['classNumber'],$_POST['classNumber']);
			$stmt->execute();
			$_SESSION["STUDENTCLASSNUMBER"] = $_POST['classNumber']; //make correlate student to poll
			$_SESSION["STUDENTEMAIL"] = $_POST['email']; //make correlate student to poll

  		}elseif ($_POST['BUTTONPRESSED'] =='resetPoll'){
  			//delete markers from specified poll
  			//$stmt = $mysqli->prepare("DELETE FROM POLL WHERE class_id=?");
  			$stmt = $mysqli->prepare("UPDATE POLL SET marker_id=0 WHERE class_id=?");
  			$stmt->bind_param("i",$_POST['CLASSNUMBER']);
			$stmt->execute();

  		}elseif ($_POST['BUTTONPRESSED'] =='sendUnderstandingData'){ //send student understanding value to db
			$stmt = $mysqli->prepare("INSERT INTO MARKERS(marker_id,email,class_id) VALUES(?,?,?) ON DUPLICATE KEY UPDATE marker_id=?, class_id=?");
			$stmt->bind_param("isiii",$_POST['VALUE'],$_SESSION["STUDENTEMAIL"],$_SESSION["STUDENTCLASSNUMBER"],$_POST['VALUE'],$_SESSION["STUDENTCLASSNUMBER"]);
			$stmt->execute();
  		}
  	//}
	$mysqli->close();
?>