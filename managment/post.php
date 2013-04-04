<?php

//--Colect given info    
    $title = $_REQUEST['title'];
    $text = $_REQUEST['text'];
    $tags = $_REQUEST['tags'];
    $status = $_REQUEST['status'];
    $action = $_REQUEST['action'];
    $postid = $_REQUEST['postid'];
        
    $today = getdate();
    $date=date('Y-m-d H:i:s');
    

    $mysqli = new mysqli($config->getValue('sql-host'), $config->getValue('sql-user'), $config->getValue('sql-pass'));
    
    if ($mysqli->connect_errno) {
        echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    }        
//Check if blog database exist    
    $mysqli->select_db($config->getValue('sql-database'));
    
//Write post to database
    if($action =="update"){
        $query = 'UPDATE '.$config->getValue('sql-post-table').' SET status="'.$status.'", title="'.$title.'", text="'.$text.'", tags="'.$tags.'" WHERE id="'.$postid.'"';    
        echo "Query: ".$query;
        $mysqli->query($query);
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=posts";
                //-->
            </script>
                    ';
    }elseif($action =="insert"){
    
        $query = 'INSERT INTO '.$config->getValue('sql-post-table').' (title,text,date,tags,status) VALUES ("'.$title.'","'.$text.'","'.$date.'","'.$tags.'","'.$status.'")';
        echo "Query: ".$query;
        $mysqli->query($query);
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=posts";
                //-->
            </script>
                    ';
    }elseif($action =="delete"){
    
        $query = 'DELETE FROM '.$config->getValue('sql-post-table').' WHERE id='.$postid;
        echo "Query: ".$query;
        $mysqli->query($query);
            echo '
            <script type="text/javascript">
                <!--
                   window.location="manager.php?area=posts";
                //-->
            </script>
                    ';
    }
    mysqli_close($mysqli);
?>
