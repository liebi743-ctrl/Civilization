<?
if (isset($_REQUEST['send'])) $yes = $_REQUEST['send'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['text'])) $text = $_REQUEST['text'];
//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
include_once("other_inc/header.php");
require($_SERVER['DOCUMENT_ROOT'].'/b_params.php');
$countryID=$_SESSION['countryID'];

 $b=CountryInfo($countryID);
 isAuthed();

printrus ("<u>Обратная связь</u><br/>\r\n");
if(!isset($yes)){
printrus("Cообщение администратору:<br/>\n");
printrus ("<form name=\"\" action=\"testip.php?send&amp;$ses\" method=\"post\">
<input name=\"text\" maxlength=\"300\" title=\"Text\" value=\"\"/>
<br/><input name=\"t1\" type=\"checkbox\" value=\"1\"/>Транслитеровать\n<br/>\n
<br/>\n");
printrus
("<input type=\"submit\" value=\"Отправить письмо\"/>
</form><br/>
");
} else {
 if(isset($t1)) $text = translit($text);
 #$text = iconv('utf-8','cp1251',$text);
 if (!isset($text) || $text == ''){
  printrus ("Вы должны ввести сообщение!<br/>\n");
 }else{
 	$yy = mysql_query("SELECT * FROM countries WHERE countryID = '$countryID' LIMIT 1");
 	$a=mysql_fetch_array($yy);
 	$coutryName=iconv('cp1251','utf-8',$a[1]);
    $text=$coutryName.': '.$text;
   function send_mime_mail($name_from, // имя отправителя
                        $email_from, // email отправителя
                        $name_to, // имя получателя
                        $email_to, // email получателя
                        $data_charset, // кодировка переданных данных
                        $send_charset, // кодировка письма
                        $subject, // тема письма
                        $body // текст письма
                        ) {
  $to = mime_header_encode($name_to, $data_charset, $send_charset)
                 . ' <' . $email_to . '>';
  $subject = mime_header_encode($subject, $data_charset, $send_charset);
  $from =  mime_header_encode($name_from, $data_charset, $send_charset)
                     .' <' . $email_from . '>';
  if($data_charset != $send_charset) {
    $body = iconv($data_charset, $send_charset, $body);
  }
  $headers = "From: $from\r\n";
  $headers .= "Content-type: text/plain; charset=$send_charset\r\n";
  $headers .= "Mime-Version: 1.0\r\n";

  return mail($to, $subject, $body, $headers);
}

function mime_header_encode($str, $data_charset, $send_charset) {
  if($data_charset != $send_charset) {
    $str = iconv($data_charset, $send_charset, $str);
  }
  return '=?' . $send_charset . '?B?' . base64_encode($str) . '?=';
}
$mail='dv@v425.ru';
 send_mime_mail($coutryName,
               'dv@v425.ru',
               "admin",
               "$mail",
               'utf-8',  // кодировка, в которой находятся передаваемые строки
               'KOI8-R', // кодировка, в которой будет отправлено письмо
               $coutryName,
               $text);




   printrus ("
   Ваше сообщение отправлено.<br/>\n");

  }

}
#!EMAIL_isBAD($mail)$mail='';
//$name = iconv('utf-8','cp1251',$name);
if (!isset($m))printrus ("---<br/><a href=\"game.php?$ses\">В игру</a><br/>");
else printrus ("---<br/><a href=\"reg.php\">к регистрации</a><br/>");
//printrus ('---<br/><b>©</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
