<? 
    require("header.php"); 
    error_reporting(0);    
?>

<div id="c_main">

<?php

    //добавление новой брони
    session_start(); 
        
    //нажата ли кнопка и совпадает ли значение из скрытого поля со значением из сессии
    if($_POST['submitted'] && $_SESSION['sluc']==$_POST['sluc'])	{
        if(empty($_POST['fio']))	{
        	echo "Укажите ФИО!<br/>";
        }
        if(empty($_POST['telef']))	{
        	echo "Укажите ваш телефон!<br/>";
        }
        if($_POST['kolvo']==0)	{
        	echo "Выберите места!<br/>";
        }
        if(empty($_POST['captcha2']))	{
        	echo "Введите число с картинки!<br/>";
        }
        if($_POST['captcha2'] != $_POST['captcha'])	{
        	echo "Число с картинки введено неверно!<br/>";
        }
        if(!empty($_POST['fio']) && !empty($_POST['telef']) && $_POST['kolvo']!=0 && !empty($_POST['captcha2']) && $_POST['captcha2'] == $_POST['captcha'])	{
        
            include_once "../func.php";
            $link = db_connect();
            
            switch($_POST["plosh"])  {
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

            print "<br/><div class=bil_form>";

            echo '<h3>Детали заказа</h3>';
            
            $sql = 'SELECT kod_predstav, data_predstav FROM afisha WHERE kod_sobitia = "'.$_POST["kod_sobitia"].'"'; 
            $result = mysql_query($sql, $link) or die ("Ошибка запроса выборки из афиши");
            $myrow_kod=mysql_fetch_array($result);
            $kod_predst = $myrow_kod["kod_predstav"];
            echo $myrow_kod["data_predstav"]."<br/><br/>";
            
            $sql2 = 'SELECT predstav FROM repertuar WHERE kod_predstav = "'.$kod_predst.'"'; 
            $result2 = mysql_query($sql2, $link) or die ("Ошибка запроса выборки из репертуара");
            $myrow_kod=mysql_fetch_array($result2);
            echo $myrow_kod["predstav"];           
            
            $sql_kodbr = 'SELECT kod_broni FROM broni ORDER BY kod_broni'; 
            $result_kodbr = mysql_query($sql_kodbr, $link) or die ("Ошибка запроса выборки кода брони");
            $kod_bron_last = 0;
            
            while ($line_kodbr=mysql_fetch_row($result_kodbr)) { 
                $kod_bron_last = $line_kodbr[0]; 
            }
            
            $kod_br = $kod_bron_last + 1;
            
            echo "<br/><br/>Код брони - ".$kod_br."<br/>ФИО - ".$_POST['fio']."<br/>Количество билетов - ".$_POST['kolvo']."<br/>Сумма заказа - ".$_POST['summazak'].' грн<br/><br/>';
            
            $date_today = date("Y-m-d H:i:s");
            
            $rw=explode(" ",$_POST['mesta']);
                
            //вносим бронь по каждому месту
            for ($i=0; $i < count($rw) - 1; $i++) {
                
                $rw2=explode("_",$rw[$i]);
                                
                $shifr = $_POST["kod_sobitia"]."_".$_POST["plosh"]."_".$rw2[0]."_".$rw2[1];
                
                $sql_kodm = 'SELECT kod_mesta FROM mesta WHERE shifr_mesta = "'.$shifr.'"';
                $result3 = mysql_query($sql_kodm) or die ("Ошибка запроса выборки кода места<br>");
                $myrow = mysql_fetch_array($result3);
                $kod_mest = $myrow["kod_mesta"];
                
                $sql = 'INSERT INTO broni (kod_broni, kod_sobitia, kod_mesta, fio, telefon, summa_tek_broni, summa_broni, data_broni, data_vikupa, kod_statusa_broni) VALUES ("'.$kod_br.'", "'.$_POST["kod_sobitia"].'", "'.$kod_mest.'", "'.$_POST['fio'].'", "'.$_POST['telef'].'", "'.$rw2[2].'", "'.$_POST['summazak'].'", "'.$date_today.'", "", "2")';
                $result = mysql_query($sql) or die ("Ошибка запроса вставки брони<br>");
                
                $sql2 = 'UPDATE mesta SET kod_statusa_mesta = "2" WHERE shifr_mesta = "'.$shifr.'" AND kod_ploshadki = "'.$_POST["plosh"].'"';
                $result2 = mysql_query($sql2) or die ("Ошибка запроса обновления статуса места<br>");
                
                //для вывода информации о местах
                echo "Площадка ".$pl_name." Ряд ".$rw2[0]." Место ".$rw2[1]." Цена ".$rw2[2].' грн <br/>';
            }
                        
            echo "<br/>Забронировано ! Бронь действительна в течение суток !<br/>";

            print "<br/></div><br/>";

            //чистим сессию
            unset ($_SESSION['sluc']); 
        
            if ($db > 0) mysql_close($db);
        }
            
        $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
        echo "<br/><a class=main_afisha href=".$url.">Назад</a>"; 
    }
?>

</div>
  
<? require("footer.php"); ?>