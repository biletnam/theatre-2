<? 
    require("adm_header.php"); 
    error_reporting(0);    
?>

<div id="c_main">

<br/><div class=bil_form>

<h2>Брони</h2>

<h3>Выкупаем бронь</h3>

<?
    //выкупаем забронированные билеты
    
    include_once "../func.php";
    $link = db_connect();
    
    $isprod = false;
    $countbil = 0;
    
    session_start();
    
    if($_POST['submitted'] && $_SESSION['sluc']==$_POST['sluc'])	{
        
        switch($_POST["ploshad"])  {
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
        
        $sql_details = 'SELECT fio FROM broni WHERE kod_broni = "'.$_POST['kod_br'].'"'; 
        $result_details = mysql_query($sql_details, $link) or die ("Ошибка запроса"); 
        $arr_pr = mysql_fetch_array($result_details);
        echo "ФИО - ".$arr_pr["fio"]."<br/><br/>"; 
        
        //чекнут ли хотя бы один чекбокс
        $check_atleast_one = false;
        
        for($i=1; $i<=$_POST['cbkol']; $i++) {
            //вернет имя чекбокса
            $cbn = $_POST['cb_'.$i.''];
            
            if(isset($_REQUEST[''.$cbn.'']))   {
                $check_atleast_one = true;    
            }
        }        
        
        $sql_kodpr = 'SELECT kod_prodaji FROM prodaji'; 
        $result_kodpr = mysql_query($sql_kodpr, $link) or die ("Ошибка запроса выборки кода продажи");
        $kod_prod_last = 0;
            
        while ($line_kodpr=mysql_fetch_row($result_kodpr)) { 
            $kod_prod_last = $line_kodpr[0]; 
        }
            
        $kod_pr = $kod_prod_last + 1;
        
        $sum = 0;
        
        //пройдем по пяти предполагаемым чекбоксам
        for($i=1; $i<=$_POST['cbkol']; $i++) { 
            
            //отобразит 'кодсоб_ряд_место'
            $cbn = $_POST['cb_'.$i.''];
            
            //чекнут ли чекбокс
            if(isset($_REQUEST[''.$cbn.'']))   {
                //echo $i." - ".$_POST['ploshad']." - ".$cbn." - true<br/>";   
                
                //если чекнут то выкупаем место    
                $sqlupd = 'UPDATE mesta SET kod_statusa_mesta = "3" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'" AND kod_ploshadki = "'.$_POST['ploshad'].'"';
                $resupd = mysql_query($sqlupd) or die ("Ошибка запроса обновления статуса места при выкупе брони<br>"); 
                
                $date_today = date("Y-m-d H:i:s"); 
                
                $sql_prod = 'INSERT INTO prodaji (kod_prodaji, kod_sobitia, kod_mesta, summa_tek_prodaji, summa_prodaji, data_prodaji, kod_statusa_prodaji) VALUES ("'.$kod_pr.'", "'.$_POST['kod_sob'].'", "'.$_POST['kod_mest_'.$i.''].'", "'.$_POST['cen_'.$i.''].'", "'.$_POST['sum_prod'].'", "'.$date_today.'", "1")';
                $result_prod = mysql_query($sql_prod) or die ("Ошибка запроса добавления в продажи<br>");
                               
                $sqlupdbr = 'UPDATE broni SET kod_statusa_broni = "1", data_vikupa = "'.$date_today.'" WHERE kod_broni = "'.$_POST['kod_br'].'" AND kod_mesta = "'.$_POST['kod_mest_'.$i.''].'"';
                $resupdbr = mysql_query($sqlupdbr) or die ("Ошибка запроса обновления статуса брони при выкупе<br>");
                
                $isprod = true;
                
                $countbil++;
                
                $sum += $_POST['cen_'.$i.''];
            
                $exp=explode("_",$cbn);
                echo "Выкуплено! Площадка ".$pl_name." Ряд ".$exp[2]." Место ".$exp[3]." Цена ".$_POST['cen_'.$i.''].'<br/>';
            }
            else    {
                //хотя бы один чекнут
                if($check_atleast_one == true)  {
                    //не чекнут текущий - аннулируем бронь
                    
                    $sqldel = 'UPDATE mesta SET kod_statusa_mesta = "1" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'" AND kod_ploshadki = "'.$_POST['ploshad'].'"';
                    $resdel = mysql_query($sqldel) or die ("Ошибка запроса update занято<br>"); 
                    
                    $sqldel1 = 'UPDATE broni SET kod_statusa_broni = "3" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'"';
                    $resdel1 = mysql_query($sqldel1) or die ("Ошибка запроса update аннул<br>"); 
                    
                    $exp=explode("_",$cbn);
                    echo "Освобождено! Площадка ".$_POST['ploshad']." Ряд ".$exp[1]." Место ".$exp[2]." Цена ".$_POST['cen_'.$i.''].'<br/>';   
                }                
            }       
        }
        
        if($isprod == true) {
            echo "<br/>По брони выкуплено ".$countbil." билетов на сумму ".$sum." грн <br/>";
            
            echo "<br/>Дата покупки по брони ".$date_today."<br/>";     
        }
        else    {
            echo "<br/>Не выбраны места для выкупа данной брони!<br/><br/>";    
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

<br /><br /><a class=main_afisha href="broni.php">Вернуться к списку броней</a> 

</div>
  
<? require("../pages/footer.php"); ?>