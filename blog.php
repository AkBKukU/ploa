<?php
    //Load Configuration Files
    include("./config.php");


    //Begin sql connection
    $mysqli = new mysqli($sqlhost, $sqluser, $sqlpass);
    
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }
    
    //Check if blog database exist    
    if(0 == $mysqli->select_db($sqldata)){
        $mysqli->query('CREATE DATABASE '.$sqldata);
        echo 'Created '.$sqldata.' database';
    }
    
    //Check if blog table exist    
    if(0 == $mysqli->query('SELECT 1 FROM '.$blog_tbname.' LIMIT 1')){
        $mysqli->query('CREATE TABLE '.$blog_tbname.'(
                            id INT NOT NULL AUTO_INCREMENT, 
                            PRIMARY KEY(id),
                            title TEXT,
                            text TEXT,
                            date TEXT,
                            tags TEXT,
                            status INT
        )');
        echo 'Created '.$blog_tbname.' table';
    }
    
    
    //Read posts from table
    $result =    $mysqli->query('SELECT * FROM '.$blog_tbname);
    if($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            if($row['status'] != "0"){
                $posts[] = array(  
                    'title' => $row['title'], 
                    'text' => $row['text'], 
                    'id' => $row['id'],
                    "date" => $row['date']
                    );    
            }
        }
    }
    
    for($c = 0; $c < count($posts); $c++){    
        $posts[$c]['year'] = substr($posts[$c]['date'],0,4);
        $posts[$c]['month'] = substr($posts[$c]['date'],5,2);
        $posts[$c]['day'] = substr($posts[$c]['date'],8,2);
        $posts[$c]['formdate'] = $posts[$c]['month'].'/'.$posts[$c]['day'].'/'.$posts[$c]['year'] ;
    
    }
    
    //Disconnect from database
    mysqli_close($mysqli);
    
    //Check to see if number of posts to show is higher th number of posts the exist
    if($blog_ps_count > count($posts)){$blog_ps_count = count($posts);}
//------------------------------------Output------------------------------------\\
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
                    
                    <p>'.$posts[$postkey]['text'].'</p>
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
                <p>'.$posts[$c]['text'].'</p>
                </'.$blog_ps_tagst.'>
                    ';
        }
    
    
        echo '
        </'.$blog_ol_tagst.'>';
    }
?>
