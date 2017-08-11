<? require("header.php"); 
error_reporting(0);

$mesiac = $_GET["af_mesiac"];

$mes = "";
$next = "";
$prev = "";

switch($mesiac)    {
    case "jan2013":
        $mes = "Январь 2013 год";
        $next = "Февраль 2013 год";
        $next_code = "feb2013";
        $prev = "Декабрь 2012 год";
        $prev_code = "dec2012";
        break;
    case "feb2013":
        $mes = "Февраль 2013 год";
        $next = "Март 2013 год";
        $next_code = "mar2013";
        $prev = "Январь 2013 год";
        $prev_code = "jan2013";
        break;
    case "mar2013":
        $mes = "Март 2013 год";
        $next = "Апрель 2013 год";
        $next_code = "april2013";
        $prev = "Февраль 2013 год";
        $prev_code = "feb2013";
        break;
    case "april2013":
        $mes = "Апрель 2013 год";
        $next = "Май 2013 год";
        $next_code = "may2013";
        $prev = "Март 2013 год";
        $prev_code = "march2013";
        break;
    case "may2013":
        $mes = "Май 2013 год";
        $next = "Июнь 2013 год";
        $next_code = "june2013";
        $prev = "Апрель 2013 год";
        $prev_code = "april2013";
        break;
    case "june2013":
        $mes = "Июнь 2013 год";
        $next = "Июль 2013 год";
        $next_code = "july2013";
        $prev = "Май 2013 год";
        $prev_code = "may2013";
        break;
    case "july2013":
        $mes = "Июль 2013 год";
        $next = "Август 2013 год";
        $next_code = "aug2013";
        $prev = "Июнь 2013 год";
        $prev_code = "june2013";
        break;
    case "aug2013":
        $mes = "Август 2013 год";
        $next = "Сентябрь 2013 год";
        $next_code = "sep2013";
        $prev = "Июль 2013 год";
        $prev_code = "july2013";
        break;
    case "sep2013":
        $mes = "Сентябрь 2013 год";
        $next = "Октябрь 2013 год";
        $next_code = "oct2013";
        $prev = "Август 2013 год";
        $prev_code = "aug2013";
        break;
    case "oct2013":
        $mes = "Октябрь 2013 год";
        $next = "Ноябрь 2013 год";
        $next_code = "nov2013";
        $prev = "Сентябрь 2013 год";
        $prev_code = "sep2013";
        break;
    case "nov2013":
        $mes = "Ноябрь 2013 год";
        $next = "Декабрь 2013 год";
        $next_code = "dec2013";
        $prev = "Октябрь 2013 год";
        $prev_code = "oct2013";
        break;
    case "dec2013":
        $mes = "Декабрь 2013 год";
        $next = "Январь 2014 год";
        $next_code = "jan2014";
        $prev = "Ноябрь 2013 год";
        $prev_code = "nov2013";
        break;
    default:
        break;
}

print '<div id="c_main">';

print '<H3>Афиша на '.$mes.'</H3>';

print '<H4><a class=main_afisha href="afisha_mon.php?af_mesiac='.$prev_code.'">'.$prev.'</a> | '.$mes.' | <a class=main_afisha href="afisha_mon.php?af_mesiac='.$next_code.'">'.$next.'</a></H4>';

?>	

<?php
    include("../func.php"); 
    $k = "polz";
    form_afisha($k, $mes);
?>

<br/>
<br/>

</div>

<? require("footer.php"); ?>	
