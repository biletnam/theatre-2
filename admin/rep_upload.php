<? require("adm_header.php"); 
error_reporting(0);
?>

<div id="c_main">

<br/><div class="rep_form">

<H3>�������� ������������� � ���������</H3>

<?php
//�������� ������ ������ ��� �������������� �������������
$ss = $_GET["kod_predstav"];
if($ss)	{
    include_once "../func.php";
    $link = db_connect();    
    $sql = 'SELECT * FROM repertuar WHERE kod_predstav="'.$ss.'"';
    $result = mysql_query($sql) or die ("������ ������� ������� �� ����������<br>");
    $myrow = mysql_fetch_array($result);
    $id = $myrow["kod_predstav"];
}
?>

<?php
//���������� ������ �������������
if($_POST['submitted'])	{
if(empty($_POST['name']))	{
	echo "������� �������� �������������!<br/>";
}
if(empty($_POST['desc']))	{
	echo "������� �������� �������������!<br/>";
}
if(empty($_POST['prod']))	{
	echo "������� ����������������� �������������!<br/>";
}
if(!empty($_POST['name']) && !empty($_POST['desc']) && !empty($_POST['prod']))	{

include_once "../func.php";
$link = db_connect();

$f = '../images/uploaded/'.$_FILES["my_file"]["name"].'';

//��������� �������� �� ����
if(is_uploaded_file($_FILES["my_file"]["tmp_name"]))   {
    //��������, ������������� �� ����������� ���� �������� ������������
	$imageinfo = getimagesize($_FILES['my_file']['tmp_name']);
	if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
		print "����������� ���� �� �������� ������������<br>";
		//die;
		$f = "";
	}	
	else	{
		//���� ���� �������� �������, ���������� ��� �� ��������� ���������� � ��������
		move_uploaded_file($_FILES["my_file"]["tmp_name"], "/home/dnua/dnua.biz/theatre/" ."images/uploaded/".$_FILES["my_file"]["name"]);
	}
}
else {
	$f = "";
	//die;
}

$f1 = '../images/uploaded/'.$_FILES["my_file3"]["name"].'';

//��������� �������� �� ����
if(is_uploaded_file($_FILES["my_file3"]["tmp_name"]))   {
    //��������, ������������� �� ����������� ���� �������� ������������
	$imageinfo = getimagesize($_FILES['my_file3']['tmp_name']);
	if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
		print "����������� ���� �� �������� ������������<br>";
		//die;
		$f1 = "";
	}	
	else	{
		//���� ���� �������� �������, ���������� ��� �� ��������� ���������� � ��������
		move_uploaded_file($_FILES["my_file3"]["tmp_name"], "/home/dnua/dnua.biz/theatre/" ."images/uploaded/".$_FILES["my_file3"]["name"]);
	}
}
else {
	$f1 = "";
	//die;
}

$f21 = '../images/uploaded/'.$_FILES["my_file2"]["name"][0].'';
$f22 = '../images/uploaded/'.$_FILES["my_file2"]["name"][1].'';
$f23 = '../images/uploaded/'.$_FILES["my_file2"]["name"][2].'';
$f24 = '../images/uploaded/'.$_FILES["my_file2"]["name"][3].'';
$f25 = '../images/uploaded/'.$_FILES["my_file2"]["name"][4].'';

$num_file = count($_FILES['my_file2']['name']);

if ($num_file<5)	{
	for($i=$num_file; $i<5; $i++)	{
		if($i==0)	$f21 = "";
		if($i==1)	$f22 = "";
		if($i==2)	$f23 = "";
		if($i==3)	$f24 = "";
		if($i==4)	$f25 = "";
	}
}

for ($i=0; $i < $num_file; $i++) {
	if(is_uploaded_file($_FILES["my_file2"]["tmp_name"][$i]))   {
		$imageinfo = getimagesize($_FILES['my_file2']['tmp_name'][$i]);
		if($imageinfo['mime'] != 'image/gif' && $imageinfo['mime'] != 'image/jpeg' && $imageinfo['mime'] != 'image/png') {
			print "����������� ���� �� �������� ������������<br>";
			break;
			//die;
		}
		move_uploaded_file($_FILES['my_file2']['tmp_name'][$i], "/home/dnua/dnua.biz/theatre/" ."images/uploaded/".$_FILES["my_file2"]["name"][$i]);
	}
    else    {
        if($i==0)   {
            $f21 = "";    
        }  
    }
}

if($id)	{
    $sql = 'UPDATE repertuar SET predstav="'.$_POST ["name"].'", opisanie="'.$_POST ["desc"].'", prod_predst="'.$_POST ["prod"].'", main_foto="'.$f.'", pic1="'.$f21.'", pic2="'.$f22.'", pic3="'.$f23.'", pic4="'.$f24.'", pic5="'.$f25.'", foto_author="'.$f1.'", opis_full="'.$_POST ["fullopis"].'", rep_god="'.$_POST ["god"].'" WHERE kod_predstav="'.$id.'"';
    $result = mysql_query($sql) or die ("������ ������� ���������� ����������<br>");
}
else	{	
    $sql = 'INSERT INTO repertuar (predstav, opisanie, prod_predst, main_foto, pic1, pic2, pic3, pic4, pic5, foto_author, opis_full, rep_god) VALUES ("'.$_POST ["name"].'", "'.$_POST ["desc"].'", "'.$_POST ["prod"].'", "'.$f.'", "'.$f21.'", "'.$f22.'", "'.$f23.'", "'.$f24.'", "'.$f25.'", "'.$f1.'", "'.$_POST ["fullopis"].'", "'.$_POST ["god"].'")';
    $result = mysql_query($sql) or die ("������ ������� ���������� � ���������<br>");        
}

if($id)	{
    $str = "������������� ��������������� !<br/><br/>";
    echo $str;
}
else	{
    $str = "������������� ��������� !<br/><br/>";
    echo $str;
}

if ($db > 0) mysql_close($db);
}
}
?>

<form method="POST" action="<?php echo $PHP_SELF?>" enctype="multipart/form-data">

<table class="rep_form_in">

    <tr>
    <td><input type=hidden name="id" value="<?php echo $myrow["kod_predstav"]?>" /></td>
    </tr>
    <tr>
    <td width=250px>�������� �������������:</td>
    <td><input type="text" name="name" value="<?php echo $myrow["predstav"]?>" size=55 required /></td>
    </tr>
    <tr>
    <td>�������� �������������:</td>
    <td><textarea cols=45 rows=5 name="desc" size=55 required><?php echo $myrow["opisanie"]?></textarea></td>
    </tr>
    <tr>
    <td>����������������� �������������:</td>
    <td><input type="text" name="prod" size=55 value="<?php echo $myrow["prod_predst"]?>" required /></td>
    </tr>
    <tr>
    <td>�������� ������:</td>
    <td><input name="my_file" type="file" value="<?php echo $myrow["main_foto"]?>" /></td>
    </tr>
    <tr>
    <td valign=top>��������:</td>
    <td><input name="my_file2[]" multiple type="file" /></td>
    </tr>
    <tr>
    <td>���� ������ ������������:</td>
    <td><input name="my_file3" type="file" value="<?php echo $myrow["foto_author"]?>" /></td>
    </tr>
    <tr>
    <td>������ ��������:</td>
    <td><textarea cols=45 rows=5 name="fullopis" size=55 required><?php echo $myrow["opis_full"]?></textarea></td>
    </tr>
    <tr>
    <td>��� (����� ����������):</td>
    <td><input type="text" name="god" size=55 value="<?php echo $myrow["rep_god"]?>" required /></td>
    </tr>

</table>

<br/>
<input type="submit" class="tog" name="submitted" value="���������" />
<input type="reset" class="tog" name="reset" value="��������" />

</form>

<br/></div>

<br /><br />

</div>

<? require("../pages/footer.php"); ?>

