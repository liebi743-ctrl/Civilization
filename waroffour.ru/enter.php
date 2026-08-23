<?
include_once("other_inc/download_widgets.php");
if (getenv('HTTP_USER_AGENT')=='http://Anonymouse.org/ (Unix)') exit("Чао..");
//Error_Reporting(E_ALL & ~E_NOTICE);
//ini_set("display_errors",'1');
if (getenv('REMOTE_ADDR')=='94.237.248.254'  || getenv('REMOTE_ADDR')=='213.87.76.52' || getenv('REMOTE_ADDR')=='94.237.248.254'|| getenv('REMOTE_ADDR')=='94.237.248.254') exit;
//Обработка переменных:
if (isset($_GET['sawform'])) $sawform = htmlspecialchars(addslashes($_GET['sawform']));
if (isset($_GET['username'])) { $username = htmlspecialchars(addslashes($_GET['username']));  $sawform=1;}
if (isset($_GET['password'])) $password = htmlspecialchars(addslashes($_GET['password']));
$username=iconv('utf-8','cp1251',$username);

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);



if(getenv('REMOTE_ADDR') == '178.121.155.217'){

}

@include_once("func/functions_clv.php");

/*if(isset($_SESSION['mr_uid']))
{
foreach($_SESSION as $key=>$var){
 unset($_SESSION[$key]);  }
mysql_query("UPDATE uzers SET onlineflag = 0 WHERE username = '".$username."'");
}else{
foreach($_SESSION as $key=>$var){
 unset($_SESSION[$key]);  }
mysql_query("UPDATE uzers SET onlineflag = 0 WHERE username = '".$username."'");
}*/
/*foreach($_SESSION as $key=>$var){
if($key!='mr_session_key'&&$key!='mr_uid')
unset($_SESSION[$key]);
}*/
unset($_SESSION['countryID']);
unset($_SESSION['auth']);
unset($_SESSION['auth2']);

mysql_query("UPDATE uzers SET onlineflag = 0 WHERE username = '".$username."'");

if ( $_SERVER[HTTP_HOST] <> 'waroffour.mgates.ru')
sesinit();


if ($_REQUEST['p_sid'] <> '')
$_SESSION['p_sid'] = $_REQUEST['p_sid'];


//шапка:
//@include_once("other_inc/header.php");




/////////////////////////////
 $enterline="<b>Вход в игру</b><br/>\r\n";
 //форма авторизации:
 $authform=
"Имя:<br/>
<form name=\"\" action=\"enter.php?sawform\" method=\"get\">
<input type='text' name='username' /><br/>
Пароль:<br/>
<input type='text' name='password' /><br/>
<input type=\"submit\" value=\"Вход\"/>
</form><br/>
<a href='forgot.php'>(забыли пароль?)</a><br/>
";

//==============================================================================
//рабочая часть скрипта=========================================================

//******************************************************************************
//авторизация*******************************************************************

 //printrus ($enterline);

 if(!isset($sawform)){
//sesinit();
//шапка:

@include_once("other_inc/header.php");
printrus ($enterline);

  printrus ($authform);
 }
 elseif(empty($username) || empty($password)){
  //sesinit();
//шапка:
@include_once("other_inc/header.php");
printrus ($enterline);
  printrus ("<b>Все поля обязательны для заполнения!</b><br/>\r\n");
  printrus ($authform);
 }
 elseif(authorize($username,$password)){
  //Запоминаем в куки пасворд и логин
$ctime=time()+864000;
setcookie('clvus',base64_encode($username),$ctime);
setcookie('clvps',base64_encode($password),$ctime);

//шапка:
@include_once("other_inc/header.php");
printrus ($enterline);

if ($_GET['otest'] == 1)
{
$_SESSION['auth']=1;
print "session: ";
print_r($_SESSION);
}


  $r = mysql_query("SELECT onlineflag,lastsessid,inv,blocked FROM `uzers` WHERE username = '$username' LIMIT 1");
  $a = mysql_fetch_array($r);
  $blocked = $a['blocked'];
  if ($a['inv']!=-1||$a['blocked']<time()){
  if ($a['onlineflag']<date(U)-965){

  printrus ("<b>Вы успешно авторизованы!</b><br/>\r\n");
  //Нужно ли выводить совет
  if ($_SESSION['noob']==2){
          $z = mysql_query("SELECT count(*) as num FROM `tips`");
          $az = mysql_fetch_array($z);
          $num = rand(1,$az['num']);
          $z = mysql_query("SELECT tip FROM `tips` WHERE id='$num'");
          $az = mysql_fetch_array($z);
          sendMessage($_SESSION['countryID'],'fullMessage','<u>Знаете ли вы, что:</u><br/>'.$az['tip']);
  }
  //Чтобы нельзя было создать вторую сессию, пишем в базу
  $tm = time();
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600), lastsessid = '$ses' WHERE username = '$username' LIMIT 1");
  if (!isset($_GET['username'])||!isset($_GET['password']))printrus ("(Сохраните <a href=\"enter.php?username=$username&amp;password=$password&amp;sawform\">эту</a> страницу для автологина)<br/>\r\n");
  else
  {
  if ( $_SERVER[HTTP_HOST] <> 'waroffour.mgates.ru')
  printrus("На этой странице вы можете сделать закладку<br/>");
  printrus("Автовход:<input class=\"text\" value=\"http://".$_SERVER['SERVER_NAME']."/enter.php?username=$username&amp;password=$password\"/><br />");
  }
  if (isset($_SESSION['auth'])){
  printrus
("
<a href='game.php?$ses'>Играть&gt;&gt;</a>
");
}else
printrus("Вы не можете играть, т.к. у Вас нет страны! Создайте страну в профайле!!!<br/>");

 if(isset($_SESSION['o_uid']))
{
printrus("
<br/><br/>
<a href='http://o.waroffour.ru/profile.php?$ses'>Профиль</a>
<br/>
");
}else{
printrus("
<br/><br/>
<a href='profile.php?$ses'>Профиль</a>
<br/>
");}
}else {
      session_destroy();
      $ses = $a['lastsessid'];
      $sec = $a['onlineflag']-date(U)+965;
      printrus("Ошибка авторизации! Попробуйте зайти по <a href=\"game.php?$ses\">этой ссылке</a> либо повторите попытку через $sec секунд<br/>\n");
      printrus("Это могло произойти из-за некорректного выхода из игры (не через ссылку \"выход\"). Выходите, пользуясь этой ссылкой<br/>\n");
      printrus ("<a href='index.php'>&lt;Война Четырех</a><br/>\r\n");
        }
 }else{
//Доступ блокирован
$r=mysql_query("SELECT * FROM `blocks` WHERE cid='".$_SESSION['userID']."' LIMIT 1");
         $a=mysql_fetch_array($r);
         printrus ("Модер <u>".$a['who']."</u> блокировал вам доступ к игре. Причина:<br/>".$a['why']."<br/>\r\n");
         printrus ("Логин будет находиться в блоке еще ".mkTimeStr($blocked-time())."<br/>");
    session_destroy();
    printrus ("<a href='index.php'>Главная</a><br/>\r\n");
    //футер страницы:
    include_once("other_inc/footer.php");
    exit;
 }

 }
 else{
 //sesinit();
//шапка:
@include_once("other_inc/header.php");
printrus ($enterline);
  printrus ("<b>Все поля обязательны для заполнения!</b><br/>\r\n");
  printrus ("<b>Неправильное имя или пароль!</b><br/>\r\n");
  printrus ($authform);
 }


//printrus ("<a href='http://getwap.ru'>&lt;&lt;GETWAP.RU</a><br/>\r\n");
//ботинки:

include_once("other_inc/footer.php");


?>
