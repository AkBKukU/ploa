<?php

//Load Configuration Files
	include("./config.php");

	
	$mysqli = new mysqli($sqlhost, $sqluser, $sqlpass);
	
	if ($mysqli->connect_errno) {
    	echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
	}
	
//Check if blog database exist	
	if(0 == $mysqli->select_db($sqldata)){
		$mysqli->query('CREATE DATABASE '.$sqldata);
		echo 'Created '.$sqldata.' database';
	}
	
//Check if blog table exist	
	if(0 == $mysqli->query('SELECT 1 FROM '.$blog_tbname.' LIMIT 1')){
		$mysqli->query('CREATE TABLE '.$blog_tbname.'(
							id INT NOT NULL AUTO_INCREMENT, 
							PRIMARY KEY(id),
							title TEXT,
							text TEXT,
							date TEXT,
							tags TEXT,
							status INT
		)');
		echo 'Created '.$blog_tbname.' table';
	}
	
	
//Read posts from table
	$result =	$mysqli->query('SELECT * FROM '.$blog_tbname);
	
	if($result->num_rows > 0) {
		while($row = $result->fetch_assoc()) {
			$posts[] = array(  
				'title' => $row['title'], 
				'text' => $row['text'], 
				"date" => $row['date']
				);	
		}
	}
	
//------------------------------------Output------------------------------------\\
	
	echo '
	<'.$blog_ol_tag.'>
		<'.$blog_ol_htag.'>'.$blog_title.'</'.$blog_ol_htag.'>';
			
	for($c = count($posts)-1; $c > -1; $c--){
		echo '
			<'.$blog_ps_tag.'>
				<'.$blog_ps_htag.'>'.$posts[$c]['title'].' - '.$posts[$c]['date'].'</'.$blog_ps_htag.'>
				<p>'.$posts[$c]['text'].'</p>
			</'.$blog_ps_tag.'>
				';
	}
	
	
	echo '
	</'.$blog_ol_tag.'>';
	mysqli_close($mysqli);
?>
