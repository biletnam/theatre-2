<?
    //���������� � �����
    function db_connect()   {
        $_SITE_NAME = 'http://theatre.dnua.biz';
    	$db="dnua_theatre";
    	
        $host="dnua.mysql.ukraine.com.ua";
    	$user="dnua_theatre";
    	$pwd = "w7ase9ur";
    
    	$link = mysql_connect($host, $user, $pwd) or die ("���������� �����������");
    	mysql_select_db($db,$link) or die ("�� �������� ������� ������ ��");  
    	mysql_set_charset('cp1251');
        
        return $link;
    }
    
    //�����
    function captcha()  {
        $captcha = rand(10000,99999);
        return $captcha;
    }
    
    //����������� ������ ���� � ��������� ������� � ������ ������� � �������� ����������� ������������ (� ������ ������� - ����� � ���)
    //������������ ��� ������������ ����� �� ���������� ����� 
    // admin/afisha.php
    function data_to_mes($data_str) {
        
        //$data_str = $_POST['sob_dat'];
        $data_time = strtotime($data_str);
        
        $poln_date = date("d.m.Y H:i", $data_time);    
        
        $giorno[0]="�����������"; 
        $giorno[1]="�����������"; 
        $giorno[2]="�������"; 
        $giorno[3]="�����"; 
        $giorno[4]="�������"; 
        $giorno[5]="�������"; 
        $giorno[6]="�������"; 
        
        $gisett = (int)date("w", $data_time);
        $day = $giorno[$gisett]; 
        
        $date2 = date("d", $data_time)." ".$day." ".date("H:i", $data_time);
        
        $mese[0]=""; 
        $mese[1]="������"; 
        $mese[2]="�������"; 
        $mese[3]="����"; 
        $mese[4]="������"; 
        $mese[5]="���"; 
        $mese[6]="����"; 
        $mese[7]="����"; 
        $mese[8]="������"; 
        $mese[9]="��������"; 
        $mese[10]="�������"; 
        $mese[11]="������"; 
        $mese[12]="�������";
        
        $mesnum=(int)date("m", $data_time); 
        $mesiac = $mese[$mesnum];
        
        $date3 = $mesiac." ".date("Y", $data_time)." ���";
        
        //echo date("d/m/Y H:m", strtotime('2011-12-17 17:41:59'));
        
        return $date3;    
    }
    
    function predst_podrobno()  {
        //�������� ������ ��� ��������� ���� �����
        $link = db_connect();
        $sql = 'SELECT predstav, opisanie, prod_predst, main_foto, pic1, pic2, pic3, pic4, pic5, foto_author, opis_full FROM repertuar WHERE kod_predstav = "'.$_GET["kod_predstav"].'"';
        $result = mysql_query($sql, $link) or die ("������ �������");
        
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
    
    //������������ ����� 
    // admin/afisha.php
    // pages/afisha_mon.php
    function form_afisha($flag, $mes) {
        
        //�������� ������ ��� ��������� ���� �����
        $link = db_connect();   
        $sql = 'SELECT kod_sobitia, kod_predstav, data_predstav FROM afisha ORDER BY data_predstav'; 
        $result = mysql_query($sql, $link) or die ("������ ������� ������� �� �����");
        
        print '<div class=outer_table>';
                        
        while ($line=mysql_fetch_row($result)) { 
            
            $mes_year = data_to_mes($line[2]);
            
            if($mes_year != $mes)   {
                continue;
            }
            
            //�� ����������
            $sql2 = 'SELECT predstav, opisanie, prod_predst, main_foto FROM repertuar WHERE kod_predstav = "'.$line[1].'"';
            $result2 = mysql_query($sql2, $link) or die ("������ ������� ������� �� ����������");
            $myrow=mysql_fetch_array($result2);                                                                        
                   
            if($flag == "admin")    {
                print '<div class=left_table><table width=350px>';
                                
                //���� � ����� �������������
                print '<tr><td class=yellow_zag_table>'.$line[2].'</td></tr>';
                
                printf ("<tr><td class=afisha_pred><a class=afisha_pred href=\"podrobno.php?kod_predstav=%s\">".$myrow["predstav"]."</a></td></tr>", $line[1]);
            }
            else    {
                print '<div class=left_table><table width=450px>';
                                
                //���� � ����� �������������
                print '<tr><td class=yellow_zag_table>'.$line[2].'</td></tr>';
                
                printf ("<tr><td class=afisha_pred><a class=afisha_pred href=\"podrobno_spec.php?kod_predstav=%s\">".$myrow["predstav"]."</a></td></tr>", $line[1]);
            }
                    
            print '<tr><td>'.$myrow["opisanie"].'</td></tr>';
            print '<tr><td>'.$myrow["prod_predst"].'</td></tr>';
            print '<tr><td>'.$myrow["main_foto"].'</td></tr>';                                                                                     
                                                                                            
            print '</table></div>';                        
                        
            if($flag != "admin")    {
                print '<div class=center_table><table width=450px>';
                
                printf ("<tr><td class=yellow_zag_table>����� �������</td></tr>");
                printf ("<tr><td><a class=main_afisha href=\"../pages/bron.php?kod_sobitia=%s&plosh=1\">������</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"../pages/bron.php?kod_sobitia=%s&plosh=2\">�������� (����� �������)</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"../pages/bron.php?kod_sobitia=%s&plosh=3\">�������� (������ �������)</a></td></tr>", $line[0]);                                                        
            
                print '</table></div>';
            }
            else    {
                print '<div class=center_table><table width=350px>';
                
                printf ("<tr><td class=yellow_zag_table>������� �������</td></tr>");
                printf ("<tr><td><a class=main_afisha href=\"prod.php?kod_sobitia=%s&plosh=1\">������</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"prod.php?kod_sobitia=%s&plosh=2\">�������� (����� �������)</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"prod.php?kod_sobitia=%s&plosh=3\">�������� (������ �������)</a></td></tr>", $line[0]);
                                                                                                               
                print '</table></div>';
                            
                print '<div class=right_table><table width=350px>';
                            
                printf ("<tr><td><a class=main_afisha href=\"broni.php?kod_sobitia=%s\">����������� �����</a></td></tr>", $line[0]);
                printf ("<tr><td><a class=main_afisha href=\"prodaji.php?kod_sobitia=%s\">����������� �������</a></td></tr>", $line[0]);
     			printf ("<tr><td><a class=main_afisha href=\"afisha_upload.php?kod_sobitia=%s\">�������������</a></td></tr>", $line[0]);
      		    printf ("<tr><td><a class=main_afisha href=\"afisha.php?af_mesiac=$mesiac&kod_sobitia=%s&del=4\" onclick=\"return confirmAction();\">�������</a></td></tr>", $line[0]);                                
                
                print '</table></div>';
            }                   
        }
        
        print '</div>';        
                
        mysql_free_result($result);
        mysql_free_result($result2);
        if ($db > 0) mysql_close($db);     
    }
    
    //������������ ����� ���� ��� ������������ � ������� �������
    // admin/prod.php
    // pages/bron.php 
    function form_hall($flag)    {
        
        $flag_kol = $flag;
        
        $plosh=$_GET["plosh"];
        $kod_sobitia=$_GET["kod_sobitia"];
    
        //�������� ������ ��� ��������� ���� �����
        include_once "../func.php";
        $link = db_connect();
        
        $sql = 'SELECT kod_predstav, data_predstav FROM afisha WHERE kod_sobitia = "'.$_GET["kod_sobitia"].'"'; 
        $result = mysql_query($sql, $link) or die ("������ ������� ������� �� �����");
        $myrow=mysql_fetch_array($result);
        $kod_predst = $myrow["kod_predstav"];
        echo $myrow["data_predstav"]."<br/><br/>";
        
        $sql2 = 'SELECT predstav FROM repertuar WHERE kod_predstav = "'.$kod_predst.'"'; 
        $result2 = mysql_query($sql2, $link) or die ("������ ������� ������� �� ����������");
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
        $res = mysql_query($sqlbron, $link) or die ("������ �������");
        
        $sqlzan = 'SELECT riad, mesto FROM mesta WHERE kod_sobitia = "'.$_GET["kod_sobitia"].'" AND kod_ploshadki = "'.$plosh.'" AND kod_statusa_mesta = "3"'; 
        $reszan = mysql_query($sqlzan, $link) or die ("������ �������");
        
        echo "<div class=\"seats\"><table class=small_seat_table border=0 cellSpacing=1>
            <tr><td width=23 height=23 style=\"BACKGROUND-COLOR: ".$color1[1]."; border: 1px solid #000;\"></td><td style=\"font-size: medium;\"> - ����� ��������</td></tr>
            <tr><td width=23 height=23 style=\"BACKGROUND-COLOR: ".$color1[0]."; border: 1px solid #000;\"></td><td style=\"font-size: medium;\"> - ����� ��������</td></tr>
            <tr><td width=23 height=23 style=\"BACKGROUND-COLOR: ".$bron."; border: 1px solid #000;\"></td><td style=\"font-size: medium;\"> - ����� �������������</td></tr>
            <tr><td width=23 height=23 style=\"BACKGROUND-COLOR: ".$zaniato."; border: 1px solid #000;\"></td><td style=\"font-size: medium;\"> - ����� ������</td></tr>
            </table>";
        
        print '<br/><br/>';
        
        $draw_flag = false;
        
        $draw_zan_flag = false;
     
        print '<table class=small_seat_table border=0 cellSpacing=1><tbody>';
        
        //������ ��������� �����
    	
        for ($i=0; $i<count($st); $i++) {
            $rw=explode(";",$st[$i]);
        	$rwpri=explode(";",$stpri[$i]);
        	echo "<TR id=row_" . $i . "><TD>" . $rw[0] . " ���</TD><TD width=12>&nbsp;</TD><TD width=12>&nbsp;</TD>";  //������ ����
            
            for ($j=1; $j<count($rw); $j++) {
                
                //��������������� �����
                $draw_flag = false;
                
                mysql_free_result($res);
                $res = mysql_query($sqlbron, $link) or die ("������ �������");
                
                while ($line=mysql_fetch_row($res)) {
                    if($line[0] == $rw[0] && $line[1] == $rw[$j])   {
                        echo "<TD class=nbt style=\"BACKGROUND-COLOR: ".$bron."\" id=col_".$i."_".$j." width=12>".$rw[$j]."</TD>";
                        $draw_flag = true;
                        break; 
                    }
                }
                
                //������� �����
                $draw_zan_flag = false;
                
                if($draw_flag != true)  {                
                    mysql_free_result($reszan);
                    $reszan = mysql_query($sqlzan, $link) or die ("������ �������");
                    
                    while ($linezan=mysql_fetch_row($reszan)) {
                        if($linezan[0] == $rw[0] && $linezan[1] == $rw[$j])   {
                            echo "<TD class=nbt style=\"BACKGROUND-COLOR: ".$zaniato."\" id=col_".$i."_".$j." width=12>".$rw[$j]."</TD>";
                            $draw_zan_flag = true;
                            break; 
                        }
                    }
                }
               
               //��������� �����
               if($draw_flag != true && $draw_zan_flag != true)  {
                    if ($rw[$j]>0)   {
                        if ($rwpri[$j]==$cena[0]) {
                            $currcolor=$color1[0];
                        }
                                        
                        if ($rwpri[$j]==$cena[1]) {
                            $currcolor=$color1[1];
                        }
                					
                        echo "<TD id=col" . $rw[0] . "_" . $rw[$j] . "-" . $rwpri[$j] . " class=nbt style=\"BACKGROUND-COLOR: ".$currcolor."\" title=\"����: $rwpri[$j] ���.\"  onclick=\"process_frag3('#col" . $rw[0] . "_" . $rw[$j] . "-" . $rwpri[$j] . "','".$flag_kol."')\" >" . $rw[$j] . "</TD>\n"; 
                   } 
                   else	{
                    	echo "<TD id=col00 class=pust>" . $rw[$j] . "</TD>\n";
               	   }           
               }
            }
         
            //onclick=\"return process_frag(col_" . $i . "_" . $j . ")"\"
            //����� ����
            
            echo "</TR><TR class=trprox><TD class=tdprox>&nbsp;</TD><TD class=tdprox>&nbsp;</TD></TR>";
        }
        
        print '</tbody></table></div></center><br /><br />';
        
        mysql_free_result($res);
        if ($db > 0) mysql_close($db);      
    }
    
?>