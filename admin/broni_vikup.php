<? 
    require("adm_header.php"); 
    error_reporting(0);    
?>

<div id="c_main">

<br/><div class=bil_form>

<h2>�����</h2>

<h3>�������� �����</h3>

<?
    //�������� ��������������� ������
    
    include_once "../func.php";
    $link = db_connect();
    
    $isprod = false;
    $countbil = 0;
    
    session_start();
    
    if($_POST['submitted'] && $_SESSION['sluc']==$_POST['sluc'])	{
        
        switch($_POST["ploshad"])  {
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
            
        //���� � �������
        $sql_sob = 'SELECT kod_predstav, data_predstav FROM afisha WHERE kod_sobitia = "'.$_POST['kod_sob'].'"';
        $result_sob = mysql_query($sql_sob, $link) or die ("������ �������");
        $arr_sob = mysql_fetch_array($result_sob);
        echo $arr_sob["data_predstav"]."<br/><br/>";
            
        $sql_pred = 'SELECT predstav FROM repertuar WHERE kod_predstav = "'.$arr_sob["kod_predstav"].'"';
        $result_pred = mysql_query($sql_pred, $link) or die ("������ �������");
        $arr_pred = mysql_fetch_array($result_pred);
        echo $arr_pred["predstav"]."<br/><br/>";
        
        $sql_details = 'SELECT fio FROM broni WHERE kod_broni = "'.$_POST['kod_br'].'"'; 
        $result_details = mysql_query($sql_details, $link) or die ("������ �������"); 
        $arr_pr = mysql_fetch_array($result_details);
        echo "��� - ".$arr_pr["fio"]."<br/><br/>"; 
        
        //������ �� ���� �� ���� �������
        $check_atleast_one = false;
        
        for($i=1; $i<=$_POST['cbkol']; $i++) {
            //������ ��� ��������
            $cbn = $_POST['cb_'.$i.''];
            
            if(isset($_REQUEST[''.$cbn.'']))   {
                $check_atleast_one = true;    
            }
        }        
        
        $sql_kodpr = 'SELECT kod_prodaji FROM prodaji'; 
        $result_kodpr = mysql_query($sql_kodpr, $link) or die ("������ ������� ������� ���� �������");
        $kod_prod_last = 0;
            
        while ($line_kodpr=mysql_fetch_row($result_kodpr)) { 
            $kod_prod_last = $line_kodpr[0]; 
        }
            
        $kod_pr = $kod_prod_last + 1;
        
        $sum = 0;
        
        //������� �� ���� �������������� ���������
        for($i=1; $i<=$_POST['cbkol']; $i++) { 
            
            //��������� '������_���_�����'
            $cbn = $_POST['cb_'.$i.''];
            
            //������ �� �������
            if(isset($_REQUEST[''.$cbn.'']))   {
                //echo $i." - ".$_POST['ploshad']." - ".$cbn." - true<br/>";   
                
                //���� ������ �� �������� �����    
                $sqlupd = 'UPDATE mesta SET kod_statusa_mesta = "3" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'" AND kod_ploshadki = "'.$_POST['ploshad'].'"';
                $resupd = mysql_query($sqlupd) or die ("������ ������� ���������� ������� ����� ��� ������ �����<br>"); 
                
                $date_today = date("Y-m-d H:i:s"); 
                
                $sql_prod = 'INSERT INTO prodaji (kod_prodaji, kod_sobitia, kod_mesta, summa_tek_prodaji, summa_prodaji, data_prodaji, kod_statusa_prodaji) VALUES ("'.$kod_pr.'", "'.$_POST['kod_sob'].'", "'.$_POST['kod_mest_'.$i.''].'", "'.$_POST['cen_'.$i.''].'", "'.$_POST['sum_prod'].'", "'.$date_today.'", "1")';
                $result_prod = mysql_query($sql_prod) or die ("������ ������� ���������� � �������<br>");
                               
                $sqlupdbr = 'UPDATE broni SET kod_statusa_broni = "1", data_vikupa = "'.$date_today.'" WHERE kod_broni = "'.$_POST['kod_br'].'" AND kod_mesta = "'.$_POST['kod_mest_'.$i.''].'"';
                $resupdbr = mysql_query($sqlupdbr) or die ("������ ������� ���������� ������� ����� ��� ������<br>");
                
                $isprod = true;
                
                $countbil++;
                
                $sum += $_POST['cen_'.$i.''];
            
                $exp=explode("_",$cbn);
                echo "���������! �������� ".$pl_name." ��� ".$exp[2]." ����� ".$exp[3]." ���� ".$_POST['cen_'.$i.''].'<br/>';
            }
            else    {
                //���� �� ���� ������
                if($check_atleast_one == true)  {
                    //�� ������ ������� - ���������� �����
                    
                    $sqldel = 'UPDATE mesta SET kod_statusa_mesta = "1" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'" AND kod_ploshadki = "'.$_POST['ploshad'].'"';
                    $resdel = mysql_query($sqldel) or die ("������ ������� update ������<br>"); 
                    
                    $sqldel1 = 'UPDATE broni SET kod_statusa_broni = "3" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'"';
                    $resdel1 = mysql_query($sqldel1) or die ("������ ������� update �����<br>"); 
                    
                    $exp=explode("_",$cbn);
                    echo "�����������! �������� ".$_POST['ploshad']." ��� ".$exp[1]." ����� ".$exp[2]." ���� ".$_POST['cen_'.$i.''].'<br/>';   
                }                
            }       
        }
        
        if($isprod == true) {
            echo "<br/>�� ����� ��������� ".$countbil." ������� �� ����� ".$sum." ��� <br/>";
            
            echo "<br/>���� ������� �� ����� ".$date_today."<br/>";     
        }
        else    {
            echo "<br/>�� ������� ����� ��� ������ ������ �����!<br/><br/>";    
        }
    }   
    
    //������ ������
    unset ($_SESSION['sluc']);
    
    mysql_free_result($resupd);
    mysql_free_result($resupdbr); 
    mysql_free_result($result_details);
    mysql_free_result($result_sob);
    mysql_free_result($resdel);
?>

<br/></div><br/>

<br /><br /><a class=main_afisha href="broni.php">��������� � ������ ������</a> 

</div>
  
<? require("../pages/footer.php"); ?>