<?php
//include ('class.format.php');
//$format = new format();


//--How to use

//--Return Fully Formated Text
//echo $format->fancy();


//--Return Plainly Formated Text
//echo $format->plain($input);

class format {

    function plain($input){
    
        $first = -1;
        $formatFront = '';
        $formatBack = '';
        $letter = 'none';
        $output = $input;
        for($c = 0; $c <= strlen($input); $c++){
            
            
            $letter = substr($input,$c,1);
            
            if($letter == '['){$first = $c;}
            if($letter == ']' && $first != -1){
                
                $toFormatraw = substr($input,$first,$c - $first);
                $toFormatArray = explode(";",$toFormatraw,2);
                
                $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                
                $output = str_replace($toFormatraw.']',$toFormatText, $output);
                $first = -1;
                $formatFront = '';
                $formatBack = '';
                
                
            }
            
        }
    
        $output = str_replace("\n",'</p><p>', $output);
        
        return '<p>'.$output.'</p>';
    }
    
    
    function oneline($input){
    
        $first = -1;
        $formatFront = '';
        $formatBack = '';
        $letter = 'none';
        $output = $input;
        for($c = 0; $c <= strlen($input); $c++){
            
            
            $letter = substr($input,$c,1);
            
            if($letter == '['){$first = $c;}
            if($letter == ']' && $first != -1){
                
                $toFormatraw = substr($input,$first,$c - $first);
                $toFormatArray = explode(";",$toFormatraw,2);
                
                $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                
                $output = str_replace($toFormatraw.']',$toFormatText, $output);
                $first = -1;
                $formatFront = '';
                $formatBack = '';
                
                
            }
            
        }
        
        if(strlen($output) > 100){
            $output = substr($output,0,97).'...';
        }
        
        return $output;
    }

    function fancy($input){
        $first = -1;
        $formatFront = '';
        $formatBack = '';
        $letter = 'none';
        $output = $input;
        for($c = 0; $c <= strlen($input); $c++){
            
            
            $letter = substr($input,$c,1);
            
            if($letter == '['){$first = $c;}
            if($letter == ']' && $first != -1){
                
                $toFormatraw = substr($input,$first,$c - $first);
                $toFormatArray = explode(";",$toFormatraw,2);
                
                $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                $formatCodesArray = explode(",",strtoupper(substr($toFormatArray[0],1,strlen($toFormatArray[0]))));
                
                for($d = 0; $d != count($formatCodesArray);$d++){
                
                    if($formatCodesArray[$d] == 'I'){       $formatFront .= '<em>';     $formatBack = '</em>'.$formatBack;}
                    elseif($formatCodesArray[$d] == 'B'){   $formatFront .= '<strong>'; $formatBack = '</strong>'.$formatBack;}
                    elseif($formatCodesArray[$d] == 'U'){   $formatFront .= '<u>';      $formatBack = '</u>'.$formatBack;}
                    elseif($formatCodesArray[$d] == 'S'){   $formatFront .= '<strike>'; $formatBack = '</strike>'.$formatBack;}
                }
    
                $toFormatText = str_replace("\n",$formatBack.'</p><p>'.$formatFront,$toFormatText);
                $output = str_replace($toFormatraw.']',$formatFront.$toFormatText.$formatBack, $output);
                $first = -1;
                $formatFront = '';
                $formatBack = '';
                
                
            }
            
        }
    
        $output = str_replace("\n",'</p><p>', $output);
        
        return '<p>'.$output.'</p>';
    }
}
