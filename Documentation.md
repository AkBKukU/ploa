#Documentation#

Installation
============
Installing ploa is fairly simple. The major components are:

- Including the blog class and making an object
- Outputting the posts
- Outputting the navigation
- Linking the RSS
- Adding the required style sheets

Including Blog Class
--------------------
To be able to access the parts of the blog you will need to include the the blog class. In a php section (`<?php |Here| ?>`) add the line , `include('classes/class.blog.php.);` , to your blog index.php. Next you need to create a blog object, and specify whos posts should be shown. To do that add this, `$blog = new blog('admin');` , after the include statment. The default user is admin but you can change the name later if you want. Remember if you do that you need to update it here as well. You should add those lines in the begining of the file because you will run into issuses if you try to call one of the functions before the class is called.

Outputting Posts
----------------
To display the posts you need to add a call to the posts function in the blog object. When called it will ouput all the posts for the user specified that are set to publish. To call the function add the line, `$blog->posts();`, where you would like the posts to appear in the HTML. They will be output using the HTML tags in the database. If more that one user is specified(See advanced features) then the tags for the first user will be used.





Advanced Features
================

It is possible to display more than one user's posts on a blog. To do so put all users in an `array()` like this `$blog = new blog(array('akbkuku','admin'));` during the declaration.
