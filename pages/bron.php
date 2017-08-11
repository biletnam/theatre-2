<? 
    require("header.php"); 
    error_reporting(0);    
?>

<div id="c_main">
    
    <h3>Бронирование билетов</h3>

<?    
    include_once "../func.php";
    form_hall(0);

    //механизм защиты от повторной отправки формы при обновлении страницы
    session_start();

    $sluc = rand(1,32768);

    $_SESSION['sluc'] = $sluc;
?>

    <div class="bil_form">

    <form method="POST" action="bron_success.php" enctype="multipart/form-data">

    <table class="bil_form_in">
        <tr>
            <td>Количество билетов</td>
            <td id=kolvo>0</td>
        </tr>
        <tr>
            <td>Места</td>
            <td id=mesta> </td>
        </tr>
        <tr>
            <td>Сумма</td>
            <td id=sumzak>0</td>
        </tr>      

        <tr>
            <td><input type=hidden name="kod_sobitia" value="<?php echo $_GET["kod_sobitia"]?>"></td>
            <td><input type=hidden name="plosh" value="<?php echo $_GET["plosh"]?>"></td>
        </tr>
        <tr>
            <td><input type=hidden name="sluc" value="<?php echo $sluc?>"></td>
        </tr>  
        <tr>
            <td>ФИО:</td>
            <td><input type="text" name="fio" value="<?php echo $myrow["fio"]?>" size="40" required /></td>
        </tr>
        <tr>
            <td>Телефон:</td>
            <td><input type="text" name="telef" value="<?php echo $myrow["telefon"]?>" size="40" required /></td>
        </tr>
        <tr>
            <td><input id="kolv" type=hidden name="kolvo" readonly="readonly" value="<?php echo $myrow["telefon"]?>" size="40" /></td>
            <td><input id="strmest" type=hidden name="mesta" readonly="readonly" value="<?php echo $myrow["telefon"]?>" size="40" /></td>
        </tr>
        <tr>
            <td><input id="sum" type=hidden name="summazak" readonly="readonly" value="<?php echo $myrow["telefon"]?>" size="40" /></td>
        </tr>
        <tr>
            <td>Введите число с картинки:</td>
            <td><input name="captcha" readonly="readonly" class="captcha" value="<?=captcha();?>" size="5" /> <input name="captcha2" value="" size="5" maxlength="5" required /> </td>
        </tr>
    </table>

    <br/>
    <input type="submit" class="tog" name="submitted" value="Забронировать" />
    
    </form>

    </div>

</div>
  
<? require("footer.php"); ?>