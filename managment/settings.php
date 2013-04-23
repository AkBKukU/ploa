<?php
        
        echo'
            <h2><p>Settings';
        if($_REQUEST['notify'] == 'saved'){echo ' - Saved';}
            
        if($_REQUEST['action'] == 'save'){
        
            $config->setValue('sql-user',$_REQUEST['sql-user']);
            if($_REQUEST['sql-pass'] == $_REQUEST['sql-pass-confirm']){
                $config->setValue('sql-pass',$_REQUEST['sql-pass']);
            }else{echo " - SQL Passwords Don't Match(Igorning Change)";}
            $config->setValue('sql-host',$_REQUEST['sql-host']);
            $config->setValue('sql-database',$_REQUEST['sql-database']);
            $config->setValue('sql-table',$_REQUEST['sql-table']);
            
            
            if($_REQUEST['blog-login-pass'] == $_REQUEST['blog-login-pass-confirm']){
                $loadPosts->setUserPass($_SESSION['currentuser'],$_REQUEST['blog-login-pass']);
            }else{echo " - Login Passwords Don't Match(Igorning Change)";}
            
            $loadPosts->updateUserSettings( $_SESSION['currentuser'],
                                            $_REQUEST['blog-title'],
                                            $_REQUEST['blog-url'],
                                            $_REQUEST['blog-posts-to-show'],
                                            $_REQUEST['blog-show-title'],
                                            $_REQUEST['blog-show-nav'],
                                            $_REQUEST['blog-nav-usestyle'],
                                            $_REQUEST['blog-nav-type'],
                                            htmlentities($_REQUEST['blog-full']),
                                            htmlentities($_REQUEST['blog-header']),
                                            htmlentities($_REQUEST['blog-nav']),
                                            htmlentities($_REQUEST['blog-post']),
                                            htmlentities($_REQUEST['blog-post-header'])
                                            );
                                            
            
            
        }    
            
            
            
        echo '</p></h2>
        <div id="settingspage" class="textarea">';
    
        if($currentUser['type'] == 0){
            echo '
                <form method="post" action="?area=settings&amp;action=save">
                    <h3 id="configdatabase"><a href="#configdatabase">Database</a></h3>
                    <p> - Configure database connection</p>
                   
                    <table class="inputtable">
                        <tr>
                           <th><label for="sql-host">Host:Port</label></th>
                           <td><input id="sql-host" name="sql-host" type="text" value="'.$config->getValue('sql-host').'"></td>
                        </tr>
                        <tr>
                           <th><label for="sql-database">Database</label></th>
                           <td><input id="sql-database" name="sql-database" type="text" value="'.$config->getValue('sql-database').'"></td>
                        </tr>
                        <tr>
                           <th><label for="sql-table">Post Table</label></th>
                           <td><input id="sql-table" name="sql-table" type="text" value="'.$config->getValue('sql-post-table').'"></td>
                        </tr>
                        <tr>
                           <th><label for="sql-table">User Table</label></th>
                           <td><input id="sql-table" name="sql-table" type="text" value="'.$config->getValue('sql-user-table').'"></td>
                        </tr>
                        
                        <tr>
                           <th><label for="sql-user">User</label></th>
                           <td><input id="sql-user" name="sql-user" type="text" value="'.$config->getValue('sql-user').'"></td>
                        </tr>
                        
                        <tr>
                           <th><label for="sql-pass">Password</label></th>
                           <td><input id="sql-pass" name="sql-pass" type="password" value="'.$config->getValue('sql-pass').'"></td>
                        </tr>
                        
                        <tr>
                           <th><label for="sql-pass-confirm">Password Confirm</label></th>
                           <td><input id="sql-pass-confirm" name="sql-pass-confirm" type="password" value="'.$config->getValue('sql-pass').'"></td>
                        </tr>
                        
                    </table>';
        }    
                
        echo '    
                <h3 id="configblog"><a href="#configblog">Blog</a></h3>
                <p> - Configure Blog info</p>
                <table class="inputtable">
                    <tr>
                       <th><label for="blog-login-pass">Login Password</label></th>
                       <td><input id="blog-login-pass" name="blog-login-pass" type="password" value="'.$loadPosts->getUserPass($currentUser['name']).'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-login-pass-confirm">Login Password Confrim</label></th>
                       <td><input id="blog-login-pass-confirm" name="blog-login-pass-confirm" type="password" value="'.$loadPosts->getUserPass($currentUser['name']).'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-title">Blog Title</label></th>
                       <td><input id="blog-title" name="blog-title" type="text" value="'.$currentUser['blogtitle'].'">
                       <p>WARNING: Changing this can mess up RSS!</p></td>
                    </tr>
                    <tr>
                       <th><label for="blog-url">Blog URL</label></th>
                       <td><input id="blog-url" name="blog-url" type="text" value="'.$currentUser['blogurl'].'">
                       <p>WARNING: Changing this can mess up RSS!</p></td>
                    </tr>
                    <tr>
                       <th><label for="blog-posts-to-show">Number of Posts to Show</label></th>
                       <td><input id="blog-posts-to-show" name="blog-posts-to-show" type="text" value="'.$currentUser['blogpoststoshow'].'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-show-title">Display Title</label></th>
                       <td><input id="blog-show-title" name="blog-show-title" type="checkbox" value="1"'; if($currentUser['blogshowtitle'] == 1){echo 'checked="checked"';} echo ' ></td>
                    </tr>
                    <tr>
                       <th><label for="blog-show-nav">Display Navigation</label></th>
                       <td><input id="blog-show-nav" name="blog-show-nav" type="checkbox" value="1"'; if($currentUser['blogshownav'] == 1){echo 'checked="checked"';} echo ' ></td>
                    </tr>
                    <tr>
                       <th><label for="blog-nav-usestyle">Force Navigation style</label></th>
                       <td><input id="blog-nav-usestyle" name="blog-nav-usestyle" type="checkbox" value="1"'; if($currentUser['blognavusestyle'] == 1){echo 'checked="checked"';} echo ' >
                       <p>WARNING: Not HTML Compliant! Link to content/styles/nav.css instead!</p></td>
                    </tr>
                    <tr>
                       <th><label for="blog-nav-type">Navigation Type</label></th>
                       <td><input id="blog-nav-type" name="blog-nav-type" type="text" value="'.$currentUser['blognavtype'].'"><p>This can be vertical or horizontal</p></td>
                    </tr>
                    
                </table>
                
                
                <h3 id="configblogtags"><a href="#configblogtags">Blog HTML Tags</a></h3>
                <p> - Configure Blog HTML Output</p>
                <table class="inputtable">
                    <tr>
                       <th><label for="blog-full">Blog Surround</label></th>
                       <td><input id="blog-full" name="blog-full" type="text" value="'.$currentUser['blogfull'].'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-header">Blog Header</label></th>
                       <td><input id="blog-header" name="blog-header" type="text" value="'.$currentUser['blogheader'].'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-nav">Blog Navigation</label></th>
                       <td><input id="blog-nav" name="blog-nav" type="text" value="'.$currentUser['blognav'].'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-post">Blog Post</label></th>
                       <td><input id="blog-post" name="blog-post" type="text" value="'.$currentUser['blogpost'].'"></td>
                    </tr>
                    <tr>
                       <th><label for="blog-post-header">Blog Post Header</label></th>
                       <td><input id="blog-post-header" name="blog-post-header" type="text" value="'.$currentUser['blogpostheader'].'"></td>
                    </tr>
                    
                    <tr>
                        <td colspan="2" class="savebutton"><input type="submit" value="Save Changes"  class="button"></td>
                    </tr>
                </table>
            </form>
            
        </div>
        ';
?>
