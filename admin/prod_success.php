<? 
    require("adm_header.php"); 
    error_reporting(0);    
?>

<div id="c_main">

<?php

    //���������� ����� �������
    session_start(); 
        
    //������ �� ������ � ��������� �� �������� �� �������� ���� �� ��������� �� ������
    if($_POST['submitted'] && $_SESSION['sluc']==$_POST['sluc'])	{
        if($_POST['kolvo']==0)	{
        	echo "�������� �����!<br/>";
        }
        if($_POST['kolvo']!=0)	{
        
            include_once "../func.php";
            $link = db_connect();
            
            switch($_POST["plosh"])  {
                case 1:
                    $pl_name = "������";
                    break;
                case 2:
                    $pl_name = "����� ��������";
                    break;
                case 3:
                    $pl_name = "������ ��������";
                    break;
                default:
                    break;            
            }

            print "<br/><div class=bil_form>";
            
            echo '<h3>������ �������</h3>';
            
            $sql = 'SELECT kod_predstav, data_predstav FROM afisha WHERE kod_sobitia = "'.$_POST["kod_sobitia"].'"'; 
            $result = mysql_query($sql, $link) or die ("������ ������� ������� �� �����");
            $myrow_kod=mysql_fetch_array($result);
            $kod_predst = $myrow_kod["kod_predstav"];
            echo $myrow_kod["data_predstav"]."<br/><br/>";
            
            $sql2 = 'SELECT predstav FROM repertuar WHERE kod_predstav = "'.$kod_predst.'"'; 
            $result2 = mysql_query($sql2, $link) or die ("������ ������� ������� �� ����������");
            $myrow_kod=mysql_fetch_array($result2);
            echo $myrow_kod["predstav"];           
            
            $sql_kodpr = 'SELECT kod_prodaji FROM prodaji ORDER BY kod_prodaji'; 
            $result_kodpr = mysql_query($sql_kodpr, $link) or die ("������ ������� ������� ���� �������");
            $kod_prod_last = 0;
            
            while ($line_kodpr=mysql_fetch_row($result_kodpr)) { 
                $kod_prod_last = $line_kodpr[0]; 
            }
            
            $kod_pr = $kod_prod_last + 1;
            
            echo "<br/><br/>��� ������� - ".$kod_pr."<br/>���������� ������� - ".$_POST['kolvo']."<br/>����� ������� - ".$_POST['summazak'].' ���<br/><br/>';
            
            $date_today = date("Y-m-d H:i:s");
            
            $rw=explode(" ",$_POST['mesta']);
                
            //������ ������� �� ������� �����
            for ($i=0; $i < count($rw) - 1; $i++) { 
                
                $rw2=explode("_",$rw[$i]);
                
                $shifr = $_POST["kod_sobitia"]."_".$_POST["plosh"]."_".$rw2[0]."_".$rw2[1];
                
                $sql_kodm = 'SELECT kod_mesta FROM mesta WHERE shifr_mesta = "'.$shifr.'"';
                $result3 = mysql_query($sql_kodm) or die ("������ ������� ������� ���� �����<br>");
                $myrow = mysql_fetch_array($result3);
                $kod_mest = $myrow["kod_mesta"]; 
                
                $sql = 'INSERT INTO prodaji (kod_prodaji, kod_sobitia, kod_mesta, summa_tek_prodaji, summa_prodaji, data_prodaji, kod_statusa_prodaji) VALUES ("'.$kod_pr.'", "'.$_POST["kod_sobitia"].'", "'.$kod_mest.'", "'.$rw2[2].'", "'.$_POST['summazak'].'", "'.$date_today.'", "1")';
                $result = mysql_query($sql) or die ("������ ������� ������� �������<br>");
                
                $sql2 = 'UPDATE mesta SET kod_statusa_mesta = "3" WHERE shifr_mesta = "'.$shifr.'" AND kod_ploshadki = "'.$_POST["plosh"].'"';
                $result2 = mysql_query($sql2) or die ("������ ������� ���������� ������� �����<br>");
                
                //��� ������ ���������� � ������
                echo "�������� ".$pl_name." ��� ".$rw2[0]." ����� ".$rw2[1]." ���� ".$rw2[2].' ��� <br/>';
            }
                        
            echo "<br/>������� !<br/>";

            print "<br/></div><br/>";
            
            //������ ������
            unset ($_SESSION['sluc']); 
        
            if ($db > 0) mysql_close($db);
        }
        
        $url = htmlspecialchars($_SERVER['HTTP_REFERER']);
        echo "<br/><a class=main_afisha href=".$url.">�����</a>"; 
    }
    
?>

</div>
  
<? require("../pages/footer.php"); ?>