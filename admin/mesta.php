
<?
    function fillHalls($kod_sobitia)    {

    //заполняем партер

    $n = 33;
    
    for($i=1; $i < 20; $i++)    {
            if($i == 1) {
                $n = 33;
            }
            else if($i==2 || $i==3 || $i==14)   {
                $n = 34;
            }
            else if($i==4 || $i==5)   {
                $n = 37;
            }
            else if($i==6 || $i==13)   {
                $n = 40;
            }
            else if($i==7)   {
                $n = 41;
            }
            else if($i==8)   {
                $n = 43;
            }
            else if($i==9 || $i==11)   {
                $n = 42;
            }
            else if($i==10)   {
                $n = 44;
            }
            else if($i==12)   {
                $n = 39;
            }
            else if($i==15)   {
                $n = 29;
            }
            else if($i==16)   {
                $n = 26;
            }
            else if($i==17)   {
                $n = 23;
            }
            else if($i==18)   {
                $n = 8;
            }
            else if($i==19)   {
                $n = 6;
            }    
        
        for($j=1; $j <= $n; $j++)    {
            
            $shifr_m = $kod_sobitia."_"."1"."_".$i."_".$j;
            
            $sql2 = 'INSERT INTO mesta (shifr_mesta, kod_sobitia, kod_ploshadki, riad, mesto, kod_statusa_mesta, kod_grupi_mest, kod_grupi_cen) VALUES ("'.$shifr_m.'", "'.$kod_sobitia.'", "1", "'.$i.'", "'.$j.'", "1", "1", "1")';         
            $result2 = mysql_query($sql2) or die ("Ошибка запроса заполнения мест партер<br>");      
        }    
    }
    
    //заполняем левый бельэтаж
    
    $n_belle = 6;
    
    for($i=1; $i < 15; $i++)    {
            if($i == 1) {
                $n_belle = 6;
            }
            else if($i==2 || $i==3)   {
                $n_belle = 7;
            }
            else if($i==4 || $i==14)   {
                $n_belle = 8;
            }
            else if($i==5)   {
                $n_belle = 9;
            }
            else if($i==6 || $i==11)   {
                $n_belle = 11;
            }
            else if($i==7)   {
                $n_belle = 14;
            }
            else if($i==8)   {
                $n_belle = 20;
            }
            else if($i==9 || $i==10)   {
                $n_belle = 19;
            }
            else if($i==12 || $i==13)   {
                $n_belle = 12;
            }
        
        for($j=1; $j <= $n_belle; $j++)    {
            
            $shifr_m = $kod_sobitia."_"."2"."_".$i."_".$j;
            
            $sql2 = 'INSERT INTO mesta (shifr_mesta, kod_sobitia, kod_ploshadki, riad, mesto, kod_statusa_mesta, kod_grupi_mest, kod_grupi_cen) VALUES ("'.$shifr_m.'", "'.$kod_sobitia.'", "2", "'.$i.'", "'.$j.'", "1", "1", "1")';         
            $result2 = mysql_query($sql2) or die ("Ошибка запроса заполнения мест левый бельэтаж<br>");      
        }    
    }
    
    //заполняем правый бельэтаж
    
    $n_belle = 5;
    
    for($i=1; $i < 15; $i++)    {
            if($i == 1) {
                $n_belle = 5;
            }
            else if($i==2)   {
                $n_belle = 6;
            }
            else if($i==3 || $i==4 || $i==14)   {
                $n_belle = 7;
            }
            else if($i==5)   {
                $n_belle = 9;
            }
            else if($i==6 || $i==12 || $i==13)   {
                $n_belle = 12;
            }
            else if($i==7)   {
                $n_belle = 15;
            }
            else if($i==8)   {
                $n_belle = 19;
            }
            else if($i==9)   {
                $n_belle = 18;
            }
            else if($i==10)   {
                $n_belle = 17;
            }
            else if($i==11)   {
                $n_belle = 11;
            }
        
        for($j=1; $j <= $n_belle; $j++)    {
            
            $shifr_m = $kod_sobitia."_"."3"."_".$i."_".$j;
            
            $sql2 = 'INSERT INTO mesta (shifr_mesta, kod_sobitia, kod_ploshadki, riad, mesto, kod_statusa_mesta, kod_grupi_mest, kod_grupi_cen) VALUES ("'.$shifr_m.'", "'.$kod_sobitia.'", "3", "'.$i.'", "'.$j.'", "1", "1", "1")';         
            $result2 = mysql_query($sql2) or die ("Ошибка запроса заполнения мест правый бельэтаж<br>");      
        }    
    }
    
    }
        
?>
