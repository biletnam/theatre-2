<? require("adm_header.php"); 
error_reporting(0);

    $mesiac = $_GET["af_mesiac"];
    
    $mes = "";
    $next = "";
    $prev = "";
    
    switch($mesiac)    {
        case "jan2013":
            $mes = "������ 2013 ���";
            $next = "������� 2013 ���";
            $next_code = "feb2013";
            $prev = "������� 2012 ���";
            $prev_code = "dec2012";
            break;
        case "feb2013":
            $mes = "������� 2013 ���";
            $next = "���� 2013 ���";
            $next_code = "mar2013";
            $prev = "������ 2013 ���";
            $prev_code = "jan2013";
            break;
        case "mar2013":
            $mes = "���� 2013 ���";
            $next = "������ 2013 ���";
            $next_code = "april2013";
            $prev = "������� 2013 ���";
            $prev_code = "feb2013";
            break;
        case "april2013":
            $mes = "������ 2013 ���";
            $next = "��� 2013 ���";
            $next_code = "may2013";
            $prev = "���� 2013 ���";
            $prev_code = "march2013";
            break;
        case "may2013":
            $mes = "��� 2013 ���";
            $next = "���� 2013 ���";
            $next_code = "june2013";
            $prev = "������ 2013 ���";
            $prev_code = "april2013";
            break;
        case "june2013":
            $mes = "���� 2013 ���";
            $next = "���� 2013 ���";
            $next_code = "july2013";
            $prev = "��� 2013 ���";
            $prev_code = "may2013";
            break;
        case "july2013":
            $mes = "���� 2013 ���";
            $next = "������ 2013 ���";
            $next_code = "aug2013";
            $prev = "���� 2013 ���";
            $prev_code = "june2013";
            break;
        case "aug2013":
            $mes = "������ 2013 ���";
            $next = "�������� 2013 ���";
            $next_code = "sep2013";
            $prev = "���� 2013 ���";
            $prev_code = "july2013";
            break;
        case "sep2013":
            $mes = "�������� 2013 ���";
            $next = "������� 2013 ���";
            $next_code = "oct2013";
            $prev = "������ 2013 ���";
            $prev_code = "aug2013";
            break;
        case "oct2013":
            $mes = "������� 2013 ���";
            $next = "������ 2013 ���";
            $next_code = "nov2013";
            $prev = "�������� 2013 ���";
            $prev_code = "sep2013";
            break;
        case "nov2013":
            $mes = "������ 2013 ���";
            $next = "������� 2013 ���";
            $next_code = "dec2013";
            $prev = "������� 2013 ���";
            $prev_code = "oct2013";
            break;
        case "dec2013":
            $mes = "������� 2013 ���";
            $next = "������ 2014 ���";
            $next_code = "jan2014";
            $prev = "������ 2013 ���";
            $prev_code = "nov2013";
            break;
        default:
            break;
    }
    
    print '<div id="c_main">';    
    print '<H3>����� �� '.$mes.'</H3>';
    
    print '<H4><a class=main_afisha href="afisha.php?af_mesiac='.$prev_code.'">'.$prev.'</a> | '.$mes.' | <a class=main_afisha href="afisha.php?af_mesiac='.$next_code.'">'.$next.'</a></H4>';

?>	

<?php
    //�������� ������������� � �������� id
    include_once "../func.php";
    $link = db_connect();
    
    $delet = $_GET["del"];
    $kod_sobitia = $_GET["kod_sobitia"];
    if($delet)	{    
        $sql2 = 'DELETE FROM mesta WHERE kod_sobitia = "'.$kod_sobitia.'"';          
        $result2 = mysql_query($sql2, $link) or die ("������ ������� �������� ����");
        
        $sql = 'DELETE FROM afisha WHERE kod_sobitia="'.$kod_sobitia.'"';
        $result = mysql_query($sql, $link) or die ("������ ������� �������� �� �����");  
        
        $str = "������������� ������� !<br>";
        echo $str;
    }
    if ($db > 0) mysql_close($db);	 
?>

<?php
    include_once "../func.php"; 
    $k = "admin";
    form_afisha($k, $mes);
?>

<br/>
<br/>

</div>

<? require("../pages/footer.php"); ?>	
