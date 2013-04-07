<?php
    if($_REQUEST['newuser'] == 'yes'){
        $loadPosts->addUser($_REQUEST['username'],$_REQUEST['userpassword'],$_REQUEST['usertype']);
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=users";
                //-->
            </script>
                    ';
    }
    
    
    if($_REQUEST['action'] == 'update'){
    
        $loadPosts->updateUser($_REQUEST['username'],$_REQUEST['userpassword'],$_REQUEST['usertype'],$_REQUEST['userid']);
    } 
        
    if($_REQUEST['action'] == 'delete'){
    
        $loadPosts->deleteUser($_REQUEST['userid']);
    } 

    //--load users to array
    $users  = $loadPosts->getAllUsers(); 
    
    for($c = 0; $c < count($users); $c++){
        
        if($users[$c]['type'] == 0){$users[$c]['type'] = 'Administrator';
        }elseif($users[$c]['type'] == 1){$users[$c]['type'] = 'Author';
        }elseif($users[$c]['type'] == 2){$users[$c]['type'] = 'Commentor';}
    }
        
    include (dirname(__DIR__).'/classes/class.format.php');
    $format = new format();
        echo '<table>';    
        for($c = count($users)-1; $c > -1; $c--){
            if($c % 2 == 0){$even=' class="even"';}else{$even='';}
            echo '
                <tbody'.$even.'>
                    <tr>
                        <td><p><strong>'.$users[$c]['name'].' - '.$users[$c]['type'].' - '.$users[$c]['postcount'].' Posts</strong></p></td>
                        <td><a title="Edit User" href="?area=usereditor&amp;edit='.$users[$c]['id'].'"><img class="postctrl" alt="Edit" src="content/images/edit.png"></a> 
                            <a title="Delete User" href="?area=users&amp;edit='.$users[$c]['id'].'&amp;delete=confirm"><img class="postctrl" alt="Delete" src="content/images/delete.png"></a></td>
                    </tr>
                </tbody>';
        }
        echo '</table>';  

        
        //Find posts array key for post to edit
        if($_REQUEST['delete'] == 'confirm'){ 
            $userid = $_REQUEST['edit'];
                for($c = count($users)-1; $c > -1; $c--){
                    if($users[$c]['id'] == $userid){
                        $userkey = $c;
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
                        <td class="alertbody">Are sure that you want to delete the user "'.$users[$userkey]['name'].'" forever?</td>
                    
                    <tr>
                        <td class="alertbuttons"><a href="?area=users&amp;action=delete&amp;userid='.$users[$userkey]['id'].'">Yes</a><a href="manager.php?area=users">No</a></td>
                    </tr>
                </tbody>
            </table>
            
            '; 
        }
?>
    
