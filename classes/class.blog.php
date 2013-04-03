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

    /*
     * Constructor 
     * 
     * Creates $config Object
     */
    public function __construct(){
        $loadPosts = new LoadPosts();
        $this->posts = $loadPosts->getPosts();
        $this->config = new ConfigHandler(dirname(__DIR__).'/'.'settings.cfg');
    }
   
    /*
     * Nav 
     * 
     * Prints Navigation to HTML File
     */
    function nav(){
    
        //--Test to Show Nav
        if($this->config->getValue('blog-show-nav') == 'true'){
        
            //--Test to use forced stylesheet
            if($this->config->getValue('blog-nav-usestyle') == 'true'){
                echo '
                    <style>'.file_get_contents("content/styles/blog.css").'</style>';
            }
            
            //--Set test menu variables
            $lastyear = $this->posts[count($this->posts)-1]['year'];
            $lastmonth = $this->posts[count($this->posts)-1]['month'];
            $lastday = $this->posts[count($this->posts)-1]['day'];
        
        
            //--Determine which Oriantation to use
            if($this->config->getValue('blog-nav-type') == 'vertical'){
                $navitemstyle = 'navitemvert';
                $navsuperstyle = 'navsupervert';
            
            }elseif($this->config->getValue('blog-nav-type') == 'horizontal'){
                $navitemstyle = 'navitemhori';
                $navsuperstyle = 'navsuperhori';
            
            
            }
            
            //--Print first menu
            echo '
                        <ul class="supermenu '.$navsuperstyle.'">';
            
            echo '
                        <li class="navmenuitem">Y '.$lastyear.'
                                <ul class="submenua '.$navitemstyle.'">';
            echo '
                                    <li class="navmenuitem">M '.$lastmonth.'
                                        <ul class="submenub navitemvert">';
                        
                        
            //--Loop through posts and print menu for each            
            for($c = count($this->posts)-1; $c >= 0; $c--){
                
                //--Check if the post's year is older than the last
                if(intval($this->posts[$c]['year']) != intval($lastyear)){
                    $lastyear = $this->posts[$c]['year'];   
                    $lastmonth = $this->posts[$c]['month'];
                    $lastday = 0;      
                    echo '
                                    </ul>
                                </li>
                            </ul>
                        </li>
                        
                        <li class="navmenuitem">Y '.$this->posts[$c]['year'].'
                            <ul class="submenua '.$navitemstyle.'">
                                <li class="navmenuitem">M '.$this->posts[$c]['month'].'
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
                                
                                <li class="navmenuitem">M '.$this->posts[$c]['month'].'
                                    <ul class="submenub navitemvert">
                                ';
                    }
                 
            echo '
                                        <li class="navmenuitem"><a href="?post='.$this->posts[$c]['id'].'">D '.$this->posts[$c]['day'].' - '.$this->posts[$c]['title'].' </a></li>
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
    
    
    
    /*
     * Nav 
     * 
     * Prints Navigation to HTML File
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
        if($this->config->getValue('blog-show-title') == 'true'){
            echo '<a href="'.$this->config->getValue('blog-url').'">'.$this->config->getValue('blog-header').$this->config->getValue('blog-title').$blog_header_end.'</a>';
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
            if($this->config->getValue('blog-posts-to-show') > count($this->posts)){$postlimit = count($this->posts);}else{$postlimit = $this->config->getValue('blog-posts-to-show');}
            for($c = count($this->posts)-1; $c > (  (count($this->posts)-1)-$postlimit  ); $c--){
            
                echo 
                    "\n            "
                    .$this->config->getValue('blog-post').
                        $this->config->getValue('blog-post-header').'<a href="?post='.$this->posts[$c]['id'].'">'.$this->posts[$c]['title'].' - '.$this->posts[$c]['formdate'].'</a>'.$blog_post_header_end                    
                        .$format->fancy($this->posts[$c]['text'])
                    ."\n            "
                    .$blog_post_end.
                    "\n         ";}
        
            echo 
                "\n         "
                .$blog_full_end;
        }
        
    }
}
?>
