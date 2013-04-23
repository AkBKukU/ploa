<?php

    //--load users to array
    $users  = $loadPosts->getAllUsers(); 
    
    $userid = $_REQUEST['view'];
    for($c = count($users)-1; $c > -1; $c--){
        if($users[$c]['id'] == $userid){
            $userkey = $c;
        }
     }
    
    //--Load other classes to be used
    include (dirname(__DIR__).'/classes/class.format.php');
    
    $format = new format();


    for($c = 0; $c < count($users); $c++){
        
        if($users[$c]['type'] == 0){$users[$c]['type'] = 'Administrator';
        }elseif($users[$c]['type'] == 1){$users[$c]['type'] = 'Author';
        }elseif($users[$c]['type'] == 2){$users[$c]['type'] = 'Commentor';}
    }
    echo 
    "\n            "
    .'<h2><p>'.$users[$userkey]['name'].'</p></h2>
        <div id="userview">'
    .'<div class="textarea">'
    ."\n            "
    .'<table>
        <tr>
            <th>Account Type</th>
            <td>'.$users[$userkey]['type'].'</td>
        </tr>
        <tr>
            <th>Number of Posts</th>
            <td>'.$users[$userkey]['postcount'].'</td>
        </tr>
    </table>'
    .'</div>'.
    "\n         ".
    '<ul class="controls">
        <li><a title="Edit User" href="?area=usereditor&amp;edit='.$users[$userkey]['id'].'">Edit</a></li>
        <li><a title="Delete User" href="?area=users&amp;edit='.$users[$userkey]['id'].'&amp;delete=confirm">Delete</a></li>
    </ul>'
    ;
    //--load posts to array
    $allposts   = $loadPosts->getAllPosts($users[$userkey]['name']);
    
    for($c = 0;$c <= count($allposts)-1; $c++){
        if($currentUser['id'] == $allposts[$c]['userid']){
            $theirposts[] = $allposts[$c];
        } 
        
    }
    
    
    echo '
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
    
    echo '</div>';  
?>
