ploa
====

ploa is designed to be a simple embeddable blog software written in php. 


Features
--------

- RSS feed of posts
- Post Editing
- SQL Storage
- Ability to change the HTML tags used to output blog posts
- Hidding posts
- Navigation menu for posts


Installation
============

0. Put all ploa files in the directory your blog will be in on your webserver.
1. Open "config.php" and make all the changes you need in there.
2. Add:

        
        <?php 
            include ('class.blog.php');
            $blog = new blog();

            echo $blog->nav();
            echo $blog->posts();
        ?>

to your PHP file where you would like the blog to appear.

You can include the class in the begining of the file and the add the "echo $blog->nav();" and "echo $blog->posts();" where ever you would like for more options.

Downloading
-----------

If you are new to github and don't know how to download all the needed files, click the zip button to the left the the textbox with the url. The zip contains the files you put in your blog directory on your website.
