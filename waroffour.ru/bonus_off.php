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


if ($m=='pumpit')
{ $amountC=round($amount/2);
			$ps = strpos($_SERVER[HTTP_HOST], 'pumpit');
			if ($ps <> 0)
				{
				
				if ($amount <> 0){
				
				$query = array(
				 'app_id' => PUMPIT_APP_ID,
				 'p_sid'  => $_SESSION['p_sid'],
				 'login'  => $_SESSION['pumpit_login2'],
				 'action' => "DoIncAppAccount",
				 'burl' => "bonus.php?m=pumpit2&amount=$amount",
				 'desc' => "Pokupka",
				 'coin' => "$amountC",
				 'sig'    => "12345"
				);
				$url = GoToPumpit($query,true);
				header("Location: $url");
				die();
				}
				
				
				}
}	


//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
//isAuthed();



//gf december 22
if( !isset($_SESSION['auth']) && !isset($_SESSION['auth2'])){

	if ($_SERVER[HTTP_HOST] == 'imperia.mgates.ru')
		{
			setcookie('PHPSESSID', '');
			header('Location: http://spaces.ru/app/?sid=&enter=48');
			die();
		}
	 
	 
	  printrus ("<u>ВЫ НЕ АВТОРИЗОВАНЫ!</u><br/>\r\n");
	printrus ("<a href='index.php?$ses'>Главная</a><br/>");
	include_once("other_inc/footer.php");
	die();

	
	
	
}


	$forbidden=array('moratory', 'res', 'save', 'addznc', 'unite', 'gena');
	if ( (     in_array($_GET[m], $forbidden)    )   AND   (    !isset($_SESSION['auth'])     )  ){
	include_once("other_inc/footer.php");
	die();
	}




//printrus("<u>Поле чудес</u><br/>Это не магазин, золото начисляется за захваты 1 захват = 1 золото, других способ получить золото нет.! кроме случаев поощрения администрацией.<br />");

/*if (_SHOP!="off"){
printrus("Извините, услуги поля чудес временно недоступны.<br/>\r\n");
printrus
("
<a href='game.php?$ses'>&lt;&lt;В игру</a>
<br/>
");
printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
exit;
}*/
//
//if(isset($_SESSION['mr_uid']))
//{header ("Location: http://"._MAINSITE."/bonus.php?m=mr&".$ses);}
//
$r = mysql_query("SELECT credits,userID,username,spent FROM `uzers` WHERE countryID = '".$countryID."' LIMIT 1");
$a = mysql_fetch_array($r);
$credits = $a['credits']; //Число золота на счету
$userID = $a['userID']; //ID юзера
$login = $a['username'];
$spent = $a['spent']; //На какую сумму сделано покупок в день
	if(isset($_SESSION['mr_uid']) || isset($_SESSION['o_uid']))
{}else{
/*if(isset($_SESSION['o_uid']) || isset($_SESSION['mr_uid'])){}else{
printrus('<img src="/img/ico/cr3.png" alt="" /><span style="color:#6FCD72"><b>Акция!!</b></span> <span style="color:#6FCD72">Пополни счет любым платежом, на любую сумму и получи + 25 % Золота. Например, при пополнении на <img src="/img/ico/cr3.png" alt="" />100 + <img src="/img/ico/cr3.png" alt="" />25 в подарок</span><br/>');
$date = strtotime("27 December 2011");  
   
 $sec=$date - time();  
 $days=floor(($date - time()) /86400);  
 $h1=floor(($date - time()) /3600);  
 $m1=floor(($date - time()) /60);  
 $hour=floor($sec/60/60 - $days*24);  
 $hours=floor($sec/60/60);  
 $min=floor($sec/60 - $hours*60);  
   
 switch(substr($days, -1)){  
 case 1: $o='остался';  
 break;  
 case 2: case 3: case 4: case 5: case 6: case 7: case 8: case 9: case 0: $o='осталось';  
 break;}  
   
 switch(substr($days, -2)){  
 case 1: $d='день';  
 break;  
 case 2: case 3: case 4: $d='дня';  
 break;  
 default: $d='дней';  
 }  
   
 switch(substr($hour, -2)) {  
 case 1: $h='час';  
 break;  
 case 2: case 3: case 4: $h='часа';  
 break;  
 default: $h='часов';  
 }  
   
 switch(substr($min, -2)) {  
 case 1: $mm='минута';  
 break;  
 case 2: case 3: case 4: $m='минуты';  
 break; 
 default:$mm='минут'; 
 }  
   
if ($sec>0) printrus( '<span style="color:#FF8040">До конца акции '.$o.' '); if ($days>0) printrus( '<b>'.$days.'</b> '.$d.' '); if ($h1>0) printrus( '<b>'.$hour.'</b> '.$h.''); if ($m1>0) printrus( ' и <b>'.$min.'</b> '.$mm.'</span>'); if ($sec<0) printrus( "Акция закончилась!");
printrus( '<br/><br/>');
}*/
$credits_n=$credits;

if ($m == 'mgates')
{

	if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' AND $_GET['sid'] == '')
	{
		if ($amount <> 0){
		
		$spend=$amount;
		$got=round($amount/6);
		
		$credits_n=$credits+$got;
		
		$mg=$mgates->spendMoney($_SESSION['sid_value'], $spend);
		mysql_query("UPDATE `uzers` SET credits = credits + $got WHERE userID = '$userID' LIMIT 1");
		printrus("Вы обменяли $spend amr на $got золота.<br/>");
		}
		


	}


}


if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' )
{
$mg=$mgates->getUserBalance($_SESSION['sid_value']);
$amr=" и ".$mg['balance']." amr";
}


printrus("У вас на счету: <b>$credits_n</b> золота$amr. Ваш ID: $userID<br/><br/>");
// генерируем email для xsolla
	$impmail = md5(uniqid(rand(),1));
	$impmail =  substr($impmail, 0, 10);
	$impmail = ''.$impmail.'@imperia.mobi';
	//$secret_key_x = ']-Nw#m5YU#y+%=Q,d9KD]xJYJb';

$ps = strpos($_SERVER[HTTP_HOST], 'pumpit');
if ($ps <> 0)
	{
	 printrus("Для пополнения счета обменяй монеты PumpItUp на <img src='/img/ico/cr3.png' alt='.' />золото Империи<br/><br/>");
	 printrus("<a href='bonus.php?m=pumpit&amp;amount=2&amp;$ses'>Купить <img src='/img/ico/cr3.png' alt='.' />2 золота</a> <span class='low'>(1 монета)</span><br/><br/>");
	 printrus("<a href='bonus.php?m=pumpit&amp;amount=30&amp;$ses'>Купить <img src='/img/ico/cr3.png' alt='.' />30 золота</a> <span class='low'>(15 монет)</span><br/><br/>");
	 printrus("<a href='bonus.php?m=pumpit&amp;amount=150&amp;$ses'>Купить <img src='/img/ico/cr3.png' alt='.' />150 золота</a> <span class='low'>(75 монет)</span><br/>
	 <span class=\"green\">Бонус +<img src='/img/ico/cr3.png' alt='.' />15 золота в подарок</span><br/><br/>");
	 printrus("<a href='bonus.php?m=pumpit&amp;amount=750&amp;$ses'>Купить <img src='/img/ico/cr3.png' alt='.' />750 золота</a> <span class='low'>(375 монет)</span><br/>
	 <span class=\"green\">Бонус +<img src='/img/ico/cr3.png' alt='.' />113 золота в подарок</span><br/><br/>");
	 printrus("<a href='bonus.php?m=pumpit&amp;amount=1500&amp;$ses'>Купить <img src='/img/ico/cr3.png' alt='.' />1500 золота</a> <span class='low'>(750 монет)</span><br/>
	 <span class=\"green\">Бонус +<img src='/img/ico/cr3.png' alt='.' />450 золота в подарок</span><br/><br/>");
	
	/*Форма
	printrus("Сколько золота хотите купить (курс 1 к 1):<br/>\r\n");
    printrus("<form name=\"\" action=\"bonus.php?m=pumpit&amp;$ses\" method=\"post\">
    <input format='*N' maxlength='7' name='amount' /><br/>");
    printrus("<input type=\"submit\" value=\"Купить\"/>
    </form><br/>");
	*/
	}

if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' )
{
	//Уже есть в другом месте кода
	if ($amount <> 0 AND 2==3){
	$mg=$mgates->spendMoney($_SESSION['sid_value'], $amount);
	mysql_query("UPDATE `uzers` SET credits = credits + $amount WHERE userID = '$userID' LIMIT 1");
	printrus("Вы купили $amount золота");
	}
	else{
	/*printrus("Сколько золота хотите купить на amr (курс 1 к 1):<br/>\r\n");
    printrus("<form name=\"\" action=\"bonus.php?m=mgates&amp;$ses\" method=\"post\">
    <input format='*N' maxlength='7' name='amount' /><br/>");
    printrus("<input type=\"submit\" value=\"Купить\"/>
    </form><br/>");
	*/
//    printrus("Для пополнения счета обменяй монеты Spaces на <img src='/img/ico/cr3.png' alt='.' />золото Империи<br/><br/>");
	printrus("200 arm = <img src='/img/ico/cr3.png' alt='.' />33 золота<br/><a href ='bonus.php?m=mgates&amp;amount=200'><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Обменять</a><br/><br/>");
	printrus("800 arm = <img src='/img/ico/cr3.png' alt='.' />132 золота<br/><a href ='bonus.php?m=mgates&amp;amount=800'><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Обменять</a><br/><br/>");
	printrus("1600 arm = <img src='/img/ico/cr3.png' alt='.' />264 золота<br/><a href ='bonus.php?m=mgates&amp;amount=1600'><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Обменять</a><br/><br/>");
	}

}else{
	if ($ps == 0){
$e_mail = $impmail;
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="bonus.php?m=mob_sms&amp;'.$ses.'">Мобильные платежи</a><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="bonus.php?m=sms&amp;'.$ses.'">Через SMS</a><br/>');
// <span class="green">(Акция)</span>
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="bonus.php?m=wmlist&amp;'.$ses.'">WebMoney</a><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="https://secure.xsolla.com/paystation2/?theme=100&amp;project=5490&amp;marketplace=mobile&amp;action=directpayment&amp;v1='.$userID.'&amp;email='.$e_mail.'&amp;country=RU&amp;local=ru&amp;pid=16">QIWI кошелек</a><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="bonus.php?m=ya&amp;'.$ses.'">Яндекс.Деньги</a><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="bonus.php?m=term&amp;'.$ses.'">Терминалы</a><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="bonus.php?m=bank&amp;'.$ses.'">Банковские карты</a><br/>');

if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' )
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="bonus.php?m=mgates&amp;'.$ses.'">Обменять на arm</a><br/>');

//printrus('<a href="bonus.php?m=wm&amp;'.$ses.'">WebMoney</a><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." /><a href="bonus.php?m=other&amp;'.$ses.'">Прочие способы</a><br/>');
//printrus('<a href="bonus.php?m=2pay&amp;'.$ses.'">Другие способы оплаты</a>');
printrus('<br/>');

if($_GET['m']=='') {
printrus("<span class=\"admin\"><b>Бонуcы:</b></span><br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>100</b> золота и получи <span class=\"green\">+10%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>300</b> золота и получи <span class=\"green\">+15%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>900</b> золота и получи <span class=\"green\">+30%</span> в подарок<br/><br/>
");}
	}
}}
/*if (($b['reggedTime']+86400*2>time())&&$_SESSION['userID']!=13){//86400
printrus("Извините, воспользоваться услугами поля чудес могут только страны, зарегистрировавшиеся более двух дней назад!<br/>\r\n");
}else{*/

switch($m):

default:
	if(isset($_SESSION['mr_uid']))
{header ("Location: http://"._MAINSITE."/sbonus.php?m=mr&".$ses);}
	if(isset($_SESSION['o_uid']))
{header ("Location: http://"._MAINSITE."/sbonus.php?".$ses);}



printrus("Услуги:<br/>");



if (      isset($_SESSION['auth'])       ){


#printrus("<a href=\"bonus.php?m=addfunds&amp;$ses\">Пополнить счет</a><br/>\r\n");
printrus("<a href=\"bonus.php?m=moratory&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Купить мораторий</a><br/>\r\n");
//printrus("<a href=\"bonus.php?m=money&amp;$ses\">Купить деньги</a><br/>\r\n");
printrus("<a href=\"bonus.php?m=res&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Купить ресурсы, деньги или рабочих</a><br/>\r\n");
printrus("<a href=\"bonus.php?m=save&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Сохранить страну</a><br/>\r\n");
printrus("<a href=\"bonus.php?m=addznc&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Поставить значок в ассамблее</a><br/>\r\n");

//Если у игрока союзов + возможных союзов, только один - разрешаем докупить второй
//if (count_unite($countryID) + $b['unites'] <= 1 )
printrus("<a href=\"bonus.php?m=unite&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Купить союз</a><br/>\r\n");

printrus("<a href=\"bonus.php?m=gena&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Эликсир молодости для генерала</a><br/>\r\n");

}else{
printrus("Услуги недоступны, так как у вас нет страны.\r\n");
}

if ($ps <> 0)
	{
printrus("<span class='low'><br/>Если при попытке купить золото, ты попал на главную страницу PumpItUp, то тебе нужно снова зайти в игру <b>Великая Империя</b> через раздел игр на сайте PumpItUp, и повторить попытку.</span><br/>\r\n");
}
if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' )
{
printrus("<span class='low'><br/>Если при попытке купить золото, ты попал на главную страницу Spaces, то тебе нужно снова зайти в игру <b>Великая Империя</b> через раздел <b>Мои игры</b> на сайте Spaces, и повторить попытку.</span><br/>\r\n");
}
//printrus("<a href=\"bonus.php?m=workers&amp;$ses\">Покупка населения</a><br/>\r\n");
break;
//**************покупаем золото***********************


case('pumpit2'):
print "Куплено $amount золота.";
break;

case('mr'):
printrus('
Покупка Золота через SMS<br/>
<a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=15 Золота&amp;sms_price=1&amp;country=ru">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=15 Золота&amp;sms_price=1&amp;country=ru">15 Золота</a><br/>
<a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=45 Золота&amp;sms_price=3&amp;country=ru">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=45 Золота&amp;sms_price=3&amp;country=ru">45 Золота</a><br/>
<a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=75 Золота&amp;sms_price=5&amp;country=ru">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="http://tel.my.mail.ru/app/payment/window?appid=643777&amp;service_id=27277&amp;service_name=75 Золота&amp;sms_price=5&amp;country=ru">75 Золота</a><br/>
<div class="small ptm"><span class="low">Точная стоимость услуги зависит от вашего оператора.<br/>
Если при попытке купить Золота, ты попал на главную страницу сайта Mail.ru, то тебе нужно снова зайти в игру <b>Великая Империя</b> через раздел Игры на сайте Mail.ru, и повторить попытку.</span></div>
');
break;

case('od'):
printrus ('Для пополнения счета обменяй OK-и сайта Одноклассники на Золото игры <b>Великая Империя</b><br/>');
if(!isset($_POST['1'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Pokupka 1 Zolota v igre Velikaja Imperia',
        'price=1',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    printrus ('<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">1 Золото  </a>(<small>1 ОК</small>)<br/>');
	}
if(!isset($_POST['2'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Pokupka 5 Zolota v igre Velikaja Imperia',
        'price=5',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    printrus ( '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">5 Золота  </a>(<small>5 ОК</small>)<br/>');
	}
if(!isset($_POST['3'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Pokupka 29 Zolota v igre Velikaja Imperia',
        'price=29',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    printrus ( '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">25 Золота  </a>(<small>29 ОК</small>) <span style="color:#6FCD72">+ 4 Золота в подарок</span><br/>');
	}
if(!isset($_POST['4'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Pokupka 115 Zolota v igre Velikaja Imperia',
        'price=115',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    printrus ( '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">100 Золота </a>(<small>100 ОК</small>) <span style="color:#6FCD72">+ 15 Золота в подарок</span><br/>');
	}
if(!isset($_POST['5'])){
	$appId="5296128";
    $appKey="CBABNBFBABABABABA";
    $app_sk = "1A05AA0864B5BD3CB5364093";
    
    $args = array(
        'application_key='.$appKey,
        'code=1',
        'name=Pokupka 600 Zolota v igre Velikaja Imperia',
        'price=600',
        'session_key='.$_SESSION['o_session_key'],
        //'session_s_key='.$_SESSION['o_session_s_key'],
    );
    sort($args);
    $str = join('', $args);
    $sig = md5($str.$_SESSION['o_session_s_key']);
    
    $req = 'http://m.odnoklassniki.ru/api/show-payment?'.join('&amp;', $args).'&amp;sig='.$sig;
        
    printrus ( '<a href="'.$req.'">Купить</a> <img src="/img/ico/cr3.png" alt="" /> <a href="'.$req.'">500 Золота </a>(<small>500 ОК</small>) <span style="color:#6FCD72">+ 100 Золота в подарок</span><br/>');
	}
	
printrus ( '<br/>* Для покупки виртуальной валюты (ОК) можно использовать веб-версию сайта <a href="http://odnoklassniki.ru">odnoklassniki.ru</a>, где доступны электронные средства платежей (WebMoney, Qiwi, Терминалы, Yandex и др.), которые помогут Вам сэкономить до 50% ваших средств.<br/><br/>');
    
printrus ( '<small>Точная стоимость услуги зависит от вашего оператора.<br/>
Если при попытке купить Золото, ты попал на главную страницу сайта Одноклассники, то тебе нужно снова зайти в игру <b>Великая Империя</b> через раздел Игры на сайте Одноклассники, и повторить попытку.</small>');
break;

//wm
case ('owm'):
printrus('<b>Покупка Золота через WebMoney</b><br/>');
printrus('
<a href="http://webmoney.ru/rus/about/index.shtml">WebMoney</a> - широко распространенная
платежная система, вы можете зарегистрировать свой аккаунт в ней <a href="http://start.webmoney.ru/">здесь</a>.<br/>
<br/>
При регистрации вы укажете как вы будете пользоваться сервисом WebMoney - c помощью специальной программы <a href="http://webmoney.ru/rus/about/demo/classic/index.shtml">WM Keeper Classic</a> ( ее
нужно установить на свой компьютер и пользоваться своим кошельком вы будете только со своего ПК ), либо с
помощью онлайн-версии этой программы <a href="http://webmoney.ru/rus/about/demo/light/index.shtml">WM Keeper
Light</a>. Необходимо отметить, что ваш кошелек будет привязан только к одной из этих программ, и вам нужно
будет с самого начала определиться какой из них для вас является предпочтительнее.<br/>
<br/>
В системе WebMoney существует несколько видов валют, на нашем сайте вы можете оплатить следующими из них: WMR,
WMZ, WMU, WMB. Если у вас кошелек, не входящий в перечисленные (WME, WMG) - вы можете воспользоваться
обменом валют в вашем кошельке (см. деморолики для <a href="http://download.webmoney.ru/demo/obmen.swf">WM
Keeper Classic</a> и для <a href="http://download.webmoney.ru/demo/obmen_light_ru.swf">WM Keeper
Light</a> )<br/>
<br/>
Пополнить ваш кошелек Webmoney можно различными способами, подробнее о них для каждого типа кошелька вы можете
узнать <a href="http://webmoney.ru/rus/addfunds/index.shtml">здесь</a>. Также вы можете легко
узнать о точках пополнения счета в <a href="http://gde.webmoney.ru">вашем
городе</a> или стране.<br/>
<br/>
Справочную информацию по платежной системе WebMoney, деморолики операций с кошельками и другую полезную
информацию вы можете также найти в <a href="http://webmoney.ru/rus/about/demo/index.shtml">WM-энциклопедии</a>.<br/>
<br/>
У вас уже есть кошелек WebMoney, и на нем есть необходимая сумма? Тогда осталось самое простое - купить игровую
валюту. Зайдите на страницу <a href="bonus.php?go=wm">оплаты WebMoney</a> - и следуйте инструкциям на
экране. После выбора желаемой суммы и валюты вы попадете на экран WebMoney Transfer, где вам необходимо будет
выбрать вид вашего кошелька (Classic или Light) или вид оплаты, авторизоваться в нем и подтвердить оплату. В течение нескольких
секунд вы получите в игре сообщение о переводе на счет вашего персонажа купленного вами количества игровой
валюты.<br/><br/>
Оплата WebMoney также возможна посредством предоставления карт Paymer.<br/>
');
printrus('<br/><a href="bonus.php?m=owm">Порядок оплаты</a>
');
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case ('wmlist'):
printrus('<b>Покупка Золота через WebMoney</b><br/>');
printrus('
<img src="/img/ico/cr3.png" alt="" /> <a href="bonus.php?m=wmr">Купить за WMR <span class="green">(+ бонус)</span></a><br/>
<img src="/img/ico/cr3.png" alt="" /> <a href="bonus.php?m=wmu">Купить за WMU <span class="green">(+ бонус)</span></a><br/>
<img src="/img/ico/cr3.png" alt="" /> <a href="bonus.php?m=wmb">Купить за WMB <span class="green">(+ бонус)</span></a><br/>
<img src="/img/ico/cr3.png" alt="" /> <a href="bonus.php?m=wmz">Купить за WMZ <span class="green">(+ бонус)</span></a><br/>
');
printrus('<br/><a href="bonus.php?m=owm">Порядок оплаты</a>
');
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case ('yes'):
	printrus('ID'.$userID.', начислен Золото!<br/>Приятной игры!');
break;

case ('no'):
	printrus('ID'.$userID.', оплата не прошла! Возможно, вы отказались от платежа или возникла другая ошибка.<br/>Попробуйте еще раз!');
break;
//
case('wmz'):
printrus('<b>Покупка Золота через WebMoney</b><br/>');
printrus('
<img src="picaso/icons/col.png" alt="" />  1 Золото. Цена 0.03 WMZ
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="0.03"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 1 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="Z237855762866"/>
<input type="hidden" name="id" value="22"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 1 Золото!
</form><br/>
<img src="picaso/icons/col.png" alt="" />  5 Золото. Цена 0.15 WMZ
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="0.15"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 5 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="Z237855762866"/>
<input type="hidden" name="id" value="23"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 5 Золото!
</form><br/>
<img src="picaso/icons/col.png" alt="" />  25 Золото. Цена 0.75 WMZ
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="0.75"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 25 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="Z237855762866"/>
<input type="hidden" name="id" value="24"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 25 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />3 в подарок)</span>
</form><br/>
<img src="picaso/icons/col.png" alt="" />  100 Золото. Цена 3 WMZ
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="3"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 100 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="Z237855762866"/>
<input type="hidden" name="id" value="25"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 100 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />15 в подарок)</span>
</form><br/>
<img src="picaso/icons/col.png" alt="" />  500 Золото. Цена 15 WMZ
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="15"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 500 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="Z237855762866"/>
<input type="hidden" name="id" value="26"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 500 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />150 в подарок)</span>
</form><br/>
');
printrus('<br/><a href="bonus.php?m=owm">Порядок оплаты</a>
');
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case('wmu'):
printrus('<b>Покупка Золота через WebMoney</b><br/>');
printrus('
<img src="picaso/icons/col.png" alt="" />  1 Золото. Цена 0.25 WMU
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="0.25"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 1 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="U103003280857"/>
<input type="hidden" name="id" value="15"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 1 Золото!
</form><br/>
<img src="picaso/icons/col.png" alt="" />  5 Золото. Цена 1.25 WMU
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1.25"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="4"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 5 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="U103003280857"/>
<input type="hidden" name="id" value="16"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 5 Золото!
</form><br/>
<img src="picaso/icons/col.png" alt="" />  25 Золото. Цена 6.25 WMU
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="6.25"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 25 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="U103003280857"/>
<input type="hidden" name="id" value="17"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 25 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />3 в подарок)</span>
</form><br/>
<img src="picaso/icons/col.png" alt="" />  100 Золото. Цена 25 WMU
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="25"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 100 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="U103003280857"/>
<input type="hidden" name="id" value="18"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 100 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />15 в подарок)</span>
</form><br/>
<img src="picaso/icons/col.png" alt="" />  500 Золото. Цена 125 WMU
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="125"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 500 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="U103003280857"/>
<input type="hidden" name="id" value="19"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 500 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />150 в подарок)</span>
</form><br/>
');
printrus('<br/><a href="bonus.php?m=owm">Порядок оплаты</a>
');
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;


case('wmb'):
printrus('<b>Покупка Золота через WebMoney</b><br/>');
printrus('
<img src="picaso/icons/col.png" alt="" />  1 Золото. Цена 274 WMB
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="274"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 1 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="B254965832143"/>
<input type="hidden" name="id" value="1"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 1 Золото!
</form><br/>
<img src="picaso/icons/col.png" alt="" />  5 Золото. Цена 1370 WMB
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="1370"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 5 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="B254965832143"/>
<input type="hidden" name="id" value="2"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 5 Золото!
</form><br/>
<img src="picaso/icons/col.png" alt="" />  25 Золото. Цена 6850 WMB
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="6850"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 25 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="B254965832143"/>
<input type="hidden" name="id" value="3"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 25 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />3 в подарок)</span>
</form><br/>
<img src="picaso/icons/col.png" alt="" />  100 Золото. Цена 27400 WMB
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="27400"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 100 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="B254965832143"/>
<input type="hidden" name="id" value="4"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 100 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />15 в подарок)</span>
</form><br/>
<img src="picaso/icons/col.png" alt="" />  500 Золото. Цена 137000 WMB
<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="137000"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 500 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="B254965832143"/>
<input type="hidden" name="id" value="5"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 500 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />150 в подарок)</span>
</form><br/>
');
printrus('<br/><a href="bonus.php?m=owm">Порядок оплаты</a>
');
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case('wmr'):
printrus('<b>Покупка Золота через WebMoney</b><br/>');
printrus('<img src="/img/ico/cr3.png" alt="" /> '); printrus('1 Золото. Цена 1 WMR');
printrus('<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="1"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 1 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="R171446592363"/>
<input type="hidden" name="id" value="8"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 1 Золото!
</form><br/>');
printrus('<img src="/img/ico/cr3.png" alt="" /> '); printrus('5 Золото. Цена 5 WMR');
printrus('<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="5"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 5 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="R171446592363"/>
<input type="hidden" name="id" value="9"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 5 Золото!
</form><br/>');
printrus('<img src="/img/ico/cr3.png" alt="" /> '); printrus('25 Золото. Цена 25 WMR');
printrus('<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="25"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 25 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="R171446592363"/>
<input type="hidden" name="id" value="10"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 25 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />3 в подарок)</span>
</form><br/>');
printrus('<img src="/img/ico/cr3.png" alt="" /> '); printrus('100 Золото. Цена 100 WMR');
printrus('<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="100"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 100 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="R171446592363"/>
<input type="hidden" name="id" value="11"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 100 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />15 в подарок)</span>
</form><br/>');
printrus('<img src="/img/ico/cr3.png" alt="" /> '); printrus('500 Золото. Цена 500 WMR');
printrus('<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp">
<input type="hidden" name="LMI_PAYMENT_NO" value="1"/>
<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="500"/>
<input type="hidden" name="LMI_PAYMENT_DESC" value="ID'.$userID.' - 500 Zoloto"/>
<input type="hidden" name="LMI_PAYEE_PURSE" value="R171446592363"/>
<input type="hidden" name="id" value="12"/>
<input type="hidden" name="name" value="'.$userID.'"/>
<input type="submit" value=" купить "/> 500 Золото! <span class="green">(+ <img src="/img/ico/cr3.png" alt="" />150 в подарок)</span>
</form><br/>');
printrus('<br/><a href="bonus.php?m=owm">Порядок оплаты</a>
');
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;
//

case('sms'):
printrus('
Для покупки золота отправь СМС с текстом:<br/>
<span class="green"><b>imp '.$userID.'</b></span> <small>(между "imp" и "'.$userID.'" есть пробел)</small><br/>
На номер:<br/><br/>');

printrus('<b>Для Украины:</b><br/>
<a href="sms:6907?body=imp+'.$userID.'">6907</a> - <img src="/img/ico/cr3.png" alt="." />12 Золота <small>(=7.00 грн.**)</small><br/>
<a href="sms:576?body=imp+'.$userID.'">576</a> - <img src="/img/ico/cr3.png" alt="." />17<span style="color:#34c924">+17</span> Золота <span style="color:#34c924"> в подарок</span> <small>(=10.00 грн.**)</small><br/>
<a href="sms:6915?body=imp+'.$userID.'">6915</a> - <img src="/img/ico/cr3.png" alt="." />27<span style="color:#34c924">+27</span> Золота <span style="color:#34c924"> в подарок</span> <small>(=15.00 грн.**)</small><br/>
');//
printrus('<b>Для России:</b><br/>
<a href="sms:7914?body=imp+'.$userID.'">7914</a> - <img src="/img/ico/cr3.png" alt="." />19 Золота <small>(~40 руб.*)</small><br/>
<a href="sms:7913?body=imp+'.$userID.'">7913</a> - <img src="/img/ico/cr3.png" alt="." />24 Золота <small>(~50 руб.*)</small><br/>
<a href="sms:7915?body=imp+'.$userID.'">7915</a> - <img src="/img/ico/cr3.png" alt="." />33<span style="color:#34c924">+33</span> Золота <span style="color:#34c924"> в подарок</span> <small>(~71 руб.*)</small><br/>
<a href="sms:7916?body=imp+'.$userID.'">7916</a> - <img src="/img/ico/cr3.png" alt="." />82<span style="color:#34c924">+82</span> Золота <span style="color:#34c924"> в подарок</span> <small>(~170 руб.*)</small><br/>
');
// казахстан
/*printrus('<br/><b>Для Казахстана:</b><br/>
<a href="sms:4446?body=imp+'.$userID.'">4446</a> - <img src="/img/ico/cr3.png" alt="." />12 золота <span class="low">(~145.53 тенге)</span><br/>
<a href="sms:4449?body=imp+'.$userID.'">4449</a> - <img src="/img/ico/cr3.png" alt="." />36<span class="green">+12</span> золота <span class="green">в подарок</span> <span class="low">(~441 тенге)</span><br/>
');*/
printrus("<br/><img src=\"/img/ico/cr3.png\" alt=\".\" /> <a href=\"https://secure.xsolla.com/paystation2/?theme=100&project=5490&marketplace=mobile&action=directpayment&v1=$userID&local=ru&pid=59\">Другие страны</a><br/>
<br/><span class=\"low\">
Поддержка по вопросам платежей<br/>
Телефон: +380-44-538-0308
<br/></span>
");
//
printrus("<br/><div class=\"small ptm\"><span class=\"low\">
* В России услуга доступна для всех операторов России. Цены указаны с НДС. Стоимость может отличаться для разных операторов. Точную стоимость Вы можете узнать у Вашего оператора.
<br/><br/>
 ** На Украине услуга доступна для всех национальных операторов сетей стандарта GSM. Цены указаны с НДС. <a href=\"bonus.php?m=ukr_info&amp;$ses\" class=\"footer\"><span>Стоимость для Украины</span></a>.</span></div>
");
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case('sms2'):
printrus('
Для покупки золота отправь СМС с текстом:<br/>
<span class="green"><b>imp '.$userID.'</b></span> <small>(между "imp" и "'.$userID.'" есть пробел)</small><br/>
На номер:<br/><br/>');
// Молдова
printrus('<b>Для Молдовы:</b><br/>
<a href="sms:4445?body=imp+'.$userID.'">4445</a> - <img src="/img/ico/cr3.png" alt="" />6 золота <span class="low">(~16.3 руб.*)</span><br/>
<a href="sms:4446?body=imp+'.$userID.'">4446</a> - <img src="/img/ico/cr3.png" alt="" />12 золота <span class="low">(~26.8 руб.*)</span><br/><br/>');

// Узбекистан
printrus('<b>Для Узбекистана:</b><br/>
<a href="sms:4446?body=imp+'.$userID.'">4446</a> - <img src="/img/ico/cr3.png" alt="" />12 золота <span class="low">(~26.8 руб.*)</span><br/>
<a href="sms:4449?body=imp+'.$userID.'">4449</a> - <img src="/img/ico/cr3.png" alt="" />36<span class="green">+12</span> золота <span class="green">в подарок</span> <span class="low">(~81.4 руб.*)</span><br/><br/>
');

// Армения
printrus('<b>Для Армении:</b><br/>
<a href="sms:4446?body=imp+'.$userID.'">4446</a> - <img src="/img/ico/cr3.png" alt="" />12 золота <span class="low">(~26.8 руб.*)</span><br/>
<a href="sms:4448?body=imp+'.$userID.'">4448</a> - <img src="/img/ico/cr3.png" alt="" />24 золота <span class="low">(~54.2 руб.*)</span><br/>
<a href="sms:4449?body=imp+'.$userID.'">4449</a> - <img src="/img/ico/cr3.png" alt="" />36<span class="green">+12</span> золота <span class="green">в подарок</span> <span class="low">(~81.4 руб.*)</span><br/><br/>
');

// Таджикистан
printrus('<b>Для Таджикистана:</b><br/>
<a href="sms:4446?body=imp+'.$userID.'">4446</a> - <img src="/img/ico/cr3.png" alt="" />12 золота <span class="low">(~26.8 руб.*)</span><br/><br/>
');

// Киргизия
printrus('<b>Для Киргизии:</b><br/>
<a href="sms:4446?body=imp+'.$userID.'">4446</a> - <img src="/img/ico/cr3.png" alt="" />12 золота <span class="low">(~26.8 руб.*)</span><br/>
<a href="sms:4449?body=imp+'.$userID.'">4449</a> - <img src="/img/ico/cr3.png" alt="" />36<span class="green">+12</span> золота <span class="green">в подарок</span> <span class="low">(~81.4 руб.*)</span><br/>
<a href="sms:4161?body=imp+'.$userID.'">4161</a> - <img src="/img/ico/cr3.png" alt="" />57<span class="green">+19</span> золота <span class="green">в подарок</span> <span class="low">(~128.8 руб.*)</span><br/><br/>
<span class="low">
Поддержка по вопросам платежей<br/>
e-mail: support@i-free.com
<br/><br/></span>
');
//
printrus("<a href=\"bonus.php?m=sms&amp;$ses\">Назад</a>");
break;

case('ukr_info'):
printrus('
<big>Стоимость для Украины</big><br/><br/>
6907 - Украина. Для всех национальных операторов сетей стандарта GSM 7.00 грн.<br/><br/>
576 - Украина. Для всех национальных операторов сетей стандарта GSM 10.00 грн.<br/><br/>
6915 - Украина. Для всех национальных операторов сетей стандарта GSM 15.00 грн.<br/><br/>
Для совершеннолетних абонентов всех национальных GSM операторов Украины. Тариф в гривнах с учетом НДС. Дополнительно учитывается сбор в ПФ в размере 7.5% от стоимости услуги без учета НДС. Услуга предоставляется при технической поддержке ООО "ВЕС МЕДИА", 02091, г.Киев, ул.Харьковское шоссе, 144в, телефон 0445380308.<br/><br/>
<a href="bonus.php?m=sms&amp;'.$ses.'">Назад</a>
');
break;

case('bank'):
printrus('Пополнение через банковскую карту - выгодно, быстро, удобно и с минимальной комиссией<br/><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." />1 золото = 1 рубль<br/><br/>');
printrus("<a href=\"http://m.xsolla.com/index.php?action=form&amp;id_project=5490&amp;id_rubric=7&amp;pid=26&amp;local=ru&amp;v1=".$userID."&amp;email=".$e_mail."\"><b>Купить Золото</b></a><br/>");

printrus("<br/><span class=\"admin\"><b>Бонуcы xsolla:</b></span><br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>100</b> золота и получи <span class=\"green\">+10%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>300</b> золота и получи <span class=\"green\">+15%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>900</b> золота и получи <span class=\"green\">+30%</span> в подарок<br/>
");

printrus("<div class=\"small ptm\"><span class=\"low\"><br/>Поддержка по вопросам платежей:<br/>
 Тел.: 8-800-200-27-29 (из регионов России бесплатно)<br/>
 ICQ: 232-437-503<br/>
 MSN: support@2pay.ru<br/>
 Skype: support_2pay.ru<br/>
 E-mail: support@xsolla.com<br/></span></div>");
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case('other'):
printrus('Более 80 способов оплат Xsolla<br/><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." />1 золото = 1 рубль<br/><br/>');
printrus("<a href=\"http://m.xsolla.com/index.php?id_project=5490&amp;local=ru&amp;v1=".$userID."&amp;email=".$e_mail."\"><b>Купить Золото</b></a><br/>");

printrus("<br/><span class=\"admin\"><b>Бонуcы xsolla:</b></span><br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>100</b> золота и получи <span class=\"green\">+10%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>300</b> золота и получи <span class=\"green\">+15%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>900</b> золота и получи <span class=\"green\">+30%</span> в подарок<br/>
");

printrus("<div class=\"small ptm\"><span class=\"low\"><br/>Поддержка по вопросам платежей:<br/>
 Тел.: 8-800-200-27-29 (из регионов России бесплатно)<br/>
 ICQ: 232-437-503<br/>
 MSN: support@2pay.ru<br/>
 Skype: support_2pay.ru<br/>
 E-mail: support@xsolla.com<br/></span></div>");
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case('ya'):
printrus('Яндекс.Деньги — удобный и безопасный способ купить Золото быстро и без очередей!<br/><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." />1 золото = 1 рубль<br/><br/>');
printrus("<a href=\"http://m.xsolla.com/index.php?action=form&amp;id_project=5490&amp;id_rubric=2&amp;pid=27&amp;local=ru&amp;v1=".$userID."&amp;email=".$e_mail."\"><b>Купить Золото</b></a><br/>");

printrus("<br/><span class=\"admin\"><b>Бонуcы Яндекс.Деньги:</b></span><br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>100</b> золота и получи <span class=\"green\">+10%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>300</b> золота и получи <span class=\"green\">+15%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>900</b> золота и получи <span class=\"green\">+30%</span> в подарок<br/>
");

printrus("<div class=\"small ptm\"><span class=\"low\"><br/>Поддержка по вопросам платежей:<br/>
 Тел.: 8-800-200-27-29 (из регионов России бесплатно)<br/>
 ICQ: 232-437-503<br/>
 MSN: support@2pay.ru<br/>
 Skype: support_2pay.ru<br/>
 E-mail: support@xsolla.com<br/></span></div>");
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case('mob_sms'):
/*	if(isset($_GET['ok'])){
	$phone = $_POST['phone'];
	$amount = $_POST['amount'];
$request['command']='invoice';
$request['project']='5490';
$request['v1']=$userID;
$request['phone']=$phone;
$request['userip']='192.33.19.70';
$request['email']='pays@l2wap.ru';
$request['out']=$amount;
$md5='';
foreach ($request as $value) {
   $md5.= $value;
 }
$request['md5'] = md5($md5 . $secret_key);
$url = 'https://secure.xsolla.com/api/mobile/payment/?';
foreach ($request as $key => $value) {
    $url.=$key . '=' . urlencode($value) . '&';
}
$url = rtrim($url, '&');
	//echo ''.$url.'';
	if ($phone != '' && $amount != ''){printrus('<span style="color:#6FCD72">Счет успешно выставлен! Вам отправлена смс</span><br/><br/>');}
	if ($phone == ''){printrus('<span style="color:#DD6666">Не задан телефон</span><br/><br/>');}
	if ($amount == ''){printrus('<span style="color:#DD6666">Не задана сумма золота</span><br/><br/>');}
}	*/
//printrus('<br/>');
printrus('Мобильные платежи – быстро и удобно!<br/>');
printrus('<img src="/img/ico/cr3.png" alt="." />1 Золото = ~1.2 рубля<br/><br/>');

printrus("<img src=\"/img/ico/cr3.png\" alt=\".\" /> <a href=\"http://m.xsolla.com/index.php?action=form&id_project=5490&id_rubric=4&pid=255&amp;local=ru&amp;v1=".$userID."&amp;email=".$e_mail."\">МТС</a><br/>");
printrus("<img src=\"/img/ico/cr3.png\" alt=\".\" /> <a href=\"http://m.xsolla.com/index.php?action=form&id_project=5490&id_rubric=4&pid=253&amp;local=ru&amp;v1=".$userID."&amp;email=".$e_mail."\">Билайн</a><br/>");
printrus("<img src=\"/img/ico/cr3.png\" alt=\".\" /> <a href=\"http://m.xsolla.com/index.php?action=form&id_project=5490&id_rubric=4&pid=254&amp;local=ru&amp;v1=".$userID."&amp;email=".$e_mail."\">Мегафон</a><br/>");
printrus("<img src=\"/img/ico/cr3.png\" alt=\".\" /> <a href=\"http://m.xsolla.com/index.php?action=form&id_project=5490&id_rubric=4&pid=81&amp;local=ru&amp;v1=".$userID."&amp;email=".$e_mail."\">Daopay</a><br/>");
printrus("<img src=\"/img/ico/cr3.png\" alt=\".\" /> <a href=\"http://m.xsolla.com/index.php?action=form&id_project=5490&id_rubric=4&pid=520&amp;local=ru&amp;v1=".$userID."&amp;email=".$e_mail."\">Infin SMS</a><br/>");

/*printrus('<form action="bonus.php?m=mob_sms&amp;ok&amp;'.$ses.'" method="post"><div>
Ваш номер телефона (Россия):<br/>
<small>10 цифр без +7 или 8. Пример:9151112233</small><br/>
<input name="phone" type="text" value=""/><br/>
Количество золота:<br/>
<input name="amount" type="text" value=""/><br/>
<input type="submit" value=" купить золото " /></div></form>');*/

printrus('<br/>');

printrus("<span class=\"admin\"><b>Бонуcы Мобильных платежей:</b></span><br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>100</b> золота и получи <span class=\"green\">+10%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>300</b> золота и получи <span class=\"green\">+15%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>900</b> золота и получи <span class=\"green\">+30%</span> в подарок<br/>
");
/*printrus('<span style="color:#EFEEC0"><b>Инструкция</b></span><br/>
<span style="color:#EFEEC0"><b>1.</b></span> Укажите свой номер телефона и количество золота. Нажмите Купить золото.<br/>
<span style="color:#EFEEC0"><b>2.</b></span> Вам прийдет бесплатное сообщение c указанием суммы, которая будет списана с вашего счета.<br/>
<span style="color:#EFEEC0"><b>3.</b></span> В этом же SMS будет краткая инструкции по подтверждению платежа. Вы отправляете ответное сообщение о подтверждении платежа.<br/>
<span style="color:#EFEEC0">Сразу после оплаты, вам моментально будет начислено золото</span>');*/

printrus("<div class=\"small ptm\"><span class=\"low\"><br/>
Мобильный платеж действует для операторов России:<br/>
 МТС, Билайн, Мегафон и только при оформлении номера на физическое лицо.<br/><br/>
Поддержка по вопросам платежей:<br/>
 Тел.: 8-800-200-27-29 (из регионов России бесплатно)<br/>
 ICQ: 232-437-503<br/>
 MSN: support@2pay.ru<br/>
 Skype: support_2pay.ru<br/>
 E-mail: support@xsolla.com<br/></span></div>");
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case('qiwi'):
	if(isset($_GET['ok'])){
	$phone = $_POST['phone'];
	$amount = $_POST['amount'];
		$m = $impmail;
		$it = iconv('Покупка Золота в игре Империя (Imperia.Mobi)');
	$a = file_get_contents("http://2pay.ru/oplata/qiwi/gate.php?id=5490&v1=".$userID."&email=".$m."&amount=".$amount."&phone=".$phone."&item=".$it."");
	//echo ''.$a.'';
	if ($a == 'OK'){printrus('<span style="color:#6FCD72">Счет успешно выставлен! Оплатить счет можно через терминал или Ваш QIWI кошелек</span><br/><br/>');}
	//if ($a != 'OK'){echo '<span style="color:#DD6666">Произошла ошибка. Попробуйте через несколько минут повторить оплату</span><br/><br/>';}
	if ($a == 'QIWIGATE.ERROR.UNDEFINED_PHONE'){printrus('<span style="color:#DD6666">Не задан телефон</span><br/><br/>');}
	if ($a == 'QIWIGATE.ERROR.UNDEFINED_AMOUNT'){printrus('<span style="color:#DD6666">Не задана сумма золота</span><br/><br/>');}
	}
printrus('QIWI – это удобный сервис для оплаты Золота!<br/><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." />1 Золото = 1 рубль<br/><br/>');

printrus('<form action="bonus.php?m=qiwi&amp;ok&amp;'.$ses.'" method="post"><div>
Ваш номер телефона:<br/>
<small>10 цифр без +7 или 8. Пример:9151112233</small><br/>
<input name="phone" type="text" value=""/><br/>
Количество золота:<br/>
<small>не менее 1 золота</small><br/>
<input name="amount" type="text" value=""/><br/>
<input type="submit" value=" купить золото " /></div></form>');

printrus('<br/>');

printrus("<span class=\"admin\"><b>Бонуcы QIWI:</b></span><br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>100</b> золота и получи <span class=\"green\">+10%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>300</b> золота и получи <span class=\"green\">+15%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>900</b> золота и получи <span class=\"green\">+30%</span> в подарок<br/><br/>");

printrus('<span style="color:#EFEEC0"><b>Инструкция</b></span><br/>
<span style="color:#EFEEC0"><b>1.</b></span> Укажите свой номер телефона и количество золота. Нажмите Купить золото.<br/>
<span style="color:#EFEEC0"><b>2.</b></span> Пройдите к терминалу и выберите там пункт "<span style="color:#EFEEC0">Личный кабинет</span>" (вторая кнопка) или в вашем QIWI кошельке. Указываете номер телефона, введенный в это поле.<br/>
<span style="color:#EFEEC0"><b>3.</b></span> Если вы никогда раньше, не пользовались QIWI, то вам придёт смс с вашим PIN-кодом(4 цифры), которые надо будет ввести в терминал. Если вы когда-то давно пользовались, и не помните PIN, то его можно легко поменять, следуя инструкции на терминале.<br/>
<span style="color:#EFEEC0"><b>4.</b></span> Затем выбираете "<span style="color:#EFEEC0">Счета к оплате</span>". На этой странице вы увидите свой счет.<br/>
<span style="color:#EFEEC0"><b>5.</b></span> Внесите наличные деньги. В случае если у вас осталась сдача, вы можете перевести ее на свой телефон.<br/>
<span style="color:#EFEEC0">Сразу после оплаты, вам моментально будет начислено золото</span>');
printrus("<br/><br/><div class=\"small ptm\"><span class=\"low\">
Войти в кабинет QIWI можно через платежные терминалы QIWI, либо через QIWI кошелек для мобильника. Скачать QIWI кошелек для мобильника можно на wap.qiwi.ru<br/><br/>
Поддержка по вопросам платежей:<br/>
 Тел.: 8-800-200-27-29 (из регионов России бесплатно)<br/>
 ICQ: 232-437-503<br/>
 MSN: support@2pay.ru<br/>
 Skype: support_2pay.ru<br/>
 E-mail: support@xsolla.com<br/></span></div>");
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;

case('term'):
printrus('Купить золото через терминал приема платежей так же просто, как положить деньги на телефон!<br/><br/>');
printrus('<img src="/img/ico/cr3.png" alt="." />1 Золото = 1 рубль<br/><br/>');
printrus('<b>Инструкция:</b><br/>
- Найди в терминале кнопку xsolla<br/>
- Введи свой личный xsolla-номер ');
$x = file_get_contents("https://api.xsolla.com/xsolla_number.php?project=5490&v1=".$userID."&format=text");
printrus('<span class="green"><b>'.$x.'</b></span>');
printrus(', внеси оплату и моментально получи <img src="/img/ico/cr3.png" alt="" />Золото!');

printrus('<br/><br/>Твой личный xsolla номер:<br/>');
$x = file_get_contents("https://api.xsolla.com/xsolla_number.php?project=5490&v1=".$userID."&format=text");
printrus('<span class="green"><b>'.$x.'</b></span>');


printrus("<br/><br/><span class=\"admin\"><b>Бонуcы xsolla:</b></span><br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>100</b> золота и получи <span class=\"green\">+10%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>300</b> золота и получи <span class=\"green\">+15%</span> в подарок<br/>
Купи более <img src=\"/img/ico/cr3.png\" alt=\"\" /><b>900</b> золота и получи <span class=\"green\">+30%</span> в подарок");

printrus("<br/><br/><div class=\"small ptm\"><span class=\"low\">Кнопка xsolla есть во всех терминалах России, Украины, Беларуси, Молдовы, Армении, Казахстана, Таджикистана<br/><br/>
Поддержка по вопросам платежей:<br/>
 Тел.: 8-800-200-27-29 (из регионов России бесплатно)<br/>
 ICQ: 232-437-503<br/>
 MSN: support@2pay.ru<br/>
 Skype: support_2pay.ru<br/>
 E-mail: support@xsolla.com<br/></span></div>");
printrus("<br/><a href=\"bonus.php?$ses\">Назад</a>");
break;
//*****************************************************
case('addznc'):
printrus("<a href=\"bonus.php?m=seeznc&amp;$ses\">Посмотреть доступные значки</a><br/>\r\n");
printrus("<a href=\"bonus.php?m=takeznc&amp;$ses\">Поставить значок</a><br/>\r\n");
break;
case('seeznc'):
//ВЫводим значки из каталога /znc

$directory = _ROOT.'/znc/'; //папка, которую сканируем
$array = array('.', '..','lapa.gif','index.php','106.gif','13.gif'); //массив со значениями, которые нужно исключить из результатов сканирования папки
$contents = array_diff(scandir($directory), $array);
$cnt=count($contents);
$g=0;
for($i=$see;$i<$cnt;$i++){

if($g<10){
if($contents[$i]!=''){
	$g++;
	$cx=explode(".",$contents[$i]);
echo '<img src="../znc/'.$contents[$i].'"/>-(<i><b>'.$cx[0].'</b></i>)<br />';
}
}else{
printrus("<a href=\"bonus.php?m=seeznc&amp;cnt=$i&amp;$ses\">Далее</a><br/>\r\n");
break;
}
}









break;
case('takeznc'):
if(isset($_REQUEST['yes']))$gooo=2;else $gooo=1;
if($gooo==1){
printrus("Установка картинки = 25 золота!<br/><br/>");
printrus("Введите номер понравившейся Вам картинки:<br/>\n");
printrus ("<form name=\"\" action=\"bonus.php?m=takeznc&amp;yes&amp;$ses\" method=\"post\">
<input name=\"indeximg\" maxlength=\"10\" title=\"Text\" value=\"\"/><br/>\n
<input type=\"submit\" value=\"Поставить значок\"/>
</form>");

}else{
	$need=25;

	$_REQUEST['indeximg']=addslashes($_REQUEST['indeximg']);
 if(!is_readable(''._ROOT.'/znc/'.$_REQUEST['indeximg'].'.gif') or $_REQUEST['indeximg']=='index'){printrus('Этого значка не существует!<br />');}
  elseif($spent+$need>10000){printrus('Вы исчерпали суточный лимит! Максимально разрешается потратить не более <b>10000</b> золота в сутки.<br />');}
  elseif($credits<$need){printrus('У Вас недостаточно золота, требуется <b>'.$need.'</b> золота!<br />');}
   else{
printrus('Значок поставлен.<br />');

mysql_query("delete from `znc`  WHERE id=".$userID." LIMIT 1");
mysql_query("insert into `znc` SET url='".$_REQUEST['indeximg']."',id='".$userID."'");
mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");

}

}
break;
/*
case('addfunds'):
printrus("Как пополнить ваш лицевой счет:<br/>\r\n");
printrus("Отправить смс с текстом \""._SHOP_PREFIKS." ".$userID."\" (без кавычек) на номер
"._SERVICE_NUMBER_RUS." для абонентов России, "._SERVICE_NUMBER_KAZ." для абонентов Казахстана и "._SERVICE_NUMBER_UKR." для абонентов Украины.
Другие страны пока не поддерживаются этим способом пополнения. Будьте внимательны при наборе
номера. Стоимость одной смс - "._PRICE." у.е. На ваш счет при этом зачисляется 100 золота. Этот
способ зачисления мгновенный, сразу после отправки смс, вам придет ответная смс и счет пополнится.<br/>
<u>Спамные запросы приведут к удалению страны!</u><br/>
------<br/>
Имейте в виду, что закупиться в магазине можно максимум на 1000 золота в день.<br/>");

break; */

case('moratory'):

if (isset($go)){
if ($days<=3)$need=$days*85;
else $need=round($days*85*0.9);
}

if (!isset($go)){
printrus("
1 сутки моратория = 85 золота!<br/>
<b>Акция!!</b><br/>
При покупке более, чем на 3 суток действует
скидка 10%.<br/>
Обратите внимание, что мораторий будет действовать также, как и ночной, т.е., если
у вас в стране есть вторжение, атакующий сможет атаковать вас и дальше, но никто другой
напасть на вас не сможет. Снять мораторий до истечения его срока вы не сможете. Купить новый мораторий
можно только через сутки после окончания старого!<br/>\r\n");
printrus("<br/>На сколько суток покупаем?<br/>\r\n");
printrus("<form name=\"\" action=\"bonus.php?m=moratory&amp;go=go&amp;$ses\" method=\"post\">
<input format='*N' maxlength='2' name='days' /><br/>
<input type=\"submit\" value=\"Купить\"/>
</form>");

}elseif($days<=0||!isset($days)){
printrus("Укажите целое положительное число дней<br/>");
}elseif($b['moratory']>time()-86400){
printrus("Мораторий можно вновь купить только по прошествии суток после окончания предыдущего!<br/>");
}elseif(!isset($sure)){
printrus("Вы уверены, что хотите приобоести мораторий на $days суток (это будет стоить $need золота)?<br/>");
printrus
("<a href=\"bonus.php?sure&amp;m=moratory&amp;go=go&amp;days=$days&amp;$ses\">Да</a><br/>
");
printrus
("<a href=\"bonus.php?m=moratory&amp;$ses\">Отмена</a><br/>
");
}elseif($credits<$need){
printrus("У вас недостаточно золота на счету (необходимо $need)!<br/>");
}elseif($spent+$need>10000){
printrus("Извините, вы не можете сделать покупок более, чем на 10000 золота в сутки! Сумма за сутки обнуляется в 5 утра по Москве.<br/>");
}else{
mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");

mysql_query("UPDATE `countries` SET moratory = '".(time()+$days*86400)."' WHERE countryID = '".$countryID."' LIMIT 1");
$b['moratory'] = time()+$days*86400;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
printrus("Вы купили мораторий на <b>$days</b> суток! С вашего счета списано <b>$need</b> золота.<br/>");

$open=fopen("logs/magaz".$countryID,"a+");
@flock ($open,LOCK_EX);
@fwrite($open,$b['countryName']."купил мораторий на $days суток. Потратил $need золота.\n");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

}

break;

case('res'):

if (isset($go)){
if ($res==0) $price = 300;
elseif($res==1) $price = 50;
elseif($res==2) $price = 150;
elseif($res==3) $price = 500;
elseif($res==4) $price = 1000;
elseif($res==5) $price = 15;
elseif($res==6) $price = 5;
else $price=9999;
$need = round(0.49999+$amount/$price);
$free_place = free_place($countryID);
}

if (!isset($go)){
printrus("Установленная банковская стоимость ресурсов, за 1 кредит:<br/>");
printrus("<b>300</b> денег<br/>");
printrus("<b>50</b> железа<br/>");
printrus("<b>150</b> камня<br/>");
printrus("<b>500</b> дерева<br/>");
printrus("<b>1000</b> зерна<br/>");
printrus("<b>15</b> нефти<br/>");
printrus("<b>5</b> рабочих<br/>");
printrus("Количество покупаемых ресурсов:<br/>\r\n");
printrus("<form name=\"\" action=\"bonus.php?m=res&amp;go=go&amp;$ses\" method=\"post\">
<input format='*N' maxlength='7' name='amount' /><br/>");
printrus ("Ресурс:<select name=\"res\">\n");
printrus ("<option value=\"0\">деньги</option>\n");
printrus ("<option value=\"1\">железо</option>\n");
printrus ("<option value=\"2\">камень</option>\n");
printrus ("<option value=\"3\">дерево</option>\n");
printrus ("<option value=\"4\">зерно</option>\n");
printrus ("<option value=\"5\">нефть</option>\n");
printrus ("<option value=\"6\">рабочие</option>\n");
printrus ("</select><br/>\n
<input type=\"submit\" value=\"Купить\"/>
</form>");

}elseif ((!isset($res)||($res!=0&&$res!=1&&$res!=2&&$res!=3&&$res!=4&&$res!=5&&$res!=6))||(!isset($amount)||$amount<=0)){
printrus("Выберите ресурс и укажите целое положительное его количество!<br/>");
}elseif($credits<$need){
printrus("У вас недостаточно золота на счету (необходимо $need)!<br/>");
}elseif($spent+$need>10000){
printrus("Извините, вы не можете сделать покупок более, чем на 10000 золота в сутки! Сумма за сутки обнуляется в 5 утра по Москве.<br/>");
}elseif(($free_place<$amount)&&($res==1||$res==2||$res==3||$res==4||$res==5)){
printrus("У вас недостаточно места на складе. Освободите место.<br/>");
}else{

mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");

if ($res==0){
mysql_query("UPDATE `countries` SET money=money+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['money'] = $b['money']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='денег';
}

if ($res==1){
mysql_query("UPDATE `countries` SET iron=iron+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['iron'] = $b['iron']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='железа';
}

if ($res==2){
mysql_query("UPDATE `countries` SET stone=stone+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['stone'] = $b['stone']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='камня';
}

if ($res==3){
mysql_query("UPDATE `countries` SET arbor=arbor+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['arbor'] = $b['arbor']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='дерева';
}

if ($res==4){
mysql_query("UPDATE `countries` SET grain=grain+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['grain'] = $b['grain']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='зерна';
}

if ($res==5){
mysql_query("UPDATE `countries` SET oil=oil+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['oil'] = $b['oil']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='нефти';
}

if ($res==6){
mysql_query("UPDATE `countries` SET workers=workers+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['workers'] = $b['workers']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='рабочих';
}

printrus("Вы купили <b>$amount</b> $s. Потрачено золота: <b>$need</b><br/>\r\n");

$open=fopen("logs/magaz".$countryID,"a+");
@flock ($open,LOCK_EX);
@fwrite($open,$b['countryName']." купил $amount $s в магазине. Потратил $need золота.\r");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);


}

break;

case('save'):
if (!isset($go)){
printrus("Стоимость сохранения - 50 золота.<br/>
Эта опция позволяет вам \"сохранить\" страну на любом этапе развития. Далее, если вашу
страну убьют, вы через некоторое время сможете восстановить те параметры страны, которые были на
момент сохранения, и появитесь среди приблизительно так же развитых стран.<br/>");
printrus("<a href=\"bonus.php?m=about_save&amp;$ses\">Подробнее</a><br/>\r\n");
//printrus("********<br/>");
printrus("<br/><a href=\"bonus.php?m=save&amp;go&amp;$ses\">Сохранить страну</a><br/>\r\n");
}elseif($credits<50){
printrus("У вас недостаточно золота на счету (необходимо 50)!<br/>");
}else{
$r = mysql_query("SELECT * FROM `saves` WHERE userID = '".$_SESSION['userID']."' LIMIT 1");
$a = mysql_fetch_array($r);
$num = mysql_num_rows($r);
if (time()-$a['lastSave']>86400*2){

if ($num!=0){
//Удаляем предыдущее сохранение
mysql_query("DELETE FROM `buildings_save` WHERE countryID = '".$a['countryID']."'");

mysql_query("DELETE FROM `countries_save` WHERE countryID = '".$a['countryID']."'");

mysql_query("DELETE FROM `general_save` WHERE countryID = '".$a['countryID']."'");

mysql_query("DELETE FROM `works_save` WHERE countryID = '".$a['countryID']."'");
}
//Сохраняем здания
mysql_query("INSERT INTO `buildings_save` (SELECT * FROM `buildings` WHERE countryID = '".$countryID."')");
//Меняем времена
mysql_query("UPDATE `buildings_save` SET var1 = ".time()." - var1 WHERE countryID = '".$countryID."' and building = 'neftevxwka' LIMIT 1");
//Сохраняем основные параметры страны:
mysql_query("INSERT INTO `countries_save` (SELECT * FROM `countries` WHERE countryID = '".$countryID."' LIMIT 1)");
//Меняем в сохранении необходимые времена
mysql_query("UPDATE `countries_save` SET reggedTime = ".(time()-$b['reggedTime']).", lastNal = ".(time()-$b['lastNal']).", lastWar = ".(time()-$b['lastWar'])." WHERE countryID = '".$countryID."' LIMIT 1");
//Сохраняем генерала
mysql_query("INSERT INTO `general_save` (SELECT * FROM `general` WHERE countryID = '".$countryID."' LIMIT 1)");
//Сохраняем работы
mysql_query("INSERT INTO `works_save` (SELECT * FROM `works` WHERE countryID = '".$countryID."')");
//Меняем времена
mysql_query("UPDATE `works_save` SET started = ".time()." - started, finished = finished - ".time()." WHERE countryID = '".$countryID."'");

if ($num==0){
mysql_query("INSERT INTO `saves` SET userID = '".$_SESSION['userID']."', countryID = '$countryID', lastSave = '".time()."'");
}else{
mysql_query("UPDATE `saves` SET countryID = '$countryID', lastSave = '".time()."' WHERE userID = '".$_SESSION['userID']."' LIMIT 1");
}
mysql_query("UPDATE `uzers` SET credits = credits - 50, spent = spent + 50 WHERE userID = '$userID' LIMIT 1");
$open=fopen("logs/magaz".$countryID,"a+");
@flock ($open,LOCK_EX);
@fwrite($open,date("H:i j.m:").$b['countryName']."сохранил страну. Потратил 50 золота.\r");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);
printrus("Ваша страна успешно сохранена!<br/>");
}else{
printrus("Сохранение возможно только по прошествии минимум 2 суток после последнего сохранения! Подождите ".mkTimeStr(86400*2-(time()-$a['lastSave']))."<br/>");
}

}

break;

case('about_save'):
printrus("При сохранении <u>НЕ</u> запишутся следующие параметры страны:<br/>
1. Ваши войны. Позаботьтесь о том, чтобы в момент сохранения как можно меньше военных находилось
в войнах на территории других государств, эти военные <u>не сохранятся</u><br/>
2. Ваши союзы. Также общее число возможных союзов не изменится (то есть, если вы потратили до
сохранения оба союза, новых не прибавится после восстановления).<br/>
3. Ваши соседи. Естественно, они поменяются при восстановлении, и следующим образом: если, допустим,
у вас была при сохранении страна 10-ти дневного развития, то вам дадут соседей также 10-ти дневного
развития <u>на момент восстановления</u> страны<br/>
4. Открытия и мораторий. Случайные открытия и купленный мораторий не сохраняются.<br/>
5. Клан. Клановая принадлежность не сохранится.<br/>
ВСЕ остальные параметры страны будут точно такими же, как и на момент сохранения. Обратите внимание,
что восстановление стоит 50 золота и оно возможно лишь по прошествии некоторого времени после
убийства страны (это время зависит от того, насколько развита была ваша страна). Повторное сохранение
возможно минимум через 2ое суток после предыдущего.<br/>");
break;

case('unite'):
$need=100;

    if (isset($go)){

  if($spent+$need>10000)
    {printrus('Вы исчерпали суточный лимит! Максимально разрешается потратить не более <b>10000</b> золота в сутки.<br />'); $error++;}
  if($credits<$need AND $error == 0)
    {printrus('У Вас недостаточно золота, требуется <b>'.$need.'</b> золота!<br />');  $error++;}
  if ( (count_unite($countryID) + $b['unites'] > 1 ) AND $error == 0)
    {printrus('Союз можно купить, только если у вас остался 1 незаключенный союз или 1 союзник, но не всё вместе. Либо если ничего не осталось.');  $error++;}

if ($error == 0)
{
    mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");
    $query="UPDATE `countries` SET unites = unites + 1 WHERE countryID = '$countryID' LIMIT 1";
    $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
    $b['unites']++;
    if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }
    printrus("Дополнительный союз куплен.");
}

    }
else
{
    printrus("Союз стоит 100 золота, покупаем?<br/>\r\n");
    printrus("<a href=\"bonus.php?m=unite&amp;go=go&amp;$ses\">Да.</a><br/>\r\n"); 
}

break;




















case('gena'):

if (isset($go)){
    $price = 50;
    $need = round(0.49999+$amount*$price); 
    $general=general_info($countryID);
}

if (!isset($go))
{
    printrus("На сколько лет будем омолаживать генерала:<br/>\r\n");
    printrus("Стоимость 1 года 50 золота!:<br/>\r\n");
    printrus("<form name=\"\" action=\"bonus.php?m=gena&amp;go=go&amp;$ses\" method=\"post\">
    <input format='*N' maxlength='7' name='amount' /><br/>");
    printrus("<input type=\"submit\" value=\"Омолодить\"/>
    </form>");
}
elseif (!isset($amount)||$amount<=0){
printrus("Укажите целое положительное количество лет, на которые омолодить генерала!<br/>");
}
elseif($general[age] == 0)
{
    printrus("У вас нет генерала!<br/>");
}
elseif($general[age] - $amount < 16)
{
    printrus("Извините, вы не можете омолодить генерала младше 16 лет!<br/>");
}
elseif($credits<$need)
{
    printrus("У вас недостаточно золота на счету (необходимо $need)!<br/>");
}
elseif($spent+$need>10000)
{
    printrus("Извините, вы не можете сделать покупок более, чем на 10000 золота в сутки! Сумма за сутки обнуляется в 5 утра по Москве.<br/>");
}
else
{


    mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");

    


    mysql_query("UPDATE general SET age = age - $amount WHERE countryID = '".$b['countryID']."'");
   $key=_PREFIKS.':general'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $mem['age'] = $mem['age']-$amount;
      $memcache->set($key,$mem,false,86400);
      }



    printrus("Вы омолодили генерала($general[age]) на <b>$amount</b> лет. Потрачено золота: <b>$need</b><br/>\r\n");

    $open=fopen("logs/magaz".$countryID,"a+");
    @flock ($open,LOCK_EX);
    @fwrite($open,$b['countryName']." омолодил генерала на $amount лет в магазине. Потратил $need золота.\r");
    @fflush($open);
    @flock ($open,LOCK_UN);
    @fclose($open);


}

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