<?php
//--How to use

//--Add this class to what you want to use it with and create an object
//      include ('class.MySQLHandler.php');
//      $MySQLHandler = new MySQLHandler();

//--loads data from the specified table
//      $MySQLHandler->getTable($table,$flags)

//--loads entry from the specified table
//      $MySQLHandler->getEntry($table,$entryKey)

//--Adds a new entry to a table
//      $MySQLHandler->addEntry($table,$data,$flags)

//--Modifies an entry from a table
//      $MySQLHandler->uptadeEntry($table,$entryKey,$data,$flags)

//--Deletes an entry from a table
//      $MySQLHandler->deleteEntry($table,$entryKey)

//--Accepts a raw SQL query and executes it
//      $MySQLHandler->rawQuery($query)


/*=======================================tableSturcture Format=======================================*\

                        //--The table names are listed here
$tableSturcture['tables'] = array('main','users');
                        
                        //--The table collumn names to be used as primary keys are put here
$tableSturcture['keys'] = array('id','id');

                        //--The table collumns are listed here with the data types and options
$tableSturcture['collumns'] =   array(
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
                
                


\*===================================================================================================*/


class MySQLHandler{

    //--Declare Feilds
    public $mysqli;
    public $sqlData;
    public $tableSturcture;

    /*
     * Constructor 
     * 
     * Checks if database matches defined sturcture and creates it if not
     */
    public function __construct($host,$user,$pass,$database,$basicTableSturcture){
        
        //--Error output Variable
        $error = 'nope';
        
        //--Convert collumns into just names
        for($c = 0;$c <= count($basicTableSturcture['tables'])-1;$c++){
        
            for($d = 0;$d <= count($basicTableSturcture['collumns'][$c])-1;$d++){
                
                $rawCollumnInfo = explode(' ',$basicTableSturcture['collumns'][$c][$d],2);
                
                $basicTableSturcture['collumnNames'][$c][$d] = $rawCollumnInfo[0];
            }
        }
        
        $this->tableSturcture  = $basicTableSturcture;
        
        
        //--Begin sql connection
        $this->mysqli = new mysqli($host, $user, $pass);
        
        //--Error check and Output
        if ($this->mysqli->connect_errno) {
            echo "Error - MSH02CON001: Failed to connect to MySQL(" . $this->mysqli->connect_errno . ") " . $this->mysqli->connect_error;
        }
        
        
        //Attept to connect to database  
        if(0 == $this->mysqli->select_db($database)){
        
            $query = 'CREATE DATABASE '.$database;
            
            //--Error check and Output
            If($this->mysqli->query($query) == 1){
            
                echo 'Created Database: '.$database."<br />\n";
                    
            }else{
            
                echo 'Error - MSH01D002: Failed to add Database '.$database."<br />\n";
            }
            
        }
        
        //--Check if tables are set
        for($c = 0;$c <= count($this->tableSturcture['tables'])-1;$c++){
        
            //--Check if tables exist    
            if(0 === $this->mysqli->query('SELECT 1 FROM '.$this->tableSturcture['tables'][$c].' LIMIT 1')){
                echo 'Checking Table: '.$this->tableSturcture['tables'][$c]."<br />\n";
                
                //--Define table
                $query = 'CREATE TABLE '.$this->tableSturcture['tables'][$c].'(';
                
                //--Define collumns
                for($d = 0;$d <= count($this->tableSturcture['collumns'][$c])-1;$d++){
                    
                    $query .= $this->tableSturcture['collumns'][$c][$d].', ';
                }
                
                //--Define Primary Key and Finish Query
                $query .= 'PRIMARY KEY('.$this->tableSturcture['keys'][$c].') )';
                
                //--Error check and Output
                If($this->mysqli->query($query) == 1){
                
                    echo 'Created Table: '.$this->tableSturcture['tables'][$c]."<br />\n";
                        
                }else{
                
                    echo 'Error - MSH01T003: Failed to add Table '.$this->tableSturcture['tables'][$c]."<br />\n";
                }   
            
            //--Check if all collumns exist 
            }else{
                unset($result);
                $result = $this->mysqli->query('SELECT * FROM '.$this->tableSturcture['tables'][$c]);
                
                if($result->num_rows > 0) {
                    $row = $result->fetch_assoc();
                    
                    
                    for($d = 0;$d <= count($this->tableSturcture['collumnNames'][$c])-1;$d++){
                    
                        if( !(isset($row[ $this->tableSturcture['collumnNames'][$c][$d] ])) ){
                            $query = 'ALTER TABLE '.$this->tableSturcture['tables'][$c].' ADD '.$this->tableSturcture['collumns'][$c][$d].'';
                            
                            If($this->mysqli->query($query) == 1){
                            
                                echo 'Created Column '.$this->tableSturcture['collumnNames'][$c][$d].'('.$this->tableSturcture['collumns'][$c][$d].")<br />\n";
                                
                            }else{
                                echo 'Error - MSH01C004: Failed to add column '.$this->tableSturcture['collumnNames'][$c][$d].'('.$this->tableSturcture['collumns'][$c][$d].')';
                            }
                        }
                    }
                    
                    
                }
                
                
            }
            
            
        }
    }
    

    /*
     * getTable 
     * 
     * loads data from the specified table
     * 
     * Returns array of table
     * 
     * Flags
     * USE_KEY: Uses the primary key as the index in the output array
     * 
     */
    function getTable($table,$flags = 'none') {
        
        //--Check for primary key override
        if($flags == 'USE_KEY'){
            $useKey = true;
        }else{
            $useKey = false;
        }
    
        //-find table key
        for($c = 0;$c <= count($this->tableSturcture['tables'])-1;$c++){
           
            if($this->tableSturcture['tables'][$c] == $table){
                
                $key = $c;
            }
        }
    
        //-find table primary Key Collumn
        for($c = 0;$c <= count($this->tableSturcture['collumnNames'])-1;$c++){
           
            if($this->tableSturcture['collumnNames'][$key][$c] == $this->tableSturcture['keys'][$key]){
                
                $primaryKeyCollumn = $this->tableSturcture['collumnNames'][$key][$c];
            }
        }
        
        
        
        //--Read entries from table
        $result = $this->mysqli->query('SELECT * FROM '.$this->tableSturcture['tables'][$key]);
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                
                unset($entry);
                for($c = 0;$c <= count($this->tableSturcture['collumnNames'][$key])-1;$c++){
                    
                    $entry[ $this->tableSturcture['collumnNames'][$key][$c] ] = $row[ $this->tableSturcture['collumnNames'][$key][$c] ];
                }
                
                if($useKey){
                    $output[ $entry[$primaryKeyCollumn] ] = $entry;
                }else{
                    $output[] = $entry;
                }
                
            }
        }
        
        
        //--Return table as array
        return $output;
    }
    

    /*
     * getEntry 
     * 
     * loads entry from the specified table
     * 
     * Returns array of the entry
     * 
     */
    function getEntry($table,$entryKey) {
        
    
        //-find table key
        for($c = 0;$c <= count($this->tableSturcture['tables'])-1;$c++){
           
            if($this->tableSturcture['tables'][$c] == $table){
                
                $key = $c;
            }
        }
        
        //-find table primary Key Collumn
        for($c = 0;$c <= count($this->tableSturcture['collumnNames'])-1;$c++){
           
            if($this->tableSturcture['collumnNames'][$key][$c] == $this->tableSturcture['keys'][$key]){
                
                $primaryKeyCollumn = $this->tableSturcture['collumnNames'][$key][$c];
            }
        }
        
        //--Read entries from table
        $result = $this->mysqli->query('SELECT * FROM '.$this->tableSturcture['tables'][$key].' WHERE '.$primaryKeyCollumn.'="'.$entryKey.'"');
        if($result->num_rows > 0) {
            while($row = $result->fetch_assoc()){
                
                
                for($c = 0;$c <= count($this->tableSturcture['collumnNames'][$key])-1;$c++){
                    
                    $entry[ $this->tableSturcture['collumnNames'][$key][$c] ] = $row[ $this->tableSturcture['collumnNames'][$key][$c] ];
                }
                
                $output = $entry;
                
            }
        }
        
        
        //--Return table as array
        return $output;
    }
    
    
    /*
     * addEntry 
     * 
     * Adds a new entry to a table
     * 
     * Returns mysqli->query result
     * 
     * Flags
     * OVERRIDE_KEY: Overides the primary key check letting you specify one
     * 
     */
    function addEntry($table,$data,$flags = 'none') {
        
        //--Check for primary key override
        if($flags == 'OVERRIDE_KEY'){
            $dontSkipKey = true;
        }else{
            $dontSkipKey = false;
        }
        
        //-find table key
        for($c = 0;$c <= count($this->tableSturcture['tables'])-1;$c++){
           
            if($this->tableSturcture['tables'][$c] == $table){
                
                $key = $c;
            }
        }
        
        //--Start query
        $query = 'INSERT INTO '.$this->tableSturcture['tables'][$key].' (';
        
        //--Get collumns
        for($c = 0;$c <= count($this->tableSturcture['collumnNames'][$key])-1;$c++){
        
            //--Check for Primary Key
            if($this->tableSturcture['collumnNames'][$key][$c] != $this->tableSturcture['keys'][$key] || $dontSkipKey){
            
                $nextComma = '';
                if( !($c+1 > count($this->tableSturcture['collumnNames'][$key])-1) ){
                    $nextComma = ', ';
                }
                $query .= $this->tableSturcture['collumnNames'][$key][$c].$nextComma;
            }
        }
        
        //--End Collumns and start Values
        $query .= ') VALUES (';
        
        //--Get collumns
        for($c = 0;$c <= count($data)-1;$c++){
        
            $nextComma = '';
            if( !($c+1 > count($data)-1) ){
                $nextComma = ', ';
            }
            $query .= ' "'.$data[$c].'"'.$nextComma;
        }
        
        //--End query
        $query .= ')';
        
        //--Executes query and returns result
        return $this->mysqli->query($query);
        
        
    }
    

    /*
     * uptadeEntry 
     * 
     * Modifies an entry from a table
     * 
     * Returns mysqli->query result
     * 
     * Flags
     * OVERWRITE_KEY: Overides the primary key check letting you overwrite it
     * 
     */
    function uptadeEntry($table,$entryKey,$data,$flags = 'none') {
        
        //--Check for primary key override
        if($flags == 'OVERWRITE_KEY'){
            $dontSkipKey = true;
        }else{
            $dontSkipKey = false;
        }
        
        //-find table key
        for($c = 0;$c <= count($this->tableSturcture['tables'])-1;$c++){
           
            if($this->tableSturcture['tables'][$c] == $table){
                
                $key = $c;
            }
        }
        
        //--Start query
        $query = 'UPDATE '.$this->tableSturcture['tables'][$key].' SET ';
        
        //--Get collumns
        for($c = 0;$c <= count($this->tableSturcture['collumnNames'][$key])-1;$c++){
        
            //--Check for Primary Key
            if($this->tableSturcture['collumnNames'][$key][$c] != $this->tableSturcture['keys'][$key] || $dontSkipKey){
            
                $filteredCollumns[] = $this->tableSturcture['collumnNames'][$key][$c];
            }
        }
                
        //--Get collumns
        for($c = 0;$c <= count($data)-1;$c++){
        
            $nextComma = '';
            if( !($c+1 > count($data)-1) ){
                $nextComma = ', ';
            }
            $query .= $filteredCollumns[$c].'="'.$data[$c].'"'.$nextComma;
        }
        
        //--End query
        $query .= ' WHERE id="'.$entryKey.'"';
        
        //--Executes query and returns result
        return $this->mysqli->query($query);
        
        
    }
    

    /*
     * deleteEntry 
     * 
     * Deletes an entry from a table
     * 
     * Returns mysqli->query result
     * 
     */
    function deleteEntry($table,$entryKey) {
                
        //-find table key
        for($c = 0;$c <= count($this->tableSturcture['tables'])-1;$c++){
           
            if($this->tableSturcture['tables'][$c] == $table){
                
                $key = $c;
            }
        }
        
        //--Form query
        $query = 'DELETE FROM '.$this->tableSturcture['tables'][$key].' WHERE id="'.$entryKey.'"';
        
        
        //--Executes query and returns result
        return $this->mysqli->query($query);
        
        
    }
    

    /*
     * rawQuery 
     * 
     * Accepts a raw SQL query and executes it
     */
    function rawQuery($query) {
        
        //--Executes query and returns result
        return $this->mysqli->query($query);
        
        
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
/*===============================================================Error Code Guide===============================================================*\
 *                                                                                                                                              *
 * Here is and example code                                                                                                                     *
 *                                                                                                                                              *
 *        MSH01E001                                                                                                                             *
 *                                                                                                                                              *
 * [MSH] The first three characters represent that it is  a MySQLHandler error.                                                                 * 
 *                                                                                                                                              *
 * [01] The next two numbers representthe action type. Here are the actions and their codes:                                                    *
 *                                                                                                                                              *
 * - 00: Undefined                                                                                                                              *
 * - 01: Write                                                                                                                                  *
 * - 02: Read                                                                                                                                   *
 * - 03: Modify                                                                                                                                 *
 * - 04: Delete                                                                                                                                 *
 *                                                                                                                                              *
 * [P] The next character identifies whether is was a connection(CON), database(D), table(T), collumn(C), or entry(E) error.                    *
 *                                                                                                                                              *
 * [001] The next three numbers identify a particular peice  of code. They will show where the error happened. Here are the identities:         *
 *                                                                                                                                              *
 * 001: Failed to connect to MySQL                                                                                                              *
 * 002: Failed to add Database                                                                                                                  *
 * 003: Failed to add Table                                                                                                                     *
 * 004: Failed to add column                                                                                                                    *
 *                                                                                                                                              *
 *                                                                                                                                              *
\*===============================================================Error Code Guide===============================================================*/
?>
