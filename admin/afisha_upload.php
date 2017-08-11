<? require("adm_header.php"); 
error_reporting(0);
?>

<div id="c_main">

<br/><div class="bil_form">

<H3>Добавить представление в афишу</H3>

<?php
    //получаем массив данных для редактирования представления
    include_once "../func.php";
    $link = db_connect();
    $ss = $_GET["kod_sobitia"];
    $pp = $_GET["kod_predstav"];
    
    if($ss)	{
        $sql = 'SELECT * FROM afisha WHERE kod_sobitia="'.$ss.'"';
        $result = mysql_query($sql) or die ("Ошибка запроса<br>");
        $myrow2 = mysql_fetch_array($result);
        $id = $myrow2["kod_sobitia"];
        $pr_id = $myrow2["kod_predstav"];
            
        $sql2 = 'SELECT predstav FROM repertuar WHERE kod_predstav="'.$pr_id.'"';
        $result2 = mysql_query($sql2) or die ("Ошибка запроса<br>");
        $myrow = mysql_fetch_array($result2);
    }
    else if($pp)   {    
        $sql = 'SELECT predstav FROM repertuar WHERE kod_predstav="'.$pp.'"';
        $result = mysql_query($sql) or die ("Ошибка запроса<br>");
        $myrow = mysql_fetch_array($result);
        $predst_name = $myrow["predstav"];    
    }
?>

<?php
    //добавление нового представления
    if($_POST['submitted'])	{
    if(empty($_POST['sob_dat']))	{
    	echo "Укажите полную дату представления!<br/>";
    }
    if(is_uploaded_file($_FILES["file_cen_parter"]["tmp_name"]) == false || is_uploaded_file($_FILES["file_cen_belle_l"]["tmp_name"]) == false || is_uploaded_file($_FILES["file_cen_belle_r"]["tmp_name"]) == false)	{
    	echo "Выберите файл цен!<br/>";
    }
    if($_FILES["file_cen_parter"]["type"] != 'application/vnd.ms-excel' || $_FILES["file_cen_belle_l"]["type"] != 'application/vnd.ms-excel' || $_FILES["file_cen_belle_r"]["type"] != 'application/vnd.ms-excel')	{
    	echo "Файл цен должен быть формата csv!<br/>";
    }
    if(!empty($_POST['sob_dat']) && is_uploaded_file($_FILES["file_cen_parter"]["tmp_name"]) == true && is_uploaded_file($_FILES["file_cen_belle_l"]["tmp_name"]) == true && is_uploaded_file($_FILES["file_cen_belle_r"]["tmp_name"]) == true && 
        $_FILES["file_cen_parter"]["type"] == 'application/vnd.ms-excel' && $_FILES["file_cen_belle_l"]["type"] == 'application/vnd.ms-excel' && $_FILES["file_cen_belle_r"]["type"] == 'application/vnd.ms-excel')	{
    
    include_once "../func.php";
    $link = db_connect();
    
        $data_str = $_POST['sob_dat'];
        $data_time = strtotime($data_str);
        
        $poln_date = date("d.m.Y H:i", $data_time);    
    
    if($id)	{
        $sql = 'UPDATE afisha SET data_predstav="'.$poln_date.'" WHERE kod_sobitia="'.$id.'"';
        $result = mysql_query($sql) or die ("Ошибка запроса обновления афиши<br>");
    }
    else	{    
        
        $f = '../ceni/'.$_FILES["file_cen_parter"]["name"].''; 
        $f_bl = '../ceni/'.$_FILES["file_cen_belle_l"]["name"].'';
        $f_br = '../ceni/'.$_FILES["file_cen_belle_r"]["name"].'';       

        //Если файл загружен успешно, перемещаем его из временной директории в конечную
        move_uploaded_file($_FILES["file_cen_parter"]["tmp_name"], "/home/dnua/dnua.biz/theatre/" ."ceni/".$_FILES["file_cen_parter"]["name"]);
        move_uploaded_file($_FILES["file_cen_belle_l"]["tmp_name"], "/home/dnua/dnua.biz/theatre/" ."ceni/".$_FILES["file_cen_belle_l"]["name"]);
        move_uploaded_file($_FILES["file_cen_belle_r"]["tmp_name"], "/home/dnua/dnua.biz/theatre/" ."ceni/".$_FILES["file_cen_belle_r"]["name"]);
        
        $sql = 'INSERT INTO afisha (kod_predstav, data_predstav, file_cen_parter, file_cen_belle_l, file_cen_belle_r) VALUES ("'.$pp.'", "'.$poln_date.'", "'.$f.'", "'.$f_bl.'", "'.$f_br.'")';
        $result = mysql_query($sql) or die ("Ошибка запроса добавления в афишу<br>");
        
        $sql2 = 'SELECT kod_sobitia FROM afisha WHERE kod_predstav = "'.$pp.'" AND data_predstav = "'.$poln_date.'"'; 
        $result2 = mysql_query($sql2, $link) or die ("Ошибка запроса выборки из афиши");
        $myrow4 = mysql_fetch_array($result2);
        
        include("mesta.php");
        
        fillHalls($myrow4["kod_sobitia"]);       
    }
    
    if($id)	{
        $str = "Представление отредактировано !<br/><br/>";
    }
    else	{
        $str = "Представление добавлено в афишу !<br/><br/>";
    }
    echo $str;
    
    if ($db > 0) mysql_close($db);
    }
    }
?>

<form method="POST" action="<?php echo $PHP_SELF?>" enctype="multipart/form-data">

<table class="bil_form_in">
    <tr>
    <td><input type=hidden name="id" value="<?php echo $myrow2["kod_sobitia"]?>"></td>
    </tr>

    <tr>
    <td>Название представления:</td>
    <td><input type="text" name="name" size=55 value="<?php echo $myrow["predstav"]?>" readonly></td>
    </tr>

    <tr>
    <td>Дата представления:</td>
    <td><input type="datetime-local" name="sob_dat" size=55 value="<?php echo $myrow2["data_predstav"]?>" required /></td>
    </tr>

    <tr><td>Файл цен:</td><td>Партер:</td></tr>
    <tr><td></td><td><input name="file_cen_parter" type="file"></td></tr>

    <tr><td></td><td>Бельэтаж (Левая сторона):</td></tr>
    <tr><td></td><td><input name="file_cen_belle_l" type="file"></td></tr>

    <tr><td></td><td>Бельэтаж (Правая сторона):</td></tr>
    <tr><td></td><td><input name="file_cen_belle_r" type="file"></td></tr>
</table>

<br/>
<input type="submit" class="tog" name="submitted" value="Отправить" />
<input type="reset" class="tog" name="reset" value="Очистить" />

</form>

<br/></div>

<br /><br />

</div>

<? require("../pages/footer.php"); ?>

