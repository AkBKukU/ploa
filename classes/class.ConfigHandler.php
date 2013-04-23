<?php
//include ('class.ConfigHandler.php');
//$config = new ConfigHandler('file.cfg');


//--How to use

//--Returns a single setting entry
//echo $config->getValue();

//--Sets a single setting entry
//echo $config->setValue();

//--Print all settings in array
//echo $config->dumpValues();


class ConfigHandler{
    
    //--Declare Feilds
    public $settings;
    public $changeSettings = 'butts';
    public $filename = '';
     
    /*
     * Constructor 
     * 
     * Loads all the values from the given file into an array
     */
    public function __construct($file){
        $this->filename = $file;
        $rawSettingsString = file_get_contents($this->filename);
        
        //--Splits file into an array at each line
        $rawSetingsArray = explode("\n",$rawSettingsString);
        
        //--Each line to get final array
        for($c = 0; $c <= count($rawSetingsArray)-1; $c++){
            
            //--Check for a "#" denoting a comment
            for($d = 0; $d <= strlen($rawSetingsArray[$c])-1; $d++){
           
                $letter = substr($rawSetingsArray[$c],$d,1);
                
                if($letter == '#'){$rawSetingsArray[$c] = substr($rawSetingsArray[$c],0,$d);}
                 
            }
           
            //--Splits the array at the ":" and removes whitespaces
            if(trim(substr($rawSetingsArray[$c],0,1)) != '#'){
                $toTrim = explode(':',$rawSetingsArray[$c],2);
                if(isset($toTrim[0])){$toTrim[0] = trim($toTrim[0]);}
                if(isset($toTrim[1])){$toTrim[1] = trim($toTrim[1]);}
                
                $this->settings[] = $toTrim;
            }
       
        }
        
    }
    
    /*
     * getValue 
     * 
     * Returns the value of the specified setting
     */
    public function getValue($name){
        
        $value = 'Not found';
        
        //--Checks array for the name of the setting
        for($c = 0; $c <= count($this->settings)-1; $c++){
            
            if($this->settings[$c][0] == $name){
                $value = $this->settings[$c][1];
            }
            
       
        }
        
        return $value;
    }
    
    
    /*
     * setValue 
     * 
     * Sets the value of the specified setting
     */
    public function setValue($name,$newValue){
                
        $this->changeSettings = 'save';
        $key = 'nope';
        for($c = 0; $c <= count($this->settings); $c++){
            
            if($this->settings[$c][0] == $name){
                $this->settings[$c][1] = $newValue;
            $key = $c;
            }
       
        }
        
        if($key == 'nope'){
            $this->addValue($name,$newValue);
        }
            
        return $this->settings[$key][1].'hi';
    }
    
    /*
     * addValue 
     * 
     * Adds a new value to the settings array
     */
    public function addValue($newname,$newValue){
                
        $this->settings[][0] = $newname;
        $this->settings[][1] = $newValue;
            
        
    }
    
    /*
     * dumpValues 
     * 
     * Returns all values of the array of settings
     */
    public function dumpValues(){
        
        return var_dump($this->settings);
    }

    /*
     * destructor 
     * 
     * Saves all settings to the file if there has been a chenge
     */
    function __destruct() {
        
        //--Tests if a change has been declared
        if($this->changeSettings == 'save'){
            $newSettingsString = '';

            //--Creates new file in a string
            for($c = 0; $c <= count($this->settings)-1; $c++){

                $newSettingsString .= $this->settings[$c][0].':'.$this->settings[$c][1]."\n";

            }
            
            //--Prints new file
            file_put_contents($this->filename,substr($newSettingsString,0,strlen($newSettingsString)-2));
         
                
        }
    }

}
?>
