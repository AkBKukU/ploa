<?php
//--How to use

//--Add this class to what you want to use it with and create an object
//      include ('class.PloaDataHandler.php');
//      $PloaDataHandler = new PloaDataHandler();



class PloaDataHandler{

    //--Declare Feilds
    public $posts;
    public $users;

    /*
     * Constructor 
     * 
     * Checks if database matches defined sturcture and creates it if not
     */
    public function __construct(){
        
        include('./classes/class.ConfigHandler.php');
        
        $config = new ConfigHandler(dirname(__DIR__).'/'.'settings.cfg');
        
        $tableSturcture ['tables'] = array('main','users');

        $tableSturcture ['collumns'] =  array(
                                            array(
                                                'id INT NOT NULL AUTO_INCREMENT',
                                                'title TEXT',
                                                'text TEXT',
                                                'date TEXT',
                                                'tags TEXT',
                                                'status INT',
                                                'userid INT',
                                                'displaydate TEXT',
                                                'allowcomments INT'
                                            ),
                                            array(
                                                'id INT NOT NULL AUTO_INCREMENT',
                                                'name TEXT',
                                                'pass TEXT',
                                                'postcount INT',
                                                'type INT',
                                                'blogtitle TEXT',
                                                'blogurl TEXT',
                                                'blogpoststoshow INT',
                                                'blogshowtitle INT',
                                                'blogshownav INT',
                                                'blognavusestyle INT',
                                                'blognavtype TEXT',
                                                'blogfull TEXT',
                                                'blogheader TEXT',
                                                'blognav TEXT',
                                                'blogpost TEXT',
                                                'blogpostheader TEXT',
                                                'pagebuttons TEXT',
                                                'buttonsinblog INT'
                                            )
                                        );
                                
        $tableSturcture ['keys'] = array('id','id');

        
        $MySQLHandler = new MySQLHandler(
                                $config->getValue('sql-host'),
                                $config->getValue('sql-user'),
                                $config->getValue('sql-pass'),
                                $config->getValue('sql-database'),
                                $tableSturcture
                            );
        
        include ('class.MySQLHandler.php');
        $MySQLHandler = new MySQLHandler(
                                $config->getValue('sql-host'),
                                $config->getValue('sql-user'),
                                $config->getValue('sql-pass'),
                                $config->getValue('sql-database'),
                                $tableSturcture
                            );
        
        $this->posts = $MySQLHandler->getTable($config->getValue('sql-post-table'));
        
        $this->users = $MySQLHandler->getTable($config->getValue('sql-user-table'));
        
        
    }
    

    /*
     * getPosts 
     * 
     * loads posts from the database
     * 
     * Returns array of posts table
     * 
     * Flags
     * OMMIT_HIDDEN: Does not include posts with status 0
     * 
     */
    function getPosts($flags = 'none') {
        
        //--Check for primary key override
        if($flags == 'OMMIT_HIDDEN'){
            $ommitHidden = true;
        }else{
            $ommitHidden = false;
        }
        
        //--Checks to see whether or not to include hidden posts
        if($ommitHidden){
            
            for($c = 0; $c <= count($this->posts) ; $c++){
                
                if($this->posts[$c]['status'] != 0){
                    
                    $output[] = $this->posts[$c];
                } 
            }
            
        }else{
            
            $output = $this->posts;
        }
    
        //--Return table as array
        return $output;
    }
    

    /*
     * getUsersPosts 
     * 
     * loads posts from the database and filters it down to one user's
     * 
     * Returns array of a single user's posts
     * 
     * Flags
     * OMMIT_HIDDEN: Does not include posts with status 0
     * 
     */
    function getUsersPosts($username, $flags = 'none') {
        
        //--Check for primary key override
        if($flags == 'OMMIT_HIDDEN'){
            $ommitHidden = true;
        }else{
            $ommitHidden = false;
        }
        
        //-Find user id
        for($c = 0;$c <= count($this->users)-1;$c++){
           
            if($this->users[$c]['name'] == $username){
                
                $userId = $this->users[$c]['id'];
            }
        }
        
        //--Filter to only the specified users posts
        for($c = 0; $c <= count($this->posts) ; $c++){
                
            if($this->posts[$c]['userid'] == $userId){
                
                $usersPosts[] = $this->posts[$c];
            }
        }
        
        
        //--Checks to see whether or not to include hidden posts
        if($ommitHidden){
            
            for($c = 0; $c <= count($usersPosts) ; $c++){
                
                if($usersPosts[$c]['status'] != 0){
                    
                    $output[] = $usersPosts[$c];
                } 
            }
            
        }else{
            
            $output = $usersPosts;
        }
    
        //--Return table as array
        return $output;
    }
    
}

?>
