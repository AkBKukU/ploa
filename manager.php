<!DOCTYPE html>
<html lang="en-US">
	<head>
		<title>Ploa Blog Test</title>
		<?php session_start(); 
        $cpass = "password";
        if($cpass==$_REQUEST['pass']){
        
            $_SESSION['loggedin'] = 1;
            }
        ?>
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
		            <a title="Manage all posts" href="?area=posts"><li>Posts</li></a>
		            <a title="Configure ploa" href="?area=settings"><li>Settings</li></a>
		            <a title="Write a new post" href="?area=writer"><li>Writer</li></a>
		            <a title="Return to the blog home page" href="index.php"><li>Back to blog</li></a>
	            </ul>
	            
            </div>
     		<div id="content">
<?php
 //--Action executed on logout
    if('kill'==$_REQUEST['kill']){
    
        $_SESSION['loggedin'] = 0;
        session_destroy();
        
    }
    
    
    if ($_SESSION['loggedin'] == 1){
    
        //--If they tried to go to another page but were not logged in, this sends them there
        if(isset($_SESSION['dest'])){
            
            echo '
            <script type="text/javascript">
                <!--
                   window.location="'.$_SESSION['dest'].'";
                //-->
            </script>
                    ';
            unset($_SESSION['dest']);
        }


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
			            <td><p><strong><a title="Veiw Post" href="http://s-mine.org:8228/?post='.$posts[$c]['id'].'">'.$posts[$c]['title'].' - '.$posts[$c]['date'].'</a></strong></p></td>
			            <td><a title="Edit Post" href="?area=writer&amp;edit='.$posts[$c]['id'].'"><img class="postctrl" alt="Edit" src="images/edit.png"></a> <a title="Delete Post" href="?area=posts&amp;edit='.$posts[$c]['id'].'&amp;delete=confirm"><img class="postctrl" alt="Delete" src="images/delete.png"></a></td>
		            </tr>
		            
	                <tr>
		                <td colspan=2 >'.substr($posts[$c]['text'],0,200).'</td>
                    </tr>
                </tbody>';
	    }
        echo '</table>';  
        
        //Find posts array key for post to edit
        if($_REQUEST['delete'] == 'confirm'){ 
            $postid = $_REQUEST['edit'];
                for($c = count($posts)-1; $c > -1; $c--){
                    if($posts[$c]['id'] == $postid){
                        $postkey = $c;
                    }
                 }
            echo '
            <div class="coverpage"></div>
            <table class="alerttable">
                <tbody>
                    <tr>
                        <td class="alertheader">Confirm Delete</td>
                    </tr>
                    
                    <tr>
                        <td class="alertbody">Are sure that you want to delete the post "'.$posts[$postkey]['title'].'" from '.$posts[$postkey]['date'].'?</td>
                    
                    <tr>
                        <td class="alertbuttons"><a href="post.php?action=delete&amp;postid='.$posts[$postkey]['id'].'">Yes</a><a href="manager.php?area=posts">No</a></td>
                    </tr>
                </tbody>
            </table>
            
            '; 
        
        }
    }
    
//----------------------------------------------------------------Writer----------------------------------------------------------------\\
    elseif($_REQUEST['area'] == 'writer'){ 
        if($_REQUEST['edit'] == 0){  
            $writetitle = 'Create a new' ;
            $writecheckbox = 'checked="checked"' ;
            $writedefaulttext = 'placeholder="Tell the world what you think here!">' ;
            $writedefaultitle = 'placeholder="New Post Title' ;
            $writedefaultags = 'placeholder="Tags here (ie flowers, computers, first)' ;
            $writeaction = '?action=insert' ;
            $writeeditid = '' ;
            
        }else{
            //Find posts array key for post to edit
            $postid = $_REQUEST['edit'];
            for($c = count($posts)-1; $c > -1; $c--){
                if($posts[$c]['id'] == $postid){
                    $postkey = $c;
                }
             }
            $writetitle = 'Edit a' ;
            if($posts[$postkey]['status']==1){$writecheckbox = 'checked="checked"' ;}else{$writecheckbox = '' ;}
            $writedefaulttext = '>'.$posts[$postkey]['text'] ;
            $writedefaultitle = 'value="'.$posts[$postkey]['title'] ;
            $writedefaultags = 'value="'.$posts[$postkey]['tags'] ;
            $writeaction = '?action=update' ;
            $writeeditid = '<input type="hidden" name="postid" value="'.$_REQUEST['edit'].'">' ;
            
        }
        echo'
        <fieldset>
	        <legend>'.$writetitle.' post</legend>
		            <form method="post" action="./post.php'.$writeaction.'">
			            <label for="title">Title </label><input name="title" id="title" type="text" class="title"'.$writedefaultitle.'">
			            <label for="tags">Tags </label><input name="tags" id="tags" type="text" class="tags"  '. $writedefaultags.'"><br />
			            <div class="separater"></div>
			            '.$writeeditid.'
			            <textarea name="text" id="text" type="text" class="text" '.$writedefaulttext.'</textarea><br />
			            <div class="inputs"><input type="submit" value="Save Post"  class="button"></input></div>
					    <div class="inputs"> <input type="checkbox" name="status" id="status" value=1 '.$writecheckbox.' class="checkbox"><label for="status" >Publish Post </label></div>	
		            </form>
            </fieldset>
        ';
    
    }
    
    
//----------------------------------------------------------------404----------------------------------------------------------------\\	    
    else{        
        echo '<div class="notfound"><p class="huge">404</p>
            <p>It looks like you were trying to get to "'.$_REQUEST['area'].'" but I cant find it</p></div> ' ;
    }
    
        }else{
    
    if('kill'==$_REQUEST['kill']){
    
        echo '
            <div class="coverpage"></div>
                <table class="alerttable">
                    <tbody>
                        <tr>
                            <td class="alertheader">Logged out</td>
                        </tr>
                        
                        <tr>
                            <td class="alertbody">You have been successfully logged out.</td>
                            
                        
                        <tr>
                            <td class="alertbuttons"><a href="manager.php">Log back in</a>
                            <a href="index.php">Back to blog</a></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            ';
        unset($_REQUEST['kill']);
    
    }else{
        echo '
            <div class="coverpage"></div>
            <form method="post" action="manager.php?area=posts">
                <table class="alerttable">
                    <tbody>
                        <tr>
                            <td class="alertheader">Login</td>
                        </tr>
                        
                        <tr>
                            <td class="alertbody">Please login to continue<input name="pass" type="password" placeholder="Password"></td>
                            
                        
                        <tr>
                            <td class="alertbuttons">
                            <input type="submit" value="Log in"><a href="index.php">Cancel</a></td>
                        </tr>
                    </tbody>
                </table>
            </form>
            ';
        }
    }

?>
     		</div>
            <footer> </footer>
	            <form class="logout" method="post" action="manager.php">
                        <input name="kill" type="hidden" value="kill">
                        <input type="submit" value="Log Out">
                    </form>
        </div>
	</body>
</html>
