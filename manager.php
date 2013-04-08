<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Ploa Blog Test</title>
        <?php session_start(); 
        
        //--Load other classes to be used
        include('./classes/class.LoadPosts.php');
        include('./classes/class.ConfigHandler.php');
        $config = new ConfigHandler(__DIR__.'/'.'settings.cfg');
        
        //--Check ploa version to the one on github to check for an update
        $loadPosts = new LoadPosts();
        $changelogArray = explode("\n",file_get_contents('./changelog.log'),2);
        $verArray = explode(':',$changelogArray[0],2);
        $currentversion = floatval($verArray[1]);
        $changelogArray = explode("\n",file_get_contents('https://raw.github.com/AkBKukU/ploa/master/changelog.log'),2);
        $verArray = explode(':',$changelogArray[0],2);
        $releaseversion = floatval($verArray[1]);
        $upgrade = '';
        if($currentversion < $releaseversion){$upgrade = '<li><a title="Update to Newest Release" href="'.$ploa_url.'">Update Availible!</a></li>';}
        //--Check if user is logged in
        if($loadPosts->checkUser($_REQUEST['userlogin'],$_REQUEST['userpass'])){
            $_SESSION['loggedin'] = 1;
            $_SESSION['currentuser'] = $_REQUEST['userlogin'];
        }
        $currentUser = $loadPosts->getUser( $_SESSION['currentuser']);
        ?>
        <meta charset=utf-8>
        <meta name="description" content="Ploa blog demonstration">
        <link rel=StyleSheet href="content/styles/global.css" type="text/css">
        <link rel=StyleSheet href="content/styles/writer.css" type="text/css">
        <link rel=StyleSheet href="content/styles/manager.css" type="text/css">
    </head>
     <body>
         <div id="sitewrapper">
             <h1>ploa v<?php echo $currentversion;?> - Manage!</h1>
                 
            <div id="sidebar">
                <ul id="nav">
                <?php
                
                $navOptions = array(
                    '<a title="Manage all posts" href="?area=posts">Posts</a>',
                    '<a title="Configure ploa" href="?area=settings">Settings</a>',
                    '<a title="Write a new post" href="?area=writer">Writer</a>',
                    '<a title="Veiw how to format posts" href="?area=help">Help</a>'
                );
                if($currentUser['type'] == 0 && $_SESSION['loggedin'] == 1){
                    $navOptions[] = '<a title="Manage all users" href="?area=users">Users</a>';
                    $navOptions[] = '<a title="Create new user" href="?area=usereditor&amp;edit=-1">User Editor</a>';
                }
                
                
                $navOptions[] = '<a title="Return to the blog home page" href="index.php">Back to blog</a>';
                for($c = 0;$c <= count($navOptions)-1; $c++){
                    echo '<li>'.$navOptions[$c].'</li>';
                }
                ?>
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
    
    
    //--Check if user is logged in
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
        
        //--load posts to array
        $posts  = $loadPosts->getPosts($currentUser['name']); 
        
        
        //--Checks what page to display   
        if($_REQUEST['area'] == 'posts'){        
            
            include('./managment/posts.php');
        }elseif($_REQUEST['area'] == 'postview'){ 
            
            include('./managment/postview.php');
        }elseif($_REQUEST['area'] == 'users'){ 
            
            include('./managment/users.php');
        }elseif($_REQUEST['area'] == 'settings'){ 
            
            include('./managment/settings.php');
        }elseif($_REQUEST['area'] == 'writer'){ 
            
            include('./managment/writer.php');    
        }elseif($_REQUEST['area'] == 'usereditor'){ 
            
            include('./managment/usereditor.php');    
        }elseif($_REQUEST['area'] == 'help'){ 
            
            include('./managment/help.php');    
        }
        
        //--Displays 404 in the page doesn't exist
        else{        
            echo '<div class="notfound"><p class="huge">404</p>
                <p>It looks like you were trying to get to "'.$_REQUEST['area'].'" but I cant find it</p></div> ' ;
        }
    
    }else{
    
        //--Alearts the use that they logged out   
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
        
        //--Asks the user to log in
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
                                <td class="alertbody">
                                    <p>Please login to continue</p>
                                    <label class="alertinputlabel" for="userlogin">User</label><input id="userlogin" name="userlogin" type="text" placeholder="Username" autofocus=""><br />
                                    <label class="alertinputlabel" for="userpass">Pass</label><input id="userpass" name="userpass" type="password" placeholder="Password">
                                </td>
                                
                            
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
