<? 
    require("adm_header.php"); 
    error_reporting(0);    
?>

<div id="c_main">

<br/><div class=bil_form>

<h2>�������</h2>

<h3>������� ��������� �������</h3>

<?
    //�������� ��������������� ������
    
    include_once "../func.php";
    $link = db_connect();
    
    $isprod = false;
    $countbil = 0;
    
    session_start();
    
    if($_POST['submitted'] && $_SESSION['sluc']==$_POST['sluc'])	{          
            
        switch($_POST['ploshad'])  {
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
        
        //������ �� ���� �� ���� �������
        $check_atleast_one = false;
        
        for($i=1; $i<=$_POST['cbkol']; $i++) {
            //������ ��� ��������
            $cbn = $_POST['cb_'.$i.''];
            
            if(isset($_REQUEST[''.$cbn.'']))   {
                $check_atleast_one = true;    
            }
        }        
        
        $sql_kodret = 'SELECT kod_return FROM returns'; 
        $result_kodret = mysql_query($sql_kodret, $link) or die ("������ ������� ������� ���� ��������");
        $kod_ret_last = 0;
            
        while ($line_kodret=mysql_fetch_row($result_kodret)) { 
            $kod_ret_last = $line_kodret[0]; 
        }
            
        $kod_ret = $kod_ret_last + 1;
        
        //������� �� ���� �������������� ���������
        for($i=1; $i<=$_POST['cbkol']; $i++) { 
            
            //��������� '������_���_�����'
            $cbn = $_POST['cb_'.$i.''];
            
            //������ �� �������
            if(isset($_REQUEST[''.$cbn.'']))   {
                //echo $i." - ".$_POST['ploshad']." - ".$cbn." - true<br/>";   
                
                //���� ������ �� ����������� �����    
                $sqlupd = 'UPDATE mesta SET kod_statusa_mesta = "1" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'" AND kod_ploshadki = "'.$_POST['ploshad'].'"';
                $resupd = mysql_query($sqlupd) or die ("������ ������� ���������� ������� ����� ��� ������������ �����<br>"); 
                
                $date_today = date("Y-m-d H:i:s"); 
                
                $sql_ret1 = 'UPDATE broni SET kod_statusa_broni = "4" WHERE kod_mesta = "'.$_POST['kod_mest_'.$i.''].'"';
                $result_ret1 = mysql_query($sql_ret1) or die ("������ ������� ���������� ������� �����<br>");
                
                $sql_ret2 = 'UPDATE prodaji SET kod_statusa_prodaji = "2" WHERE kod_prodaji = "'.$_POST['kod_prod'].'" AND kod_mesta = "'.$_POST['kod_mest_'.$i.''].'"';
                $result_ret2 = mysql_query($sql_ret2) or die ("������ ������� ���������� ������� �������<br>");
                
                $sql_ret3 = 'INSERT INTO returns (kod_return, kod_sobitia, kod_mesta, data_return) VALUES ("'.$kod_ret.'", "'.$_POST['kod_sob'].'", "'.$_POST['kod_mest_'.$i.''].'", "'.$date_today.'")';
                $result_ret3 = mysql_query($sql_ret3) or die ("������ ������� ���������� � ��������<br>");
                
                $isprod = true;
                
                $countbil++;
            
                $exp=explode("_",$cbn);
                echo "����������! �������� ".$pl_name." ��� ".$exp[2]." ����� ".$exp[3]." ���� ".$_POST['cen_'.$i.''].' ��� <br/>';
            }       
        }
        
        if($isprod == true) { 
            echo "<br/>���� �������� ".$date_today."<br/>";               
        }
        else    {
            echo "<br/>�� ������� ����� ��� �������� !<br/><br/>";    
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

<br /><br /><a class=main_afisha href="prodaji.php">��������� � ������ ������</a> 

</div>
  
<? require("../pages/footer.php"); ?>