<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
        <title>Театр</title>
        <link rel="stylesheet" type="text/css" href="../styles/afisha_style.css" />
        <link rel="stylesheet" type="text/css" href="../styles/effects_js.css" />
        <link rel="stylesheet" type="text/css" href="../styles/<?php include("../browsers.php");?>" />
    </head>
<body>
    
<div id="outer">

	<div id="header">

        <div id="titul">
            <?php
                session_start();
                unset ($_SESSION['vxod']);
            ?>

            <a class="titul_link" href="http://theatre.dnua.biz">THEATRE</a>
        </div>
        
		<div id="menu_line">
			<div id="top_menu">
			<ul>
			<li><a class="lmen" href="afisha_mon.php?af_mesiac=june2013" target="_self">АФИША</a></li>
			</ul>
			</div>  
		</div>
        
        <div id="adm">
            <?
       
            session_start(); 
             
            if (isset($_SESSION['vxod'])) {
                echo "Вход выполнен!";
                printf (" <a class=adm_link href=\"logout.php\">Выйти</a>"); 
            }
            else {
                printf (" <a class=adm_link href=\"../admin.php\">Войти</a>"); 
                //die();    
            }     
            
            ?>
  
        </div>
	
    </div>