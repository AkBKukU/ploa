<?php

	$title = $_REQUEST['title'];
	$text = $_REQUEST['text'];
	$tags = $_REQUEST['tags'];
	
	$today = getdate();
	$date=($today[mon]. "/".$today[mday]."/".$today[year].date(' g:i a'));

//Load Configuration Fles
	include("./config.php");

	
	$mysqli = new mysqli($sqlhost, $sqluser, $sqlpass);
	
	if ($mysqli->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}		
//Check if blog database exist	
	$mysqli->select_db($sqldata);
	
//Write post to database	
	$query = 'INSERT INTO '.$blog_tbname.' (title,text,date,tags) VALUES ("'.$title.'","'.$text.'","'.$date.'","'.$tags.'")';
	$mysqli->query($query);
	
	mysqli_close($mysqli);
?>
