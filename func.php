<?
    //соединение с базой
    function db_connect()   {
        $_SITE_NAME = 'http://theatre.dnua.biz';
    	$db="dnua_theatre";
    	
        $host="dnua.mysql.ukraine.com.ua";
    	$user="dnua_theatre";
    	$pwd = "w7ase9ur";
    
    	$link = mysql_connect($host, $user, $pwd) or die ("Невозможно соединиться");
    	mysql_select_db($db,$link) or die ("Не возможно выбрать данную БД");  
    	mysql_set_charset('cp1251');
        
        return $link;
    }
    
    //капча
    function captcha()  {
        $captcha = rand(10000,99999);
        return $captcha;
    }
    
    //преобразует полную дату в строковом формате в формат времени и выделяет необходимые составляющие (в данной функции - месяц и год)
    //используется при формировании афиши на конкретный месяц 
    // admin/afisha.php
    function data_to_mes($data_str) {
        
        //$data_str = $_POST['sob_dat'];
        $data_time = strtotime($data_str);
        
        $poln_date = date("d.m.Y H:i", $data_time);    
        
        $giorno[0]="Воскресенье"; 
        $giorno[1]="Понедельник"; 
        $giorno[2]="Вторник"; 
        $giorno[3]="Среда"; 
        $giorno[4]="Четверг"; 
        $giorno[5]="Пятница"; 
        $giorno[6]="Суббота"; 
        
        $gisett = (int)date("w", $data_time);
        $day = $giorno[$gisett]; 
        
        $date2 = date("d", $data_time)." ".$day." ".date("H:i", $data_time);
        
        $mese[0]=""; 
        $mese[1]="Январь"; 
        $mese[2]="Февраль"; 
        $mese[3]="Март"; 
        $mese[4]="Апрель"; 
        $mese[5]="Май"; 
        $mese[6]="Июнь"; 
        $mese[7]="Июль"; 
        $mese[8]="Август"; 
        $mese[9]="Сентябрь"; 
        $mese[10]="Октябрь"; 
        $mese[11]="Ноябрь"; 
        $mese[12]="Декабрь";
        
        $mesnum=(int)date("m", $data_time); 
        $mesiac = $mese[$mesnum];
        
        $date3 = $mesiac." ".date("Y", $data_time)." год";
        
        //echo date("d/m/Y H:m", strtotime('2011-12-17 17:41:59'));
        
        return $date3;    
    }
    
    function predst_podrobno()  {
        //получаем массив для просмотра всей афиши
        $link = db_connect();
        $sql = 'SELECT predstav, opisanie, prod_predst, main_foto, pic1, pic2, pic3, pic4, pic5, foto_author, opis_full FROM repertuar WHERE kod_predstav = "'.$_GET["kod_predstav"].'"';
        $result = mysql_query($sql, $link) or die ("Ошибка запроса");
        
        while ($line=mysql_fetch_row($result)) {            
            for ($i=0; $i<count($line); $i++) {
                if ($line[$i]) {
                    
                    if ($i == 0) {
                        print '<br/><h2>'.$line[$i].'</h2><br/>';  
                    }
                    else    {
                        print '<br/>'.$line[$i].'<br/>';      
                    }
                }
            }
        }
        
        mysql_free_result($result);
        if ($db > 0) mysql_close($db);
    }
    
    //формирование афиши 
    // admin/afisha.php
    // pages/afisha_mon.php
    function form_afisha($flag, $mes) {
        
        //получаем массив для просмотра всей афиши
        $link = db_connect();   
        $sql = 'SELECT kod_sobitia, kod_predstav, data_predstav FROM afisha ORDER BY data_predstav'; 
        $result = mysql_query($sql, $link) or die ("Ошибка запроса выборки из афиши");
        
        print '<div class=outer_table>';
                        
        while ($line=mysql_fetch_row($result)) { 
            
            $mes_year = data_to_mes($line[2]);
            
            if($mes_year != $mes)   {
                continue;
            }
            
            //из репертуара
            $sql2 = 'SELECT predstav, opisanie, prod_predst, main_foto FROM repertuar WHERE kod_predstav = "'.$line[1].'"';
            $result2 = mysql_query($sql2, $link) or die ("Ошибка запроса выборки из репертуара");
            $myrow=mysql_fetch_array($result2);                                                                        
                   
            if($flag == "admin")    {
                print '<div class=left_table><table width=350px>';
                                
                //дата и время представления
                print '<tr><td class=yellow_zag_table>'.$line[2].'</td></tr>';
                
                printf ("<tr><td class=afisha_pred><a class=afisha_pred href=\"podrobno.php?kod_predstav=%s\">".$myrow["predstav"]."</a></td></tr>", $line[1]);
            }
            else    {
                print '<div class=left_table><table width=450px>';
                                
                //дата и время представления
                print '<tr><td class=yellow_zag_table>'.$line[2].'</td></tr>';
                
                printf ("<tr><td class=afisha_pred><a class=afisha_pred href=\"podrobno_spec.php?kod_predstav=%s\">".$myrow["predstav"]."</a></td></tr>", $line[1]);
            }
                    
            print '<tr><td>'.$myrow["opisanie"].'</td></tr>';
            print '<tr><td>'.$myrow["prod_predst"].'</td></tr>';
            print '<tr><td>'.$myrow["main_foto"].'</td></tr>';                                                                                     
                                                                                            
            print '</table></div>';                        
                        
            if($flag != "admin")    {
                print '<div class=center_table><table width=450px>';
                
                printf ("<tr><td class=yellow_zag_table>Бронь билетов</td></tr>");
                printf ("<tr><td><a class=main_afisha href=\"../pages/bron.php?kod_sobitia=%s&plosh=1\">Партер</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"../pages/bron.php?kod_sobitia=%s&plosh=2\">Бельэтаж (Левая сторона)</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"../pages/bron.php?kod_sobitia=%s&plosh=3\">Бельэтаж (Правая сторона)</a></td></tr>", $line[0]);                                                        
            
                print '</table></div>';
            }
            else    {
                print '<div class=center_table><table width=350px>';
                
                printf ("<tr><td class=yellow_zag_table>Продажа билетов</td></tr>");
                printf ("<tr><td><a class=main_afisha href=\"prod.php?kod_sobitia=%s&plosh=1\">Партер</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"prod.php?kod_sobitia=%s&plosh=2\">Бельэтаж (Левая сторона)</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"prod.php?kod_sobitia=%s&plosh=3\">Бельэтаж (Правая сторона)</a></td></tr>", $line[0]);
                                                                                                               
                print '</table></div>';
                            
                print '<div class=right_table><table width=350px>';
                            
                printf ("<tr><td><a class=main_afisha href=\"broni.php?kod_sobitia=%s\">Просмотреть брони</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"prodaji.php?kod_sobitia=%s\">Просмотреть продажи</a></td></tr>", $line[0]);
     			printf ("<tr><td><a class=main_afisha href=\"afisha_upload.php?kod_sobitia=%s\">Редактировать</a></td></tr>", $line[0]);
      		    printf ("<tr><td><a class=main_afisha href=\"afisha.php?af_mesiac=$mesiac&kod_sobitia=%s&del=4\" onclick=\"return confirmAction();\">Удалить</a></td></tr>", $line[0]);                                
                
                print '</table></div>';
            }                   
        }
        
        print '</div>';        
                
        mysql_free_result($result);
        mysql_free_result($result2);
        if ($db > 0) mysql_close($db);     
    }
    
    //формирование карты зала для бронирования и продажи билетов
    // admin/prod.php
    // pages/bron.php 
    function form_hall($flag)    {
        
        $flag_kol = $flag;
        
        $plosh=$_GET["plosh"];
        $kod_sobitia=$_GET["kod_sobitia"];
    
        //получаем массив для просмотра всей афиши
        include_once "../func.php";
        $link = db_connect();
        
        $sql = 'SELECT kod_predstav, data_predstav FROM afisha WHERE kod_sobitia = "'.$_GET["kod_sobitia"].'"'; 
        $result = mysql_query($sql, $link) or die ("Ошибка запроса выборки из афиши");
        $myrow=mysql_fetch_array($result);
        $kod_predst = $myrow["kod_predstav"];
        echo $myrow["data_predstav"]."<br/><br/>";
        
        $sql2 = 'SELECT predstav FROM repertuar WHERE kod_predstav = "'.$kod_predst.'"'; 
        $result2 = mysql_query($sql2, $link) or die ("Ошибка запроса выборки из репертуара");
        $myrow=mysql_fetch_array($result2);
        echo $myrow["predstav"];
            
        mysql_free_result($result);
        if ($db > 0) mysql_close($db);
                
        print '<center><br /><br />';
        
        if ($plosh==1)	{
    	   $st=file("../zali/ope-parter.csv");
    	   $stpri=file("../zali/ope-parter-price1.csv");
    	   $cena[0]=50;
           $cena[1]=80;
    	}
        
        if ($plosh==2)  {
    	   $st=file("../zali/ope-belleleft.csv");
    	   $stpri=file("../zali/ope-belleleft-price.csv");
    	   $cena[0]=30;
    	   $cena[1]=40;
    	}
    	
        if ($plosh==3)	{
    	   $st=file("../zali/ope-belleright.csv");
    	   $stpri=file("../zali/ope-belleright-price.csv");
    	   $cena[0]=30;
    	   $cena[1]=40;
    	}
        
        if (!isset($plosh))	{
            $st=file("../zali/ope-parter.csv");
    		$stpri=file("../zali/ope-parter-price1.csv");
    	}
            
        $color1[0] = '#fdf7dd'; //#ff2a00
        $color1[1] = '#fee3da'; //#ffa200
        
        $bron = '#ef6c63';
        $zaniato = '#ff31af';
        
        $sqlbron = 'SELECT riad, mesto FROM mesta WHERE kod_sobitia = "'.$_GET["kod_sobitia"].'" AND kod_ploshadki = "'.$plosh.'" AND kod_statusa_mesta = "2"'; 
        $res = mysql_query($sqlbron, $link) or die ("Ошибка запроса");
        
        $sqlzan = 'SELECT riad, mesto FROM mesta WHERE kod_sobitia = "'.$_GET["kod_sobitia"].'" AND kod_ploshadki = "'.$plosh.'" AND kod_statusa_mesta = "3"'; 
        $reszan = mysql_query($sqlzan, $link) or die ("Ошибка запроса");
        
        echo "<div class=\"seats\"><table class=small_seat_table border=0 cellSpacing=1>
            <tr><td width=23 height=23 style=\"BACKGROUND-COLOR: ".$color1[1]."; border: 1px solid #000;\"></td><td style=\"font-size: medium;\"> - место свободно</td></tr>
            <tr><td width=23 height=23 style=\"BACKGROUND-COLOR: ".$color1[0]."; border: 1px solid #000;\"></td><td style=\"font-size: medium;\"> - место свободно</td></tr>
            <tr><td width=23 height=23 style=\"BACKGROUND-COLOR: ".$bron."; border: 1px solid #000;\"></td><td style=\"font-size: medium;\"> - место забронировано</td></tr>
            <tr><td width=23 height=23 style=\"BACKGROUND-COLOR: ".$zaniato."; border: 1px solid #000;\"></td><td style=\"font-size: medium;\"> - место занято</td></tr>
            </table>";
        
        print '<br/><br/>';
        
        $draw_flag = false;
        
        $draw_zan_flag = false;
     
        print '<table class=small_seat_table border=0 cellSpacing=1><tbody>';
        
        //начало генерации рядов
    	
        for ($i=0; $i<count($st); $i++) {
            $rw=explode(";",$st[$i]);
        	$rwpri=explode(";",$stpri[$i]);
        	echo "<TR id=row_" . $i . "><TD>" . $rw[0] . " ряд</TD><TD width=12>&nbsp;</TD><TD width=12>&nbsp;</TD>";  //начало ряда
            
            for ($j=1; $j<count($rw); $j++) {
                
                //забронированные места
                $draw_flag = false;
                
                mysql_free_result($res);
                $res = mysql_query($sqlbron, $link) or die ("Ошибка запроса");
                
                while ($line=mysql_fetch_row($res)) {
                    if($line[0] == $rw[0] && $line[1] == $rw[$j])   {
                        echo "<TD class=nbt style=\"BACKGROUND-COLOR: ".$bron."\" id=col_".$i."_".$j." width=12>".$rw[$j]."</TD>";
                        $draw_flag = true;
                        break; 
                    }
                }
                
                //занятые места
                $draw_zan_flag = false;
                
                if($draw_flag != true)  {                
                    mysql_free_result($reszan);
                    $reszan = mysql_query($sqlzan, $link) or die ("Ошибка запроса");
                    
                    while ($linezan=mysql_fetch_row($reszan)) {
                        if($linezan[0] == $rw[0] && $linezan[1] == $rw[$j])   {
                            echo "<TD class=nbt style=\"BACKGROUND-COLOR: ".$zaniato."\" id=col_".$i."_".$j." width=12>".$rw[$j]."</TD>";
                            $draw_zan_flag = true;
                            break; 
                        }
                    }
                }
               
               //свободные места
               if($draw_flag != true && $draw_zan_flag != true)  {
                    if ($rw[$j]>0)   {
                        if ($rwpri[$j]==$cena[0]) {
                            $currcolor=$color1[0];
                        }
                                        
                        if ($rwpri[$j]==$cena[1]) {
                            $currcolor=$color1[1];
                        }
                					
                        echo "<TD id=col" . $rw[0] . "_" . $rw[$j] . "-" . $rwpri[$j] . " class=nbt style=\"BACKGROUND-COLOR: ".$currcolor."\" title=\"Цена: $rwpri[$j] грн.\"  onclick=\"process_frag3('#col" . $rw[0] . "_" . $rw[$j] . "-" . $rwpri[$j] . "','".$flag_kol."')\" >" . $rw[$j] . "</TD>\n"; 
                   } 
                   else	{
                    	echo "<TD id=col00 class=pust>" . $rw[$j] . "</TD>\n";
               	   }           
               }
            }
         
            //onclick=\"return process_frag(col_" . $i . "_" . $j . ")"\"
            //конец ряда
            
            echo "</TR><TR class=trprox><TD class=tdprox>&nbsp;</TD><TD class=tdprox>&nbsp;</TD></TR>";
        }
        
        print '</tbody></table></div></center><br /><br />';
        
        mysql_free_result($res);
        if ($db > 0) mysql_close($db);      
    }
    
?>