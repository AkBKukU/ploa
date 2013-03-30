<?php
//include ('class.blog.php');
//$blog = new blog();


//--How to use

//--Print Navigation
//echo $blog->nav();


//--Print post(s)
//echo $blog->posts();

class blog {

/*-----------------------------------------  Encrypt  -----------------------------------------*/  	
    
    
//------------------------------------Output------------------------------------\\
   
   
   
   function nav(){
   include("loadsql.php");
    if($blog_nav_show){
    $lastyear = $posts[count($posts)-1]['year'];
    $lastmonth = $posts[count($posts)-1]['month'];
    $lastday = $posts[count($posts)-1]['day'];
        if($blog_nav_type == 'vertical'){
            $navitemstyle = 'navitemvert';
            $navsuperstyle = 'navsupervert';
        
        }elseif($blog_nav_type == 'horizontal'){
            $navitemstyle = 'navitemhori';
            $navsuperstyle = 'navsuperhori';
        
        
        }
        
        
    echo '
                <ul class="supermenu '.$navsuperstyle.'">
    ';
        echo '
                    <li class="navmenuitem">Y '.$lastyear.'
                            <ul class="submenua '.$navitemstyle.'">';
        echo '
                                <li class="navmenuitem">M '.$lastmonth.'
                                    <ul class="submenub navitemvert">';
                    
                    
                    
        for($c = count($posts)-1; $c >= 0; $c--){
        
            if(intval($posts[$c]['year']) != intval($lastyear)){
                $lastyear = $posts[$c]['year'];   
                $lastmonth = $posts[$c]['month'];
                $lastday = 0;      
                echo '
                                </ul>
                            </li>
                        </ul>
                    </li>
                    
                    <li class="navmenuitem">Y '.$posts[$c]['year'].'
                        <ul class="submenua '.$navitemstyle.'">
                            <li class="navmenuitem">M '.$posts[$c]['month'].'
                                <ul class="submenub navitemvert">
                            ';
                }
                       
            if(intval($posts[$c]['month']) != intval($lastmonth)){
                    $lastmonth = $posts[$c]['month'];   
                    $lastday = 0;       
                echo '
                                </ul>
                            </li>
                            
                            <li class="navmenuitem">M '.$posts[$c]['month'].'
                                <ul class="submenub navitemvert">
                            ';
                }
             
        echo '
                                    <a href="?post='.$posts[$c]['id'].'"><li class="navmenuitem">D '.$posts[$c]['day'].' - '.$posts[$c]['title'].' </li></a>
                            ';
                       
            }
    echo '
                                </ul>
                            </li>
                        </ul>
                    </li>
                </ul>
                
                ';
    
    }
    }
    function posts(){
    
    include ('class.format.php');
    $format = new format();
    
    include("loadsql.php");
    
    
    if(isset($_REQUEST['post'])){
        $postid = $_REQUEST['post'];
        for($c = count($posts)-1; $c > -1; $c--){
            if($posts[$c]['id'] == $postid){
                $postkey = $c;
            }
        }
        echo '
        <'.$blog_ol_tag.'>';
            if($blog_title_show){echo '<a href="'.$blog_url.'"><'.$blog_ol_htag.'>'.$blog_title.'</'.$blog_ol_htag.'></a>';}
         echo   '<'.$blog_ps_tag.'>
                    <'.$blog_ps_htag.'>'.$posts[$postkey]['title'].' - '.$posts[$postkey]['formdate'].'</'.$blog_ps_htag.'>
                    
                    '.$format->plain($posts[$postkey]['text']).'
                 </'.$blog_ps_tagst.'>
        </'.$blog_ol_tagst.'>';
        
    }else{
        echo '
        <'.$blog_ol_tag.'>';
            if($blog_title_show){echo '<'.$blog_ol_htag.'>'.$blog_title.'</'.$blog_ol_htag.'>';}
            
        for($c = count($posts)-1; $c > (count($posts)-$blog_ps_count-1); $c--){
            echo '
                <'.$blog_ps_tag.'>
                <a href="?post='.$posts[$c]['id'].'"><'.$blog_ps_htag.'>'.$posts[$c]['title'].' - '.$posts[$c]['formdate'].'</'.$blog_ps_htag.'></a>
                '.$format->fancy($posts[$c]['text']).'
                </'.$blog_ps_tagst.'>
                    ';
        }
    
    
        echo '
        </'.$blog_ol_tagst.'>';
    }
    }
}
?>
