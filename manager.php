<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Ploa Blog Test</title>
        <?php session_start(); 
        
        //Load Configuration Files
        include("./config.php");
        
        ;
        $currentversion = floatval(file_get_contents('ver.txt'));
        $releaseversion = floatval(file_get_contents('https://raw.github.com/AkBKukU/ploa/master/ver.txt'));
        $upgrade = '';
        if($currentversion < $releaseversion){$upgrade = '<a title="Update to Newest Release" href="'.$ploa_url.'"><li>Update Availible!</li></a>';}
        if($blog_pass==$_REQUEST['pass']){
        
            $_SESSION['loggedin'] = 1;
            }
        ?>
        <meta charset=utf-8>
        <meta name="description" content="Ploa blog demonstration">
        <link rel=StyleSheet href="styles/global.css" type="text/css">
        <link rel=StyleSheet href="styles/writer.css" type="text/css">
        <link rel=StyleSheet href="styles/manager.css" type="text/css">
    </head>
     <body>
         <div id="sitewrapper">
             <h1>ploa v<?php echo $currentversion;?> - Manage!</h1>
                 
            <div id="sidebar">
                <ul id="nav">
                    <li><a title="Manage all posts" href="?area=posts">Posts</a></li>
                    <li><a title="Configure ploa" href="?area=settings">Settings</a></li>
                    <li><a title="Write a new post" href="?area=writer">Writer</a></li>
                    <li><a title="Veiw how to format posts" href="?area=help">Help</a></li>
                    <li><a title="Return to the blog home page" href="index.php">Back to blog</a></li>
                    <?php echo $upgrade; ?>
                </ul>
                <form class="logout" method="post" action="manager.php">
                        <input name="kill" type="hidden" value="kill">
                        <input type="submit" value="Log Out">
                    </form>
                
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
    
    include ('class.format.php');
    $format = new format();
        echo '<table>';    
        for($c = count($posts)-1; $c > -1; $c--){
            if($c % 2 == 0){$even=' class="even"';}else{$even='';}
            echo '
                <tbody'.$even.'>
                    <tr>
                        <td><p><strong><a title="Veiw Post" href="'.$blog_url.'?post='.$posts[$c]['id'].'">'.$posts[$c]['title'].' - '.$posts[$c]['date'].'</a></strong></p></td>
                        <td><a title="Edit Post" href="?area=writer&amp;edit='.$posts[$c]['id'].'"><img class="postctrl" alt="Edit" src="images/edit.png"></a> <a title="Delete Post" href="?area=posts&amp;edit='.$posts[$c]['id'].'&amp;delete=confirm"><img class="postctrl" alt="Delete" src="images/delete.png"></a></td>
                    </tr>
                    
                    <tr>
                        <td colspan=2 >'.$format->oneline($posts[$c]['text']).'</td>
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
    
//----------------------------------------------------------------Settings----------------------------------------------------------------\\
    elseif($_REQUEST['area'] == 'settings'){ 
        
        
        echo'
        <div id="settingspage" class="textarea">
            <h2>Settings';
            
        
        if($_REQUEST['action'] == 'save'){
        
            $config->setValue('blog-posts-to-show',$_REQUEST['blog-posts-to-show']);
            $config->setValue('sql-user',$_REQUEST['sql-user']);
            if($_REQUEST['sql-pass'] == $_REQUEST['sql-pass-confirm']){
                $config->setValue('sql-pass',$_REQUEST['sql-pass']);
            }else{echo " - SQL Passwords Don't Match(Igorning Change)";}
            $config->setValue('sql-host',$_REQUEST['sql-host']);
            $config->setValue('sql-database',$_REQUEST['sql-database']);
            $config->setValue('sql-table',$_REQUEST['sql-table']);
            $config->setValue('blog-title',$_REQUEST['blog-title']);
            $config->setValue('blog-url',$_REQUEST['blog-url']);
            $config->setValue('blog-show-title',$_REQUEST['blog-show-title']);
            $config->setValue('blog-show-nav',$_REQUEST['blog-show-nav']);
            $config->setValue('blog-nav-type',$_REQUEST['blog-nav-type']);
            if($_REQUEST['blog-login-pass'] == $_REQUEST['blog-login-pass-confirm']){
                $config->setValue('blog-login-pass',$_REQUEST['blog-login-pass']);
            }else{echo " - Login Passwords Don't Match(Igorning Change)";}
            $config->setValue('blog-full',$_REQUEST['blog-full']);
            $config->setValue('blog-header',$_REQUEST['blog-header']);
            $config->setValue('blog-nav',$_REQUEST['blog-nav']);
            $config->setValue('blog-post',$_REQUEST['blog-post']);
            $config->setValue('blog-post-header',$_REQUEST['blog-post-header']);
            echo ' - Saved';
        }    
            
            
            
            
            
        echo '</h2>
            <hr />
            <form method="post" action="?area=settings&amp;action=save">
                <h3 id="configdatabase"><a href="#textformat">Database</a></h3>
                <p> - Configure database connection</p>
               
                <table>
                    <tr>
                       <th><label for="sql-host">Host:Port</label></th>
                       <td><input id="sql-host" name="sql-host" type="text" value="'.$config->getValue('sql-host').'"></td>
                    </tr>
                    <tr>
                       <th><label for="sql-database">Database</label></th>
                       <td><input id="sql-database" name="sql-database" type="text" value="'.$config->getValue('sql-database').'"></td>
                    </tr>
                    <tr>
                       <th><label for="sql-table">Blog Table</label></th>
                       <td><input id="sql-table" name="sql-table" type="text" value="'.$config->getValue('sql-table').'"></td>
                    </tr>
                    
                    <tr>
                       <th><label for="sql-user">User</label></th>
                       <td><input id="sql-user" name="sql-user" type="text" value="'.$config->getValue('sql-user').'"></td>
                    </tr>
                    
                    <tr>
                       <th><label for="sql-pass">Password</label></th>
                       <td><input id="sql-pass" name="sql-pass" type="password" value="'.$config->getValue('sql-pass').'"></td>
                    </tr>
                    
                    <tr>
                       <th><label for="sql-pass-confirm">Password Confirm</label></th>
                       <td><input id="sql-pass-confirm" name="sql-pass-confirm" type="password" value="'.$config->getValue('sql-pass').'"></td>
                    </tr>
                    
                </table>
                
                
                <h3 id="configblog"><a href="#textformat">Blog</a></h3>
                <p> - Configure Blog info</p>
                <table>
                    <tr>
                       <th><label for="blog-login-pass">Manager Password</label></th>
                       <td><input id="blog-login-pass" name="blog-login-pass" type="password" value="'.$config->getValue('blog-login-pass').'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-login-pass-confirm">Manager Password Confrim</label></th>
                       <td><input id="blog-login-pass-confirm" name="blog-login-pass-confirm" type="password" value="'.$config->getValue('blog-login-pass').'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-title">Blog Title</label></th>
                       <td><input id="blog-title" name="blog-title" type="text" value="'.$config->getValue('blog-title').'"><p>WARNING: Changing this can mess up RSS!</p></td>
                    </tr>
                    <tr>
                       <th><label for="blog-url">Blog URL</label></th>
                       <td><input id="blog-url" name="blog-url" type="text" value="'.$config->getValue('blog-url').'"><p>WARNING: Changing this can mess up RSS!</p></td>
                    </tr>
                    <tr>
                       <th><label for="blog-posts-to-show">Number of Posts to Show</label></th>
                       <td><input id="blog-posts-to-show" name="blog-posts-to-show" type="text" value="'.$config->getValue('blog-posts-to-show').'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-show-title">Display Title?</label></th>
                       <td><input id="blog-show-title" name="blog-show-title" type="text" value="'.$config->getValue('blog-show-title').'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-show-nav">Display Navigation?</label></th>
                       <td><input id="blog-show-nav" name="blog-show-nav" type="text" value="'.$config->getValue('blog-show-nav').'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-nav-type">Navigation Type</label></th>
                       <td><input id="blog-nav-type" name="blog-nav-type" type="text" value="'.$config->getValue('blog-nav-type').'"></td>
                    </tr>
                    
                </table>
                
                
                <h3 id="configblogtags"><a href="#textformat">Blog HTML Tags</a></h3>
                <p> - Configure Blog HTML Output</p>
                <table>
                    <tr>
                       <th><label for="blog-full">Blog Surround</label></th>
                       <td><input id="blog-full" name="blog-full" type="text" value='."'".$config->getValue('blog-full')."'".'></td>
                    </tr>
                    <tr>
                       <th><label for="blog-header">Blog Header</label></th>
                       <td><input id="blog-header" name="blog-header" type="text" value="'.$config->getValue('blog-header').'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-nav">Blog Navigation</label></th>
                       <td><input id="blog-nav" name="blog-nav" type="text" value='."'".$config->getValue('blog-nav')."'".'></td>
                    </tr>
                    <tr>
                       <th><label for="blog-post">Blog Post</label></th>
                       <td><input id="blog-post" name="blog-post" type="text" value="'.$config->getValue('blog-post').'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-post-header">Blog Post Header</label></th>
                       <td><input id="blog-post-header" name="blog-post-header" type="text" value="'.$config->getValue('blog-post-header').'"></td>
                    </tr>
                    
                </table>
                <input type="submit" value="Save Changes"  class="button">
            </form>
            
        </div>
        ';
        
    }
    
//----------------------------------------------------------------Writer----------------------------------------------------------------\\
    elseif($_REQUEST['area'] == 'writer'){ 
        if($_REQUEST['edit'] == 0){  
            $writetitle = 'Create a new' ;
            $writecheckbox = 'checked="checked"' ;
            $writedefaulttext = ' placeholder="Tell the world what you think here!">' ;
            $writedefaultitle = ' placeholder="New Post Title' ;
            $writedefaultags = ' placeholder="Tags here (ie flowers, computers, first)' ;
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
                        <label for="title">Title </label><input name="title" id="title" type="text" class="title"'.$writedefaultitle.'" autofocus="">
                        <label for="tags">Tags </label><input name="tags" id="tags" type="text" class="tags"  '. $writedefaultags.'"><br />
                        <div class="separater"></div>
                        '.$writeeditid.'
                        <textarea name="text" id="text" class="text" '.$writedefaulttext.'</textarea><br />
                        <div class="inputs"><input type="submit" value="Save Post"  class="button"></div>
                        <div class="inputs"> <input type="checkbox" name="status" id="status" value=1 '.$writecheckbox.' class="checkbox"><label for="status" >Publish Post </label></div>    
                    </form>
            </fieldset>
        ';
    
    }
    
//----------------------------------------------------------------Help----------------------------------------------------------------\\
    elseif($_REQUEST['area'] == 'help'){ 
        echo'
        <div id="helppage" class="textarea">
            <h2>Help</h2>
            <hr />
            <h3 id="textformat"><a href="#textformat">Formatting Text</a></h3>
            <p>You can add formating such as being bold to your text when you post. To do it you put the text in braces and add codes like this:</p>
            
            <table>
                <tr>
                   <th>Open Brace</th>
                   <th>Format Tags</th>
                   <th>Semi-Colon</th>
                   <th>Text</th>
                   <th>Close Brace</th>
                </tr>
                
                <tr>
                    <td>[</td>
                    <td>b,u</td>
                    <td>;</td>
                    <td>This text would be bold and underlined</td>
                    <td>]</td>
                </tr>
            </table>
            <p>So typed into the writer page bold and underlined formated text would look like this, [b,u;This text would be bold and underlined], and would show up on the blog like this,  <strong><u>This text would be bold and underlined </u></strong>. Also note that you cannot nest braces so if you want to achive this, <strong> bold <u>bold and underlined</u> bold</strong>, you need to type it like this, [b; bold] [b,u;bold and underlined] [b;bold].</p>
            
            <p>Here are the avaible tags*:</p>
            <ul>
                <li>U: <u>Underlines the text</u></li>
                <li>B: <strong>Make the text bold</strong></li>
                <li>S: <strike>Strikes trough the text</strike></li>
                <li>I: <em>Italisizes the text</em></li>
            </ul>
            
            <small>*Capitalization does not matter</small>
        </div>
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
                            <td class="alertbody">Please login to continue<input name="pass" type="password" placeholder="Password" autofocus=""></td>
                            
                        
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
        </div>
    </body>
</html>
