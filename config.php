<?php
    /*===================================================================='\
    |                                                                      |
    |                        lllllll                                       |
    |                        l:::::l                                       |
    |                        l:::::l                                       |
    |                        l:::::l                                       |
    |    ppppp   ppppppppp    l::::l    ooooooooooo     aaaaaaaaaaaaa      |
    |    p::::ppp:::::::::p   l::::l  oo:::::::::::oo   a::::::::::::a     |
    |    p:::::::::::::::::p  l::::l o:::::::::::::::o  aaaaaaaaa:::::a    |
    |    pp::::::ppppp::::::p l::::l o:::::ooooo:::::o           a::::a    |
    |     p:::::p     p:::::p l::::l o::::o     o::::o    aaaaaaa:::::a    |
    |     p:::::p     p:::::p l::::l o::::o     o::::o  aa::::::::::::a    |
    |     p:::::p     p:::::p l::::l o::::o     o::::o a::::aaaa::::::a    |
    |     p:::::p    p::::::p l::::l o::::o     o::::oa::::a    a:::::a    |
    |     p:::::ppppp:::::::pl::::::lo:::::ooooo:::::oa::::a    a:::::a    |
    |     p::::::::::::::::p l::::::lo:::::::::::::::oa:::::aaaa::::::a    |
    |     p::::::::::::::pp  l::::::l oo:::::::::::oo  a::::::::::aa:::a   |
    |     p::::::pppppppp    llllllll   ooooooooooo     aaaaaaaaaa  aaaa   |
    |     p:::::p                                                          |
    |     p:::::p       _____             ___ _                            |
    |    p:::::::p     / ____|           / __(_)                           |
    |    p:::::::p     | |     ___  _ __ | |_ _  __ _                      |
    |    p:::::::p     | |    / _ \| '_ \|  _| |/ _` |                     |
    |    ppppppppp     | |___| (_) | | | | | | | (_| |                     |
    |                  \______\___/|_| |_|_| |_|\__, |                     |
    |                                            __/ |                     |
    |                                           |___/                      |
    |                   _________________________________                  |
    |                  | Variables                       |                 |
    |                  |---------------------------------|                 |
    \'===================================================================='/
                                                                                    
                               SQL Login                                                
                            SQL User:                                       
                         */ $sqluser = 'root'; /*                           
                                                                            
                            SQL Pass:                                       
                         */ $sqlpass = 'password'; /*                       
                                                                            
                            SQL Host:                                       
                         */ $sqlhost = 'localhost'; /*                      
                                                                            
                            SQL Database:                                   
                         */ $sqldata = 'blog'; /*                           
                                                                            
                                                                            
                         Blog Specific                                      
                            Table Name:                                     
                         */ $blog_tbname = 'main';/*                        
                                                                            
                            Title:                                          
                         */ $blog_title = 'Main Blog'; /*                  
                                                                            
                            Blog URL:                                          
                         */ $blog_url = 'http://s-mine.org:8228/'; /*                 
                                                                            
                            Blog Outline Tag:                               
                         */ $blog_ol_tag = 'section class="theme"'; /*                    
                                                                            
                            Blog Header Tag:                                
                         */ $blog_ol_htag = 'h2'; /*                        
                                                                            
                            Post Tag:                                       
                         */ $blog_ps_tag = 'article class="theme"'; /*                    
                                                                            
                            Post Header Tag:                                
                         */ $blog_ps_htag = 'h3'; /*          
                         
                         
                         
                         
                         
                         
                         

//------------------------------------Returns only first word of tags------------------------------------\\      
                         #This allows you to be able to define classes and id's
                                                               
                            Blog Outline Tag:              
                         */ $blog_ol_tagar = explode(" ",$blog_ol_tag,2);
                         	$blog_ol_tagst = $blog_ol_tagar[0]; /*                   
                                                                            
                            Blog Header Tag:             
                         */ $blog_ol_htagar = explode(" ",$blog_ol_htag,2);
                         	$blog_ol_htagst = $blog_ol_htagar[0]; /*                     
                                                                            
                            Post Tag:                                       
                         */ $blog_ps_tagar = explode(" ",$blog_ps_tag,2);
                         	$blog_ps_tagst = $blog_ps_tagar[0]; /*                      
                                                                            
                            Post Header Tag:                   
                         */ $blog_ps_htagar = explode(" ",$blog_ps_htag,2);
                         	$blog_ps_htagst = $blog_ps_htagar[0]; /*                                 
                                                                            
*/?>
