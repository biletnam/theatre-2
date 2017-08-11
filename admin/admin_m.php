<? require("adm_header.php");
error_reporting(0); ?>
   
    <div id="c_main">
       
    <H3>Админ</H3>	     	
	 
    <?
       
    session_start(); 
     
    if (isset($_SESSION['vxod'])) {
        echo "Вход выполнен!";
    }
    else {
        printf ("Доступ закрыт<br/><br/>");
        printf ("<a href=\"../admin.php\">Вход</a>"); 
        die();    
    }     
    
    ?>
       
    <a class="adm_link" href="logout.php">Выйти</a>   
       
    </div>

<? require("../pages/footer.php"); ?>