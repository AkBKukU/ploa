<?php
//include ('class.LoadPosts.php');
//$LoadPosts = new LoadPosts();


//--How to use

//--Returns all posts in an array
//echo $LoadPosts->getPosts($input);


class LoadPosts{

    //--Declare Feilds
    public $posts;

    /*
     * Constructor 
     * 
     * Loads all post info into an array
     */
    public function __construct(){
        //--Load Configuration Files
        $sqlConfig = new ConfigHandler(dirname(__DIR__).'/'.'settings.cfg');


        //--Begin sql connection
        $mysqli = new mysqli($sqlConfig->getValue('sql-host'), $sqlConfig->getValue('sql-user'), $sqlConfig->getValue('sql-pass'));
        
        if ($mysqli->connect_errno) {
            echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
        }
        
        //Check if blog database exist    
        if(0 == $mysqli->select_db($sqlConfig->getValue('sql-database'))){
            $mysqli->query('CREATE DATABASE '.$sqlConfig->getValue('sql-database'));
            echo 'Created '.$config->getValue('sql-database').' database';
        }
        
        //--Check if blog table exist    
        if(0 == $mysqli->query('SELECT 1 FROM '.$sqlConfig->getValue('sql-table').' LIMIT 1')){
            $mysqli->query('CREATE TABLE '.$sqlConfig->getValue('sql-table').'(
                                id INT NOT NULL AUTO_INCREMENT, 
                                PRIMARY KEY(id),
                                title TEXT,
                                text TEXT,
                                date TEXT,
                                tags TEXT,
                                status INT
            )');
            echo 'Created '.$sqlConfig->getValue('sql-table').' table';
        }
        
        
        //--Read posts from table
        $result =    $mysqli->query('SELECT * FROM '.$sqlConfig->getValue('sql-table'));
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $this->posts[] = array(  
                    'title' => $row['title'], 
                    'text' => $row['text'], 
                    'id' => $row['id'],
                    "date" => $row['date'],
                    'status' => $row['status']
                    );    
                
            }
        }
        
        for($c = 0; $c < count($this->posts); $c++){    
            $this->posts[$c]['year'] = substr($this->posts[$c]['date'],0,4);
            $this->posts[$c]['month'] = substr($this->posts[$c]['date'],5,2);
            $this->posts[$c]['day'] = substr($this->posts[$c]['date'],8,2);
            $this->posts[$c]['formdate'] = $this->posts[$c]['month'].'/'.$this->posts[$c]['day'].'/'.$this->posts[$c]['year'] ;
        
        }
        
        //--Disconnect from database
        mysqli_close($mysqli);
        
    }
    
    /*
     * getPosts 
     * 
     * Returns all posts in an array that are mark with status 1
     */
    public function getPosts(){
        
        for($c = 0;$c <= count($this->posts)-1; $c++){
            if($this->posts[$c]['status'] != 0){
                $shownPosts[] = array(  
                            'title' => $this->posts[$c]['title'], 
                            'text' => $this->posts[$c]['text'], 
                            'id' => $this->posts[$c]['id'],
                            "date" => $this->posts[$c]['date'],
                            'year' => $this->posts[$c]['year'], 
                            'month' => $this->posts[$c]['month'], 
                            'day' => $this->posts[$c]['day'],
                            'formdate' => $this->posts[$c]['formdate']
                            );   
            } 
        }
        
        
        
        return $shownPosts;
    }
    
    /*
     * getAllPosts 
     * 
     * Returns all posts
     */
    public function getAllPosts(){
        
        return $this->posts;
    }
}
?>
