<?php
//include ('class.LoadPosts.php');
//$LoadPosts = new LoadPosts();


//--How to use

//--Returns all posts in an array
//echo $LoadPosts->getPosts($input);


class LoadPosts{

    //--Declare Feilds
    public $posts;
    public $users;
    public $sqlConfig;
    public $mysqli;

    /*
     * Constructor 
     * 
     * Loads all post info into an array
     */
    public function __construct(){
    
        
        //--Load Configuration Files
        $this->sqlConfig = new ConfigHandler(dirname(__DIR__).'/'.'settings.cfg');


        //--Begin sql connection
        $this->mysqli = new mysqli($this->sqlConfig->getValue('sql-host'), $this->sqlConfig->getValue('sql-user'), $this->sqlConfig->getValue('sql-pass'));
        
        if ($this->mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
        
        //Check if blog database exist    
        if(0 == $this->mysqli->select_db($this->sqlConfig->getValue('sql-database'))){
            $this->mysqli->query('CREATE DATABASE '.$this->sqlConfig->getValue('sql-database'));
            echo 'Created '.$config->getValue('sql-database').' database';
        }
        
        //--Check if post table exist    
        if(0 == $this->mysqli->query('SELECT 1 FROM '.$this->sqlConfig->getValue('sql-post-table').' LIMIT 1')){
            $this->mysqli->query('CREATE TABLE '.$this->sqlConfig->getValue('sql-post-table').'(
                                id INT NOT NULL AUTO_INCREMENT, 
                                PRIMARY KEY(id),
                                title TEXT,
                                text TEXT,
                                date TEXT,
                                tags TEXT,
                                status INT,
                                userid INT,
                                displaydate TEXT,
                                allowcomments INT
            )');
            echo 'Created '.$this->sqlConfig->getValue('sql-table').' table';
        }
        
        //--Check if user table exist    
        if(0 == $this->mysqli->query('SELECT 1 FROM '.$this->sqlConfig->getValue('sql-user-table').' LIMIT 1')){
            $this->mysqli->query('CREATE TABLE '.$this->sqlConfig->getValue('sql-user-table').'(
                                id INT NOT NULL AUTO_INCREMENT, 
                                PRIMARY KEY(id),
                                name TEXT,
                                pass TEXT,
                                postcount INT,
                                type INT,
                                blogtitle TEXT,
                                blogurl TEXT,
                                blogpoststoshow INT,
                                blogshowtitle INT,
                                blogshownav INT,
                                blognavusestyle INT,
                                blognavtype TEXT,
                                blogfull TEXT,
                                blogheader TEXT,
                                blognav TEXT,
                                blogpost TEXT,
                                blogpostheader TEXT
            )');
            echo 'Created '.$this->sqlConfig->getValue('sql-user-table').' table';
            
            $query = 'INSERT INTO '.$this->sqlConfig->getValue('sql-user-table').' (name,
                                                                                    pass,
                                                                                    postcount,
                                                                                    type,
                                                                                    blogtitle,
                                                                                    blogurl,
                                                                                    blogpoststoshow,
                                                                                    blogshowtitle,
                                                                                    blogshownav,
                                                                                    blognavusestyle,
                                                                                    blognavtype,
                                                                                    blogfull,
                                                                                    blogheader,
                                                                                    blognav,
                                                                                    blogpost,
                                                                                    blogpostheader) 
                                                                                    
                                                                           VALUES ( "admin",
                                                                                    "password",
                                                                                    "0",
                                                                                    "0",
                                                                                    "Default Blog",
                                                                                    "http://127.0.0.1:/",
                                                                                    "10",
                                                                                    "1",
                                                                                    "1",
                                                                                    "0",
                                                                                    "horizontal",
                                                                                    "&lt;section class=&quot;theme&quot;&gt;",
                                                                                    "&lt;h2&gt;",
                                                                                    "&lt;div class=&quot;nav&quot;&gt;",
                                                                                    "&lt;article&gt;",
                                                                                    "&lt;h3&gt;")';
                    
            echo "Query: ".$query;
            $this->mysqli->query($query);
            echo 'Added admin user with pass root';
        }
        
        //--Read posts from table
        $result =    $this->mysqli->query('SELECT * FROM '.$this->sqlConfig->getValue('sql-post-table'));
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $this->posts[] = array(  
                    'title' => $row['title'], 
                    'text' => $row['text'], 
                    'id' => $row['id'],
                    'userid' => $row['userid'],
                    'tags' => $row['tags'],
                    "date" => $row['date'],
                    'status' => $row['status']
                    );    
                
            }
        }
        
        //--Read users from table
        $result =    $this->mysqli->query('SELECT * FROM '.$this->sqlConfig->getValue('sql-user-table'));
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $this->users[] = array(  
                    'name' => $row['name'], 
                    'pass' => $row['pass'], 
                    'id' => $row['id'],
                    "postcount" => $row['postcount'],
                    'type' => $row['type'],
                    'blogtitle' => $row['blogtitle'],
                    'blogurl' => $row['blogurl'],
                    'blogpoststoshow' => $row['blogpoststoshow'],
                    'blogshowtitle' => $row['blogshowtitle'],
                    'blogshownav' => $row['blogshownav'],
                    'blognavusestyle' => $row['blognavusestyle'],
                    'blognavtype' => $row['blognavtype'],
                    'blogfull' => $row['blogfull'],
                    'blogheader' => $row['blogheader'],
                    'blognav' => $row['blognav'],
                    'blogpost' => $row['blogpost'],
                    'blogpostheader' => $row['blogpostheader']
                    );    
                
            }
        }
        
        //--Get individual date parts
        for($c = 0; $c < count($this->posts); $c++){    
            $this->posts[$c]['year'] = substr($this->posts[$c]['date'],0,4);
            $this->posts[$c]['month'] = substr($this->posts[$c]['date'],5,2);
            $this->posts[$c]['day'] = substr($this->posts[$c]['date'],8,2);
            $this->posts[$c]['formdate'] = $this->posts[$c]['month'].'/'.$this->posts[$c]['day'].'/'.$this->posts[$c]['year'] ;
        
        }
        
        //--Count the user posts
        for($c = 0; $c < count($this->users); $c++){
            
            for($d = 0; $d < count($this->posts); $d++){    
                if($this->users[$c]['id'] == $this->posts[$d]['userid']){$this->users[$c]['postcount']++;}
            }
        }
        
    }
    
    /*
     * getPosts 
     * 
     * Returns all posts in an array that are mark with status 1
     */
    public function getPosts($username){
        
        if(is_array($username)){
        
            for($c = 0;$c <= count($this->users)-1; $c++){
                for($d = 0;$d <= count($username); $d++){
                    if($this->users[$c]['name'] == $username[$d]){
                        $userid[] = $this->users[$c]['id'];
                    } 
                }
            }
            
            for($c = 0;$c <= count($this->posts)-1; $c++){
                for($d = 0;$d <= count($username); $d++){
                    if($this->posts[$c]['userid'] == $userid[$d]){
                        $userPosts[] = $this->posts[$c];   
                    }
                } 
            }
        
        }else{
        
            for($c = 0;$c <= count($this->users)-1; $c++){
                if($this->users[$c]['name'] == $username){
                    $userid = $this->users[$c]['id'];
                } 
            }
            
            for($c = 0;$c <= count($this->posts)-1; $c++){
                if($this->posts[$c]['userid'] == $userid){
                    $userPosts[] = $this->posts[$c];   
                } 
            }
        }
        
        
        
        return $userPosts;
    }
    
    /*
     * getAllPosts 
     * 
     * Returns all posts
     */
    public function getAllPosts(){
        
        return $this->posts;
    }
    
    /*
     * addPost 
     * 
     * Returns all posts
     */
    public function addPost($title,$text,$tags,$status,$userid){
        
        //--Set the current date
        $date=date('Y-m-d H:i:s');
        
        $query = 'INSERT INTO '.$this->sqlConfig->getValue('sql-post-table').' (title,text,date,tags,status,userid) VALUES ("'.$title.'","'.$text.'","'.$date.'","'.$tags.'","'.$status.'","'.$userid.'")';
        echo "Query: ".$query;
        If($this->mysqli->query($query) == 1){
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=posts";
                //-->
            </script>
                    ';
        }else{
            echo 'Error - PL01P001: Failed to add post.';
        }
    }
    
    /*
     * updatePost 
     * 
     * Returns all posts
     */
    public function updatePost($title,$text,$tags,$status,$postid){
    
       $query = 'UPDATE '.$this->sqlConfig->getValue('sql-post-table').' SET status="'.$status.'", title="'.$title.'", text="'.$text.'", tags="'.$tags.'" WHERE id="'.$postid.'"';    
        echo "Query: ".$query;
        If($this->mysqli->query($query) == 1){
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=posts";
                //-->
            </script>
                    ';
        }else{
            echo 'Error - PL03P002: Failed to update post.';
        }
    }
    
    /*
     * deletePost 
     * 
     * Returns all posts
     */
    public function deletePost($postid){
    
        $query = 'DELETE FROM '.$this->sqlConfig->getValue('sql-post-table').' WHERE id='.$postid;
        echo "Query: ".$query;
        
        If($this->mysqli->query($query) == 1){
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=posts";
                //-->
            </script>
                    ';
        }else{
            echo 'Error - PL04P003: Failed to delete post.';
        }
    }
    
    
    
    
    
    /*
     * checkUser 
     * 
     * Returns true or false if it is a valid login
     */
    public function checkUser($name,$pass){
        
        $authentic = false;
        
        for($c = 0;$c <= count($this->users)-1; $c++){
            if($this->users[$c]['name'] == $name && $this->users[$c]['pass'] == $pass ){
            $authentic = true;
            } 
        }
        
        
        
        return $authentic;
    }
    
    /*
     * getUserPass 
     * 
     * Returns the users password
     */
    public function getUserPass($name){
        
        $pass = '';
        
        for($c = 0;$c <= count($this->users)-1; $c++){
            if($this->users[$c]['name'] == $name){
            $pass = $this->users[$c]['pass'];
            } 
        }
        
        
        
        return $pass;
    }
    
    /*
     * getUser
     * 
     * Returns the users info
     */
    public function getUser($name){
        
                
        for($c = 0;$c <= count($this->users)-1; $c++){
            if($this->users[$c]['name'] == $name){
                $theuser = $this->users[$c];   
                
            } 
        }
        
        return $theuser;
    }
    
    /*
     * setUserPass 
     * 
     * Changes the users password
     */
    public function setUserPass($name,$newpass){
        
        
        for($c = 0;$c <= count($this->users)-1; $c++){
            if($this->users[$c]['name'] == $name){
            $id = $this->users[$c]['id'];
            } 
        }
        
        
        $query = 'UPDATE '.$this->sqlConfig->getValue('sql-user-table').' SET pass="'.$newpass.'" WHERE id="'.$id.'"';
        
        $this->mysqli->query($query);
        
    }
    
    /*
     * updateUserSettings 
     * 
     * Changes the users password
     */
    public function updateUserSettings( $name,
                                        $blogtitle,
                                        $blogurl,
                                        $blogpoststoshow,
                                        $blogshowtitle,
                                        $blogshownav,
                                        $blognavusestyle,
                                        $blognavtype,
                                        $blogfull,
                                        $blogheader,
                                        $blognav,
                                        $blogpost,
                                        $blogpostheader){
        
        
        for($c = 0;$c <= count($this->users)-1; $c++){
            if($this->users[$c]['name'] == $name){
                
                $id = $this->users[$c]['id'];
            } 
        }
        
        
        $query = 'UPDATE '.$this->sqlConfig->getValue('sql-user-table').' SET   blogtitle="'        .$blogtitle         .'",
                                                                                blogurl="'          .$blogurl           .'",
                                                                                blogpoststoshow="'  .$blogpoststoshow   .'",
                                                                                blogshowtitle="'    .$blogshowtitle     .'",
                                                                                blogshownav="'      .$blogshownav       .'",
                                                                                blognavusestyle="'  .$blognavusestyle   .'",
                                                                                blognavtype="'      .$blognavtype       .'",
                                                                                blogfull="'         .$blogfull          .'",
                                                                                blogheader="'       .$blogheader        .'",
                                                                                blognav="'          .$blognav           .'",
                                                                                blogpost="'         .$blogpost          .'",
                                                                                blogpostheader="'   .$blogpostheader    .'" 
                                                                                
                                                                                WHERE id="'.$id.'"';
                                                                                
                                      
        echo "Result: ".$this->mysqli->query($query);
        
    }
    
    /*
     * addUser
     * 
     * Creates a new user
     */
    public function addUser($name,$pass,$type){
        
        $query = 'INSERT INTO '.$this->sqlConfig->getValue('sql-user-table').' (name,
                                                                                pass,
                                                                                postcount,
                                                                                type,
                                                                                blogtitle,
                                                                                blogurl,
                                                                                blogpoststoshow,
                                                                                blogshowtitle,
                                                                                blogshownav,
                                                                                blognavusestyle,
                                                                                blognavtype,
                                                                                blogfull,
                                                                                blogheader,
                                                                                blognav,
                                                                                blogpost,
                                                                                blogpostheader)  
                                                                                
                                                                    VALUES (    "'.$name.'",
                                                                                "'.$pass.'",
                                                                                "0",
                                                                                "'.$type.'",
                                                                                "Default Blog",
                                                                                "http://127.0.0.1:/",
                                                                                "10",
                                                                                "1",
                                                                                "1",
                                                                                "0",
                                                                                "horizontal",
                                                                                "&lt;section class=&quot;theme&quot;&gt;",
                                                                                "&lt;h2&gt;",
                                                                                "&lt;div class=&quot;nav&quot;&gt;",
                                                                                "&lt;article&gt;",
                                                                                "&lt;h3&gt;")';
                                                                
        $this->mysqli->query($query);
        
    }
    
    /*
     * updateUser 
     * 
     * Returns all posts
     */
    public function updateUser($name,$pass,$type,$userid){
    
       $query = 'UPDATE '.$this->sqlConfig->getValue('sql-user-table').' SET name="'.$name.'", pass="'.$pass.'", type="'.$type.'" WHERE id="'.$userid.'"';    
        echo "Query: ".$query;
        If($this->mysqli->query($query) == 1){
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=users";
                //-->
            </script>
                    ';
        }else{
            echo 'Error - PL03U005: Failed to update user.';
        }
    }
    
    /*
     * deleteUser 
     * 
     * Returns all posts
     */
    public function deleteUser($userid){
    
        $query = 'DELETE FROM '.$this->sqlConfig->getValue('sql-user-table').' WHERE id='.$userid;
        echo "Query: ".$query;
        
        If($this->mysqli->query($query) == 1){
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=users";
                //-->
            </script>
                    ';
        }else{
            echo 'Error - PL04U004: Failed to delete user.';
        }
    }
    
    /*
     * getAllUsers
     * 
     * Returns all user info
     */
    public function getAllUsers(){
        
        return $this->users;
    }

    /*
     * destructor 
     * 
     * Closes database conection
     */
    function __destruct() {
        
        //--Disconnect from database
        mysqli_close($this->mysqli);
    }
}
?>
