<?php

    //Load Configuration Files
    include("./config.php");


    //Begin sql connection
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
    $result =    $mysqli->query('SELECT * FROM '.$blog_tbname);
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
    
    for($c = 0; $c < count($posts); $c++){    
        $posts[$c]['year'] = substr($posts[$c]['date'],0,4);
        $posts[$c]['month'] = substr($posts[$c]['date'],5,2);
        $posts[$c]['day'] = substr($posts[$c]['date'],8,2);
        $posts[$c]['formdate'] = $posts[$c]['month'].'/'.$posts[$c]['day'].'/'.$posts[$c]['year'] ;
    
    }
    
    //Disconnect from database
    mysqli_close($mysqli);
    
    //Check to see if number of posts to show is higher th number of posts the exist
    if($blog_ps_count > count($posts)){$blog_ps_count = count($posts);}
    
?>
