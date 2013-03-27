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
    |                                                                      |
    |                                                                      |
    \'===================================================================='/
                                                                                    
                        SQL                                              
                            SQL User:                                       
                         */ $sqluser = 'root'; /*                           
                                                                            
                            SQL Pass:                                       
                         */ $sqlpass = 'password'; /*                       
                                                                            
                            SQL Host:                                       
                         */ $sqlhost = 'localhost'; /*                      
                                                                            
                            SQL Database:                                   
                         */ $sqldata = 'blog'; /*         
                                         
                            Table Name:                                     
                         */ $blog_tbname = 'main';/*                         
                                                                            
                                                                            
                         Blog Info                                       
                                                                            
                            Title:                                          
                         */ $blog_title = 'Main Blog'; /*                  
                                                                            
                            Blog URL:                                          
                         */ $blog_url = 'http://127.0.0.1:8124/'; /*   
                         
                                                   
                                                                            
                         Blog Settings                                     
                                                                            
                            Number of posts to show:                                
                         */ $blog_ps_count = 5; /*                  
                                                                            
                            Show blog title:                                
                         */ $blog_title_show = true; /*           
                                                                            
                            Show blog Navigation:                                
                         */ $blog_nav_show = true; /*           
                                                                            
                            Blog Navigation Type:          'horizontal' OR 'vertical'                      
                         */ $blog_nav_type = 'vertical'; /*       
                                
                                                                            
                         Blog Tags     
                                                                            
                            Blog Outline Tag:                               
                         */ $blog_ol_tag = 'section class="theme"'; /*                    
                                                                            
                            Blog Header Tag:                                
                         */ $blog_ol_htag = 'h2'; /*                                 
                                                                            
                            Blog Nav Tag:                                
                         */ $blog_ol_navtag = 'div class="nav"'; /*                        
                                                                            
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
                                                                            
                            Blog Nav Tag:             
                         */ $blog_ol_navtagar = explode(" ",$blog_ol_htag,2);
                             $blog_ol_navtagst = $blog_ol_htagar[0]; /*                     
                                                                            
                            Post Tag:                                       
                         */ $blog_ps_tagar = explode(" ",$blog_ps_tag,2);
                             $blog_ps_tagst = $blog_ps_tagar[0]; /*                      
                                                                            
                            Post Header Tag:                   
                         */ $blog_ps_htagar = explode(" ",$blog_ps_htag,2);
                             $blog_ps_htagst = $blog_ps_htagar[0]; /*                                 
                                                                            
*/?>
