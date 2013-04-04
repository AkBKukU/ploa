<?php

    //--load users to array
    $users  = $loadPosts->getAllUsers(); 
    
if($_REQUEST['edit'] < 0){  
            $writetitle = 'Create a new' ;
            $writecheckbox = 'checked="checked"' ;
            $writedefaulttext = ' placeholder="Tell the world what you think here!">' ;
            $writedefaulusername = ' placeholder="New Username' ;
            $writedefaulpass = ' placeholder="Password' ;
            $writeaction = '&amp;newuser=yes' ;
            $writeeditid = '' ;
            $writedefaulttype = '">Choose an account type';
            
}else{
            //Find posts array key for post to edit
            $userid = $_REQUEST['edit'];
                for($c = count($users)-1; $c > -1; $c--){
                    if($users[$c]['id'] == $userid){
                        $userkey = $c;
                    }
                 }
                 
            $writetitle = 'Edit a' ;
            if($users[$userkey]['status'] == '1'){$writecheckbox = 'checked="checked"' ;}else{$writecheckbox = '' ;}
            $writedefaulttext = '>'.$users[$userkey]['text'] ;
            $writedefaulusername = 'value="'.$users[$userkey]['name'] ;
            $writedefaulpass = 'value="'.$users[$userkey]['pass'] ;
            $writeaction = '&amp;action=update' ;
            $writeeditid = '<input type="hidden" name="postid" value="'.$_REQUEST['edit'].'">' ;
            $writedefaulttype = $users[$userkey]['type'].'">Current account type';
            
        }
        echo'
    <div id="usereditor" class="textarea">
        <fieldset>
            <legend>'.$writetitle.' User</legend>
                    <form method="post" action="?area=users'.$writeaction.'">
                        <label for="username">Username </label><input name="username" id="username" type="text" '.$writedefaulusername.'" autofocus=""><br />
                        <label for="userpassword">Password </label><input name="userpassword" id="userpassword" type="password"  '. $writedefaulpass.'"><br />
                        <label for="userpasswordconfirm">Password Confirm</label><input name="userpasswordconfirm" id="userpasswordconfirm" type="password"  '. $writedefaulpass.'"><br />
                        <label for="usertype">User Type</label>
                        <select name="usertype" id="usertype">
                            <option value="'.$writedefaulttype.'</option>
                            <option value="0">Administrator</option>
                            <option value="1">Author</option>
                            <option value="1">Commentor</option>
                        </select>
                        <br />
                        <input type="submit" value="Save User"  class="button">
                    </form>
        </fieldset>
    </div>
        ';
?>
