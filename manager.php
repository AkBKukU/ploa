<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title>Ploa Blog Test</title>
		<meta charset=utf-8>
		<meta name="description" content="Ploa blog demonstration">
		<link rel=StyleSheet href="styles/global.css" type="text/css">
		<link rel=StyleSheet href="styles/manager.css" type="text/css">
		<link rel=StyleSheet href="styles/writer.css" type="text/css">
	</head>
 	<body>
     	<div id="sitewrapper">
     		<h1>ploa - Manage!</h1>
     		    
		    <div id="sidebar">
		        <ul>
		            <a href="?area=posts"><li>Posts</li></a>
		            <a href="?area=settings"><li>Settings</li></a>
		            <a href="?area=writer"><li>Writer</li></a>
	            </ul>
            </div>
     		<div id="content">
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
	    $result =	$mysqli->query('SELECT * FROM '.$blog_tbname);
	    if($result->num_rows > 0) {
		    while($row = $result->fetch_assoc()) {
		        $posts[] = array(  
			        'title' => $row['title'], 
			        'text' => $row['text'], 
			        'id' => $row['id'],
			        'tags' => $row['tags'],
			        'status' => $row['status'],
			        "date" => $row['date']
			        );	
	        
		    }
	    }
	
        for($c = 0; $c < count($posts); $c++){	
            $year = substr($posts[$c]['date'],0,4);
            $month = substr($posts[$c]['date'],5,2);
            $day = substr($posts[$c]['date'],8,2);
            $posts[$c]['date'] = $month.'/'.$day.'/'.$year ;
	
        }
	
	    //Disconnect from database
	    mysqli_close($mysqli);

//----------------------------------------------------------------Posts----------------------------------------------------------------\\	    
    if($_REQUEST['area'] == 'posts'){        
        echo '<table>';    
	    for($c = count($posts)-1; $c > -1; $c--){
            if($c % 2 == 0){$even=' class="even"';}else{$even='';}
		    echo '
                <tbody'.$even.'>
		            <tr>
			            <td><p><strong><a title="Veiw Post" href="http://s-mine.org:8228/?post='.$posts[$c]['id'].'">'.$posts[$c]['title'].'</a></strong></p></td>
			            <td class="postctrl"><a title="Edit Post" href="?area=writer&amp;edit='.$posts[$c]['id'].'"><img alt="Edit" src="images/edit.png"></a></td>
		            </tr>
		            
	                <tr>
		                <td colspan=2 >'.substr($posts[$c]['text'],0,200).'</td>
                    </tr>
                </tbody>';
	    }
        echo '</table>';    
    }
    
//----------------------------------------------------------------Writer----------------------------------------------------------------\\
    if($_REQUEST['area'] == 'writer'){ 
        if($_REQUEST['edit'] == 0){  
            $writetitle = 'Create a new' ;
            $writecheckbox = 'checked="checked"' ;
            $writedefaulttext = 'Tell the world what you think here!' ;
            $writedefaultitle = 'New Post Title' ;
            $writedefaultags = 'Tags here (ie flowers, computers, first)' ;
        }else{
            $postid = $_REQUEST['edit'];
            for($c = count($posts)-1; $c > -1; $c--){
                if($posts[$c]['id'] == $postid){
                    $postkey = $c;
                }
             }
            $writetitle = 'Edit a' ;
            if($posts[$postkey]['status']==1){$writecheckbox = 'checked="checked"' ;}else{$writecheckbox = '' ;}
            $writedefaulttext = $posts[$postkey]['text'] ;
            $writedefaultitle = $posts[$postkey]['title'] ;
            $writedefaultags = $posts[$postkey]['tags'] ;
            
        }
        echo'
        <fieldset>
	        <legend>'.$writetitle.' post</legend>
		            <form method="post" action="./post.php">
			            <label for="title">Title </label><input name="title" id="title" type="text" class="title" placeholder="'.$writedefaultitle.'">
			            <label for="tags">Tags </label><input name="tags" id="tags" type="text" class="tags"  placeholder="'. $writedefaultags.'"><br />
			            <div class="separater"></div>
			            <textarea name="text" id="text" type="text" class="text" placeholder="'.$writedefaulttext.'"></textarea><br />
			            <div class="inputs"><input type="submit" value="Save Post"  class="button"></input></div>
					    <div class="inputs"> <input type="checkbox" name="status" id="status" value=1 '.$writecheckbox.' class="checkbox"><label for="status" >Publish Post </label></div>	
		            </form>
            </fieldset>
        ';
    
    }
?>
     		</div>
            <footer>hi</footer>
        </div>
	</body>
</html>
