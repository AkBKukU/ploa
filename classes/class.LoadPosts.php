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
                                userid INT
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
                                type INT
            )');
            echo 'Created '.$this->sqlConfig->getValue('sql-table').' table';
            
            $query = 'INSERT INTO '.$this->sqlConfig->getValue('sql-user-table').' (name,pass) VALUES ("admin","password")';
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
                    'type' => $row['type']
                    );    
                
            }
        }
        
        for($c = 0; $c < count($this->posts); $c++){    
            $this->posts[$c]['year'] = substr($this->posts[$c]['date'],0,4);
            $this->posts[$c]['month'] = substr($this->posts[$c]['date'],5,2);
            $this->posts[$c]['day'] = substr($this->posts[$c]['date'],8,2);
            $this->posts[$c]['formdate'] = $this->posts[$c]['month'].'/'.$this->posts[$c]['day'].'/'.$this->posts[$c]['year'] ;
        
        }
        
        
    }
    
    /*
     * getPosts 
     * 
     * Returns all posts in an array that are mark with status 1
     */
    public function getPosts($username){
        
        for($c = 0;$c <= count($this->users)-1; $c++){
            if($this->users[$c]['name'] == $username){
                $userid = $this->users[$c]['id'];
            } 
        }
        
        for($c = 0;$c <= count($this->posts)-1; $c++){
            if($this->posts[$c]['userid'] == $userid){
                $userPosts[] = array(  
                            'title' => $this->posts[$c]['title'], 
                            'text' => $this->posts[$c]['text'], 
                            'id' => $this->posts[$c]['id'],
                            'userid' => $this->posts[$c]['userid'],
                            "date" => $this->posts[$c]['date'],
                            'tags' => $this->posts[$c]['tags'], 
                            'year' => $this->posts[$c]['year'], 
                            'month' => $this->posts[$c]['month'], 
                            'day' => $this->posts[$c]['day'],
                            'formdate' => $this->posts[$c]['formdate'],
                            'status' => $this->posts[$c]['status']
                            );   
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
                $theuser = array(  
                    'name' => $this->users[$c]['name'], 
                    'pass' => $this->users[$c]['pass'], 
                    'id' => $this->users[$c]['id'],
                    "postcount" => $this->users[$c]['postcount'],
                    'type' => $this->users[$c]['type']
                    );   
                
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
        echo "Query: ".$query;
        echo "Result: ".$this->mysqli->query($query);
        
    }
    
    /*
     * addUser
     * 
     * Creates a new user
     */
    public function addUser($name,$pass,$type){
        
        $query = 'INSERT INTO '.$this->sqlConfig->getValue('sql-user-table').' (name,pass,type,postcount) VALUES ("'.$name.'","'.$pass.'","'.$type.'","0")';
        echo "Query: ".$query;
        $this->mysqli->query($query);
        
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
