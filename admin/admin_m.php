<? require("adm_header.php");
error_reporting(0); ?>
   
    <div id="c_main">
       
    <H3>�����</H3>	     	
	 
    <?
       
    session_start(); 
     
    if (isset($_SESSION['vxod'])) {
        echo "���� ��������!";
    }
    else {
        printf ("������ ������<br/><br/>");
        printf ("<a href=\"../admin.php\">����</a>"); 
        die();    
    }     
    
    ?>
       
    <a class="adm_link" href="logout.php">�����</a>   
       
    </div>

<? require("../pages/footer.php"); ?>