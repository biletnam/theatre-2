<? require("adm_header.php"); 
error_reporting(0);

include "../func.php";
$link = db_connect();

$god = $_GET["rep_god"];

$year = "";
$next = "";
$prev = "";

switch($god)    {
    case "2013":
        $year = "2013";
        $next = "2014";
        $prev = "2012";
        break;
    case "2014":
        $year = "2014";
        $next = "2015";
        $prev = "2013";
        break;
    default:
        break;
}

print '<div id="c_main">';

print '<H3>��������� �� '.$year.'</H3>';

print '<H4><a class=main_afisha href="repertuar.php?rep_god='.$prev.'">'.$prev.'</a> '.$year.' <a class=main_afisha href="repertuar.php?rep_god='.$next.'">'.$next.'</a></H4>';

?>	

<a class="main_afisha" href="rep_upload.php">�������� ������������� � ���������</a><br /><br /> 

<?php
//�������� ������������� � �������� id
$delet = $_GET["del"];
$pred_id = $_GET["kod_predstav"];

if($delet)	{
$sql = 'DELETE FROM repertuar WHERE kod_predstav="'.$pred_id.'"';
$result = mysql_query($sql, $link) or die ("������ ������� �������� ������������� �� ����������");

$sql3 = 'DELETE FROM afisha WHERE kod_predstav="'.$pred_id.'"';
$result3 = mysql_query($sql3, $link) or die ("������ ������� �������� ������������� �� �����");

/*
$sql4 = 'SELECT sobitie_id FROM afisha WHERE kod_predstav="'.$pred_id.'"';
$result4 = mysql_query($sql4) or die ("������ ������� ������� ���� ������� �� �����<br>");
$myrow = mysql_fetch_array($result);
$sob_id = $myrow["sobitie_id"];

$sql2 = 'DELETE FROM mesta WHERE kod_sobitia = "'.$sob_id.'"';          
$result2 = mysql_query($sql2, $link) or die ("������ ������� �������� �� ����");  
*/

$str = "������������� ������� �� ���������� !<br>";
echo $str;
}
if ($db > 0) mysql_close($db);	 
?>

<?php

function rep_data($god, $link)  {
    //�������� ������ ��� ��������� ����������
    $sql = 'SELECT kod_predstav, predstav, opisanie, prod_predst, main_foto, pic1, pic2, pic3, pic4, pic5 FROM repertuar WHERE rep_god = "'.$god.'" ORDER BY kod_predstav'; 
    $result = mysql_query($sql, $link) or die ("������ ������� ������� ���������� �� ����");
    return $result;
}

$result = rep_data($year, $link);

print '<div class=outer_table>';

while ($line=mysql_fetch_row($result)) { 

    //������� ���������
    print '<div class=left_table><table width=450px>';
    
    for ($i=0; $i<count($line); $i++) {	
    	if ($line[$i]) {
    	    
            if($i==1)   {
                printf ("<tr><td class=afisha_pred><a class=afisha_pred href=\"podrobno.php?kod_predstav=%s\">$line[$i]</a></td></tr>", $line[0]);
            }   
            
            if($i>=2 && $i<=3)    {
    	        print '<tr><td>'.$line[$i].'</td></tr>';    
    	    }
                 
            if($i>=4 && $i<=9)   {
                print '<tr><td><img src='.$line[$i].' width=110px align=top hspace=5px vspace=5px></td></tr>';           
            }
         
    		if ($i==3)	{
                print '</table></div>';
            
                print '<div class=center_table><table width=450px>';
              
                printf ("<tr><td><a class=main_afisha href=\"afisha_upload.php?kod_predstav=%s\">�������� ������������� � �����</a></td></tr>", $line[0]);
            	printf ("<tr><td><a class=main_afisha href=\"rep_upload.php?kod_predstav=%s\">������������� ��������</a></td></tr>", $line[0]);
     		    printf ("<tr><td><a class=main_afisha href=\"repertuar.php?rep_god=$god&kod_predstav=%s&del=4\" onclick=\"return confirmAction();\">�������</a></td></tr>", $line[0]);
    	        print '</table></div>';
            }
        }
    }
}

print '</div>';

mysql_free_result($result);
if ($db > 0) mysql_close($db);
?>

<br/>
<br/>

</div>

<? require("../pages/footer.php"); ?>	
