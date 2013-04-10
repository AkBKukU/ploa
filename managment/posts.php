<?php
    include (dirname(__DIR__).'/classes/class.format.php');
    $format = new format();
    
    //--load posts to array
    $theirposts  = $loadPosts->getPosts($currentUser['name']); 

    if(isset($_REQUEST['action'])){
        //--Colect given info    
        $title = $_REQUEST['title'];
        $text = $_REQUEST['text'];
        $tags = $_REQUEST['tags'];
        $status = $_REQUEST['status'];
        $action = $_REQUEST['action'];
        $postid = $_REQUEST['postid'];
        $userid = $_REQUEST['userid'];
    }
    if($_REQUEST['action'] == 'add'){
    
        $loadPosts->addPost($title,$text,$tags,$status,$userid);
    }  
    
    if($_REQUEST['action'] == 'update'){
    
        $loadPosts->updatePost($title,$text,$tags,$status,$postid);
    } 
    
    if($_REQUEST['action'] == 'delete'){
    
        $loadPosts->deletePost($postid);
    } 
    echo '<h2><p>'.$currentUser['name']."'s ".'Posts</p></h2>
    <table class="listtable">';    
    for($c = count($theirposts)-1; $c > -1; $c--){
        if($c % 2 == 0){$even=' class="even"';}else{$even='';}
        echo '
            <tbody'.$even.'>
                <tr>
                    <td><p><strong><a title="Veiw Post" href="?area=postview&amp;view='.$theirposts[$c]['id'].'">'.$theirposts[$c]['title'].' - '.$theirposts[$c]['date'].'</a></strong></p></td>
                    <td><a title="Edit Post" href="?area=writer&amp;edit='.$theirposts[$c]['id'].'"><img class="postctrl" alt="Edit" src="content/images/edit.png"></a> 
                        <a title="Delete Post" href="?area=posts&amp;edit='.$theirposts[$c]['id'].'&amp;delete=confirm"><img class="postctrl" alt="Delete" src="content/images/delete.png"></a></td>
                </tr>
                
                <tr>
                    <td colspan=2 >'.$format->oneline($theirposts[$c]['text']).'</td>
                </tr>
            </tbody>';
    }
    echo '</table>';  
    
    //Find posts array key for post to edit
    if($_REQUEST['delete'] == 'confirm'){ 
        $postid = $_REQUEST['edit'];
            for($c = count($posts)-1; $c > -1; $c--){
                if($posts[$c]['id'] == $postid){
                    $postkey = $c;
                }
             }
        echo '
        <div class="coverpage"></div>
        <table class="alerttable">
            <tbody>
                <tr>
                    <td class="alertheader">Confirm Delete</td>
                </tr>
                
                <tr>
                    <td class="alertbody">Are sure that you want to delete the post "'.$posts[$postkey]['title'].'" from '.$posts[$postkey]['date'].'?</td>
                </tr>
                
                <tr>
                    <td class="alertbuttons"><a href="?area=posts&amp;action=delete&amp;postid='.$posts[$postkey]['id'].'">Yes</a><a href="manager.php?area=posts">No</a></td>
                </tr>
            </tbody>
        </table>
        
        '; 
    
    }
    
