<? require("header_m.php"); 
error_reporting(0);
?>    
    
<div id="c_main">
<H3>Админ</H3>

<?php

session_start(); 

if (isset($_SESSION['vxod'])) {
    header('Location: admin/admin_m.php');
}

if($_POST['submitted'] && (empty($_POST['log']) || empty($_POST['pass'])))	{
    $info_err = "Введите данные!<br/><br/>";
    echo $info_err;      
}
if($_POST['submitted'] && !empty($_POST['log']) && !empty($_POST['pass']))	{
    
    $_SESSION['login'] = $_POST['log']; 
    $_SESSION['passw'] = $_POST['pass'];

    include "func.php";
    $link = db_connect();
    $sql = "SELECT admin_id FROM admin WHERE login = '".$_SESSION['login']."' AND password = '".sha1($_SESSION['passw'])."' ";
    $result = mysql_query($sql, $link) or die ("Ошибка запроса");
        
    if(mysql_num_rows($result) != 0) {
        $str = "Вход выполнен !";
  		echo $str;
        
        $_SESSION['vxod'] = 5;
        
        header('Location: admin/admin_m.php');
    }
    else   {
        $info_err = "Неверный логин или пароль !<br/><br/>";
        echo $info_err; 
          
        unset ($_SESSION['vxod']); 
    } 
    
    mysql_free_result($result);
    if ($db > 0) mysql_close($db);
}

?>

<div class="enter_form">

<form method="POST" action="<?php echo $PHP_SELF?>" enctype="multipart/form-data">

<input type=hidden name="adm_id">
Login:<br/>
<input class="input_data" type="text" name="log" size=25 required><br/>
Password:<br/>
<input class="input_data" type="password" name="pass" size=25 required><br/><br/>

<input class="tog" type="submit" name="submitted" value="Войти" />

</form>

</div>

</br>

</div>	

<? require("pages/footer.php"); ?>