<?php
        
    session_start(); 
        
    unset ($_SESSION['vxod']); 
    
    header('Location: ../admin.php');
   
?>