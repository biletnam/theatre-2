<? 
    require("adm_header.php"); 
    error_reporting(0);    
?>

<div id="c_main">

<br/><div class=bil_form>

<h2>Продажи</h2>

<h3>Возврат проданных билетов</h3>

<?
    //выкупаем забронированные билеты
    
    include_once "../func.php";
    $link = db_connect();
    
    $isprod = false;
    $countbil = 0;
    
    session_start();
    
    if($_POST['submitted'] && $_SESSION['sluc']==$_POST['sluc'])	{          
            
        switch($_POST['ploshad'])  {
        case 1:
            $pl_name = "партер";
            break;
        case 2:
            $pl_name = "левый бельэтаж";
            break;
        case 3:
            $pl_name = "правый бельэтаж";
            break;
        default:
            break;            
        }    
            
        //инфо о событии
        $sql_sob = 'SELECT kod_predstav, data_predstav FROM afisha WHERE kod_sobitia = "'.$_POST['kod_sob'].'"';
        $result_sob = mysql_query($sql_sob, $link) or die ("Ошибка запроса");
        $arr_sob = mysql_fetch_array($result_sob);
        echo $arr_sob["data_predstav"]."<br/><br/>";
            
        $sql_pred = 'SELECT predstav FROM repertuar WHERE kod_predstav = "'.$arr_sob["kod_predstav"].'"';
        $result_pred = mysql_query($sql_pred, $link) or die ("Ошибка запроса");
        $arr_pred = mysql_fetch_array($result_pred);
        echo $arr_pred["predstav"]."<br/><br/>";
        
        //чекнут ли хотя бы один чекбокс
        $check_atleast_one = false;
        
        for($i=1; $i<=$_POST['cbkol']; $i++) {
            //вернет имя чекбокса
            $cbn = $_POST['cb_'.$i.''];
            
            if(isset($_REQUEST[''.$cbn.'']))   {
                $check_atleast_one = true;    
            }
        }        
        
        $sql_kodret = 'SELECT kod_return FROM returns'; 
        $result_kodret = mysql_query($sql_kodret, $link) or die ("Ошибка запроса выборки кода возврата");
        $kod_ret_last = 0;
            
        while ($line_kodret=mysql_fetch_row($result_kodret)) { 
            $kod_ret_last = $line_kodret[0]; 
        }
            
        $kod_ret = $kod_ret_last + 1;
        
        //пройдем по пяти предполагаемым чекбоксам
        for($i=1; $i<=$_POST['cbkol']; $i++) { 
            
            //отобразит 'кодсоб_ряд_место'
            $cbn = $_POST['cb_'.$i.''];
            
            //чекнут ли чекбокс
            if(isset($_REQUEST[''.$cbn.'']))   {
                //echo $i." - ".$_POST['ploshad']." - ".$cbn." - true<br/>";   
                
                //если чекнут то освобождаем место    
                $sqlupd = 'UPDATE mesta SET kod_statusa_mesta = "1" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'" AND kod_ploshadki = "'.$_POST['ploshad'].'"';
                $resupd = mysql_query($sqlupd) or die ("Ошибка запроса обновления статуса места при освобождении места<br>"); 
                
                $date_today = date("Y-m-d H:i:s"); 
                
                $sql_ret1 = 'UPDATE broni SET kod_statusa_broni = "4" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'"';
                $result_ret1 = mysql_query($sql_ret1) or die ("Ошибка запроса обновления статуса брони<br>");
                
                $sql_ret2 = 'UPDATE prodaji SET kod_statusa_prodaji = "2" WHERE kod_prodaji = "'.$_POST['kod_prod'].'" AND kod_mesta = "'.$_POST['kod_mest_'.$i.''].'"';
                $result_ret2 = mysql_query($sql_ret2) or die ("Ошибка запроса обновления статуса продажи<br>");
                
                $sql_ret3 = 'INSERT INTO returns (kod_return, kod_sobitia, kod_mesta, data_return) VALUES ("'.$kod_ret.'", "'.$_POST['kod_sob'].'", "'.$_POST['kod_mest_'.$i.''].'", "'.$date_today.'")';
                $result_ret3 = mysql_query($sql_ret3) or die ("Ошибка запроса добавления в возвраты<br>");
                
                $isprod = true;
                
                $countbil++;
            
                $exp=explode("_",$cbn);
                echo "Возвращено! Площадка ".$pl_name." Ряд ".$exp[2]." Место ".$exp[3]." Цена ".$_POST['cen_'.$i.''].' грн <br/>';
            }       
        }
        
        if($isprod == true) { 
            echo "<br/>Дата возврата ".$date_today."<br/>";               
        }
        else    {
            echo "<br/>Не выбраны места для возврата !<br/><br/>";    
        }
    }
    
    //чистим сессию
    unset ($_SESSION['sluc']);
    
    mysql_free_result($resupd);
    mysql_free_result($resupdbr); 
    mysql_free_result($result_details);
    mysql_free_result($result_sob);
    mysql_free_result($resdel);
?>

<br/></div><br/>

<br /><br /><a class=main_afisha href="prodaji.php">Вернуться к списку продаж</a> 

</div>
  
<? require("../pages/footer.php"); ?>