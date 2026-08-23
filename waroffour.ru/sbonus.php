<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];

if (isset($_REQUEST['days'])) $days = $_REQUEST['days'];
if (isset($days)&&!is_numeric($days)) $days=0;
if (isset($days)&&$days<0) $days=0;
if (isset($days))$days = round($days);
if (isset($days) && $days>100)$days=0;

if (isset($_REQUEST['amount'])) $amount = $_REQUEST['amount'];
if (isset($amount)&&!is_numeric($amount)) $amount=0;
if (isset($amount)&&$amount<0) $amount=0;
if (isset($amount))$amount = round($amount);
if (isset($amount) && $amount>1000000)$amount=0;

if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
if (isset($_REQUEST['res'])) $res = $_REQUEST['res'];

if (isset($_REQUEST['cnt'])) $see = $_REQUEST['cnt']; else $see =0;
//if (isset($_REQUEST['building'])) $building = $_REQUEST['building'];

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();

$r = mysql_query("SELECT credits,userID,username,spent FROM `uzers` WHERE countryID = '".$countryID."' LIMIT 1");
$a = mysql_fetch_array($r);
$credits = $a['credits']; //Число золота на счету
$userID = $a['userID']; //ID юзера
$login = $a['username'];
$spent = $a['spent']; //На какую сумму сделано покупок в день

switch($m):

default:
echo 'Для пополнения счета обменяй OK-и сайта Одноклассники на Золото игры <b>Великая Империя</b><br/>';
if(!isset($_POST['1'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Покупка 1 Золота в игре Великая Империя',
        'price=1',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    echo '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">1 Золото  </a>(<small>1 ОК</small>)<br/>';
	}
if(!isset($_POST['2'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Покупка 5 Золота в игре Великая Империя',
        'price=5',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    echo '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">5 Золота  </a>(<small>5 ОК</small>)<br/>';
	}
if(!isset($_POST['3'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Покупка 30 Золота в игре Великая Империя',
        'price=25',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    echo '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">25 Золота  </a>(<small>25 ОК</small>) <span style="color:#6FCD72">+ 5 Золота в подарок</span><br/>';
	}
if(!isset($_POST['4'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Покупка 120 Золота в игре Великая Империя',
        'price=100',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    echo '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">100 Золота </a>(<small>100 ОК</small>) <span style="color:#6FCD72">+ 20 Золота в подарок</span><br/>';
	}
if(!isset($_POST['5'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Покупка 600 Золота в игре Великая Империя',
        'price=500',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    echo '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">500 Золота </a>(<small>500 ОК</small>) <span style="color:#6FCD72">+ 100 Золота в подарок</span><br/>';
	}

echo "Услуги:<br/>";
#echo ""<a href=\"bonus.php?m=addfunds&amp;$ses\">Пополнить счет</a><br/>\r\n";
echo "<a href=\"bonus.php?m=moratory&amp;$ses\">Купить мораторий</a><br/>\r\n";
//echo "<a href=\"bonus.php?m=money&amp;$ses\">Купить деньги</a><br/>\r\n";
echo "<a href=\"bonus.php?m=res&amp;$ses\">Купить ресурсы, деньги или рабочих</a><br/>\r\n";
echo "<a href=\"bonus.php?m=save&amp;$ses\">Сохранить страну</a><br/>\r\n";
echo "<a href=\"bonus.php?m=addznc&amp;$ses\">Поставить значок в ассамблее</a><br/>\r\n";
//echo "<a href=\"bonus.php?m=workers&amp;$ses\">Покупка населения</a><br/>\r\n";
	
echo '<br/>* Для покупки виртуальной валюты (ОК) можно использовать веб-версию сайта <a href="http://odnoklassniki.ru">odnoklassniki.ru</a>, где доступны электронные средства платежей (WebMoney, Qiwi, Терминалы, Yandex и др.), которые помогут Вам сэкономить до 50% ваших средств.<br/><br/>';
    
echo '<div class="small ptm"><span class="low">Точная стоимость услуги зависит от вашего оператора.<br/>
Если при попытке купить Золото, ты попал на главную страницу сайта Одноклассники, то тебе нужно снова зайти в игру <b>Великая Империя</b> через раздел Игры на сайте Одноклассники, и повторить попытку.</span></div>';
break;
//**************покупаем золото***********************

case('mr'):
echo '
Покупка Золота через SMS<br/>
<a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=15 Золота&amp;sms_price=1&amp;country=ru">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=15 Золота&amp;sms_price=1&amp;country=ru">15 Золота</a><br/>
<a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=55 Золота&amp;sms_price=3&amp;country=ru">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=55 Золота&amp;sms_price=3&amp;country=ru">45 Золота</a><span style="color:#6FCD72">+ 10 Золота в подарок</span><br/>
<a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=95 Золота&amp;sms_price=5&amp;country=ru">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=95 Золота&amp;sms_price=5&amp;country=ru">75 Золота</a><span style="color:#6FCD72">+ 20 Золота в подарок</span><br/>';

echo "Услуги:<br/>";
#echo ""<a href=\"bonus.php?m=addfunds&amp;$ses\">Пополнить счет</a><br/>\r\n";
echo "<a href=\"bonus.php?m=moratory&amp;$ses\">Купить мораторий</a><br/>\r\n";
//echo "<a href=\"bonus.php?m=money&amp;$ses\">Купить деньги</a><br/>\r\n";
echo "<a href=\"bonus.php?m=res&amp;$ses\">Купить ресурсы, деньги или рабочих</a><br/>\r\n";
echo "<a href=\"bonus.php?m=save&amp;$ses\">Сохранить страну</a><br/>\r\n";
echo "<a href=\"bonus.php?m=addznc&amp;$ses\">Поставить значок в ассамблее</a><br/>\r\n";
//echo "<a href=\"bonus.php?m=workers&amp;$ses\">Покупка населения</a><br/>\r\n";

echo '<div class="small ptm"><span class="low">Точная стоимость услуги зависит от вашего оператора.<br/>
Если при попытке купить Золота, ты попал на главную страницу сайта Mail.ru, то тебе нужно снова зайти в игру <b>Великая Империя</b> через раздел Игры на сайте Mail.ru, и повторить попытку.</span></div>
';
break;

endswitch;

//}

//=============================================================================//Конец скрипту================================================================print "---<br/>\r\n";
/*printrus
("
<br/><a href='game.php?$ses'>Главная</a>
<br/>
");*/
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
?>