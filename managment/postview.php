<?php

    $postid = $_REQUEST['view'];
    for($c = count($posts)-1; $c > -1; $c--){
        if($posts[$c]['id'] == $postid){
            $postkey = $c;
        }
     }
    
    //--Load other classes to be used
    include (dirname(__DIR__).'/classes/class.format.php');
    
    $format = new format();


    echo 
    "\n            "
    .'<h2><p>'.$posts[$postkey]['title'].' - '.$posts[$postkey]['formdate'].'</p></h2>'
    .'<div class="textarea">'.
        ''                    
        .$format->fancy($posts[$postkey]['text'])
    ."\n            "
    .'</div>'.
    "\n         ".
    '<div class="controls">
        <p><a href="index.php?post='.$posts[$postkey]['id'].'">View on blog</a></p>
        <p><a href="?area=writer&amp;edit='.$posts[$postkey]['id'].'">Edit</a></p>
        <p><a title="Delete Post" href="?area=posts&amp;edit='.$posts[$postkey]['id'].'&amp;delete=confirm">Delete</a></p>
    </div>'
    ;
?>