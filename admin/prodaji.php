<? 
    require("adm_header.php"); 
    error_reporting(0);    
?>

<div id="c_main">

<h2>Продажи</h2>

<?    
    $kod_sob = $_GET["kod_sobitia"];
    
    echo "<table class=tab_bot>
        <tr><td class=tab_bot width=23 height=23></td><td class=tab_words> билет продан</td></tr>
        <tr><td class=tab_ret width=23 height=23></td><td class=tab_words> билет возвращен</td></tr>
        </table><br/>";       

    //получаем массив для просмотра всех продаж
    include_once "../func.php";
    $link = db_connect();
    
    if($kod_sob)    {
        $sql = 'SELECT kod_prodaji, kod_sobitia, kod_mesta, summa_prodaji, data_prodaji, kod_statusa_prodaji FROM prodaji WHERE kod_sobitia = "'.$kod_sob.'" ORDER BY kod_prodaji';      
    }
    else    {
        $sql = 'SELECT kod_prodaji, kod_sobitia, kod_mesta, summa_prodaji, data_prodaji, kod_statusa_prodaji FROM prodaji ORDER BY kod_prodaji';          
    }
    
    $result = mysql_query($sql, $link) or die ("Ошибка запроса выборки продаж");
    
    //механизм защиты от повторной отправки формы при обновлении страницы
    session_start();
        
    $sluc = rand(1,32768);
        
    $_SESSION['sluc'] = $sluc;
    
    $line_pred = 0;
    
    //пройдемся по продажам
    while ($line=mysql_fetch_row($result)) {
        
        //если следующая продажа с таким же кодом что и предыдущая - пропускаем. выводим одну уникальную       
        if($line[0] == $line_pred)   {
            continue;            
        }
        
        $line_pred = $line[0];
        
        //для раскрашивания при любом возврате (проблема первого чекбокса)
        $sql_ras = 'SELECT kod_statusa_prodaji FROM prodaji WHERE kod_prodaji = "'.$line[0].'"'; 
        $result_ras = mysql_query($sql_ras, $link) or die ("Ошибка запроса выборки продаж");
        
        $co_ras_pr = 0;
        $co_ras_vz = 0;
        
        while ($line_ras=mysql_fetch_row($result_ras)) {
            //если возврат
            if($line_ras[0] == "1") {
                $co_ras_pr++;
            }
            else if($line_ras[0] == "2")    {
                $co_ras_vz++;   
            }
        }
        
        if($co_ras_pr > 0 && $co_ras_vz == 0)  {
            print '<table width=70% class=tab_bot><tr>';    
        }
        else if($co_ras_vz > 0)  {
            print '<table width=70% class=tab_ret><tr>';
        }
        
        $kod_prod = $line[0];
        
        //выводим информацию о продажах 
        for ($i=0; $i<count($line); $i++) {
            if ($line[$i]) {                
                if($i == 0) {
                    print '<td width=1% title = "Код продажи">'.$line[0].'</td>';     
                }
                if($i == 1) {                    
                    $sql2 = 'SELECT kod_predstav, data_predstav FROM afisha WHERE kod_sobitia = "'.$line[1].'"'; 
                    $result2 = mysql_query($sql2, $link) or die ("Ошибка запроса");
                    $arr2 = mysql_fetch_array($result2);
                    
                    $sql_pr = 'SELECT predstav FROM repertuar WHERE kod_predstav = "'.$arr2["kod_predstav"].'"'; 
                    $result_pr = mysql_query($sql_pr, $link) or die ("Ошибка запроса");
                    $arr_pr = mysql_fetch_array($result_pr);
                    
                    print '<td width=2% title = "Событие">'.$arr_pr["predstav"].'</td>';  
                    print '<td width=1% title = "Дата события">'.$arr2["data_predstav"].'</td>'; 
                }
                if($i == 3) {
                    print '<td width=1% title = "Сумма продажи">'.$line[3].' грн </td>';          
                } 
                if($i == 4) {
                    print '<td width=1% title = "Дата продажи">'.$line[4].'</td>';          
                    $podr = "podr".$line[0];
                    print '<td width=1%><div class=tog title = "'.$podr.'" onclick=toglin("'.$line[0].'","'.true.'")>Развернуть</div></td>';   
                }    
            }
        }
        
        print '</tr>';
        print '</table>';
        
        //по нажатию подробнее - выплывает новая таблица с инфой о местах по продаже
        $sql_mest = 'SELECT kod_mesta, summa_tek_prodaji, kod_statusa_prodaji FROM prodaji WHERE kod_prodaji = "'.$kod_prod.'"'; 
        $result_mest = mysql_query($sql_mest, $link) or die ("Ошибка запроса выборки кодов мест из продажи");
        
        print '<div class=podrobn title = "'.$line[0].'">';
        print '<table width=50% class=tab_bot><tr>
                <td width=10%>Площадка</td>
                <td width=10%>Ряд</td>
                <td width=10%>Место</td>
                <td width=10%>Цена</td>';
                
        if($co_ras_pr > 0 && $co_ras_vz == 0) {
            print '<td width=10%>Возврат билетов</td>';
        }
                
        print '</tr><br/>';
        
        $mest_co = 0;        
        $cbcount = 0;
        
        //пройдемся по кодам проданных мест 
        while ($line_mest=mysql_fetch_row($result_mest)) {
        
            $sql3 = 'SELECT shifr_mesta, kod_ploshadki, riad, mesto FROM mesta WHERE kod_mesta = "'.$line_mest[0].'"'; 
            $result3 = mysql_query($sql3, $link) or die ("Ошибка запроса выборки мест по продаже");     
            
            print '<form method="post" action="prodaji_vozvrat.php" onsubmit="return confirmAction();" enctype="multipart/form-data">';
            
            $pl_kod = "";
            
            //пройдемся по информации о каждом забронированном месте
            while ($line3=mysql_fetch_row($result3)) { 
                $sql_plos = 'SELECT ploshadka FROM ploshadki WHERE kod_ploshadki = "'.$line3[1].'"'; 
                $result_plos = mysql_query($sql_plos, $link) or die ("Ошибка запроса выборки названия площадки");   
                $arr_plos = mysql_fetch_array($result_plos);
                
                //если возврат
                if($line_mest[2] != "1") {
                    print '<tr class=tab_ret >';    
                }
                else    {
                    print '<tr class=tab_bot >';    
                }
                            
                for ($k=1; $k<count($line3); $k++) {
                    if($k==1)   {
                        print '<td width=1%>'.$arr_plos["ploshadka"].'</td>'; 
                    }    
                    else if($k==2)  {
                        print '<td width=1%>'.$line3[$k].'</td>';     
                    }
                    else if($k==3)  {
                        print '<td width=1%>'.$line3[$k].'</td>';
                        print '<td width=1%>'.$line_mest[1].' грн </td>';
                    }  
                }    
                    
                //если не было возврата - есть чекбоксы     
                if($co_ras_pr > 0 && $co_ras_vz == 0) {                
                    $cbcount++;
                    //имя чекбокса - 'кодсоб_ряд_место'
                    $name_cb = $line3[0];
                    
                    print '<td width=1%><input type="checkbox" checked="checked" name="'.$name_cb.'"></td>';
                    //имена чекбоксов
                    print '<input type=hidden name="cb_'.$cbcount.'" value="'.$name_cb.'">';
                    //цены мест
                    print '<input type=hidden name="cen_'.$cbcount.'" value="'.$line_mest[1].'">';             
                    print '</tr>';
                        
                    $pl_kod = $line3[1];
                }
            }
                           
            //площадка
            print '<input type=hidden name="ploshad" value="'.$pl_kod.'">';
            //кол-во чекбоксов
            print '<input type=hidden name="cbkol" value="'.$cbcount.'">';                
            print '<input type=hidden name="sluc" value="'.$sluc.'">';            
            $mest_co++; 
            //коды мест
            print '<input type=hidden name="kod_mest_'.$mest_co.'" value="'.$line_mest[0].'">';            
            //код события
            print '<input type=hidden name="kod_sob" value="'.$line[1].'">';            
            //код продажи
            print '<input type=hidden name="kod_prod" value="'.$line[0].'">';            
            //сумма продажи
            print '<input type=hidden name="sum_prod" value="'.$line[3].'">';
        }
        
        //если не было возврата
        if($co_ras_pr > 0 && $co_ras_vz == 0) {
            print '<tr><td colspan=4></td><td><input type="submit" class=tog name="submitted" value="Возврат"></td></tr>';          
        }
        
        print '</form>';
        print '</table><br/>';
        print '</div>';       
    }   
      
    mysql_free_result($result);
    mysql_free_result($result2);
    mysql_free_result($result3);
    if ($db > 0) mysql_close($db);
?>

</div>
  
<? require("../pages/footer.php"); ?>