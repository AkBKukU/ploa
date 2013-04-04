<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Ploa Blog Test</title>
        <meta charset=utf-8>
        <link rel=StyleSheet href="content/styles/nav.css" type="text/css">
        <link rel="alternate" href="/rss/" title="My RSS feed" type="application/rss+xml" />
    </head>
     <body>
         <h1>Demonstration Blog!</h1>
         <a href="manager.php?area=posts">go to manager</a>
         
        <?php 

        include ('./classes/class.blog.php');
        $blog = new blog('akbkuku');

        echo $blog->nav();
        echo '<hr />';
        echo $blog->posts();

        ?>

    </body>
</html>
