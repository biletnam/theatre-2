<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
        <title>�����</title>
        <link rel="stylesheet" type="text/css" href="../styles/afisha_style.css" />
        <link rel="stylesheet" type="text/css" href="../styles/effects_js.css" />
        <link rel="stylesheet" type="text/css" href="../styles/<?php include("../browsers.php");?>" />
    </head>
<body>
    
<div id="outer">

	<div id="header">

        <div id="titul">
            <a class="titul_link" href="http://theatre.dnua.biz">THEATRE</a>
        </div>
		
		<div id="menu_line">
			<div id="top_menu">
			<ul>
			<li><a class="lmen" href="repertuar.php?rep_god=2013" target="_self">���������</a></li>
            <li><a class="lmen" href="afisha.php?af_mesiac=june2013" target="_self">�����</a></li>
            <li><a class="lmen" href="broni.php" target="_self">�����</a></li>
            <li><a class="lmen" href="prodaji.php" target="_self">�������</a></li>
			</ul>
			</div>		
        </div>
        
        <div id="adm">
            <?
       
            session_start(); 
             
            if (isset($_SESSION['vxod'])) {
                echo "���� ��������!";
            }
            else {
                echo "������ ������!";
                printf (" <a class=adm_link href=\"../admin.php\">����</a>"); 
                die();    
            }     
            
            ?>
       
            <a class=adm_link href="logout.php">�����</a>
        </div>
	
    </div> 