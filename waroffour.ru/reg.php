<?
function printrus2($str){
$str = iconv('cp1251','utf-8',$str);
print "$str";
}


//printrus2('Технические работы. Начать игру можно будет через 3-4 часа.');
//die();

if ($_SERVER['REMOTE_ADDR'] == '31.170.166.14')
die();

if ($_SERVER['REMOTE_ADDR'] == '209.190.85.80')
die();

if ($_SERVER['REMOTE_ADDR'] == '209.190.85.81')
die();

$GLOBALS['redir_username']=$_REQUEST['username'];
$host = $_SERVER["HTTP_HOST"];
if(substr($host,0,1)=="o" OR $otest==1){
	if (isset($_SESSION['auth2']))
		header('Location: profile.php');
}

function output($page){
if ($GLOBALS['off'] == 1)
$page='';
return $page;
}

if ( $_SERVER[HTTP_HOST] == 'waroffour.mgates.ru'){
ob_start("output");
}

include_once("other_inc/download_widgets.php");
foreach($_POST as $key => $var){
$_POST[$key]=trim(htmlspecialchars(addslashes($_POST[$key])));
}
if (getenv('HTTP_USER_AGENT')=='http://Anonymouse.org/ (Unix)') exit("Чао..");
//Error_Reporting(E_ALL & ~E_NOTICE);
//ini_set('display_errors','1');
if (getenv('REMOTE_ADDR')=='94.237.248.254' || getenv('REMOTE_ADDR')=='213.87.76.52' || getenv('REMOTE_ADDR')=='94.237.248.254'|| getenv('REMOTE_ADDR')=='94.237.248.254' || getenv('REMOTE_ADDR')=='188.16.114.62') exit("Блок");
if(isset($_SESSION['auth'])){
	header('Location: game.php');
exit;
}
//Обработка переменных:
if (isset($_GET['type'])) $type = $_GET['type'];
if (isset($_REQUEST['ras'])){$ras = $_REQUEST['ras'];}else{$ras=0;}
if (isset($ras)&&!is_numeric($ras)) $ras=0;
if (isset($ras)&&$ras<0) $ras=0;
if (isset($_REQUEST['k'])){$k = $_REQUEST['k'];}else{$k=0;}
if (isset($k)&&!is_numeric($k)) $k=0;
if (isset($k)&&$k<0) $k=0;
if (isset($_GET['sawform'])) $sawform = $_GET['sawform'];
if (isset($_GET['sawform2'])) $sawform2 = $_GET['sawform2'];
if (isset($_GET['username'])) {$username = $_GET['username']; $sawform=1;}
if (isset($_GET['pass'])) {$pass = $_GET['pass'];}
if (isset($_GET['ppass'])) {$ppass = $_GET['ppass'];}
if (isset($_POST['imya'])) $imya = $_POST['imya'];
if (isset($_POST['about'])) $about = $_POST['about'];
if (isset($_POST['mail'])) $mail = $_POST['mail'];
if (isset($_GET['username'])) $countryName = $_GET['username'];
if (isset($countryName)){
$countryName = trim($countryName);
$countryName = ereg_replace(" +"," ",$countryName);
}


//Список ip адресов, с которых допустима регистрация
$dopusk = array('82.204.177.34');

//Запрет входа с компа
$accept = @getenv("HTTP_Accept");
if (strpos($accept,'x-xbitmap')!==FALSE) $komp = TRUE; else $komp=FALSE;
if (in_array($_SERVER['REMOTE_ADDR'],$dopusk))$komp = FALSE;
$komp=false;

function check($str,$hsc=1){   //Проверка на спецсимволы
$str=strtr($str,array(chr("0")=>"",chr("1")=>"",chr("2")=>"",chr("3")=>"",chr("4")=>"",chr("5")=>"",chr("6")=>"",chr("7")=>"",chr("8")=>"",chr("9")=>"",chr("10")=>"",chr("11")=>"",chr("12")=>"",chr("13")=>"",chr("14")=>"",chr("15")=>"",chr("16")=>"",chr("17")=>"",chr("18")=>"",chr("19")=>"",chr("20")=>"",chr("21")=>"",chr("22")=>"",chr("23")=>"",chr("24")=>"",chr("25")=>"",chr("26")=>"",chr("27")=>"",chr("28")=>"",chr("29")=>"",chr("30")=>"",chr("31")=>"","Р?"=>"И","вЂ¦"=>" ","вЂ©-"=>" ","вЂњ"=>" ","вЂќ"=>" ","вЂ©"=>" ","вЂ“"=>"-","\n"=>" ","$"=>"$$"));
if($hsc==1)$str = HtmlSpecialChars($str);
$str = ereg_replace(" +"," ",$str);
//$str = ereg_replace("$","$$",$str);
$str = trim($str);
return $str;
}
//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

//@include_once("other_inc/header.php");

if (isset($sawform)){
$code_confirm = trim($_GET['code']);
// партнеры
if(isset($_SERVER ["HTTP_X_FORWARDED_FOR"]) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"])){ $ip=$_SERVER["HTTP_X_FORWARDED_FOR"];}
if(isset($_SERVER ["HTTP_X_FWD_IP_ADDR"]) && !empty($_SERVER["HTTP_X_FWD_IP_ADDR"])){ $ip=$_SERVER["HTTP_X_FWD_IP_ADDR"];}
if(isset($_SERVER["HTTP_VIA"]) && !empty($_SERVER["HTTP_VIA"])){ $ip=$_SERVER["HTTP_VIA"];}
if(isset($_SERVER ["HTTP_PROXY_CONNECTION"]) && !empty ($_SERVER["HTTP_PROXY_CON NECTION"])){ $ip=$_SERVER["HTTP_PROXY_CON NECTION"];}
if(getenv("REMOTE_ADDR")){ $ip = getenv("REMOTE_ADDR");}

$ip=htmlspecialchars(stripslashes($ip));
if(!empty($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'])){$brow=$_SERVER['HTTP_X_OPERAMINI_PHONE_UA'];}elseif(!empty($_SERVER['HTTP_X_OPERAMINI_PHONE'])){
$brow=$_SERVER['HTTP_X_OPERAMINI_PHONE'];}else{
$brow=htmlspecialchars(stripslashes(getenv('HTTP_USER_AGENT')));}
$brow=str_replace('|', '', $brow);

if($_SESSION['site']!=''){
$partner=str_replace('.', '', $_SESSION['site']);

$fp=fopen('data/partner/'.$partner.'_reg.dat',"a+");
flock($fp,LOCK_EX);
fputs($fp,$username."|".time()."|nomail|".$brow."|".$ip."|\r\n");
fflush($fp);
flock($fp,LOCK_UN);
fclose($fp);
chmod ('data/partner/'.$partner.'_reg.dat.dat', 0666);
}
}
 //Дизайн строки типа "Регистрация":
 //$topline="<b>Регистрация</b><br/><br/>\r\n";

if ($komp==TRUE){
//хедер страницы:
include_once("other_inc/header.php");
printrus("Извините, с компьютера регистрироваться нельзя");
//футер страницы:
include_once("other_inc/footer.php");
exit;
   }
 if(!isset($sawform))
 $code1 = rand(1000,2000).rand(2000,3000);


$query="select count(*) as num from uzers";
 $r = mysql_query($query);
 $a = mysql_fetch_array($r);
 $num2 = $a['num'];

$regform1="<div class=\"a\"><img src=\"/img/pic/logo2.png\" alt=\"\" /><br/>
<div class=\"dot\"><b>Выберите расу</b><br /> <b>Каждая раса уникальна по своему</b></div><br/>
<a href=\"faq_rass.php\">Помощь по выбору Расы</a><br/>\n <br/>
<a class=\"sr\" href=\"reg.php?ras=1&amp;sid=$_GET[sid]\">Демоны <br /><img src=\"img/pic/demon.png\" /></a>
<a class=\"sr\" href=\"reg.php?ras=2&amp;sid=$_GET[sid]\">Люди<br /><img src=\"img/pic/ludi.png\" /></a>
<a class=\"sr\" href=\"reg.php?ras=3&amp;sid=$_GET[sid]\">Нежить<br /><img src=\"img/pic/negit.png\" /></a>
<a class=\"sr\" href=\"reg.php?ras=4&amp;sid=$_GET[sid]\">Гномы<br /><img src=\"img/pic/gnom.png\" /></a>
<br /></form></div>";

$regform2="<div class=\"a\"><img src=\"/img/pic/logo2.png\" alt=\"\" /><br/>
<div class=\"dot\"><b>Выберите класс</b></div><br/>
<a class=\"sr2\" href=\"reg.php?ras=$ras&amp;k=1&amp;sid=$_GET[sid]\">Воин<br /><img src=\"img/pic/voin.png\" /></a>
<a class=\"sr2\" href=\"reg.php?ras=$ras&amp;k=2&amp;sid=$_GET[sid]\">Торговец<br /><img src=\"img/pic/voin.png\" /></a>
<a class=\"sr2\" href=\"reg.php?ras=$ras&amp;k=3&amp;sid=$_GET[sid]\">Странник<br /><img src=\"img/pic/voin.png\" /></a>
<a class=\"sr2\" href=\"reg.php?ras=$ras&amp;k=4&amp;sid=$_GET[sid]\">Ремесленник<br /><img src=\"img/pic/voin.png\" /></a><br />
<a class=\"sr2\" href=\"reg.php?ras=$ras&amp;k=5&amp;sid=$_GET[sid]\">Вор<br /><img src=\"img/pic/voin.png\" /></a>
<a class=\"sr2\" href=\"reg.php?ras=$ras&amp;k=6&amp;sid=$_GET[sid]\">Дипломат<br /><img src=\"img/pic/voin.png\" /></a>
<a class=\"sr2\" href=\"reg.php?ras=$ras&amp;k=7&amp;sid=$_GET[sid]\">Адмирал<br /><img src=\"img/pic/voin.png\" /></a>
<a class=\"sr2\" href=\"reg.php?ras=$ras&amp;k=8&amp;sid=$_GET[sid]\">Разбойник<br /><img src=\"img/pic/voin.png\" /></a>
<br /></form></div>";

$regform3=
"<div class=\"a\"><img src=\"/img/pic/logo2.png\" alt=\"\" /><br/>
<div class=\"dot\"><b>Война Четырех</b> - бесплатная онлайн игра<br/>
<span style=\"font-family:Georgia\">Онлайн: <b>".online("c")."</b>, всего регистраций: <b>".$num2."</b></span><br/>
</div><br/>
<form name=\"\" action=\"reg.php?sawform=1&amp;sid=$_GET[sid]\" method=\"get\">
<div style=\"text-align : left; \">
<span class=\"green\">Логин (название страны)</span><br/>
<span class=\"low\"><small>Разрешены латинские или русские знаки, цифры кроме 0, символы: !, - и пробел.</small></span>
<input class=\"text\" type='text' value='".iconv('utf-8', 'cp1251',htmlspecialchars($username))."' name='username'/><br/>
<span class=\"green\">Пароль</span>
<span class=\"low\"><small>[a-z, 0-9]</small></span>
<input class=\"text\" type='text' value='".iconv('utf-8', 'cp1251',htmlspecialchars($pass))."' name='pass'/><br/>
<span class=\"green\">Повторите пароль</span>
<span class=\"low\"><small>[a-z, 0-9]</small></span></div>
<input class=\"text\" type='text' value='".iconv('utf-8', 'cp1251',htmlspecialchars($ppass))."' name='ppass'/><br/>
<span class=\"green\">Введите код безопасности:</span><br/>
<img src='captcha/?".session_name()."=".session_id()."' alt='code'/><br />
<input type='text' value='' name='code'/><br/>
<input type=\"hidden\" name=\"ras\" value=\"".$ras."\">
<input type=\"hidden\" name=\"k\" value=\"".$k."\">
<input class=\"button_medium\" type=\"submit\" value=\"Начать игру\"/>
</form>
<small>Я согласен с</small> <a href=\"rules.php\"><small>правилами</small></a> <small>игры</small><br/></div>
";

// Разрешены знаки латинского или русского алфавита, цифры кроме 0, символы: !, - и пробел. Запрещены одновременно русские и латинские знаки.

//==============================================================================
//рабочая часть скрипта=========================================================

//******************************************************************************
//если пользователь ничего не смотрел, даём выбор расы:*************************
 if(!isset($sawform) and ($ras<1 or $ras>4) and ($k<1 or $k>8)){
  //хедер страницы:
 include_once("other_inc/header.php");
  printrus ($regform1);
 //*****************************************************************************
 //если пользователь выбрал расу но не выбрал класс, даём выбор класса:*********
 }elseif(!isset($sawform) and $ras >= 1 and $ras <= 4 and ($k<1 or $k>8)){
  //хедер страницы:
 include_once("other_inc/header.php");
  printrus ($regform2);
//******************************************************************************
 //если пользователь выбрал расу и класс но не смотрел форму, даём заполнить форму:
 }elseif(!isset($sawform) and $ras >= 1 and $ras <= 4 and $k>=1 and $k<=8){
  //хедер страницы:
 include_once("other_inc/header.php");
  printrus ($regform3);
 //*****************************************************************************
//А если пользователь смотрел форму, то:****************************************
 }else{
  //генерируем пароль:
  $password=$pass;
//сообщение для отправки на мыло)
  $message=
"Поздравляем!
Вы успешно зарегистрировались в игре Война Четырех!
Для входа используйте:
-------
имя -- $username
пароль -- $password
-------
Удачной Вам игры!";
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Проверяем всякие переменные на предмет дураковства::::::::::::::::::::::::::::
 // if ($code1!=$code_confirm){
  if($ras < 1 or $ras > 4){
  //хедер страницы:
  include_once("other_inc/header.php");
  printrus ("<u>Вы не выбрали расу!</u><br/>\r\n");
  printrus ($regform1);

  }elseif($k < 1 or $k > 8){
  //хедер страницы:
  include_once("other_inc/header.php");
  printrus ("<u>Вы не выбрали класс!</u><br/>\r\n");
  printrus ($regform2);
  }elseif(!isset($_SESSION['captcha_keystring']) or $_SESSION['captcha_keystring'] != $code_confirm){
  //хедер страницы:
  include_once("other_inc/header.php");
  printrus ($topline);
  printrus ("<u>Неверный код безопасности!</u><br/>\r\n");
  printrus ($regform3);
  }elseif(empty($username) or empty($countryName) or empty($pass)){
   //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Все поля обязательны для заполнения!</u><br/>\r\n");
   printrus ($regform3);
  }elseif(!cnameisok($username)){
  //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Имя пользователя содержит недопустимые символы!</u><br/>\r\n");
   printrus ($regform3);

  }elseif(!cnameisok(chs($username))){
  //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Имя пользователя содержит недопустимые символы!</u><br/>\r\n");
   printrus ($regform3);

  }elseif(!preg_match('/^[a-z0-9]{4,20}$/i',$pass)){
  //хедер страницы:
 include_once("other_inc/header.php");
   printrus ("<u>Неверный пароль!<br />Разрешено использывать латинские буквы, цифры, длина пароля от 4 до 20 знаков!</u><br/>\r\n");
   printrus ($regform3);
  }elseif($pass!==$ppass){
  //хедер страницы:
  include_once("other_inc/header.php");
   printrus ("<u>Пароли не совпадают!</u><br/>\r\n");
   printrus ($regform3);
  }elseif(!VARLEN_isOK($username)){
  //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Имя, которое вы использовали слишком длинное!</u><br/>\r\n");
   printrus ($regform3);
  }elseif(ThereIsSuchUserAlready(iconv('utf-8','cp1251',$username))){
  //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Пользователь с таким именем уже зарегистрирован в игре!</u><br/>\r\n");
   printrus ($regform3);
  }elseif(!VARLEN_isOK($mail)){
  //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Длина Email адреса слишком большая! Пожалуйста испольсуйте другой адрес.</u><br/>\r\n");
   printrus ($regform3);
  }elseif(!cnameisok($countryName)){
  //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Название страны содержит недопустимые символы!</u><br/>\r\n");
   printrus ($regform3);
  }elseif(!VARLEN_isOK(iconv('utf-8','cp1251',$countryName))){
  //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Название страны слишком длинное!</u><br/>\r\n");
   printrus ($regform3);
  }elseif(ThereIsSuchCountryAlready(iconv('utf-8','cp1251',$countryName))){
  //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
   printrus ("<u>Страна с таким названием уже зарегистрирована в игре (либо есть в сохранениях)!</u><br/>\r\n");
   printrus ($regform3);
  }else{
  $captcha_in = $_SESSION['captcha_keystring'];
  unset($_SESSION['captcha_keystring']);
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Если все прикольно, то регаем чувака (мыло уже отправлено)::::::::::::::::::::
  if(isset($_SERVER ["HTTP_X_FORWARDED_FOR"]) && !empty($_SERVER["HTTP_X_FORWARDED_FOR"])){ $ip=$_SERVER["HTTP_X_FORWARDED_FOR"];}
if(isset($_SERVER ["HTTP_X_FWD_IP_ADDR"]) && !empty($_SERVER["HTTP_X_FWD_IP_ADDR"])){ $ip=$_SERVER["HTTP_X_FWD_IP_ADDR"];}
if(isset($_SERVER["HTTP_VIA"]) && !empty($_SERVER["HTTP_VIA"])){ $ip=$_SERVER["HTTP_VIA"];}
if(isset($_SERVER ["HTTP_PROXY_CONNECTION"]) && !empty ($_SERVER["HTTP_PROXY_CON NECTION"])){ $ip=$_SERVER["HTTP_PROXY_CON NECTION"];}
if(getenv("REMOTE_ADDR")){ $ip = getenv("REMOTE_ADDR");}

$ip=htmlspecialchars(stripslashes($ip));
 //Антиклонизм
//$ip = getIp2();
$soft = getenv("HTTP_USER_AGENT");

 //По куке
 if (isset($_COOKIE['clvreg'])){
    if (base64_decode($_COOKIE['clvreg'])>=time()){
//хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);
  $timeleft = base64_decode($_COOKIE['clvreg'])-time();
  printrus("Извините, с Вашего телефона регистрация невозможна! Подождите $timeleft секунд<br/>\n");

  //Заносим ip+soft в "черный список"
  @$open=fopen("mod/blacklist.dat","a+");
@flock ($open,LOCK_EX);
$str = "ip:$ip, soft:$soft\n\r";
@fwrite ($open,$str);
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

  printrus ("<a href='index.php'>Назад</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
exit;
            }else setcookie('clvreg',base64_encode((time()+600)),time()+3600);
    }else setcookie('clvreg',base64_encode((time()+600)),time()+3600);
   //хедер страницы:
include_once("other_inc/header.php");
  printrus ($topline);

  //По ip+soft
$ip = addslashes($ip);
$soft = addslashes($soft);
$r = mysql_query("SELECT * FROM `regs` WHERE ip='$ip' LIMIT 1");
$a = mysql_fetch_array($r);

if ($a!==FALSE && $a['time']>=time()){
$timeleft = $a['time']-time();
printrus("Извините, с Вашего телефона регистрация невозможна! Подождите $timeleft секунд<br/>\n");
printrus ("<a href='index.php'>Назад</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
exit;
   }else {
     $newtime = time()+300;
     if ($a===FALSE) mysql_query("INSERT INTO `regs` SET ip='$ip', soft='$soft', time = '$newtime'");
     else mysql_query("UPDATE `regs` SET time='$newtime' WHERE ip = '$ip' LIMIT 1");
     }

   //Регаем...
   // check mail ru
//global $mail_ru_mode;
//if($mail_ru_mode == true)
//{
$pasa = $password;
    if(isset($_SESSION['mr_uid']))
    {
 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

        // check dependence exists
        $r = mysql_query("select user_name,user_pass from mr_reg where mr_uid='".$_SESSION['mr_uid']."'");
        if($err && mysql_error()!='')    {        echo "_db_user_exists: ".mysql_error();    }
        if($r!=false)
        {
            if(mysql_num_rows($r)==0)
            {
                if($username!='')
				{$ID = $userID;
				$loga = $username;
				$loga=iconv('utf-8','cp1251',$loga);
                    $r = mysql_query("insert into mr_reg (user_name,user_pass,mr_uid,user_id) values ('".$loga."','".$pasa."','".$_SESSION['mr_uid']."','".$ID."') ");
                    // echo mysql_error();
                }
            }
            else
            {
                $r_l = mysql_fetch_array($r);
                $mr_udata = $r_l['user_name'];
                global $loga;
                $loga=$mr_udata[0];
                $pasa=$mr_udata[1];
            }
        }
    }
    //exit;
    if(isset($_SESSION['o_uid']))
    {
 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

        // check dependence exists
        $r = mysql_query("select user_name,user_pass from o_reg where o_uid='".$_SESSION['o_uid']."'");
        if($err && mysql_error()!='')    {        echo "_db_user_exists: ".mysql_error();    }
        if($r!=false)
        {
            if(mysql_num_rows($r)==0)
            {
                if($username!='')
				{$ID = $userID;
				$loga = $username;
				$loga=iconv('utf-8','cp1251',$loga);
                    $r = mysql_query("insert into o_reg (user_name,user_pass,o_uid,user_id) values ('".$loga."','".$pasa."','".$_SESSION['o_uid']."','".$ID."') ");
                    // echo mysql_error();
                }
            }
            else
            {
                $r_l = mysql_fetch_array($r);
                $mr_udata = $r_l['user_name'];
                global $loga;
                $loga=$mr_udata[0];
                $pasa=$mr_udata[1];
            }
        }
    }
    //exit;
//}
//
   if (strpos(strtolower($about),'lastb')!==FALSE)$about='';
   $imya = check(iconv('utf-8','cp1251',$imya));
   $about = check(iconv('utf-8','cp1251',$about));
   addUSERtoBASE($code_confirm,$captcha_in,$username,$mail,$password,$countryName,$imya,$about,$ras,$k);

    if (!EMAIL_isBAD($mail))$mail='';
    else {

 $text = convert_cyr_string("Поздравляем Вы успешно зарегистрированы в онлайн игре Война Четырех!\n".'Ник: '.$username." \n".'Пароль: '.$password." \n-------\n".'Это письмо сгенерировано автоматически, и отвечать на него нет смысла.', 'w','k');
 $subject = encodeHeader(convert_cyr_string('ИМПЕРИЯ. Ваш пароль', 'w','k'));
 $from = encodeHeader(convert_cyr_string('Война Четырех waroffour.ru', 'w','k').' <dv@v425.ru>');
 $adds = "From: $from\r\n";
 $adds .= "X-Sender: waroffour.ru\r\n";
 $adds .= "Content-Type: text/plain; charset=koi8-r";
 mail($mail,$subject,$text,$adds);
   }
   $username=iconv('utf-8','cp1251',$username);
   $rok=1;
   //И говорим об успехе:
   printrus ("<span class=\"green\">Вы успешно зарегистрировались!</span><br/><br/>\r\n");
   if ( $_SERVER[HTTP_HOST] == 'waroffour.mgates.ru'){
   $GLOBALS['off'] = 1;
   header("Location: http://waroffour.my.mgates.spaces.ru/enter.php?sawform=1&sid=$_GET[sid]&username=$GLOBALS[redir_username]&password=$password");
   }
   printrus ("<b>Ваш логин:</b><br/>$username<br/> <b>Ваш пароль:</b><br/> $password<br/>Установите почтовый ящик для $username. Это позволит сохранить страну и восстановить пароль при его утере или же подтвердить владельца в случае необходимости!<br/>\r\n");
   //authorize($username,$password);
   printrus
("<form name=\"\" action=\"enter.php?sawform=1&amp;sid=$_GET[sid]\" method=\"get\">
  <input name=\"username\" type=\"hidden\" value=\"$username\"/>
  <input name=\"password\" type=\"hidden\" value=\"$password\"/>
  <input type=\"submit\" value=\"Играть\"/>
</form><br/>
");
  }
 }
 //пишем в лог все, что происходит на странице
 //$reg_log=json_encode($_REQUEST);
 //$reg_log = 'test';
 //$reg_log_file = fopen("reg_log.txt", "a") or die("один");
 //fwrite($reg_log_file, $reg_log.'
//') or die("не записал");
 //fclose($reg_log_file);
 //var_dump($reg_log);

//$file='reg_log.txt';
 //file_put_contents($file, $reg_log, FILE_APPEND);
printrus ("<ul class=\"navs\"><li><a href='index.php'><img src=\"/img/ico/point.png\" class=\"menu\" alt=\"\" />Главная</a></li></ul>");
//printrus ("<a href='index.php'>Назад</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
if ( $_SERVER[HTTP_HOST] == 'waroffour.mgates.ru')
ob_end_flush();
?>
