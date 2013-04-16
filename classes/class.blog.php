<?php
//include ('class.blog.php');
//$blog = new blog();


//--How to use

//--Print Navigation
//echo $blog->nav();


//--Print post(s)
//echo $blog->posts();

//--Load other classes to be used
include('class.ConfigHandler.php');
include('class.LoadPosts.php');

class blog {

/*-----------------------------------------  Encrypt  -----------------------------------------*/  	
    
    
//------------------------------------Output------------------------------------\\
   
    //--Declare Feilds
    public $posts;
    public $config;
    public $currentUser;

    /*
     * Constructor 
     * 
     * Creates $config Object
     */
    public function __construct($username = "admin"){
    
        $username = explode(',',$username);
        $loadPosts = new LoadPosts();
        $this->posts = $loadPosts->getPosts($username);
        $this->config = new ConfigHandler(dirname(__DIR__).'/'.'settings.cfg');
        $this->currentUser = $loadPosts->getUser($username);
    }
   
    /*
     * Nav 
     * 
     * Prints Navigation to HTML File
     */
    function nav($inlinetype){
    
        //--Test to Show Nav
        if($this->currentUser['blogshownav'] == 1){
        
            //--Test to use forced stylesheet
            if($this->currentUser['blognavusestyle'] == 1){
                echo '
                    <style>'.file_get_contents("content/styles/nav.css").'</style>';
            }
            
            //--Set test menu variables
            $lastyear = $this->posts[count($this->posts)-1]['year'];
            $lastmonth = $this->posts[count($this->posts)-1]['month'];
            $lastday = $this->posts[count($this->posts)-1]['day'];
        
            
            //--Determine which Oriantation to use
            If(isset($inlinetype)){
                if($inlinetype == 'vertical'){
                    $navitemstyle = 'navitemvert';
                    $navsuperstyle = 'navsupervert';
                
                }elseif($inlinetype == 'horizontal'){
                    $navitemstyle = 'navitemhori';
                    $navsuperstyle = 'navsuperhori';
                
                
                }
            }else{
                if($this->currentUser['blognavtype'] == 'vertical'){
                    $navitemstyle = 'navitemvert';
                    $navsuperstyle = 'navsupervert';
                
                }elseif($this->currentUser['blognavtype'] == 'horizontal'){
                    $navitemstyle = 'navitemhori';
                    $navsuperstyle = 'navsuperhori';
                
                
                }
            }
            //--Print first menu
            echo '
                        <ul class="supermenu '.$navsuperstyle.'">';
            
            if($this->posts[count($this->posts)-1]['year']==date('Y-m-d H:i:s')){
                echo '
                        <li class="navmenuitem">'.$lastyear.'
                                <ul class="submenua '.$navitemstyle.'">';
            }
            echo '
                                    <li class="navmenuitem">'.$lastmonth.' - '.$this->numMonth($lastmonth).'
                                        <ul class="submenub navitemvert">';
                        
                        
            //--Loop through posts and print menu for each            
            for($c = count($this->posts)-1; $c >= 0; $c--){
                
                if($this->posts[$c]['status'] == 1){
                    //--Check if the post's year is older than the last
                    if(intval($this->posts[$c]['year']) != intval($lastyear)){
                        $lastyear = $this->posts[$c]['year'];   
                        $lastmonth = $this->posts[$c]['month'];
                        $lastday = 0;      
                        echo '
                                        </ul>
                                    </li>';
            if($this->posts[count($this->posts)-1]['year']==date('Y-m-d H:i:s')){
                echo'           </ul>';
            }
            echo '
                            </li>
                            
                            <li class="navmenuitem">'.$this->posts[$c]['year'].'
                                <ul class="submenua '.$navitemstyle.'">
                                    <li class="navmenuitem">'.$this->posts[$c]['month'].' - '.$this->numMonth($this->posts[$c]['month']).'
                                        <ul class="submenub navitemvert">
                                    ';
                        }
                               
                        //--Check if the post's month is older than the last
                        if(intval($this->posts[$c]['month']) != intval($lastmonth)){
                                $lastmonth = $this->posts[$c]['month'];   
                                $lastday = 0;       
                            echo '
                                            </ul>
                                        </li>
                                        
                                        <li class="navmenuitem">'.$this->posts[$c]['month'].' - '.$this->numMonth($this->posts[$c]['month']).'
                                            <ul class="submenub navitemvert">
                                        ';
                        }
                         
                        echo '
                                            <li class="navmenuitem"><a href="?post='.$this->posts[$c]['id'].'">'.$this->posts[$c]['day'].' - '.$this->posts[$c]['title'].' </a></li>
                                    ';
                   }
                }
        echo '
                                    </ul>
                                </li>';
            if($this->posts[count($this->posts)-1]['year']==date('Y-m-d H:i:s')){
                echo'       </ul>';
            }
            echo'      </li>
                    </ul>
                    
                    ';
            
        }
    }
    
    
    
    /*
     * posts 
     * 
     * Prints users posts to HTML File
     */
    function posts(){
    
        //--Load other classes to be used
        include ('class.format.php');
        
        $format = new format();
    
        //--Get first word of tags to be used as end tags
                                                               
        #Blog Outline Tag:              
        $blog_ol_tagar = explode(" ",$this->config->getValue('blog-full'),2);
         $blog_full_end = '</'.str_replace('>','',substr($blog_ol_tagar[0],1)).'>';                 
                                                        
        #Blog Header Tag:             
        $blog_ol_htagar = explode(" ",$this->config->getValue('blog-header'),2);
         $blog_header_end = '</'.str_replace('>','',substr($blog_ol_htagar[0],1)).'>';                
                                                        
        #Blog Nav Tag:             
        $blog_ol_navtagar = explode(" ",$this->config->getValue('blog-nav'),2);
         $blog_nav_end = '</'.str_replace('>','',substr($blog_ol_htagar[0],1)).'>';                      
                                                        
        #Post Tag:                                       
        $blog_ps_tagar = explode(" ",$this->config->getValue('blog-post'),2);
         $blog_post_end = '</'.str_replace('>','',substr($blog_ps_tagar[0],1)).'>';                       
                                                        
        #Post Header Tag:                   
        $blog_ps_htagar = explode(" ",$this->config->getValue('blog-post-header'),2);
        $blog_post_header_end = '</'.str_replace('>','',substr($blog_ps_htagar[0],1)).'>';    
    
        //--Print Out Posts
        echo 
        
            "\n         "
            .$this->config->getValue('blog-full');
            
        //--Tests whether or not to show the blog header    
        if($this->currentUser['blogshowtitle'] == 1){
            echo $this->config->getValue('blog-header').'<a href="'.$this->currentUser['blogurl'].'">'.$this->currentUser['blogtitle'].'</a>'.$blog_header_end;
        }
        
        //--Tests if only one post it to be shown
        if(isset($_REQUEST['post'])){
        
            $postid = $_REQUEST['post'];
            
            //--Matches the post's id
            for($c = count($this->posts)-1; $c > -1; $c--){
                if($this->posts[$c]['id'] == $postid){
                    $postkey = $c;
                }
            }
            
            //--Prints single post
            echo  
                 "\n            "
                 .$this->config->getValue('blog-post').
                            $this->config->getValue('blog-post-header').$this->posts[$postkey]['title'].' - '.$this->posts[$postkey]['formdate'].$blog_post_header_end                    
                            .$format->fancy($this->posts[$postkey]['text'])
                 ."\n            "
                 .$blog_post_end;
                 
        //--Prints all the posts if one is not specified
        }else{    
            if($this->currentUser['blogpoststoshow'] > count($this->posts)){$postlimit = count($this->posts);}else{$postlimit = $this->currentUser['blogpoststoshow'];}
            for($c = count($this->posts)-1; $c > (  (count($this->posts)-1)-$postlimit  ); $c--){
                if($this->posts[$c]['status'] == 1){
                    echo 
                        "\n            "
                        .$this->config->getValue('blog-post').
                            $this->config->getValue('blog-post-header').'<a href="?post='.$this->posts[$c]['id'].'">'.$this->posts[$c]['title'].' - '.$this->posts[$c]['formdate'].'</a>'.$blog_post_header_end                    
                            .$format->fancy($this->posts[$c]['text'])
                        ."\n            "
                        .$blog_post_end.
                        "\n         ";
                }
            }
        
            echo 
                "\n         "
                .$blog_full_end;
        }
        
    }
    
    /*
     * Nav 
     * 
     * Prints Navigation to HTML File
     */
    function numMonth($month){
        
        if     ($month == '01'){
            $output = 'January';
        }elseif($month == '02'){
            $output = 'February';
        }elseif($month == '03'){
            $output = 'March';
        }elseif($month == '04'){
            $output = 'April';
        }elseif($month == '05'){
            $output = 'May';
        }elseif($month == '06'){
            $output = 'June';
        }elseif($month == '07'){
            $output = 'July';
        }elseif($month == '08'){
            $output = 'August';
        }elseif($month == '09'){
            $output = 'September';
        }elseif($month == '10'){
            $output = 'October';
        }elseif($month == '11'){
            $output = 'November';
        }elseif($month == '12'){
            $output = 'December';
        }
        
        return $output;
    }
}
?>
