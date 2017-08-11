<?php
    
    include_once "../func.php";
    $link = db_connect();
            
    $sql2 = 'SELECT kod_broni, data_broni, kod_sobitia FROM broni WHERE kod_statusa_broni = "2"';
    $result2 = mysql_query($sql2) or die ("Ошибка запроса выборки ожидающих броней<br>");
    
    while ($line=mysql_fetch_row($result2)) {            
        
        $sql_dat = 'SELECT data_predstav FROM afisha WHERE kod_sobitia = "'.$line[2].'"';
        $result_dat = mysql_query($sql_dat) or die ("Ошибка запроса выборки дат<br>");
        $dat_sob = mysql_fetch_array($result_dat);
        $date_pred = $dat_sob["data_predstav"];        
              
        $date_po_afishe = date("Y-m-d H:i:s", strtotime($date_pred));        
        $ymd_dat = date("Y-m-d ", strtotime($date_po_afishe));        
        $h_dat = date("H", strtotime($date_po_afishe));
        $is_dat = date(":i:s", strtotime($date_po_afishe));        
        $split_af = $ymd_dat."".($h_dat-2)."".$is_dat;
        $split_afdate = date("Y-m-d H:i:s", strtotime($split_af));
        
        $date_broni = date("Y-m-d H:i:s", strtotime($line[1]));        
        $ym_broni = date("Y-m-", strtotime($line[1]));                
        $d_broni = date("d", strtotime($line[1]));                
        $his_broni = date(" H:i:s", strtotime($line[1]));         
        $split = $ym_broni."".($d_broni+1)."".$his_broni;
        $split_date = date("Y-m-d H:i:s", strtotime($split));
                
        $date_today = date("Y-m-d H:i:s");
        
        if($date_today >= $split_date || $date_today >= $split_afdate) {           
            $sqlupd = 'UPDATE broni SET kod_statusa_broni = "3" WHERE kod_broni = "'.$line[0].'"';
            $resupd = mysql_query($sqlupd) or die ("Ошибка запроса обновления статуса брони при аннулировании<br>");    
        }   
    }     

?>