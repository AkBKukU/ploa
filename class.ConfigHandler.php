<?php

class ConfigHandler{
    
    public $settings;
    public $changeSettings = 'butts';
    public $filename = '';
     
    public function __construct($file){
        $this->filename = $file;
        $rawSettingsString = file_get_contents($this->filename);
        
        $rawSetingsArray = explode("\n",$rawSettingsString);
        
        for($c = 0; $c <= count($rawSetingsArray)-1; $c++){
            
            
            for($d = 0; $d <= strlen($rawSetingsArray[$c])-1; $d++){
           
                $letter = substr($rawSetingsArray[$c],$d,1);
                
                if($letter == '#'){$rawSetingsArray[$c] = substr($rawSetingsArray[$c],0,$d);}
                 
            }
           
            
            if(trim(substr($rawSetingsArray[$c],0,1)) != '#'){
                $toTrim = explode(':',$rawSetingsArray[$c],2);
                $toTrim[0] = trim($toTrim[0]);
                $toTrim[1] = trim($toTrim[1]);
                
                $this->settings[] = $toTrim;
            }
       
        }
        
    }
    
    public function getValue($name){
        
        $value = 'Not found';
        
        for($c = 0; $c <= count($this->settings); $c++){
            
            if($this->settings[$c][0] == $name){
                $value = $this->settings[$c][1];
            }
            
       
        }
        
        return $value;
    }
    
    
    public function setValue($name,$newValue){
                
        $this->changeSettings = 'save';
    $key = 'nope';
        for($c = 0; $c <= count($this->settings); $c++){
            
            if($this->settings[$c][0] == $name){
                $this->settings[$c][1] = $newValue;
            $key = $c;
            }
       
        }
        
        return $this->settings[$key][1].'hi';
    }
    
    public function dumpValues(){
        
        return var_dump($this->settings);
    }

   function __destruct() {
        if($this->changeSettings == 'save'){
            $newSettingsString = '';
            
            
            for($c = 0; $c <= count($this->settings)-1; $c++){
                
                $newSettingsString .= $this->settings[$c][0].':'.$this->settings[$c][1]."\n";
           
            }
         
            file_put_contents($this->filename,substr($newSettingsString,0,strlen($newSettingsString)-2));
         
                
        }
   }

}
?>
