<?php
#---------------------------------------------#
#            (c) by FrosT, 2008 - 2011        #
#---------------------------------------------#
//
function www1($message)
{
$message=str_replace('|','I',$message);
$message=str_replace('||','II',$message);
$message=str_replace('&','&amp;',$message);
$message=str_replace('\"','',$message);
$message=str_replace('/','',$message);
$message=str_replace('>','',$message);
$message=str_replace('<','',$message);
$message=htmlspecialchars($message);
$message=str_replace('\"','&quot;',$message);
$message=str_replace('/\\\$/','',$message);
$message=str_replace('$','',$message);
$message=str_replace('\\','', $message);
$message=str_replace('`','', $message);
$message=str_replace('%','', $message);
$message=str_replace('^','', $message);
$message=str_replace('#','', $message);
$message=str_replace('../','', $message);
$message=stripslashes(trim($message));
return $message;
}

function www3($message)
{
settype($message, 'int');
if($message<0){$message=0;}
$message=str_replace('-','',$message);
return $message;
}

function nn($mes)
{
$mes=strtolower($mes);
$mes=strrev($mes);
$mes=wordwrap($mes, 3, "`", 1);
$mes=strrev($mes);
return $mes;
}
//
Error_Reporting(E_ALL & ~E_NOTICE);
Error_Reporting (ERROR | WARNING);
ini_set('session.use_cookies', 1);
ini_set('arg_separator.output', "&amp;");
session_name("SID");
session_start();
if(isset($_GET['kol'])){$kolmes = www3($_GET['kol']); $_SESSION['kolmes']=$kolmes;}elseif(isset($_SESSION['kolmes'])){$kolmes = $_SESSION['kolmes'];}else{$kolmes = 10;}

header("cache-control: no-cache, must-revalidate");
header("pragma: no-cache");
header("Content-type:text/html; charset=utf-8");
ob_start();
echo '
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<head>
<link rel="shortcut icon" href="favicon.ico">
<title>imperia.mobi - Statistics for partner</title>
<link href="img/partners/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="wrap">
<div id="header">
<h1 id="sitename"><span class="big">!</span>
<span class="logosmall">imperia.mobi</span></h1>
<div id="navigation">
<ul>
<li'; if(isset($_GET['per'])){echo ' class="active"';} echo '><a href="partner.php?per">ПЕРЕХОДЫ</a></li>
<li'; if(isset($_GET['reg'])){echo ' class="active"';} echo '><a href="partner.php?reg">РЕГИСТРАЦИИ</a></li>
<li'; if(isset($_GET['sms'])){echo ' class="active"';} echo '><a href="partner.php?sms">СМС</a></li>
<li'; if(isset($_GET['all']) || (!isset($_GET['per']) &&!isset($_GET['sms']) && !isset($_GET['reg']) && !isset($_GET['kon']))){echo ' class="active"';} echo '><a href="partner.php?all">ОБЩАЯ</a></li>
<li
</ul>
</div>
<div class="clear"></div>
</div>
<div id="cns">
';
if(isset($_GET['aut'])){
if(www1($_POST['ps']=='art24534259')){$_SESSION['pas']='art24534259'; $_SESSION['partner']='wapartemkaru'; $prov='1';}
if(www1($_POST['ps']=='enzo3678746')){$_SESSION['pas']='enzo3678746'; $_SESSION['partner']='enzocomnet'; $prov='1';}
if(www1($_POST['ps']=='fonzo239398')){$_SESSION['pas']='fonzo239398'; $_SESSION['partner']='fonzoru'; $prov='1';}
if(www1($_POST['ps']=='sotik45h376')){$_SESSION['pas']='sotik45h376'; $_SESSION['partner']='sotikru'; $prov='1';}
if(www1($_POST['ps']=='wapos45b6h')){$_SESSION['pas']='wapos45b6h'; $_SESSION['partner']='waposru'; $prov='1';}
if(www1($_POST['ps']=='waplogb456')){$_SESSION['pas']='waplogb456'; $_SESSION['partner']='waplognet'; $prov='1';}
if(www1($_POST['ps']=='sizab546')){$_SESSION['pas']='sizab546'; $_SESSION['partner']='sizaru'; $prov='1';}
if(www1($_POST['ps']=='seclubb4576')){$_SESSION['pas']='seclubb4576'; $_SESSION['partner']='seclubru'; $prov='1';}
if(www1($_POST['ps']=='wapmobb546')){$_SESSION['pas']='wapmobb546'; $_SESSION['partner']='wapmobua'; $prov='1';}
if(www1($_POST['ps']=='gruzmob5b46')){$_SESSION['pas']='gruzmob5b46'; $_SESSION['partner']='gruzmobru'; $prov='1';}
if(www1($_POST['ps']=='kengub654')){$_SESSION['pas']='kengub654'; $_SESSION['partner']='kenguru'; $prov='1';}
if(www1($_POST['ps']=='mobrikacom354')){$_SESSION['pas']='mobrikacom354'; $_SESSION['partner']='mobrikacom'; $prov='1';}

if($prov=='1'){echo '<div align="center"><h1>Авторизация</h1></div><p align="center">Авторизация прошла успешно!<br><a href="partner.php">Продолжить</a></p>';
include_once 'other_inc/partnerend.php';
}
else{echo '<font color="red"><b>Пароль неверный!</b></font>';}
include_once 'other_inc/partnerend.php';
}

if(empty($_SESSION['pas'])){echo '<div align="center"><h1>Авторизация</h1></div>';
echo '<hr><br><form action="partner.php?aut" method="post">
<div class="contactform">';
echo '<label for="Name">Пароль :</label><input class="textfield" title="Ваше имя" type="password" name="ps" value=""><div class="clear2"></div>
<label for="Submit"></label><input type="submit" title="Ввести" type="button" class="button" value="Ввести"><div class="clear2"></div></div>
</form><br>';
include_once 'other_inc/partnerend.php';
}

if(isset($_GET['per'])){
echo '<hr><br><form action="partner.php?per" method="get">
<div class="contactform">';
echo '<label for="Name">Кол-во на страницу:</label><input class="textfield" title="Кол-во" maxlength="3" name="kol" value="">
<input name="per" type="hidden" value="">
<input type="submit" title="изменить" type="button" class="button" value="изменить"><div class="clear2"></div></div>
</form><br>';

$data = @file('data/partner/'.$_SESSION['partner'].'_site.dat');
$data = array_reverse($data);
$count = count($data);
$ii=$count;
$stranic = ceil($count/$kolmes);

if(empty($_GET['page'])) {$page_get = 1;} else {$page_get = www3($_GET['page']); if ($page_get > $stranic) {$page_get=$stranic;}}
$do = $kolmes * ($page_get-1);
$end = $kolmes * $page_get;
$page_nazad = $page_get-1;
$page_dalee = $page_get+1;

if(empty($data)) {echo '<p class="b">Переходов нет<br></p>';}
else
 {
 echo '<div align="center"><h1>Детализация переходов</h1></div>
<table>
<tr>
<th>№ п/п</th>
<th>Дата, время</th>
<th>IP</th>
<th>Браузер</th>
</tr>
';
if($page_get!=1){$ii=$count-$page_get*$kolmes+$kolmes;}else{$ii=$count;}
for ($i = $do; $i < $end; $i++)
 {
 if (!empty($data[$i]))
  {
  $viewmess = explode('|', $data[$i]);

$dta=date('Y-m-d', $viewmess[0]);
$time=date('H:i:s', $viewmess[0]);
  echo '<tr>
<td>'.$ii--.'</td>
<td>'.$dta.' '.$time.'</td>
<td>'.$viewmess[2].'</td>
<td>'.$viewmess[1].'</td>
</tr>';
   }
 }

echo '</table>';
if($stranic > 1)
{
echo '<hr><p align="center">';
if($page_get > 1) {echo '<a href="partner.php?per&amp;page='.$page_nazad.'">Назад</a>';}else{echo 'Назад';}
echo '|';
if($stranic > $page_get) {echo '<a href="partner.php?per&amp;page='.$page_dalee.'">Дальше</a>';}else{echo 'Дальше';}
echo '<br>Страница:'.$page_get.'<br>';

echo 'Всего страниц:'.$stranic.'<br>';
if($page_get > 1) {echo '<a href="partner.php?per&amp;page=1">В начало</a>';}else{echo 'В начало';}
echo '|';
if($stranic > $page_get) {echo '<a href="partner.php?per&amp;page='.$stranic.'">В конец</a><br>';}else{echo 'В конец';}
echo '<hr></p>';
}
echo '<p>Всего <b>'.nn($count).'</b> переходов.<br><br><br><br><br></p>';
  }
include_once 'other_inc/partnerend.php';
}

if(isset($_GET['reg'])){
echo '<hr><br><form action="partner.php?reg" method="get">
<div class="contactform">';
echo '<label for="Name">Кол-во на страницу:</label><input class="textfield" title="Кол-во" maxlength="3" name="kol" value="">
<input name="reg" type="hidden" value="">
<input type="submit" title="изменить" type="button" class="button" value="изменить"><div class="clear2"></div></div>
</form><br>';

$data = @file('data/partner/'.$_SESSION['partner'].'_reg.dat');
$data = array_reverse($data);
$count = count($data);
$ii=$count;
$stranic = ceil($count/$kolmes);

if(empty($_GET['page'])) {$page_get = 1;} else {$page_get = $_GET['page']; settype($page_get, "integer");}
$do = $kolmes * ($page_get-1);
$end = $kolmes * $page_get;
$page_nazad = $page_get-1;
$page_dalee = $page_get+1;

if (eregi("([0-9])", $page_get))
{
if (($page_get < 0 | $page_get > $stranic) && !empty($data)) {echo '<p>Данной страницы несуществует!</p>';}

if(empty($data)) {echo '<p class="b">Регистраций нет<br></p>';}
else
 { echo '<div align="center"><h1>Детализация регистраций</h1></div>
<table>
<tr>
<th>№ п/п</th>
<th>Дата, время</th>
<th>Ник</th>
<th>IP</th>
<th>Браузер</th>
<th>E-mail</th>
</tr>
';
if($page_get!=1){$ii=$count-$page_get*$kolmes+$kolmes;}else{$ii=$count;}
for ($i = $do; $i < $end; $i++)
 {
 if (!empty($data[$i]))
  {
  $viewmess = explode('|', $data[$i]);

$dta=date('Y-m-d', $viewmess[1]);
$time=date('H:i:s', $viewmess[1]);
  echo '<tr>
<td>'.$ii--.'</td>
<td>'.$dta.' '.$time.'</td>
<td>'.$viewmess[0].'</td>
<td>'.$viewmess[4].'</td>
<td>'.$viewmess[3].'</td>
<td>'.$viewmess[2].'</td>
</tr>';
   }
 }

echo '</table>';
if($stranic > 1)
{
echo '<hr><p align="center">';
if($page_get > 1) {echo '<a href="partner.php?reg&amp;page='.$page_nazad.'">Назад</a>';}else{echo 'Назад';}
echo '|';
if($stranic > $page_get) {echo '<a href="partner.php?reg&amp;page='.$page_dalee.'">Дальше</a>';}else{echo 'Дальше';}
echo '<br>Страница:'.$page_get.'<br>';

echo 'Всего страниц:'.$stranic.'<br>';
if($page_get > 1) {echo '<a href="partner.php?reg&amp;page=1">В начало</a>';}else{echo 'В начало';}
echo '|';
if($stranic > $page_get) {echo '<a href="partner.php?reg&amp;page='.$stranic.'">В конец</a><br>';}else{echo 'В конец';}
echo '<hr></p>';
}
echo '<p>Всего <b>'.nn($count).'</b> регистраций.<br><br><br><br><br></p>';
  }
}
else{echo '<p align="center">Не наглей!';}
include_once 'other_inc/partnerend.php';
}

/*if(isset($_GET['kon']))
{
echo '<h1>Связь с администраторами</h1>
<p>Если у вас есть вопросы, предложения или идеи по поводу сервиса, пишите по ниже указанным контактам.</p><hr>
<p><b>Техническая поддержка. Подключение.</b><br>E-mail: support@imperia.mobi<br>
ICQ: 249-6-349<br>Тел. +3(8 093)7750688</p><hr>
<p><b>Организиционные вопросы</b><br>E-mail: support@imperia.mobi<br>
ICQ: 623-856-811</p>';
include_once 'other_inc/partnerend.php';
}*/

if(isset($_GET['sms'])){

echo '<hr><br><form action="partner.php?sms" method="get">
<div class="contactform">';
echo '<label for="Name">Кол-во на страницу:</label><input class="textfield" title="Кол-во" maxlength="3" name="kol" value="">
<input name="sms" type="hidden" value="">
<input type="submit" title="изменить" type="button" class="button" value="изменить"><div class="clear2"></div></div>
</form><br>';

$data = @file('data/partner/'.$_SESSION['partner'].'_sms.dat');
$data = array_reverse($data);
$count = count($data);
$ii=$count;
$stranic = ceil($count/$kolmes);

if(empty($_GET['page'])) {$page_get = 1;} else {$page_get = $_GET['page']; settype($page_get, "integer");}
$do = $kolmes * ($page_get-1);
$end = $kolmes * $page_get;
$page_nazad = $page_get-1;
$page_dalee = $page_get+1;

if (eregi("([0-9])", $page_get))
{
if (($page_get < 0 | $page_get > $stranic) && !empty($data)) {echo '<p>Данной страницы несуществует!</p>';}

if(empty($data)) {echo '<p class="b">СМС нет<br></p>';}
else
 { echo '<div align="center"><h1>Детализация SMS</h1></div>
<table>
<tr>
<th>№ п/п</th>
<th>Дата, время</th>
<th>Номер</th>
<th>Оператор</th>
<th>Телефон</th>
<th>Текст SMS</th>
<th>Доход (rur)</th>';
echo '<th>50% (rur)</th>';
echo '</tr>
';
if($page_get!=1){$ii=$count-$page_get*$kolmes+$kolmes;}else{$ii=$count;}
for ($i = $do; $i < $end; $i++)
 {
 if (!empty($data[$i]))
  {
  $viewmess = explode('||', $data[$i]);

$dohod=round($viewmess[4]*50/100,3);
  echo '<tr>
<td>'.$ii--.'</td>
<td>'.$viewmess[5].'</td>
<td>'.$viewmess[1].'</td>
<td>'.$viewmess[2].'</td>
<td>'.$viewmess[3].'</td>
<td>'.$viewmess[0].'</td>
<td>'.round($viewmess[4],3).'</td>
<td>'.$dohod.'</td>
</tr>';
   }
 }

echo '</table>';
if($stranic > 1)
{
echo '<hr><p align="center">';
if($page_get > 1) {echo '<a href="partner.php?sms&amp;page='.$page_nazad.'">Назад</a>';}else{echo 'Назад';}
echo '|';
if($stranic > $page_get) {echo '<a href="partner.php?sms&amp;page='.$page_dalee.'">Дальше</a>';}else{echo 'Дальше';}
echo '<br>Страница:'.$page_get.'<br>';

echo 'Всего страниц:'.$stranic.'<br>';
if($page_get > 1) {echo '<a href="partner.php?sms&amp;page=1">В начало</a>';}else{echo 'В начало';}
echo '|';
if($stranic > $page_get) {echo '<a href="partner.php?sms&amp;page='.$stranic.'">В конец</a><br>';}else{echo 'В конец';}
echo '<hr></p>';
}
echo '<p>Всего <b>'.nn($count).'</b> смс сообщений.</p><br><br><br><br><br>';
  }
}
else{echo '<p align="center">Не наглей!';}
include_once 'other_inc/partnerend.php';
}

if(isset($_GET['all']) || (!isset($_GET['per']) && !isset($_GET['sms']) && !isset($_GET['reg']) && !isset($_GET['kon']))){$files=file('data/partner/'.$_SESSION['partner'].'_reg.dat');
$countreg=count($files);

$files=file('data/partner/'.$_SESSION['partner'].'_site.dat');
$countp=count($files);

$file=file('data/partner/'.$_SESSION['partner'].'_sms.dat');
$countsms=count($file);
$summ='0';
for ($b=0; $b<$countsms; $b++)
{
$dt=explode('||',$file[$b]);
$summ=$summ+$dt[4]; //общая сумма
}
$summ=round($summ);
$summ2=round($summ*50/100);

if($_SESSION['partner']=='wapartemkaru'){$sila='wap.artemka.ru';}
if($_SESSION['partner']=='enzocomnet'){$sila='enzocom.net';}
if($_SESSION['partner']=='fonzoru'){$sila='fonzo.ru';}
if($_SESSION['partner']=='sotikru'){$sila='sotik.ru';}
if($_SESSION['partner']=='waposru'){$sila='wapos.ru';}
if($_SESSION['partner']=='waplognet'){$sila='waplog.net';}
if($_SESSION['partner']=='sizaru'){$sila='siza.ru';}
if($_SESSION['partner']=='seclubru'){$sila='seclub.ru';}
if($_SESSION['partner']=='wapmobua'){$sila='wap.mob.ua';}
if($_SESSION['partner']=='gruzmobru'){$sila='gruzmob.ru';}
if($_SESSION['partner']=='kenguru'){$sila='kengu.ru';}
if($_SESSION['partner']=='mobrikacom'){$sila='mobrika.com';}

echo '<p align="center">Ссылка для рекламной кампании:<br><a href="http://imperia.mobi/?site='.$sila.'">http://imperia.mobi/?site='.$sila.'</a><hr></p>';
echo '<p align="left">Переходов: <b>'.nn($countp).'</b>
<br>Успешных регистраций: <b>'.nn($countreg).'</b>
<br>Всего смс: <b>'.nn($countsms).'</b>
<br>Всего заработано: <b>'.nn($summ).'</b> рублей
<br>Доход партнера: <b>'.nn($summ2).'</b> рублей</p>
<hr>';}
/*if($_SESSION['partner']='secluborg') {echo '<p align="left">Переходов за 11.10: <b>13 557</b>
<br>Успешных регистраций за 11.10: <b>3 445</b>
<br>Всего смс за 11.10: <b>422</b>
<br>Всего заработано за 11.10: <b>8 641</b> рублей
<br>Доход партнера за 11.10: <b>2 585</b> рублей</p>
<hr>';}*/
include_once 'other_inc/partnerend.php';
?>