<?php
/*
	not currently being used yet
	CONNECTION SCRIPT
	ENABLES USERS TO CONNECT TO MySQL DB
	scipt should be called as a requirement for other php scripts
	within the Web Service, and stored outside of the html folder as a layer of security.

	ON SERVER SIDE: 
	- Must grant default 'user' access to connection w/specified password (sensitive data) the ability to INSERT, DELETE, SELECT, UPDATE.
*/

DEFINE ('DB_USER', 'user');
DEFINE ('DB_PASSWORD', 'ece373');		
DEFINE ('DB_HOST', '104.154.132.135'); 	// development host
DEFINE ('DB_NAME', 'CLASSROOMCONNECT'); // db in sql
 
// $dbc will contain a resource link to the database
// @ keeps the error from showing in the browser
 
$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die('Could not connect to MySQL: ' .
mysqli_connect_error());
?>