<?php
//--How to use

//--Add this class to what you want to use it with and create an object
//      include ('class.PloaData.php');
//      $ploaData = new PloaData();



class PloaData{

    //--Declare Feilds
    public $posts;
    public $users;
    public $MySQLHandler;
    public $configHandler;

    /*
     * Constructor 
     * 
     * Checks if database matches defined sturcture and creates it if not
     */
    public function __construct($flags = 'none'){
        
        //--Check for post hidding
        if($flags == 'DONT_INCLUDE_CONFIG'){
            $dontIncludeConfig = true;
        }else{
            $dontIncludeConfig = false;
        }
        
        
        if(!($dontIncludeConfig)){
            include('./classes/class.ConfigHandler.php');
        }
        
        $this->configHandler = new ConfigHandler(dirname(__DIR__).'/'.'settings.cfg');
        
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
        
        include ('class.MySQLHandler.php');
        $this->MySQLHandler = new   MySQLHandler(
                                        $this->configHandler->getValue('sql-host'),
                                        $this->configHandler->getValue('sql-user'),
                                        $this->configHandler->getValue('sql-pass'),
                                        $this->configHandler->getValue('sql-database'),
                                        $tableSturcture
                                    );
        
        $this->posts = $this->MySQLHandler->getTable($this->configHandler->getValue('sql-post-table'));
        
        $this->users = $this->MySQLHandler->getTable($this->configHandler->getValue('sql-user-table'));
        
        //---Corrections for previous versions
        
        //--Covert Times to true ISO 8601
        for($c = 0; $c <= count($this->posts)-1 ; $c++){
        
            if(substr($this->posts[$c]['date'],10,1) == ' '){
                    
                $this->posts[$c]['date'] = substr($this->posts[$c]['date'],0,10).'T'.substr($this->posts[$c]['date'],11);
                
                //--Put post data into an array
                $postData = array(
                                $this->posts[$c]['title'],
                                $this->posts[$c]['text'],
                                $this->posts[$c]['date'],
                                $this->posts[$c]['tags'],
                                $this->posts[$c]['status'],
                                $this->posts[$c]['userid'],
                                $this->posts[$c]['displaydate'],
                                $this->posts[$c]['allowcomments']
                            );
                
                $this->MySQLHandler->uptadeEntry($this->configHandler->getValue('sql-post-table'),$this->posts[$c]['id'],$postData);
             
            }
            
            
        
        
        }
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
        
        //--Check for post hidding
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
     * loads posts from the database and filters it down to the specified users'
     * 
     * Returns array of a single user's or multiple users' posts
     * 
     * Flags
     * OMMIT_HIDDEN: Does not include posts with status 0
     * 
     */
    function getUsersPosts($username, $flags = 'none') {
        
        //--Check for post hidding
        if($flags == 'OMMIT_HIDDEN'){
            $ommitHidden = true;
        }else{
            $ommitHidden = false;
        }
        
        //-Find user id
        $userId = $this->getUsersId($username);
        
        //--Filter to only the specified users posts
        for($c = 0; $c <= count($this->posts)-1 ; $c++){
        
            if(is_array($userId)){
            
                for($d = 0;$d <= count($userId)-1; $d++){
                
                    if($this->posts[$c]['userid'] == $userId[$d]){
                    
                        $usersPosts[] = $this->posts[$c];
                    } 
                }
                
                
            }else{   
            
                
                if($this->posts[$c]['userid'] == $userId){
                    
                    $usersPosts[] = $this->posts[$c];
                }
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
    
    /*
     * addPost 
     * 
     * Adds a new post to the database
     */
    function addPost($title,$text,$tags,$status,$userId,$displayDate = '', $allowComments = 1){
        
        if($displayDate == ''){
            $displayDate = date('Y-m-d').'T'.date('H:i:s');
        }
        
        //--Put post data into an array
        $postData = array(
                        $title,
                        $text,
                        date('Y-m-d').'T'.date('H:i:s'),
                        $tags,
                        $status,
                        $userId,
                        $displayDate,
                        $allowComments
                    );
        
        //--Add to database
        return $this->MySQLHandler->addEntry($this->configHandler->getValue('sql-post-table'),$postData);
    }
    
    /*
     * uptadeEntry 
     * 
     * Updates an existing post
     */
    function uptadePost($title,$text,$tags,$status,$postId,$displayDate = '', $allowComments = 1){
        
        //-find post key
        for($c = 0;$c <= count($this->posts)-1;$c++){
           
            if($this->posts[$c]['id'] == $postId){
                
                $postKey = $c;
            }
        }
        
        
        if($displayDate == ''){
            $displayDate = date('Y-m-d').'T'.date('H:i:s');
        }
        
        //--Put post data into an array
        $postData = array(
                        $title,
                        $text,
                        date('Y-m-d').'T'.date('H:i:s'),
                        $tags,
                        $status,
                        $this->posts[$postKey]['userid'],
                        $displayDate,
                        $allowComments
                    );
        
        //--Update database
        return $this->MySQLHandler->uptadeEntry($this->configHandler->getValue('sql-post-table'),$postId,$postData);
    }
    
    
    /*
     * uptadeEntry 
     * 
     * Updates an existing post
     */
    function uptadeEntry($title,$text,$tags,$status,$postId,$displayDate = '', $allowComments = 1){
        
        //-find post key
        for($c = 0;$c <= count($this->posts)-1;$c++){
           
            if($this->posts[$c]['id'] == $postId){
                
                $postKey = $c;
            }
        }
        
        
        if($displayDate == ''){
            $displayDate = date('Y-m-d').'T'.date('H:i:s');
        }
        
        //--Put post data into an array
        $postData = array(
                        $title,
                        $text,
                        date('Y-m-d').'T'.date('H:i:s'),
                        $tags,
                        $status,
                        $this->posts[$postKey]['userid'],
                        $displayDate,
                        $allowComments
                    );
        
        //--Update database
        return $this->MySQLHandler->uptadeEntry($this->configHandler->getValue('sql-post-table'),$postId,$postData);
    }
    
    
    
    
    /*
     * getUsersId 
     * 
     * findes the user's id number
     * 
     * Returns an int or an array of ints with the user id(s)
     * 
     */
    function getUsersId($username) {
    
        
        
        //-Find user id
        for($c = 0;$c <= count($this->users)-1;$c++){
        
            if(is_array($username)){
            
                for($d = 0;$d <= count($username)-1; $d++){
                
                    if($this->users[$c]['name'] == $username[$d]){
                    
                        $userid[] = $this->users[$c]['id'];
                    } 
                }
                
                
            }else{   
            
                if($this->users[$c]['name'] == $username){
                    
                    $userId = $this->users[$c]['id'];
                }
            }
        }
        
        return $userId;
    }
    
}

?>
