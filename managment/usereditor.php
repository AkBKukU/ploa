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
            $writeaction = '&amp;action=update&amp;userid='.$users[$userkey]['id'] ;
            $writeeditid = '<input type="hidden" name="postid" value="'.$_REQUEST['edit'].'">' ;
            $writedefaulttype = $users[$userkey]['type'].'">Current account type';
            
        }
        echo'
    <div id="usereditor">
            <h2><p>'.$writetitle.' User</p></h2>
        <fieldset class="textarea">
                    <form method="post" action="?area=users'.$writeaction.'">
                        
                        <table class="inputtable">
                            <tr>
                                <th><label for="username">Username </label></th>
                                <td><input name="username" id="username" type="text" '.$writedefaulusername.'" autofocus=""></td>
                            </tr>
                            
                        
                            <tr>
                                <th><label for="userpassword">Password </label></th>
                                <td><input name="userpassword" id="userpassword" type="password"  '. $writedefaulpass.'"></td>
                            </tr>
                            
                        
                            <tr>
                                <th><label for="userpasswordconfirm">Password Confirm</label></th>
                                <td><input name="userpasswordconfirm" id="userpasswordconfirm" type="password"  '. $writedefaulpass.'"></td>
                            </tr>
                            
                        
                            <tr>
                                <th><label for="usertype">User Type</label></th>
                                <td><select name="usertype" id="usertype">
                                        <option value="'.$writedefaulttype.'</option>
                                        <option value="0">Administrator</option>
                                        <option value="1">Author</option>
                                        <option value="2">Commentor</option>
                                    </select></td>
                            </tr>
                            
                            <tr>
                                <td colspan="2" class="savebutton"><input type="submit" value="Save User"  class="button"></td>
                            </tr>
                        </table>
                    </form>
        </fieldset>
    </div>
        ';
?>
