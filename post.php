<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title>Ploa Blog Test</title>
		<meta charset=utf-8>
		<meta name="description" content="Ploa blog demonstration">
		<link rel=StyleSheet href="styles/global.css" type="text/css">
		<link rel=StyleSheet href="styles/manager.css" type="text/css">
		<link rel=StyleSheet href="styles/writer.css" type="text/css">
		<meta http-equiv="REFRESH" content="0;url=manager.php?area=posts">
	</head>
 	<body>
     	<div id="sitewrapper">
     		<h1>ploa - Post!</h1>
     		    
     		<div id="content">
<?php

	$title = $_REQUEST['title'];
	$text = $_REQUEST['text'];
	$tags = $_REQUEST['tags'];
	$status = $_REQUEST['status'];
	$action = $_REQUEST['action'];
	$postid = $_REQUEST['postid'];
	
	echo "Saving Post";
	
	$today = getdate();
	$date=date('Y-m-d H:i:s');

//Load Configuration Fles
	include("./config.php");

	
	$mysqli = new mysqli($sqlhost, $sqluser, $sqlpass);
	
	if ($mysqli->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}		
//Check if blog database exist	
	$mysqli->select_db($sqldata);
	
//Write post to database
    if($action =="update"){
        $query = 'UPDATE '.$blog_tbname.' SET status="'.$status.'", title="'.$title.'", text="'.$text.'", tags="'.$tags.'" WHERE id="'.$postid.'"';	
	    $mysqli->query($query);
	}else{
	
	    $query = 'INSERT INTO '.$blog_tbname.' (title,text,date,tags,status) VALUES ("'.$title.'","'.$text.'","'.$date.'","'.$tags.'","'.$status.'")';
	    $mysqli->query($query);
	}
	mysqli_close($mysqli);
?>
     		</div>
            <footer>hi</footer>
        </div>
	</body>
</html>
