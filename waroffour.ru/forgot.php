<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['sawform'])) $sawform = $_REQUEST['sawform'];
if (isset($_REQUEST['username'])) $username = $_REQUEST['username'];
if (isset($_REQUEST['email'])) $email = $_REQUEST['email'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
$username = iconv('utf-8','cp1251',$username);
//==============================================================================
//подключаем скрипты, там, и еще всякая фигня:)=================================

define('IN_CLV',true);
//подключаем скрипты
include_once("func/functions_clv.php");



//шапка:
include_once("other_inc/header.php");

 $topline="<u>Восстановление пароля</u><br/>\r\n";
 //форма авторизации:
 $authform=
"<form name=\"\" action=\"forgot.php?sawform\" method=\"post\">
Ваш логин(НЕ ИМЯ СТРАНЫ!):<br/>
<input type='text' name='username' value='' /><br/>
E-mail, указанный при регистрации:<br/>
<input type='email' name='email' value='' /><br/>
<input type=\"submit\" value=\"Восстановить\"/>
</form><br/>
";

//==============================================================================
//рабочая часть скрипта=========================================================

 printrus ($topline);

 if(!isset($sawform) || empty($username)){
  printrus ($authform);
 }else{

 $true_email=getMail($username);
 if($true_email!=FALSE){

 if (strtolower($email)==strtolower($true_email)){

 $r = mysql_query("SELECT lastEmail FROM `uzers` WHERE username = '$username' LIMIT 1");
 $a = mysql_fetch_array($r);
 if (time()-86400>$a['lastMail']){

 if (strpos($email,"gala.net")===FALSE){
  if(@mkpass($username,$email)){

    printrus ("<u>Новый пароль отправлен вам на Email, указанный при регистрации.</u><br/>\r\n");

  }else{
   printrus ("<u>Не удалось отправить Email. Повторите попытку позднее.</u><br/>\r\n");
  }
  }else{
        printrus ("<u>Извините, сервис не работает с ящиками gala.net!</u><br/>\r\n");
          }

 }else{
 printrus ("<u>Нельзя восстанавливать пароль чаще, чем раз в сутки!</u><br/>\r\n");
 }


 }else{
 printrus ("<u>Неверный email!</u><br/>\r\n");
 printrus ($authform);
 }

 }else{
  printrus ("<u>Такого пользователя не существует!</u><br/>\r\n");
  printrus ($authform);
 }
 }

printrus ("<a href='index.php'>&lt;&lt;Война Четырех</a><br/>\r\n");
//ботинки:
include_once("other_inc/footer.php");
?>
