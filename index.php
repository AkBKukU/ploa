<!DOCTYPE html>
<html lang="en-US">
    <head>
        <title>Ploa Blog Test</title>
        <meta charset=utf-8>
        <link rel=StyleSheet href="content/styles/nav.css" type="text/css">
        <link rel="alternate" href="/rss/" title="My RSS feed" type="application/rss+xml" />
        <style>
        body{
            background: #bbccff;
            font-size: 62.5%;
            font-family: Arial, Helvetica, sans-serif;
        }
        section{
            box-shadow: 0px 0px 1px #111111;
            font-size: 1.2em;
            background: #ffffff;
            padding: 10px;
            margin: 0;
        }
        ul.supermenu{
            font-size: 1.5em;
        
        }
        h1{
            background: #5566cc;
            font-size: 3em;
            color: #eeeeee;
            padding:  .25em .5em;
            margin: 0;
            border: 0;
        }

        h2{
            background: #5566cc;
            font-size: 2em;
            color: #eeeeee;
            padding:  .25em .5em;
            margin: -10px -10px 10px -10px;
            border: 0;
        }

        article{
            background: #eeeeee;
            font-size: 1.25em;
            padding: 10px;
            border: solid 1px #2233ff;
            margin: 0 0  0.5em 0 ;

        }

        h3{
            background: #6677dd;
            font-size: 1.5em;
            margin: -10px -10px 0 -10px;
            color: #eeeeee;
            padding:  .25em .5em;
            text-shadow: 0px -1px 1px rgba(0, 0, 0, 0.251);

        }
        h3 a:link, h3 a:hover, h3 a:visited, h3 a:focus{
            color: #eeeeee;
        
        }
        .fakemenuitem{
            display: block;
            font-size: 1.5em;
            text-decoration: none;
            color: #777;
            background: #fff;
            padding: 5px;
            height: 30px;
            border: 1px solid #ccc;
            border-top: 0;
            margin: 0;
            border-bottom: 1px solid #ccc;
            transition: all 300ms cubic-bezier(0.500, 0.460, 0.450, 0.940);
        }
         
        .fakemenuitem:hover{
         
            transform: scale(1);
            background: #ccc;
        }

        /*------Layout------*/

        body {
            margin: 0 auto;
            padding: 2em;
            min-width:60em;
            max-width: 110em;
         }
         #sitewrapper{
            background: #ffffff;
         }
         #sidebar{
            float: left;
         }
         #main{
            margin: 0 0 0 200px;
         }
         footer{
            clear: left;
         }
        </style>
    </head>
     <body>
         <h1>Demonstration Blog!</h1>
         
        <?php 

        include ('./classes/class.blog.php');
        $blog = new blog(array('akbkuku','admin'));
        ?>
        <div id="sitewrapper">
            <div id="sidebar">
                <?php echo $blog->nav('vertical'); ?>
                <a class="fakemenuitem" href="manager.php?area=posts">Login</a>
            </div>
            
            <div id="main">
                <?php echo $blog->posts(); ?>
            </div>
        </div>
     

    </body>
</html>
