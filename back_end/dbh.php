<?php

$conn = mysqli_connect("localhost", "root", "root", "loginserver");
//assumes database named loginserver, on localhost, un and pw = root


if(!$conn) {
	die("Connection failed: ".mysqli_connect_error());
}