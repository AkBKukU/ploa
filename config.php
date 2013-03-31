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
    |             */include('class.ConfigHandler.php');
                    $config = new ConfigHandler(__DIR__.'/'.'settings.cfg');/*         |
    |                                                                      |
    \'===================================================================='/
                                                                                    
                        SQL                                              
                            SQL User:                
                         */ $sqluser = $config->getValue('sql-user'); /*                           
                                                                            
                            SQL Pass:                                       
                         */ $sqlpass = $config->getValue('sql-pass'); /*                       
                                                                            
                            SQL Host:                                       
                         */ $sqlhost = $config->getValue('sql-host'); /*                      
                                                                            
                            SQL Database:                                   
                         */ $sqldata = $config->getValue('sql-database'); /*         
                                         
                            Table Name:                                     
                         */ $blog_tbname = $config->getValue('sql-table');/*                         
                                                                            
                                                                            
                         Blog Info                                       
                                                                            
                            Title:                                          
                         */ $blog_title = $config->getValue('blog-title'); /*                  
                                                                            
                            Blog URL:                                          
                         */ $blog_url = $config->getValue('blog-url'); /*   
                         
                                                   
                                                                            
                         Blog Settings                                     
                                                                            
                            Number of posts to show:                                
                         */ $blog_ps_count = $config->getValue('blog-posts-to-show'); /*                  
                                                                            
                            Show blog title:                                
                         */ $blog_title_show = $config->getValue('blog-show-title'); /*           
                                                                            
                            Show blog Navigation:                                
                         */ $blog_nav_show = $config->getValue('blog-show-nav'); /*           
                                                                            
                            Blog Navigation Type:          'horizontal' OR 'vertical'                      
                         */ $blog_nav_type = $config->getValue('blog-nav-type'); /*             
                                                                            
                            Manager Logmin Passwordn:                                
                         */ $blog_pass = $config->getValue('blog-login-pass'); /*       
                                
                                                                            
                         Blog Tags     
                                                                            
                            Blog Outline Tag:                               
                         */ $blog_ol_tag = $config->getValue('blog-full'); /*                    
                                                                            
                            Blog Header Tag:                                
                         */ $blog_ol_htag = $config->getValue('blog-header'); /*                                 
                                                                            
                            Blog Nav Tag:                                
                         */ $blog_ol_navtag = $config->getValue('blog-nav'); /*                        
                                                                            
                            Post Tag:                                       
                         */ $blog_ps_tag = $config->getValue('blog-post'); /*                    
                                                                            
                            Post Header Tag:                                
                         */ $blog_ps_htag = $config->getValue('blog-post-header'); /*               
                         
                         
                         
                         
                         
//----------------------------------------------Do not modify!-------------------------------------------\\     
//------------------------------------Returns only first word of tags------------------------------------\\
                         #This allows you to be able to define classes and id's
                                                               
                            Blog Outline Tag:              
                         */ $blog_ol_tagar = explode(" ",$blog_ol_tag,2);
                             $blog_ol_tagst = '</'.str_replace('>','',substr($blog_ol_tagar[0],1)).'>'; /*                   
                                                                            
                            Blog Header Tag:             
                         */ $blog_ol_htagar = explode(" ",$blog_ol_htag,2);
                             $blog_ol_htagst = '</'.str_replace('>','',substr($blog_ol_htagar[0],1)).'>'; /*                
                                                                            
                            Blog Nav Tag:             
                         */ $blog_ol_navtagar = explode(" ",$blog_ol_htag,2);
                             $blog_ol_navtagst = '</'.str_replace('>','',substr($blog_ol_htagar[0],1)).'>'; /*                     
                                                                            
                            Post Tag:                                       
                         */ $blog_ps_tagar = explode(" ",$blog_ps_tag,2);
                             $blog_ps_tagst = '</'.str_replace('>','',substr($blog_ps_tagar[0],1)).'>'; /*                      
                                                                            
                            Post Header Tag:                   
                         */ $blog_ps_htagar = explode(" ",$blog_ps_htag,2);
                             $blog_ps_htagst = '</'.str_replace('>','',substr($blog_ps_htagar[0],1)).'>'; /*                                 
                                                                             
//-----------------------------------------------Ploa settings-------------------------------------------\\
  
                            Ploa Homepage:                                          
                         */ $ploa_url = 'https://github.com/AkBKukU/ploa'; /*   
*/?>
