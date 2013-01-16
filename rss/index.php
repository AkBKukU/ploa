<?php

	//Load Configuration Files
	include(dirname( dirname(__FILE__) )."/config.php");

	//Begin sql connection
	$mysqli = new mysqli($sqlhost, $sqluser, $sqlpass);
	
	
	//Check if blog database exist	
	if(0 == $mysqli->select_db($sqldata)){
		$mysqli->query('CREATE DATABASE '.$sqldata);
	}
	
	//Check if blog table exist	
	if(0 == $mysqli->query('SELECT 1 FROM '.$blog_tbname.' LIMIT 1')){}
	
	
	//Read posts from table
	$result =	$mysqli->query('SELECT * FROM '.$blog_tbname);
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			if($row['status'] != "0"){
			    $posts[] = array(  
				    'title' => $row['title'], 
				    'text' => $row['text'], 
				    'id' => $row['id'],
				    "date" => $row['date']
				    );	
		    }
		    
		}
	}
	
	//Disconnect from database
	mysqli_close($mysqli);
//------------------------------------Output------------------------------------\\
	
    header("Content-Type: application/rss+xml; charset=ISO-8859-1");

    $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>';
    $rssfeed .= '<rss version="2.0">';
    $rssfeed .= '<channel>';
    $rssfeed .= '<title>'.$blog_title.'</title>';
    $rssfeed .= '<link>http://s-mine.org:8228/</link>';
    $rssfeed .= '<description>This is the RSS feed for the blog '.$blog_title.'</description>';
    $rssfeed .= '<language>en-us</language>';
    $rssfeed .= '<copyright>Copyright (C) 2009 mywebsite.com</copyright>';
    
	for($c = count($posts)-1; $c > -1; $c--){
		$rssfeed .= '<item>';
        $rssfeed .= '<title>' . $posts[$c]['title'] . '</title>';
        $rssfeed .= '<description>' . $posts[$c]['text'] . '</description>';
        $rssfeed .= '<link>http://s-mine.org:8228/?post='.$posts[$c]['id'].'</link>';
        $rssfeed .= '<pubDate>' . $posts[$c]['date'] . '</pubDate>';
        $rssfeed .= '</item>';
	}	
	
	
 
    $rssfeed .= '</channel>';
    $rssfeed .= '</rss>';
 
    echo $rssfeed;
?>
