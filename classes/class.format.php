<?php
//include ('class.format.php');
//$format = new format();


//--How to use

//--Returns Plainly Formated Text
//echo $format->plain($input);

//--Returns a short version of the post in plain formatting with no tags
//echo $format->online();

//--Returns Fully Formated Text
//echo $format->fancy();


class format {
    
    /*
     * plain 
     * 
     * Returns Plainly Formated Text
     */
    function plain($input){
        
        //--Set intial values
        $first = -1;
        $formatFront = '';
        $formatBack = '';
        $letter = 'none';
        $output = $input;
        
        //--Run through string to check for special characters
        for($c = 0; $c <= strlen($input); $c++){
            
            
            $letter = substr($input,$c,1);
            
            //--Tests if a special character has been found
            if($letter == '['){$first = $c;}
            if($letter == ']' && $first != -1){
                
                //--Find formatting 
                $toFormatraw = substr($input,$first,$c - $first);
                $toFormatArray = explode(";",$toFormatraw,2);
                
                $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                
                //--Strips formatting 
                $output = str_replace($toFormatraw.']',$toFormatText, $output);
                $first = -1;
                $formatFront = '';
                $formatBack = '';
                
                
            }
            
        }
        
        //--Handles the newlines
        $output = str_replace("\n",'</p><p>', $output);
        
        //--Returns Plainly Formated Text
        return '<p>'.$output.'</p>';
    }
    
    
    /*
     * plain 
     * 
     * Returns a short version of the post in plain formatting with no tags
     */
    function oneline($input){
    
        //--Set intial values
        $first = -1;
        $formatFront = '';
        $formatBack = '';
        $letter = 'none';
        $output = $input;
        
        //--Run through string to check for special characters
        for($c = 0; $c <= strlen($input); $c++){
            
            
            $letter = substr($input,$c,1);
            
            //--Tests if a special character has been found
            if($letter == '['){$first = $c;}
            if($letter == ']' && $first != -1){
                
                //--Find formatting 
                $toFormatraw = substr($input,$first,$c - $first);
                $toFormatArray = explode(";",$toFormatraw,2);
                
                $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                
                //--Strips formatting 
                $output = str_replace($toFormatraw.']',$toFormatText, $output);
                $first = -1;
                $formatFront = '';
                $formatBack = '';
                
                
            }
            
        }
        
        //--Limits text length to 100 characters
        if(strlen($output) > 100){
            $output = substr($output,0,97).'...';
        }
        
        //--Returns short plain text
        return $output;
    }

    /*
     * fancy 
     * 
     * Returns Fully Formated Text
     */
    function fancy($input){
    
        //--Set intial values
        $first = -1;
        $formatFront = '';
        $formatBack = '';
        $letter = 'none';
        $output = $input;
        
        //--Run through string to check for special characters
        for($c = 0; $c <= strlen($input); $c++){
            
            
            $letter = substr($input,$c,1);
            
            //--Tests if a special character has been found
            if($letter == '['){$first = $c;}
            if($letter == ']' && $first != -1){
                
                //--Find formatting 
                $toFormatraw = substr($input,$first,$c - $first);
                $toFormatArray = explode(";",$toFormatraw,2);
                
                $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                $formatCodesArray = explode(",",strtoupper(substr($toFormatArray[0],1,strlen($toFormatArray[0]))));
                
                //--Get formats used
                for($d = 0; $d != count($formatCodesArray);$d++){
                
                    if($formatCodesArray[$d] == 'I'){       $formatFront .= '<em>';     $formatBack = '</em>'.$formatBack;}
                    elseif($formatCodesArray[$d] == 'B'){   $formatFront .= '<strong>'; $formatBack = '</strong>'.$formatBack;}
                    elseif($formatCodesArray[$d] == 'U'){   $formatFront .= '<u>';      $formatBack = '</u>'.$formatBack;}
                    elseif($formatCodesArray[$d] == 'S'){   $formatFront .= '<strike>'; $formatBack = '</strike>'.$formatBack;}
                }
    
                //--Embeds formatting 
                $toFormatText = str_replace("\n",$formatBack.'</p><p>'.$formatFront,$toFormatText);
                $output = str_replace($toFormatraw.']',$formatFront.$toFormatText.$formatBack, $output);
                $first = -1;
                $formatFront = '';
                $formatBack = '';
                
                
            }
            
        }
    
        //--Handles the newlines
        $output = str_replace("\n",'</p><p>', $output);
        
        //--Returns Fully Formated Text
        return '<p>'.$output.'</p>';
    }
}
