<?php

    //Load Configuration Files
    include(dirname( dirname(__FILE__) )."/classes/class.ConfigHandler.php");
    include(dirname( dirname(__FILE__) )."/classes/class.LoadPosts.php");
    $loadPosts = new LoadPosts();
    $posts = $loadPosts->getPosts();
    $config = new ConfigHandler(dirname(__DIR__) .'/'.'settings.cfg');
//------------------------------------Output------------------------------------\\
    
    header("Content-Type: application/rss+xml; charset=ISO-8859-1");

    $rssfeed = '<?xml version="1.0" encoding="ISO-8859-1"?>'."\n";
    $rssfeed .= '<rss version="2.0">'."\n";
    $rssfeed .= '<channel>'."\n";
    $rssfeed .= '<title>'.$config->getValue('blog-title').'</title>'."\n";
    $rssfeed .= '<link>'.$config->getValue('blog-url').'</link>'."\n";
    $rssfeed .= '<description>This is the RSS feed for the blog '.$config->getValue('blog-title').'</description>'."\n";
    $rssfeed .= '<language>en-us</language>'."\n";
    $rssfeed .= '<copyright>Copyright (C) 2013 Shelby Jueden</copyright>'."\n";
    
    for($c = count($posts)-1; $c > -1; $c--){
        $rssfeed .= '<item>'."\n";
        $rssfeed .= '<title>' . $posts[$c]['title'] . '</title>'."\n";
        $rssfeed .= '<description>' . $posts[$c]['text'] . '</description>'."\n";
        $rssfeed .= '<link>'.$config->getValue('blog-url').'?post='.$posts[$c]['id'].'</link>'."\n";
        $rssfeed .= '<pubDate>' . $posts[$c]['date'] . '</pubDate>'."\n";
        $rssfeed .= '</item>';
    }    
    
    
 
    $rssfeed .= '</channel>'."\n";
    $rssfeed .= '</rss>'."\n";
 
    echo $rssfeed;
?>
