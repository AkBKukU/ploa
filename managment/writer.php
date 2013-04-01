<?php

if($_REQUEST['edit'] == 0){  
            $writetitle = 'Create a new' ;
            $writecheckbox = 'checked="checked"' ;
            $writedefaulttext = ' placeholder="Tell the world what you think here!">' ;
            $writedefaultitle = ' placeholder="New Post Title' ;
            $writedefaultags = ' placeholder="Tags here (ie flowers, computers, first)' ;
            $writeaction = '&amp;action=insert' ;
            $writeeditid = '' ;
            
        }else{
            //Find posts array key for post to edit
            $postid = $_REQUEST['edit'];
            for($c = count($posts)-1; $c > -1; $c--){
                if($posts[$c]['id'] == $postid){
                    $postkey = $c;
                }
             }
            $writetitle = 'Edit a' ;
            if($posts[$postkey]['status'] == '1'){$writecheckbox = 'checked="checked"' ;}else{$writecheckbox = '' ;}
            $writedefaulttext = '>'.$posts[$postkey]['text'] ;
            $writedefaultitle = 'value="'.$posts[$postkey]['title'] ;
            $writedefaultags = 'value="'.$posts[$postkey]['tags'] ;
            $writeaction = '&amp;action=update' ;
            $writeeditid = '<input type="hidden" name="postid" value="'.$_REQUEST['edit'].'">' ;
            
        }
        echo'
        <fieldset>
            <legend>'.$writetitle.' post</legend>
                    <form method="post" action="?area=post'.$writeaction.'">
                        <label for="title">Title </label><input name="title" id="title" type="text" class="title"'.$writedefaultitle.'" autofocus="">
                        <label for="tags">Tags </label><input name="tags" id="tags" type="text" class="tags"  '. $writedefaultags.'"><br />
                        <div class="separater"></div>
                        '.$writeeditid.'
                        <textarea name="text" id="text" class="text" '.$writedefaulttext.'</textarea><br />
                        <div class="inputs"><input type="submit" value="Save Post"  class="button"></div>
                        <div class="inputs"> <input type="checkbox" name="status" id="status" value="1" ' .$writecheckbox.' class="checkbox"><label for="status" >Publish Post </label></div>    
                    </form>
            </fieldset>
        ';
?>
