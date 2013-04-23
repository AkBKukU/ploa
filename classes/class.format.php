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
        
        $found = true;
        
        while($found){
        
            $input = $output;
            //--Run through string to check for special characters
            for($c = 0; $c <= strlen($input); $c++){
                
                
                $letter = substr($input,$c,1);
                
                //--Tests if a special character has been found
                if($letter == '['){$level++;$firstBrace[$level] = $c;}
                elseif($letter == ']' && $firstBrace[$level] != -1){
                    
                    //--Find formatting 
                    $toFormatraw = substr($input,$firstBrace[$level],$c - $firstBrace[$level]);
                    $toFormatArray = explode(";",$toFormatraw,2);
                    
                    $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                    $formatCodesArray = explode(",",strtoupper(substr($toFormatArray[0],1,strlen($toFormatArray[0]))));
                    
                    //--Strip Formatting
                    for($d = 0; $d != count($formatCodesArray);$d++){
                    
                        if($formatCodesArray[$d] == 'LINK'){
                            
                            $anchorArray = explode(";",$toFormatText,3);
                            $toFormatText = $anchorArray[1];
                            
                        }elseif($formatCodesArray[$d] == 'IMAGE'){
                            $imageArray = explode(";",$toFormatText,3);
                            if(trim($imageArray[1])  == '' || !(isset($imageArray[1])) ){
                                $toFormatText = '<strong>|You need to add an alt tag to the image!|</strong>';
                            }else{
                                $toFormatText = '|Image Alt: '.$imageArray[1].'|';}
                            
                        }elseif($formatCodesArray[$d] == 'PLACE'){
                            $placeArray = explode(";",$toFormatText,2);
                            $toFormatText = $placeArray[1];
                            
                        }elseif($formatCodesArray[$d] == 'WIDTH'){
                            $widthArray = explode(";",$toFormatText,3);
                            $toFormatText = $widthArray[2];
                            
                        }elseif($formatCodesArray[$d] == 'COLOR' || $formatCodesArray[$d] == 'COLOUR' ){
                            $colourArray = explode(";",$toFormatText,2);
                            $toFormatText = $colourArray[1];
                            
                        }elseif($formatCodesArray[$d] == 'SIZE'){
                            $colourArray = explode(";",$toFormatText,2);
                            $toFormatText = $colourArray[1];
                            
                        }elseif($formatCodesArray[$d] == 'CSS'){
                            $cssArray = explode(";",$toFormatText,2);
                            $toFormatText = $cssArray[1];
                        }
                    }
        
                    //--Embeds formatting 
                    $toFormatText = str_replace("\n",$formatBack.'</p><p>'.$formatFront,$toFormatText);
                    $output = str_replace($toFormatraw.']',$formatFront.$toFormatText.$formatBack, $output);
                    $firstBrace[$level] = -1;
                    $formatFront = '';
                    $formatBack = '';
                    $level--;
                    $found = true;
                    break;
                }else{$found = false;}
                
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
        
        $found = true;
        
        while($found){
        
            $input = $output;
            //--Run through string to check for special characters
            for($c = 0; $c <= strlen($input); $c++){
                
                
                $letter = substr($input,$c,1);
                
                //--Tests if a special character has been found
                if($letter == '['){$level++;$firstBrace[$level] = $c;}
                elseif($letter == ']' && $firstBrace[$level] != -1){
                    
                    //--Find formatting 
                    $toFormatraw = substr($input,$firstBrace[$level],$c - $firstBrace[$level]);
                    $toFormatArray = explode(";",$toFormatraw,2);
                    
                    $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                    $formatCodesArray = explode(",",strtoupper(substr($toFormatArray[0],1,strlen($toFormatArray[0]))));
                    
        
                    //--Strip Formatting
                    for($d = 0; $d != count($formatCodesArray);$d++){
                    
                        if($formatCodesArray[$d] == 'LINK'){
                            $anchorArray = explode(";",$toFormatText,3);
                            $toFormatText = $anchorArray[1];
                            
                        }elseif($formatCodesArray[$d] == 'IMAGE'){
                            $imageArray = explode(";",$toFormatText,3);
                            if(trim($imageArray[1])  == '' || !(isset($imageArray[1])) ){
                                $toFormatText = '[b;|You need to add an alt tag to the image!|]';
                            }else{
                                $toFormatText = '|Image Alt: '.$imageArray[1].'|';}
                            
                        }elseif($formatCodesArray[$d] == 'PLACE'){
                            $placeArray = explode(";",$toFormatText,2);
                            $toFormatText = $placeArray[1];
                            
                        }elseif($formatCodesArray[$d] == 'WIDTH'){
                            $widthArray = explode(";",$toFormatText,3);
                            $toFormatText = $widthArray[2];
                            
                        }elseif($formatCodesArray[$d] == 'COLOR' || $formatCodesArray[$d] == 'COLOUR' ){
                            $colourArray = explode(";",$toFormatText,2);
                            $toFormatText = $colourArray[1];
                            
                        }elseif($formatCodesArray[$d] == 'SIZE'){
                            $colourArray = explode(";",$toFormatText,2);
                            $toFormatText = $colourArray[1];
                            
                        }elseif($formatCodesArray[$d] == 'CSS'){
                            $cssArray = explode(";",$toFormatText,2);
                            $toFormatText = $cssArray[1];
                        }
                    }
                    
                    //--Embeds formatting 
                    $toFormatText = str_replace("\n",$formatBack.' '.$formatFront,$toFormatText);
                    $output = str_replace($toFormatraw.']',$formatFront.$toFormatText.$formatBack, $output);
                    $firstBrace[$level] = -1;
                    $formatFront = '';
                    $formatBack = '';
                    $level--;
                    $found = true;
                    break;
                }else{$found = false;}
                
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
        $level = 0;
        $firstBrace[$level] = -2;
        $formatFront = '';
        $formatBack = '';
        $letter = 'none';
        $output = $input;
        
        $found = true;
        
        while($found){
        
            $input = $output;
            //--Run through string to check for special characters
            for($c = 0; $c <= strlen($input); $c++){
                
                
                $letter = substr($input,$c,1);
                
                //--Tests if a special character has been found
                if($letter == '['){$level++;$firstBrace[$level] = $c;}
                elseif($letter == ']' && $firstBrace[$level] != -1){
                    
                    //--Find formatting 
                    $toFormatraw = substr($input,$firstBrace[$level],$c - $firstBrace[$level]);
                    $toFormatArray = explode(";",$toFormatraw,2);
                    
                    $toFormatText = substr($toFormatArray[1],0,strlen($toFormatArray[1]));
                    $formatCodesArray = explode(",",strtoupper(substr($toFormatArray[0],1,strlen($toFormatArray[0]))));
                    
                    //--Get formats used
                    for($d = 0; $d != count($formatCodesArray);$d++){
                    
                        if($formatCodesArray[$d] == 'I'){       $formatFront .= '<em>';     $formatBack = '</em>'.$formatBack;}
                        elseif($formatCodesArray[$d] == 'B'){   $formatFront .= '<strong>'; $formatBack = '</strong>'.$formatBack;}
                        elseif($formatCodesArray[$d] == 'U'){   $formatFront .= '<u>';      $formatBack = '</u>'.$formatBack;}
                        elseif($formatCodesArray[$d] == 'S'){   $formatFront .= '<strike>'; $formatBack = '</strike>'.$formatBack;}
                        elseif($formatCodesArray[$d] == 'LIST'){$formatFront .= '</p><ul><li>'; $formatBack = '</li></ul><p> '.$formatBack;
                            $toFormatText = str_replace("\n",'</li><li>',$toFormatText);} 
                        elseif($formatCodesArray[$d] == 'NUMLIST'){$formatFront .= '</p><ol><li>'; $formatBack = '</li></ol><p> '.$formatBack;
                            $toFormatText = str_replace("\n",'</li><li>',$toFormatText);} 
                        elseif($formatCodesArray[$d] == 'LINK'){
                            $anchorArray = explode(";",$toFormatText,3);
                            $toFormatText = $anchorArray[1];
                            $formatFront .= '<a href="'.$anchorArray[0].'" title="'.$anchorArray[2].'">'; $formatBack = '</a> '.$formatBack;}
                        elseif($formatCodesArray[$d] == 'IMAGE'){
                            $imageArray = explode(";",$toFormatText,3);
                            $toFormatText = '';
                            if(trim($imageArray[1])  == '' || !(isset($imageArray[1])) ){
                                $toFormatText = '[b;|You need to add an alt tag to the image!|]';
                            }else{
                                $formatFront .= '<img src="'.$imageArray[0].'" alt="'.$imageArray[1].'" title="'.$imageArray[2].'">';
                                ;}  
                        }
                        elseif($formatCodesArray[$d] == 'PLACE'){
                            $placeArray = explode(";",$toFormatText,2);
                            if( strtoupper($placeArray[0]) == 'CENTER'){
                                $styleType = 'text-align:center;';
                            }elseif(strtoupper($placeArray[0]) == 'LEFT'){
                                $styleType = 'text-align:left;';
                            }elseif(strtoupper($placeArray[0]) == 'RIGHT'){
                                $styleType = 'text-align:right;';
                            }elseif(strtoupper($placeArray[0]) == 'WRAPLEFT'){
                                $styleType = 'display:inline-block;float:left;margin: 0 1em;';
                            }elseif(strtoupper($placeArray[0]) == 'WRAPRIGHT'){
                                $styleType = 'display:inline-block;float:right;margin: 0 1em;';
                            }
                            $formatFront .= '<div style="'.$styleType.'" >';
                            $formatBack = '</div> '.$formatBack;
                            $toFormatText = $placeArray[1];
                            $styleType = '';
                        } 
                         
                        elseif($formatCodesArray[$d] == 'WIDTH'){
                            $styleType = '';
                            $widthArray = explode(";",$toFormatText,3);
                            if( strtoupper($widthArray[0]) == 'EM'){
                                $styleType = 'width: '.$widthArray[1].'em;';
                            }elseif(strtoupper($widthArray[0]) == 'CHAR'){
                                $styleType = 'width: '.$widthArray[1].'em;';
                            }elseif(strtoupper($widthArray[0]) == 'PX'){
                                $styleType = 'width: '.$widthArray[1].'px;';
                            }elseif(strtoupper($widthArray[0]) == 'PIXELS'){
                                $styleType = 'width: '.$widthArray[1].'px;';
                            }elseif(strtoupper($widthArray[0]) == 'PERCENT'){
                                $styleType = 'width: '.$widthArray[1].'%;';
                            }elseif(strtoupper($widthArray[0]) == '%'){
                                $styleType = 'width: '.$widthArray[1].'%;';
                            }
                            $formatFront .= '<div style="'.$styleType.'" >';
                            $formatBack = '</div> '.$formatBack;
                            $toFormatText = $widthArray[2];
                        } 
                          
                        elseif($formatCodesArray[$d] == 'COLOR' || $formatCodesArray[$d] == 'COLOUR' ){
                            $colourArray = explode(";",$toFormatText,2);
                            if( strtoupper($colourArray[0]) == 'RED'){
                                $styleType = 'color: #ff0000;';
                            }elseif(strtoupper($colourArray[0]) == 'GREEN'){
                                $styleType = 'color: #00ff00;';
                            }elseif(strtoupper($colourArray[0]) == 'BLUE'){
                                $styleType = 'color: #0000ff;';
                            }elseif(strtoupper($colourArray[0]) == 'YELLOW'){
                                $styleType = 'color: #ffff00;';
                            }elseif(strtoupper($colourArray[0]) == 'CYAN'){
                                $styleType = 'color: #00ffff;';
                            }elseif(strtoupper($colourArray[0]) == 'PURPLE'){
                                $styleType = 'color: #ff00ff;';
                            }else{
                                $styleType = 'color: '.$colourArray[0].';';
                            }
                            $formatFront .= '<div style="'.$styleType.'" >';
                            $formatBack = '</div> '.$formatBack;
                            $toFormatText = $colourArray[1];
                            $styleType = '';
                        }
                        elseif($formatCodesArray[$d] == 'SIZE'){
                            $colourArray = explode(";",$toFormatText,2);
                            if( strtoupper($colourArray[0]) == 'HUGE'){
                                $styleType = 'display:inline;font-size: 4em;';
                            }elseif( strtoupper($colourArray[0]) == 'BIG'){
                                $styleType = 'display:inline;font-size: 2em;';
                            }elseif(strtoupper($colourArray[0]) == 'NORMAL'){
                                $styleType = 'display:inline;font-size: 1em;';
                            }elseif(strtoupper($colourArray[0]) == 'SMALL'){
                                $styleType = 'display:inline;font-size: 0.5em;';
                            }elseif(strtoupper($colourArray[0]) == 'TINY'){
                                $styleType = 'display:inline;font-size: 0.25em;';
                            }
                            $formatFront .= '<div style="'.$styleType.'" >';
                            $formatBack = '</div> '.$formatBack;
                            $toFormatText = $colourArray[1];
                            $styleType = '';
                        }
                        elseif($formatCodesArray[$d] == 'CSS'){
                            $cssArray = explode(";",$toFormatText,2);
                            
                            
                            $formatFront .= '<div style="'.str_replace(',',';',$cssArray[0]).'" >';
                            $formatBack = '</div> '.$formatBack;
                            $toFormatText = $cssArray[1];
                            $styleType = '';
                        }
                    }
        
                    //--Embeds formatting 
                    $toFormatText = str_replace("\n",$formatBack.'</p><p>'.$formatFront,$toFormatText);
                    $output = str_replace($toFormatraw.']',$formatFront.$toFormatText.$formatBack, $output);
                    $firstBrace[$level] = -1;
                    $formatFront = '';
                    $formatBack = '';
                    $level--;
                    $found = true;
                    break;
                }else{$found = false;}
                
            }
        }
        //--Handles the newlines
        $output = str_replace("\n",'</p><p>', $output);
        
        //--Returns Fully Formated Text
        return '<p>'.$output.'</p>';
    }
}
