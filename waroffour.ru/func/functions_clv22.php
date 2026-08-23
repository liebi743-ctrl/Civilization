<?php
require 'functions_new.php';

function market(){
  	global $countryID,$n;

  	$query="select sum(count) as cnt, sum(price) as prc from market where countryID!='".$countryID."' and what='$n'";
    $result=MYSQL_QUERY($query);
	//$num=mysql_num_rows($result);
	$a=mysql_fetch_array($result);
	$query="select * from market where countryID!='".$countryID."' and what='$n'";
	$result=MYSQL_QUERY($query);
	$num=mysql_num_rows($result);
    return array('cnt'=>$a['cnt'],'price'=>round($a['prc']/$num,2),'prd'=>$num);
  }
function market2($b){
  	global $countryID,$n;

$tst=mysql_query("select sum(count) as cnt, sum(price) as prc from market where countryID!='".$b['countryID']."' and what = '$n' and price<=".$b."");
//$num=mysql_num_rows($result);
$s=mysql_fetch_array($tst);
$query="select * from market where countryID!='".$countryID."' and what='$n' and price<=".$b."";
$result=MYSQL_QUERY($query);
$num=mysql_num_rows($result);
    return array('cnt'=>$s['cnt'],'price'=>round($s['prc']/$num,2),'prd'=>$num);
  }
// Функция формирования QUERY_STRING c подписью
function GoToPumpit($query, $billing=false) {
     // Формируем подпись запроса
     $sig = getSig($query, $billing);
      //echo "SIG: $sig"."\n";

     $url = PUMPIT_API_URL;
     // Собираем URL с сортировкой по ключам
     ksort($query);
     foreach ($query as $key=>$value){
         // Исключаем параметр sig
         if (strtolower($key)!='sig'){
             $url .= urlencode($key)."=".urlencode($value)."&";
         }
     }
     $url .= "sig=".$sig;
      //echo "URL: $url"."\n";
	  return $url;
}

// Функция формирования подписи
function getSig($query, $billing=false) {
     $str = "";
     // Собираем строку для подписи с сортировкой по ключам
     ksort($query);
     foreach ($query as $key=>$value){
         // Исключаем параметр sig
         if (strtolower($key)!='sig'){
             $str .= $key."=".$value;
         }
     }
     // echo "String for sign: $str"."\n";
     $appkey = ($billing) ? PUMPIT_KEY_BILLING : PUMPIT_KEY_API;
     return md5($str.$appkey);
}


define("PUMPIT_API_URL",     "http://pumpit.ru/riba_api?");
define("PUMPIT_KEY_BILLING", "09mVsXAYRFO4rWJlw");
define("PUMPIT_KEY_API",     "SmWpBuMUaceGrK8Gi");
define("PUMPIT_APP_ID",      "12");




$obl=mktime(23, 45, 0, 6, 10, 2011)-time();// часы.минуты.секунды.месяц.день.год
if($obl>0){
die('start after: '.$obl);}
if (!defined('IN_CLV'))exit;

#define("_ROOT","\home\imp.d\www");
define("_ROOT","/var/www/local/data/www/local.site");
define("_CONFIG","/var/www/local/data/www");
#define("_ROOT","/var/www/imp_test/data/www/local.site");
//==============================================================================
//Константы
//

/*
Над одним зданием может работать определенный максимум
рабочих, напрямую зависящий от пространства, которое
занимает данное строение. Т.е. на одой единице земли
может работать только установленное число рабочих:
*/
$workers_max=5;
/*
Скорость работы рабочих над зданием зависит от характеристик
постройки. Зависимость определяется следующей функцией worktime()
(определена в func/game_func.php)
*/
require (_CONFIG.'/config.php');

require (_ROOT.'/b_params.php'); //Инфа о зданиях

//==============================================================================
//sys_func.php: (СИСТЕМНЫЕ ФУНКЦИИ)

//==============================================================================
//функа получения айпишника чувачка=============================================
//реальный IP пользователя
function getIp2()
    {

  if (!empty($_SERVER['HTTP_CLIENT_IP']))
  {
    $ip=$_SERVER['HTTP_CLIENT_IP'];
  }
  elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
  {
    if($ip=='')
    $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
  }
  else
  {
    if($ip=='')
    $ip=$_SERVER['REMOTE_ADDR'];
  }
  return $ip;


    }
//проверяем

function getIP(){
 //return "айпишник чувака";
  $HTTP_USER_AGENT=getIp2();
 #$HTTP_USER_AGENT = getenv("HTTP_USER_AGENT");
 return $HTTP_USER_AGENT;
}

//==============================================================================
//функа записывания в лог-файл==================================================

function printLog($logfilename,$logstring,$dosym = false){

 if($dosym){
  $logstring = htmlspecialchars(addslashes($logstring));
 }

 if(!$fp = @fopen($logfilename,"a")){
  return 1;
 }
 @flock ($fp,LOCK_EX);
 if(!@fputs($fp,$logstring."\r\n")){
  return 2;
 }
 @flock ($fp,LOCK_UN);
 if(!@fclose($fp)){
  return 3;
 }

 return 0;

}

//==============================================================================
//функи описывающие ошибки======================================================

//******************************************************************************
//функа обрабатывающая ошибку коннекта к базе***********************************

function mySQLconnectERROR($ip='',$db_hostname){

 //время возникновения ошибки
 $error_time = date("d.m.Y H:i:s");

 //определяем $ip:
 $ip=getIp2();

 //говорим юзеру, типа "без паники"
 print "РџСЂРѕРёР·РѕС€Р»Р° РѕС€РёР±РєР° РїСЂРё РїРѕРґРєР»СЋС‡РµРЅРёРё Рє СЃРµСЂРІРµСЂСѓ Р±Р°Р·С‹ РґР°РЅРЅС‹С…. РџРѕРїСЂРѕР±СѓР№С‚Рµ РїРѕРїС‹С‚РєСѓ РїРѕР·РґРЅРµРµ.";
 @include_once("other_inc/footer.php");

 //кладем запись в лог, ибо надо же админу сказать об ошибке
 if(@printLog("errorlog.log","($error_time)[$ip]: Не удалось подключиться к базе данных по адресу $db_hostname")>0){
  return false;
 }else{
  return true;
 }

}

//******************************************************************************
//функа обрабатывающая ошибку отправки запроса**********************************

function mySQLqueryERROR($query){

 //время возникновения ошибки
 $error_time = date("d.m.Y H:i:s");

 //определяем $ip:
 $ip=getIp2();

 //говорим юзеру, типа "без паники"
 print "РќРµ СѓРґР°Р»РѕСЃСЊ РѕС‚РїСЂР°РІРёС‚СЊ Р·Р°РїСЂРѕСЃ Рє Р±Р°Р·Рµ РґР°РЅРЅС‹С…. РџРѕРІС‚РѕСЂРёС‚Рµ РїРѕРїС‹С‚РєСѓ РїРѕР·РґРЅРµРµ.".mysql_error()." ";
 @include_once("other_inc/footer.php");

 //кладем запись в лог, ибо надо же админу сказать об ошибке
 if(@printLog("errorlog.log","($error_time)[$ip]: Не выполнен sql запрос -- ".$query)>0){
  return false;
 }else{
  return true;
 }
}

//******************************************************************************
//функа обрабатывающая ошибку выделения таблицы*********************************

function mySQLselect_dbERROR($databasename){

 //время возникновения ошибки
 $error_time = date("d.m.Y H:i:s");

 //определяем $ip:
 $ip=getIp2();

 //говорим юзеру, типа "без паники"
 print "РќРµ СѓРґР°Р»РѕСЃСЊ РѕС‚РїСЂР°РІРёС‚СЊ Р·Р°РїСЂРѕСЃ Рє Р±Р°Р·Рµ РґР°РЅРЅС‹С…. РџРѕРІС‚РѕСЂРёС‚Рµ РїРѕРїС‹С‚РєСѓ РїРѕР·РґРЅРµРµ.";
 @include_once("other_inc/footer.php");

 //кладем запись в лог, ибо надо же админу сказать об ошибке
 if(@printLog("errorlog.log","($error_time)[$ip]: Не удалось подключится к таблице $databasename")>0){
  return false;
 }else{
  return true;
 }
}

//==============================================================================
//функа для определения, кто онлайн, а кто нет:) ===============================

function online($flag){

 $now = time();
 //аналог time()

 switch($flag):
 case("c"):
  //готовим запрос:
  $query="SELECT count(*) as num FROM uzers WHERE onlineFlag>$now";
  //отправляем запрос:
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  //скока онлайн:
  $a = mysql_fetch_array($result);
  $OnlineAtAll=$a['num'];

$see = file(_ROOT.'/liders/maxon.dat');
if(trim($see[0])<$OnlineAtAll){
$open=fopen(_ROOT."/liders/maxon.dat","w+");
@flock ($open,LOCK_EX);
@fwrite($open,$OnlineAtAll."\n");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);
 }

  return $OnlineAtAll;
 break;
 case("s"):
 return;
 break;
 endswitch;

}

//=============================================================================
//функция отправляющая новый пароль на мыло чуваку=============================
function mkpass($username,$email){

 //Узнаем идентификатор юзера:
 $query="select countryID from uzers where UserName='$username' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $countryID=mysql_result($result,0);

 //меняем пароль в базе:
 $npass=rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9).rand(0,9);
 //@include_once("func/work_func.php");
 changePassword($countryID,$npass);
 $text = convert_cyr_string('Ник: '.$username." \n".'Новый пароль: '.$npass." \n-------\n".'Это письмо сгенерировано автоматически по запросу на восстановление забытого пароля, и отвечать на него нет смысла.', 'w','k');
 $subject = encodeHeader(convert_cyr_string('Империя. Новый пароль', 'w','k'));
 $from = encodeHeader(convert_cyr_string('Империя '._MAINSITE, 'w','k').' <send@imperia.mobi>');
 $adds = "From: $from\r\n";
 $adds .= "X-Sender: RUMAIL.RU\r\n";
 $adds .= "Content-Type: text/plain; charset=koi8-r";
 mail($email,$subject,$text,$adds);
// if (mail($email,$subject,$text,$adds)){
// return true;
//}else return FALSE;
return TRUE;

}
      //кодируем заголовки
     function encodeHeader($input, $charset = 'koi8-r')
    {
        preg_match_all('/(\w*[\x80-\xFF]+\w*)/', $input, $matches);
        foreach ($matches[1] as $value) {
            $replacement = preg_replace('/([\x80-\xFF])/e', '"=" . strtoupper(dechex(ord("\1")))', $value);
            $input = str_replace($value, '=?'.$charset.'?Q?=20'.$replacement.'?=', $input);
        }
       return $input;
    }














































//ПОДКЛЮЧЕНИЕ К БАЗЕ ДАННЫХ

 //создаем соединение с базой:
 
 
 

 
 $ip='';
 $dblink=@mysql_pconnect(_HOSTNAME,_USERNAME,_DBPASS) or (mySQLconnectERROR($ip,_HOSTNAME) and die("1"));
 mysql_query('SET NAMES cp1251');

 @mysql_select_db(_DBNAME,$dblink) or (mySQLselect_dbERROR($ip,_DBNAME) and die("2")) ;





























 //коннектимся с мемкашем

function mem_connect(){
Global $memcache;
if(!isset($memcache)||$memcache=='')$memcache = @memcache_pconnect('127.0.0.1', 11211) or die ('Connection to memory system failed!<br/><anchor>'.utf('Назад').'<prev/></anchor>');
}





























//string_func.php (СТРОКОВЫЕ ФУНКЦИИ)
//==============================================================================
//Функция, заменяющиая все русские буквы на "|" (для исключения использования
//одновременно русских и англ. букв
function replace_rus($str){
                $str = str_replace("Р°","|",$str);
                $str = str_replace("Р±","|",$str);
                $str = str_replace("РІ","|",$str);
                $str = str_replace("Рі","|",$str);
                $str = str_replace("Рґ","|",$str);
                $str = str_replace("Рµ","|",$str);
                $str = str_replace("С‘","|",$str);
                $str = str_replace("Р¶","|",$str);
                $str = str_replace("Р·","|",$str);
                $str = str_replace("Рё","|",$str);
                $str = str_replace("Р№","|",$str);
                $str = str_replace("Рє","|",$str);
                $str = str_replace("Р»","|",$str);
                $str = str_replace("Рј","|",$str);
                $str = str_replace("РЅ","|",$str);
                $str = str_replace("Рѕ","|",$str);
                $str = str_replace("Рї","|",$str);
                $str = str_replace("СЂ","|",$str);
                $str = str_replace("СЃ","|",$str);
                $str = str_replace("С‚","|",$str);
                $str = str_replace("Сѓ","|",$str);
                $str = str_replace("С„","|",$str);
                $str = str_replace("С…","|",$str);
                $str = str_replace("С‡","|",$str);
                $str = str_replace("С†","|",$str);
                $str = str_replace("С€","|",$str);
                $str = str_replace("С‰","|",$str);
                $str = str_replace("СЊ","|",$str);
                $str = str_replace("С‹","|",$str);
                $str = str_replace("СЉ","|",$str);
                $str = str_replace("СЌ","|",$str);
                $str = str_replace("СЋ","|",$str);
                $str = str_replace("СЏ","|",$str);
                $str = str_replace("Рђ","|",$str);
                $str = str_replace("Р‘","|",$str);
                $str = str_replace("Р’","|",$str);
                $str = str_replace("Р“","|",$str);
                $str = str_replace("Р”","|",$str);
                $str = str_replace("Р•","|",$str);
                $str = str_replace("РЃ","|",$str);
                $str = str_replace("Р–","|",$str);
                $str = str_replace("Р—","|",$str);
                $str = str_replace("Р?","|",$str);
                $str = str_replace("Р™","|",$str);
                $str = str_replace("Рљ","|",$str);
                $str = str_replace("Р›","|",$str);
                $str = str_replace("Рњ","|",$str);
                $str = str_replace("Рќ","|",$str);
                $str = str_replace("Рћ","|",$str);
                $str = str_replace("Рџ","|",$str);
                $str = str_replace("Р ","|",$str);
                $str = str_replace("РЎ","|",$str);
                $str = str_replace("Рў","|",$str);
                $str = str_replace("РЈ","|",$str);
                $str = str_replace("Р¤","|",$str);
                $str = str_replace("РҐ","|",$str);
                $str = str_replace("Р§","|",$str);
                $str = str_replace("Р¦","|",$str);
                $str = str_replace("РЁ","|",$str);
                $str = str_replace("Р©","|",$str);
                $str = str_replace("Р¬","|",$str);
                $str = str_replace("Р«","|",$str);
                $str = str_replace("РЄ","|",$str);
                $str = str_replace("Р­","|",$str);
                $str = str_replace("Р®","|",$str);
                $str = str_replace("РЇ","|",$str);
                return $str;
                }

//******************************************************************************
//функа преобразующая строку в вин кодировку и выводящая ее в браузер***********

function printrus($str){
$str = iconv('cp1251','utf-8',$str);
print "$str";
}

//Возвращает имя юнита
function get_unit_name($i){
if ($i==1)return 'кавалеристов';
elseif ($i==2)return 'стрелков';
elseif ($i==3)return 'пушек';
elseif ($i==4)return 'подрывников';
elseif ($i==5)return 'самолетов';
elseif ($i==6)return 'магов';
elseif ($i==7)return 'генералиссимусов';
else return 'пехотинцев';
}

//Возвращает имя юнита в именительном падеже
function get_unit_name_im($i){
if ($i==1)return 'кавалеристы';
elseif ($i==2)return 'стрелки';
elseif ($i==3)return 'пушки';
elseif ($i==4)return 'подрывники';
elseif ($i==5)return 'самолеты';
elseif ($i==6)return 'маги';
elseif ($i==7)return 'генералиссимусы';
else return 'пехотинцы';
}

//Вывод кол-ва войска:
function print_voisko($wariors){
$str='';
for($i=0;$i<=7;$i++){
if ($wariors[$i]>0) $str .= get_unit_name($i).': <b>'.$wariors[$i].'</b>,<br/>';
}
return $str;
}

//Проверяем название страны на наличие недопустимых символов
//$str - в утф кодировке
function cnameisok($str){
        $bak = replace_rus($str);
        if ((!preg_match("!^[a-z 1-9\\!\\-]+$!i",$str))&&(!preg_match("!^[1-9 \\!\\-\\|]+$!i",$bak))) return FALSE;
        else return TRUE;
        }
function cselfisok($str){
        $bak = replace_rus($str);
        if ((!preg_match("!^[a-z 1-9\\!\\-:;)({}?.,]+$!i",$str))&&(!preg_match("!^[1-9 \\!\\-:;)({}?.,\\|]+$!i",$bak))) return FALSE;
        else return TRUE;
        }
//******************************************************************************
//функа проверяющая переменную на наличие недопустимых символов*****************
function VALUE_isOK($variable){
 if(ereg("[а-яА-Я,$,>,<,',;,/,\,&,#,,,:,*,@,!,%,^,(,)]",$variable) || ereg('"',$variable)){
  return false;
 }else{
  return true;
 }

}

//******************************************************************************
//функа проверяющая username на наличие недопустимых символов*******************

function username_isOK($variable){

 if(!preg_match("!^[a-z1-9]+$!i",$variable)){
  return false;
 }else{
  return true;
 }

}
//******************************************************************************
//функа проверяющая переменную на длинность*************************************

function VARLEN_isOK($variable){

 //максимальная допустимая длина переменной
 $maxlen=21;

 if(strlen($variable)>$maxlen){
  return false;
 }else{
  return true;
 }

}

//******************************************************************************
//функа проверяющая пароль на короткость****************************************

function PASSLEN_isOK($pass){

 //максимальная допустимая длина переменной
 $minlen=4;

 if(strlen($pass)<$minlen){
  return false;
 }else{
  return true;
 }

}

//******************************************************************************
//функа проверяющая мыло на правильность ввода**********************************

function EMAIL_isBAD($str){
 if(!eregi("^[a-z0-9\._-]+@[a-z0-9\._-]+\.[a-z]{2,4}\$", $str))return FALSE;
        else return TRUE;
}

//******************************************************************************
//функа генерирующая id страны по данным юзера**********************************

function generateCountryID($userID,$password,$userName,$countryName){
 return md5("$userID$password".round(rand(1000,999999))).round(rand(10,99));
}













































//game_func.php (ИГРОВЫЕ ФУНКЦИИ)
//удаляем страну
function delete_country($countryID){

 global $memcache;

 $countryID=addslashes($countryID);
  $query="select * from countries where countryID='$countryID'";
  $test=mysql_fetch_array(mysql_query($query));
  $g=0;
  $cnt=count($test);
  foreach($test as $keys=>$vars){
  	++$g;
  	if(!is_numeric($keys)){
  	if($keys!="soft"&&$keys!="ip"&&$keys!="countryID"&&$keys!="countryName")
  	{$sets.=" $keys='0'";  if($g<$cnt){$sets.=",";}else $sets.=" "; }else{
  	 if($keys!="countryName" && $keys!="countryID"){$sets.=" $keys=''"; if($g<$cnt){$sets.=", ";}else $sets.=" ";
  	}
  	}
  	}
  }

 //$query="delete from countries where countryID='$countryID'";
 $query="UPDATE countries SET $sets where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':id'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from buildings where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':buildings'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from general where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':general'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from messages where countryID='$countryID' and `from`!='loose'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':messages'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from otkrytiya where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':otkrytiya'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from market where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':market'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from neighbours where countryID='$countryID' or neighbourID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':neighs'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from unite where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':unite'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from wars where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':wars'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);


}

//вывод текущего сообщения
function exec_message($countryID,$a,$i,$where="."){

 global $memcache;

 $ref=rand(10000,99999);

 $ses=SID;
 $ses="$ses&amp;$ref";

 $from=$a["from"];
 $message=$a["message"];

 $countryID=addslashes($countryID);
 $from=addslashes($from);
 $message=addslashes($message);

 switch($from):
 case('newBuilding'):
  printrus ("<u>Постройка готова:</u> ".printBuilding($message)."<br/>\r\n");
  print "-----<br/>\r\n";
  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  return 1;
 break;
 case('BuildingRepairedFinally'):
  printrus ("<u>Здание восстановлено:</u> ".printBuilding($message)."<br/>\r\n");
  print "-----<br/>\r\n";
  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  return 1;
 break;
 case('BuildingRepairingBreaked'):
  printrus ("<u>Ремонт здания прерван:</u> ".printBuilding($message)."<br/>\r\n");
  print "-----<br/>\r\n";
  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  return 1;
 break;
 case('fullMessage'):
  printrus ("$message<br/>\r\n");
  print "-----<br/>\r\n";
  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  return 1;
 break;
 case('loose'):
  if(!empty($message)) printrus ("Вы разбиты гос-вом <u>$message</u>!<br/>\r\n");
  printrus ("<u>!!!ВЫ ПРОИГРАЛИ!!!</u><br/>\r\n");
  $query="update uzers set useit='1' where `countryID` = '$countryID'";
  mysql_query($query);
  delete_country($countryID);
  $_SESSION['dies']=1;

  /*session_destroy();
  mysql_query("UPDATE uzers SET onlineflag = 0 WHERE countryID = '$countryID' LIMIT 1");
  printrus ("<br/><a href='index.php'>Назад</a><br/>\r\n");
  include_once("other_inc/footer.php");
  exit();*/

 break;

 case('offerClan'):
  $z=mysql_query("SELECT * FROM `clans` WHERE id='".$message."'");
  $s=mysql_fetch_array($z);

  printrus ("Посол <u>".$s['name']."</u> принес предложение о вступлении в этот клан. Вы согласны?<br/>\r\n");

   printrus
("<a href=\"$where/tobe.php?n=agree&amp;clan=$message&amp;$ses\">[вступить]</a><br/>
");
  printrus
("<a href=\"$where/tobe.php?n='disagree&amp;clan=$message&amp;$ses\">[отклонить]</a><br/>
");

  print "-----<br/>\r\n";

 break;


 case('offerunite'):
  printrus ("Гос-во <u>$message</u> предлагает вам союз.<br/>\r\n");
  $message_ = getCountryID($message);
  if((building_exists($countryID,"citadel")) && !war_between($countryID,$message_)){
   printrus
("<a href=\"$where/buildings/citadel.php?n=mkunite&amp;m=neighbours&amp;neighbour=$message_&amp;$ses\">[заключить]</a><br/>
");
  printrus
("<a href=\"$where/buildings/citadel.php?n=nounite&amp;m=neighbours&amp;neighbour=$message_&amp;$ses\">[отклонить]</a><br/>
");
}else{
      printrus("Но у вас нет цитадели, чтобы вы могли отреагировать (либо вы воюете с этим государством)! Союз автоматически отклоняется!<br/>\n");
  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
        }
  print "-----<br/>\r\n";

 break;
 case('mkunite'):
  printrus ("Гос-во <u>$message</u> подтвердило ваш запрос на заключение союза.<br/>\r\n");
  $message_ = getCountryID($message);
  if(building_exists($countryID,"ratusha") || building_exists($countryID,"citadel"))
   printrus
("<a href=\"$where/messages/writemessage.php?to=$message_&amp;$ses\">[сообщение]</a><br/>
");
  print "-----<br/>\r\n";

  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 break;
 case('nounite'):
  printrus ("Гос-во <u>$message</u> отклонило ваш запрос о заключении союза.<br/>\r\n");
  $message_ = getCountryID($message);
  if(building_exists($countryID,"ratusha") || building_exists($countryID,"citadel"))
   printrus
("<a href=\"$where/messages/writemessage.php?to=$message_&amp;$ses\">[сообщение]</a><br/>
");
  print "-----<br/>\r\n";

  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 break;
 case('closeunite'):
  printrus ("Гос-во <u>$message</u> рассторгло союз с вами!<br/>\r\n");
  $message_ = getCountryID($message);
  if(building_exists($countryID,"ratusha") || building_exists($countryID,"citadel"))
   printrus
("<a href=\"$where/messages/writemessage.php?to=$message_&amp;$ses\">[сообщение]</a><br/>
");
  print "-----<br/>\r\n";

  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 break;
 case('barter'):
  if(building_exists($countryID,"ratusha") || building_exists($countryID,"citadel")){
   list($country,$resgive,$res,$restake,$hisres)=explode('***',$message);
   $country = checkCountryID($country);
   //В country - имя страны теперь!
   if($res=='iron'){
    $rg="железа";
   }elseif($res=='arbor'){
    $rg="дерева";
   }elseif($res=='stone'){
    $rg="камня";
   }elseif($res=='grain'){
    $rg="зерна";
   }elseif($res=='money'){
    $rg="денег";
   }elseif($res=='oil'){
    $rg="нефти";
   }
   if($hisres=='iron'){
    $rt="железа";
   }elseif($hisres=='arbor'){
    $rt="дерева";
   }elseif($hisres=='stone'){
    $rt="камня";
   }elseif($hisres=='grain'){
    $rt="зерна";
   }elseif($hisres=='money'){
    $rt="денег";
   }elseif($hisres=='oil'){
    $rt="нефти";
   }
   printrus ("Гос-во <u>$country</u> предлагает вам обменять <b>$resgive</b> $rg на <b>$restake</b> $rt!<br/>\r\n");
   $country_ = getCountryID($country);
   printrus
("<a href=\"$where/buildings/citadel.php?m=okbarter&amp;messcheck=$message&amp;neighbour=$country_&amp;resgive=$resgive&amp;res=$res&amp;restake=$restake&amp;hisres=$hisres&amp;$ses\">[обменять]</a><br/>
");
   printrus
("<a href=\"$where/buildings/citadel.php?m=nobarter&amp;messcheck=$message&amp;neighbour=$country_&amp;$ses\">[отклонить]</a><br/>
");
   print "-----<br/>\r\n";
  }else{
        printrus("Вам предлагают обмен, но он невозможен, т.к. у вас нет ни ратуши, ни цитадели!<br/>\n");
          }
 break;
 case('newNeighbour'):
  printrus ("Новое соседнее государство: <u>$message</u>!<br/>\r\n");
  $message_ = getCountryID($message);
  if(building_exists($countryID,"ratusha") || building_exists($countryID,"citadel"))
   printrus
("<a href=\"$where/messages/writemessage.php?to=$message_&amp;$ses\">[сообщение]</a><br/>
");
  print "-----<br/>\r\n";
  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  return 1;
 break;
 default:
  $query="select `countryName` from countries where countryID='$from' limit 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  if(@mysql_num_rows($result)>0){
   $from_=@mysql_result($result,0);
   printrus ("<u>$from_</u>: $message<br/>\r\n");
   $key=_PREFIKS.':clans'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $clanID = $mem;
    }else{
    $r=mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$countryID'");
    $h=mysql_fetch_array($r);
    if ($h!==FALSE) $clanID = $h['clanID'];
    else $clanID=0;
    }

   if(building_exists($countryID,"ratusha")||building_exists($countryID,"citadel")||$clanID!=0)
    printrus
("<a href=\"$where/messages/writemessage.php?to=$from&amp;$ses\">ответить</a><br/>
");
   print "-----<br/>\r\n";
  }else{
   printrus ("<b>#RIP#</b>: $message<br/>\r\n");
   print "-----<br/>\r\n";
  }
  $query="DELETE FROM `messages` WHERE `countryID` = '$countryID' AND `from` = '$from' AND `message` = '$message' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  return 1;
 break;
 endswitch;
}

//==============================================================================
//определение общих характеристик в стрене======================================

//инфа о зданиях в стране
//Возвращает в виде двойного массива:

function returnBuildings($countryID){

 global $memcache;

 $key=_PREFIKS.':buildings'.$countryID;
 if(($a=$memcache->get($key))!==FALSE){
         return $a;
         }else{
 $query="select * from buildings where countryID='$countryID'";
 $result=@MYSQL_QUERY($query);


  $buildings = array();
  while (($a=mysql_fetch_array($result))!==FALSE){
          array_push($buildings,$a);
          }

  return $buildings;

 }

}

//подсчет населения в стране

function countPeople($countryID){

 global $memcache;

 $key=_PREFIKS.':id'.$countryID;
 if(($a=$memcache->get($key))!==FALSE){
         $people = $a['workers']+$a['scientists']+$a['wariors_free']+$a['wariors_free_2']+$a['wariors_free_3']+$a['wariors_free_4']+$a['wariors_free_5']+$a['wariors_free_6']+$a['wariors_free_7']+$a['wariors_free_8'];
         }else{
 $r = mysql_query("SELECT workers, scientists, wariors_free,wariors_free_2,wariors_free_3,wariors_free_4,wariors_free_5,wariors_free_6,wariors_free_7,wariors_free_8 FROM `countries` WHERE countryID = '$countryID'");
 $a = mysql_fetch_array($r);
 $people = $a['workers']+$a['scientists']+$a['wariors_atall']+$a['wariors_atall_2']+$a['wariors_atall_3'];
 }
 //Люди на охране зданий
 $buildings = returnBuildings($countryID);
 for ($i=0;$i<count($buildings);$i++){
 $people = $people + $buildings[$i]['guard']+$buildings[$i]['guard_2']+$buildings[$i]['guard_3']
 +$buildings[$i]['guard_4']+$buildings[$i]['guard_5']+$buildings[$i]['guard_6']
 +$buildings[$i]['guard_7']+$buildings[$i]['guard_8'];
 }

 return $people;

}

//инфа о случайных открытиях

function otkr_exists($countryID,$otkr_name){

global $memcache;

 $countryID=addslashes($countryID);
 $otkr_name=addslashes($otkr_name);

 $key=_PREFIKS.':otkrytiya'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $num=0;
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['otkr']==$otkr_name){
        $num=1;
        break;
        }
    }else{
 $query="select count(*) as num from otkrytiya where countryID='$countryID' and otkr='$otkr_name' LIMIT 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 $num=$a['num'];
 }

 if($num>0){
  return 1;
 }else{
  return 0;
 }

}

//инфа о строящихся зданиях в стране
//Возвращает в виде двойного массива:
//kind_1*what_1*peopleatwork_1*started_1*finished_1*var1_1*var2_1|kind_2*what_2*peopleatwork_2...

function returnProcess($countryID,$kind='building',$what=''){

 global $memcache;

 if ($kind=='empty')$kind='';

 $key = _PREFIKS.':works'.$countryID;
 if(($a=$memcache->get($key))!==FALSE){
         $result=array();
         for ($i=0;$i<count($a);$i++){
                 if ($a[$i]["kind"]=="$kind"||$kind==''){
                 if ($what==''){
                         array_push($result,$a[$i]);
                         }else{
                         if ($a[$i]["what"]=="$what")
                           array_push($result,$a[$i]);
                         }
                    }
                 }
         if (count($result)!=0)return $result;
          else return FALSE;
         }else{
 //$countryID=addslashes($countryID);
 $kind=addslashes($kind);
 $what=addslashes($what);

 if(empty($kind)){
  $what='';
 }elseif(empty($what)){
  $kind=" and kind='$kind'";
 }else{
  $kind=" and kind='$kind'";
  $what=" and what='$what'";
 }

 $query="select * from works where countryID='$countryID'$kind$what";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 if(mysql_num_rows($result)>0){

  $works = array();
  while (($a=mysql_fetch_array($result))!==FALSE){
          array_push($works,$a);
          }

  return $works;
 }else{
  return false;
 }

 }

}

//Вывод инфы о зданиях в человеческом виде

function printBuilding($building){

 switch($building):
 case("barracks"):
  return "Казармы";
 break;
 case("warhouse"):
  return "Дом войны";
 break;
 case("ratusha"):
  return "Ратуша";
 break;
 case("citadel"):
  return "Цитадель";
 break;
 case("university"):
  return "Университет";
 break;
 case("scientificcenter"):
  return "Научный центр";
 break;
 case("village"):
  return "Деревня";
 break;
 case("keeping"):
  return "Хранилище";
 break;
 case("market"):
  return "Рынок";
 break;
 case("wall"):
  return "Стена";
 break;
 case("magictower"):      //Позволяет нанимать магов
  return "Башня магов";
 break;
 case("fabrika"):         //Позволяет нанимать пушки и самолеты
  return "Фабрика";
 break;
 case("zavod"):           //Позволяет нанимать подрывников и улучшать параметры пушек, самолетов и подрывников
  return "Завод";
 break;
 case("gorodmagov"):      //Позволяет улучшать параметры магов. Требуется фабрика
  return "Город магов";
 break;
 case("neftevxwka"):      //Добыча нефти
  return "Нефтяная вышка";
 break;
 default:
  //Запись в лог об ошибке в имени здания
  return "Ошибка!";
 break;
 endswitch;

}

//Вывод инфы об открытиях в человеческом виде

function printOtkr($otkr){

 switch($otkr):
 case("MWIB"):
  return "Поношенные латы";
 break;
 default:
  //Запись в лог об ошибке в имени здания
  return "Ошибка!";
 break;
 endswitch;

}

//Узнаем скока всего земли

function countAllLand($countryID,$bl=FALSE){

 global $memcache;
 $key=_PREFIKS.':id'.$countryID;

 if(($a=$memcache->get($key))!==FALSE){
 $AllLand = $a['land']+$a['forest']+$a['mountains'];
 //Прибавляем землю, занятую зданиями
 if ($bl==TRUE){
    $bland=0;
    $key=_PREFIKS.':buildings'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) $bland = $bland + $mem[$i]['space'];
       $AllLand = $AllLand + $bland;
       }else{
       $r = mysql_query("SELECT sum(space) as num FROM `buildings` WHERE countryID = '$countryID'");
       $a = mysql_fetch_array($r);
       $AllLand = $AllLand + $a['num'];
       }
  //Посевами
    $wland=0;
    $key=_PREFIKS.':works'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++)  if ($mem[$i]['kind']=='working' && $mem[$i]['what']=='grain') {$wland = $mem[$i]['var2'];break;}
       $AllLand = $AllLand + $wland;
       }else{
       $r = mysql_query("SELECT var2 FROM `works` WHERE countryID = '$countryID' and kind = 'working' and what = 'grain' LIMIT 1");
       $a = mysql_fetch_array($r);
       $AllLand = $AllLand + $a['var2'];
       }

    }
 return $AllLand;
         }else{

 $query="select land,mountains,forest from countries where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $land=@mysql_result($result,0,"land");
 $mountains=@mysql_result($result,0,"mountains");
 $forest=@mysql_result($result,0,"forest");

 $AllLand=$land+$mountains+$forest;

 //Прибавляем землю, занятую зданиями
 if ($bl==TRUE){
    $bland=0;
    $key=_PREFIKS.':buildings'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++) $bland = $bland + $mem[$i]['space'];
       $AllLand = $AllLand + $bland;
       }else{
       $r = mysql_query("SELECT sum(space) as num FROM `buildings` WHERE countryID = '$countryID'");
       $a = mysql_fetch_array($r);
       $AllLand = $AllLand + $a['num'];
       }
 //Посевами
 $wland=0;
    $key=_PREFIKS.':works'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++)  if ($mem[$i]['kind']=='working' && $mem[$i]['what']=='grain') {$wland = $mem[$i]['var2'];break;}
       $AllLand = $AllLand + $wland;
       }else{
       $r = mysql_query("SELECT var2 FROM `works` WHERE countryID = '$countryID' and kind = 'working' and what = 'grain' LIMIT 1");
       $a = mysql_fetch_array($r);
       $AllLand = $AllLand + $a['var2'];
       }

    }

 //$AllLand = $_SESSION['land'] + $_SESSION['mountains'] + $_SESSION['forest'];
 return $AllLand;
 }

}

//считаем свободное место в стране

function countFreeLand($countryID){

require (_ROOT.'/b_params.php'); //Инфа о зданиях

global $memcache;
$key1=_PREFIKS.':id'.$countryID;
$key2=_PREFIKS.':buildings'.$countryID;
$key3=_PREFIKS.':works'.$countryID;

 if ((($a=$memcache->get($key1))!==FALSE)&&(($b=$memcache->get($key2))!==FALSE)&&(($c=$memcache->get($key3))!==FALSE)){
         $land = $a['land'];
         $sum_sp=0;
         for ($i=0;$i<count($b);$i++){
                 $sum_sp = $sum_sp + $b[$i]["space"];
                 }
         $sum_wsp=0;
         for ($i=0;$i<count($c);$i++){
                 if ($c[$i]['kind']=='building'){
                 $building_land=$c[$i]["what"]."_land";
                 $sum_wsp = $sum_wsp+$$building_land;
                 }
                 }
         return ($land-$sum_wsp-$sum_sp);
         }else{

 $countryID=addslashes($countryID);

 $query="select land,mountains,forest from countries where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $land=$a["land"];

 $query = "SELECT sum(space) as summa FROM buildings WHERE countryID='".$countryID."'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $TakenLand = $a['summa'];

 $FreeLand=$land-$TakenLand;

 //Теперь считаем землю, на которой идет стройка
 $query = "SELECT * FROM works WHERE (countryID='".$countryID."')and(kind='building')";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $sm = 0;
 while (($a=mysql_fetch_array($result))!==FALSE){
         $building_land = $a['what']."_land";
         $sm = $sm + $$building_land;
         }

 $FreeLand=$FreeLand - $sm;
 return $FreeLand;

 }

}

//Выцепливаем конкретное значение

function getValue($where,$from,$res){

 //$countryID=addslashes($countryID);
 $from=addslashes($from);

 $query="select $res from `$from` where $where limit 1";

 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $res=mysql_result($result,0,"$res");

 return $res;

}

//Выцепливаем конкретный ресурс

function getResourse($countryID,$res){

 $countryID=addslashes($countryID);

 $query="select $res from countries where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $res=@mysql_result($result,0,"$res");

 return $res;

}

//Выцепливаем научную разработку

function getScience($countryID,$res){

 $countryID=addslashes($countryID);

 $query="select $res from countries where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $res=@mysql_result($result,0,"$res");

 return $res;

}

//инфа о зданиях в стране

function mkWarning($str){

 if($str<4){
  $str="<b><u>!$str!</u></b>";
 }elseif($str<6){
  $str="<b><u>$str</u></b>";
 }elseif($str<10){
  $str="<b>$str</b>";
 }

 return $str;

}

//Получение процента выполнения работы

function getWorkPercent($started,$finished,$now){

 $percent100=$finished-$started;
 $percentX=$now-$started;
 $percent=round(($percentX/$percent100)*10000)/100;

 return $percent;

}

//Создание красивой строки со временем из секунд

function mkTimeStr($sec){

 $min=round($sec/60-0.5);
 $hour=round($min/60-0.5);
 if($min<=1){
  $time="<b>$sec</b> сек.";
 }elseif($hour<=1){
  $time="<b>$min</b> мин.";
  $sec=$sec-$min*60;
  if($sec!=0) $time.=" <b>$sec</b> сек.";
 }else{
  $time="<b>$hour</b> час.";
  $min=$min-$hour*60;
  if($min!=0) $time.=" <b>$min</b> мин.";
 }

 return $time;

}

//время создания здания

//$a -- дерево, нужное для постройки,
//$s -- камень,
//$i -- железо,
//$l -- земля, которую занимает здание
//$w -- рабочие, строящие здание.
//функция возвращает время, в секундах, необходимое для постройки


function workTime($a,$s,$i,$l,$w){
 $time=round(1000000*($a+$s+$i)/($l*$w));
 return $time;
}

function workTime_new($a,$s,$i,$l,$w){
 $time=round(1000000*($a+$s+$i)/($l*$w));
 return $time;
}


//Считаем свободное хранительное место

function free_place($countryID){

global $memcache;
$key1=_PREFIKS.':id'.$countryID;
$key2=_PREFIKS.':buildings'.$countryID;
$key3=_PREFIKS.':market'.$countryID;
if ((($a=$memcache->get($key1))!==FALSE)&&(($b=$memcache->get($key2))!==FALSE)&&(($c=$memcache->get($key3))!==FALSE)){
        $max_free = 6000;
        for ($i=0;$i<count($b);$i++){
                if ($b[$i]["building"]=='keeping') $max_free=($b[$i]["space"]*50+2500);
                if ($b[$i]["building"]=='market') $max_free=$b[$i]["space"]*100;
                }
        $max_free = $max_free - $a['arbor'] - $a['stone'] - $a['iron'] - $a['grain'] - $a['oil'];
        for ($i=0;$i<count($c);$i++){
                $max_free = $max_free - $c[$i]['count'];
                }
        return $max_free;

        }else{

 if(building_exists($countryID,'keeping')){
  $max_free=getValue("countryID='$countryID' and building='keeping'","buildings","space")*50+2500;
 }elseif(building_exists($countryID,'market')){
  $max_free=getValue("countryID='$countryID' and building='market'","buildings","space")*100;
 }else{
  $max_free=6000;
 }


 $r = mysql_query("SELECT arbor,stone,iron,grain,oil FROM countries WHERE countryID='".$countryID."'");
 $a = mysql_fetch_array($r);
 $max_free = $max_free-$a['arbor']-$a['stone']-$a['iron']-$a['grain']-$a['oil'];

 $r = mysql_query("SELECT sum(`count`) as summ FROM market WHERE countryID = '".$countryID."'");
 $a = mysql_fetch_array($r);
 $max_free = $max_free - $a['summ'];
 return $max_free;
 }

}


//Максимальное число рабочих
function count_workers_max($countryID){

 global $memcache;
 $key1 = _PREFIKS.':buildings'.$countryID;
 $key2 = _PREFIKS.':id'.$countryID;
 if ((($a=$memcache->get($key1))!==FALSE) && (($b=$memcache->get($key2))!==FALSE)){
 $workers_max=200;
 for ($i=0;$i<count($a);$i++){
         if ($a[$i]['building']=='village') $workers_max = round(3*$a[$i]['space']*(round(($b['plotn_people']+2)/10)));
         }
 return $workers_max;
         }else{
 $r = mysql_query("SELECT plotn_people FROM `countries` WHERE countryID = '$countryID' LIMIT 1");
 $a = mysql_fetch_array($r);

 //$countryID=addslashes($countryID);

 if(building_exists($countryID,'village')){
  $query="select * from `buildings` where countryID='$countryID' and building='village' limit 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $space=mysql_result($result,0,'space');
  $workers_max=round(3*$space*(round(($a['plotn_people']+2)/10)));
  //$workers_max=3*$space*round($_SESSION["plotn_people"]/10);
 }else{
  $workers_max=200;
 }
 return $workers_max;
 }

}

//Посылаем сообщение
function sendMessage($toID,$from,$text){

 global $memcache;
 $key=_PREFIKS.':messages'.$toID;
 //В поле $text сообщение должно быть в КОДИРОВКЕ WIN!!!!!!!!!!
 $toID=addslashes($toID);
 $from=addslashes($from);
 //$text=iconv('utf-8','cp1251',addslashes($text));
 $tm = time();

 $query="INSERT INTO `messages` VALUES ('$toID', '$from', '$text',$tm)";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 if (($a=$memcache->get($key))!==FALSE){
         //Пишем мессагу еще и в мемкеш
         $msg = array("countryID"=>$toID, "from"=>$from, "message"=>$text, "tm"=>$tm);
         array_push($a,$msg);
         $memcache->set($key,$a,false,86400);
         }

}

//создание нового здания
function createBuilding($countryID,$building,$var1,$var2){

require (_ROOT.'/b_params.php'); //Инфа о зданиях

 global $memcache;
 $key1 = _PREFIKS.':id'.$countryID;
 $key2 = _PREFIKS.':buildings'.$countryID;
 $key3 = _PREFIKS.':works'.$countryID;

 $a = countryInfo($countryID);
 $b = returnBuildings($countryID);
 $c = returnProcess($countryID,'empty');

 //Если был апгрейд, удаляем старое здание и возвращаем охрану, если была, в свободных военных
 switch($building):
 case('warhouse'): $oldbuilding = 'barracks';break;
 case('citadel'): $oldbuilding = 'ratusha';break;
 case('scientificcenter'): $oldbuilding = 'university';break;
 case('market'): $oldbuilding = 'keeping';break;
 case('zavod'): $oldbuilding = 'fabrika';break;
 case('gorodmagov'): $oldbuilding = 'magictower';break;
 endswitch;
 $guard=$guard_2=$guard_3=$guard_4=$guard_5=$guard_6=$guard_7=$guard_8=0;
 $old_exists=FALSE;
 for ($i=0;$i<count($b);$i++){
     if (isset($oldbuilding) && $b[$i]['building']==$oldbuilding){
     $guard=$b[$i]['guard'];
     $guard_2=$b[$i]['guard_2'];
     $guard_3=$b[$i]['guard_3'];
     $guard_4=$b[$i]['guard_4'];
     $guard_5=$b[$i]['guard_5'];
     $guard_6=$b[$i]['guard_6'];
     $guard_7=$b[$i]['guard_7'];
     $guard_8=$b[$i]['guard_8'];
     $b[$i]['building']=$building;
     $b[$i]['var1']=$var1;
     $b[$i]['var2']=$var2;
     $b[$i]['hits']=100;
     $land=$building."_land";
     $b[$i]['land']=$$land;
     $memcache->set($key2,$b,false,86400);
     $old_exists=TRUE;
     //В мемкеш пишем новое здание
     break;
     }

     }
     if (isset($oldbuilding)){
     $query="delete from `buildings` where countryID='$countryID' and building='$oldbuilding' limit 1";
     $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
     }
 //Рабочих - на место
 $peopleatwork=0;
 $newworks=array();
 for ($i=0;$i<count($c);$i++){
         if ($c[$i]['kind']=='building'&& $c[$i]['what']==$building){
                 $peopleatwork=$c[$i]['peopleatwork'];
                 }else
            {
            array_push($newworks,$c[$i]);
                    }
         }
  mysql_query("UPDATE countries SET workers = workers + $peopleatwork WHERE countryID='".$countryID."' LIMIT 1");
  $a['workers'] = $a['workers'] + $peopleatwork;
  $memcache->set($key1,$a,false,86400);
  $memcache->set($key3,$newworks,false,86400);
  //прекращаем работу
  $query="delete from `works` where countryID='$countryID' and kind='building' and what='$building' limit 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

  //создаем здание
  $land=$building."_land";

  //!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! $$land

  $query="INSERT INTO `buildings` VALUES ('$countryID', '$building', $guard, $guard_2, $guard_3, $guard_4, $guard_5, $guard_6, $guard_7, $guard_8, ".($$land).", $var1, $var2, 100)";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  if (!isset($oldbuilding)||$old_exists==FALSE){
  //Если это не апгрейд или старое здание уже разрушено, то надо записать в мемкеш новое здание
  $build = array("countryID"=>$countryID, "building"=>$building, "guard"=>$guard, "guard_2"=>$guard_2, "guard_3"=>$guard_3, "guard_4"=>$guard_4, "guard_5"=>$guard_5, "guard_6"=>$guard_6, "guard_7"=>$guard_7, "guard_8"=>$guard_8, "space"=>($$land), "var1"=>$var1, "var2"=>$var2, "hits"=>100);
  array_push($b,$build);
  $memcache->set($key2,$b,false,86400);
  //В мемкеш пишем новое здание
  }

 //посылаем сообщение:
 sendMessage($countryID, "newBuilding", $building);

}

//завершение починки здания

function repaireBuilding($countryID,$building){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 $key2=_PREFIKS.':buildings'.$countryID;
 $key3=_PREFIKS.':works'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 if (($b=$memcache->get($key2))!==FALSE) $build_m = TRUE; else $build_m = FALSE;
 if (($c=$memcache->get($key3))!==FALSE) $works_m = TRUE; else $works_m = FALSE;

 $countryID=addslashes($countryID);
 $building=addslashes($building);

 if ($works_m==TRUE){
 $newworks=array();
 for ($i=0;$i<count($c);$i++){
     if($c[$i]['kind']=='repairing'&&$c[$i]['what']==$building)$peopleatwork=$c[$i]['peopleatwork'];
     else array_push($newworks,$c[$i]);
         }

         }else{
 //возвращяем людей на место
 $query="select * from `works` where countryID='$countryID' and kind='repairing' and what='$building' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $peopleatwork=@mysql_result($result,0,'peopleatwork');
 }

 mysql_query("UPDATE countries SET workers = workers + $peopleatwork WHERE countryID='".$countryID."'");
 if ($id_m==TRUE){
    $a['workers']=$a['workers'] + $peopleatwork;
    $memcache->set($key1,$a,false,86400);
    }
 //$_SESSION['workers'] = $_SESSION['workers'] + $peopleatwork;
 //setValue("countryID='$countryID'","resources","workers",getResourse($countryID,"workers")+$peopleatwork);

 //меняем жизнь здания:
 mysql_query("UPDATE buildings SET hits=100 WHERE countryID='".$countryID."' and building='$building'");

 if ($build_m==TRUE){
    for ($i=0;$i<count($b);$i++){
        if ($b[$i]['building']==$building){
           $b[$i]['hits']=100;
           $memcache->set($key2,$b,false,86400);
           }
        }
    }

 //прекращаем работу:
 $query="delete from `works` where countryID='$countryID' and kind='repairing' and what='$building' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 if ($works_m==TRUE){
    $memcache->set($key3,$newworks,false,86400);
    }

 //и посылаем сообщение:
 sendMessage($countryID, "BuildingRepairedFinally", $building);

}

//Прекращение починки здания

function repaireBuildingStop($countryID,$building,$hits){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 $key2=_PREFIKS.':buildings'.$countryID;
 $key3=_PREFIKS.':works'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 if (($b=$memcache->get($key2))!==FALSE) $build_m = TRUE; else $build_m = FALSE;
 if (($c=$memcache->get($key3))!==FALSE) $works_m = TRUE; else $works_m = FALSE;

 $countryID=addslashes($countryID);
 $building=addslashes($building);

 //возвращяем людей на место
 if ($works_m==TRUE){
 $newworks=array();
 for ($i=0;$i<count($c);$i++){
     if ($c[$i]['kind']=='repairing'&&$c[$i]['what']==$building){
             $peopleatwork=$c[$i]['peopleatwork'];
             $finished=$c[$i]['finished'];
             $started=$c[$i]['started'];
             }else array_push($newworks,$c[$i]);
     }
    }else{
 $query="select * from `works` where countryID='$countryID' and kind='repairing' and what='$building' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $peopleatwork=@mysql_result($result,0,'peopleatwork');
 $started=mysql_result($result,0,'started');
 $finished=mysql_result($result,0,'finished');
 }

 mysql_query("UPDATE countries SET workers = workers + $peopleatwork WHERE countryID='".$countryID."'");

 if ($id_m==TRUE){
         $a['workers']=$a['workers']+$peopleatwork;
         $memcache->set($key1,$a,false,86400);
         }

 $percent=getWorkPercent($started,$finished,date("U"));
 $hits=$hits+round((100-$hits)*$percent/100);

 //меняем жизнь здания:
 mysql_query("UPDATE buildings SET hits=$hits WHERE countryID='".$countryID."' and building='$building'");

 if ($build_m==TRUE){
    for ($i=0;$i<count($b);$i++){
        if ($b[$i]['building']==$building){
           $b[$i]['hits']=$hits;
           $memcache->set($key2,$b,false,86400);
           break;
           }
        }
    }

 //прекращаем работу:
 $query="delete from `works` where countryID='$countryID' and kind='repairing' and what='$building' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 if($works_m==TRUE){
    $memcache->set($key3,$newworks,false,86400);
    }

 //и посылаем сообщение:
 sendMessage($countryID, "BuildingRepairingBreaked", $building);

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."прекращает ремонт $building\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 return $hits;

}

//Обучаем людей

function teachPeople($countryID,$peoplekind,$scientists,$teached){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 $key2=_PREFIKS.':buildings'.$countryID;
 $key3=_PREFIKS.':works'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 if (($b=$memcache->get($key2))!==FALSE) $build_m = TRUE; else $build_m = FALSE;
 if (($c=$memcache->get($key3))!==FALSE) $works_m = TRUE; else $works_m = FALSE;

 $countryID=addslashes($countryID);
 $peoplekind=addslashes($peoplekind);

 //возвращяем ученых на место
 mysql_query("UPDATE countries SET scientists = scientists + $scientists WHERE countryID='".$countryID."' LIMIT 1");

 if ($id_m==TRUE){
    $a['scientists'] = $a['scientists'] + $scientists;
    //$memcache->set($key1,$a,false,86400);
    }

 //добавляем обученный народ:
 if($peoplekind=="scientists"){
  mysql_query("UPDATE countries SET scientists = scientists + $teached WHERE countryID='".$countryID."' LIMIT 1");
 if ($id_m==TRUE){
    $a['scientists'] = $a['scientists'] + $teached;
    //$memcache->set($key1,$a,false,86400);
    }

  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Обучено <b>$teached</b> ученых!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }elseif($peoplekind=="wariors"){

  mysql_query("UPDATE countries SET wariors_free = wariors_free + $teached WHERE countryID='".$countryID."' LIMIT 1");

  if ($id_m==TRUE){
    //$a['wariors_atall'] = $a['wariors_atall'] + $teached;
    $a['wariors_free'] = $a['wariors_free'] + $teached;
    //$memcache->set($key1,$a,false,86400);
    }

  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Обучено <b>$teached</b> пехотинцев!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }elseif($peoplekind=="wariors_2"){

  mysql_query("UPDATE countries SET wariors_free_2 = wariors_free_2 + $teached WHERE countryID='".$countryID."' LIMIT 1");

  if ($id_m==TRUE){
    //$a['wariors_atall_2'] = $a['wariors_atall_2'] + $teached;
    $a['wariors_free_2'] = $a['wariors_free_2'] + $teached;
    //$memcache->set($key1,$a,false,86400);
    }

  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Обучено <b>$teached</b> кавалеристов!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }elseif($peoplekind=="wariors_3"){

  mysql_query("UPDATE countries SET wariors_free_3 = wariors_free_3 + $teached WHERE countryID='".$countryID."' LIMIT 1");

  if ($id_m==TRUE){
    //$a['wariors_atall_3'] = $a['wariors_atall_3'] + $teached;
    $a['wariors_free_3'] = $a['wariors_free_3'] + $teached;
    //$memcache->set($key1,$a,false,86400);
    }

  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Обучено <b>$teached</b> стрелков!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }elseif($peoplekind=="wariors_4"){
  mysql_query("UPDATE countries SET wariors_free_4 = wariors_free_4 + $teached WHERE countryID='".$countryID."' LIMIT 1");
  if ($id_m==TRUE){
    $a['wariors_free_4'] = $a['wariors_free_4'] + $teached;
    }
  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Произведено <b>$teached</b> пушек!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }elseif($peoplekind=="wariors_5"){
  mysql_query("UPDATE countries SET wariors_free_5 = wariors_free_5 + $teached WHERE countryID='".$countryID."' LIMIT 1");
  if ($id_m==TRUE){
    $a['wariors_free_5'] = $a['wariors_free_5'] + $teached;
    }
  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Обучено <b>$teached</b> подрывников!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }elseif($peoplekind=="wariors_6"){
  mysql_query("UPDATE countries SET wariors_free_6 = wariors_free_6 + $teached WHERE countryID='".$countryID."' LIMIT 1");
  if ($id_m==TRUE){
    $a['wariors_free_6'] = $a['wariors_free_6'] + $teached;
    }
  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Произведено <b>$teached</b> самолетов!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }elseif($peoplekind=="wariors_7"){
  mysql_query("UPDATE countries SET wariors_free_7 = wariors_free_7 + $teached WHERE countryID='".$countryID."' LIMIT 1");
  if ($id_m==TRUE){
    $a['wariors_free_7'] = $a['wariors_free_7'] + $teached;
    }
  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Обучено <b>$teached</b> магов!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }elseif($peoplekind=="wariors_8"){
  mysql_query("UPDATE countries SET wariors_free_8 = wariors_free_8 + $teached WHERE countryID='".$countryID."' LIMIT 1");
  if ($id_m==TRUE){
    $a['wariors_free_8'] = $a['wariors_free_8'] + $teached;
    }
  //и посылаем сообщение:
  sendMessage($countryID, "fullMessage", "Обучено <b>$teached</b> генералиссимусов!");
  if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);
 }

 //прекращаем работу:
 $query="delete from `works` where countryID='$countryID' and kind='teaching' and what='$peoplekind' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 if ($works_m==TRUE){
    $newworks=array();
    for ($i=0;$i<count($c);$i++){
        if ($c[$i]['kind']=='teaching'&&$c[$i]['what']==$peoplekind){
                }else array_push($newworks,$c[$i]);
        }
    $memcache->set($key3,$newworks,false,86400);
    }

}
//Двигаем науку

function upgradeScience($countryID,$sciencekind,$scientists,$new_lvl, $aid){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 $key2=_PREFIKS.':buildings'.$countryID;
 $key3=_PREFIKS.':works'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 if (($b=$memcache->get($key2))!==FALSE) $build_m = TRUE; else $build_m = FALSE;
 if (($c=$memcache->get($key3))!==FALSE) $works_m = TRUE; else $works_m = FALSE;

 $countryID=addslashes($countryID);
 $sciencekind=addslashes($sciencekind);

 $pl = round($new_lvl/100);

 if ($id_m==TRUE){
 $new_lvl = min(100,$a["$sciencekind"]+round($new_lvl/10));
    }else{
 $r = mysql_query("SELECT * FROM `countries` WHERE countryID = '$countryID' LIMIT 1");
 $a = mysql_fetch_array($r);
 $new_lvl = min(100,$a["$sciencekind"]+round($new_lvl/10));
 }

 //возвращяем ученых на место
 //Тут было, по ходу, в 100 раз меньше, чем нужно (т.к. в $new_lvl не процент, а часть)
 //Это я исправил при записи в БД - записывается % а не часть
 //$new_lvl2 = round($new_lvl*100);
 mysql_query("UPDATE countries SET scientists = scientists + $scientists, $sciencekind = $new_lvl WHERE countryID='".$countryID."'");

 if ($id_m==TRUE){
    $a['scientists'] = $a['scientists'] + $scientists;
    $a["$sciencekind"] = $new_lvl;
    $memcache->set($key1,$a,false,86400);
    }

 //изменяем уровень науч. центра, если таковой имеется
 if ($build_m==TRUE){
 for ($i=0;$i<count($b);$i++){
     if ($b[$i]['building']=='scientificcenter'){
        $var2 = $b[$i]['var2'];
  if(($var2+($pl*1.3))<10){
   $new_lvl_full=$var2+round($pl*0.7);
  }else{
   $new_lvl_full=10;
  }
  $b[$i]['var2'] = $new_lvl_full;
        break;
        }
     }
    }else{
 $query="select * from `buildings` where countryID='$countryID' and building='scientificcenter' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $num=@mysql_num_rows($result);
 if($num>0){
  $var2=mysql_result($result,0,"var2");
  if(($var2+($pl*1.3))<10){
   $new_lvl_full=$var2+round($pl*0.7);
  }else{
   $new_lvl_full=10;
  }

  }

  }

  mysql_query("UPDATE buildings SET var2 = $new_lvl_full WHERE countryID='".$countryID."' and building='scientificcenter'");

  if ($build_m==TRUE){
     $memcache->set($key2,$b,false,86400);
     }
  if(round($pl*0.7>0) && isset($new_lvl_full)){
   sendMessage($countryID, "fullMessage", "Уровень научного центра поднялся на <b>".round($pl*0.7)."</b> ед.! (максимум 10 уровень)");
  }

 //и посылаем сообщение:
 switch($sciencekind):
 case("grain_making"):
  sendMessage($countryID, "fullMessage", "Уровень земледелия повышен до <b>".$new_lvl."</b>%");
 break;
 case("arbor_making"):
  sendMessage($countryID, "fullMessage", "Уровень добычи древесины повышен до <b>".$new_lvl."</b>%");
 break;
 case("iron_making"):
  sendMessage($countryID, "fullMessage", "Уровень металлургии повышен до <b>".$new_lvl."</b>%");
 break;
 case("stone_making"):
  sendMessage($countryID, "fullMessage", "Уровень каменной промышленности повышен до <b>".$new_lvl."</b>%");
 break;
 case("oil_making"):
  sendMessage($countryID, "fullMessage", "Уровень добычи нефти повышен до <b>".$new_lvl."</b>%");
 break;
 case("science"):
  sendMessage($countryID, "fullMessage", "Научный уровень повышен до <b>".$new_lvl."</b>%");
 break;
 case("plotn_people"):
  sendMessage($countryID, "fullMessage", "Макс. уровень плотности населения повышен до <b>".$new_lvl."</b>");
 break;
 case("plotn_wariors"):
  sendMessage($countryID, "fullMessage", "Макс. уровень плотности войска повышен до <b>".$new_lvl."</b>");
 break;
 case("people_adding"):
  sendMessage($countryID, "fullMessage", "Прирост населения увеличен до <b>".$new_lvl."</b>%");
 break;
 case("forest_adding"):
  sendMessage($countryID, "fullMessage", "Уровень выращивания лесов увеличен до <b>".$new_lvl."</b>%");
 break;
 case("atomic"):
  sendMessage($countryID, "fullMessage", "Атомная бомба готова к использованию!!!");
 break;
 case("mountains_max"):
  sendMessage($countryID, "fullMessage", "Уровень прочности шахт увеличен до <b>".$new_lvl."</b>%");
 break;
 case("forest_max"):
  sendMessage($countryID, "fullMessage", "Уровень сохранения лесов увеличен до <b>".$new_lvl."</b>%");
 break;
 case("demontaj"):
  sendMessage($countryID, "fullMessage", "Уровень демонтажа зданий увеличен до <b>".$new_lvl."</b>%");
  break;
 case("artefakt"):
  sendMessage($countryID, "fullMessage", "Уровень археологии увеличен до <b>".$new_lvl."</b>%");
  break;
  case("art"): $art_name=artefactName(artefactById($aid));
  sendMessage($countryID, "fullMessage", "Исследование артефакта завершено. Вы получили $art_name.");
  mysql_query("UPDATE artefacts SET researched=1 WHERE id=$aid");
 break;
 endswitch;

 //прекращаем работу:
 $query="delete from `works` where countryID='$countryID' and kind='science' and what='$sciencekind' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 if ($works_m==TRUE){
    $newworks=array();
    for ($i=0;$i<count($c);$i++){
        if ($c[$i]['kind']=='science'&&$c[$i]['what']==$sciencekind){
           }else array_push($newworks,$c[$i]);
        }
    $memcache->set($key3,$newworks,false,86400);
    }

}


//Добываем ресурсы

function ResourceMade($countryID,$resKind,$workers,$res,$land_taken){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 $key2=_PREFIKS.':buildings'.$countryID;
 $key3=_PREFIKS.':works'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 if (($b=$memcache->get($key2))!==FALSE) $build_m = TRUE; else $build_m = FALSE;
 if (($c=$memcache->get($key3))!==FALSE) $works_m = TRUE; else $works_m = FALSE;

 //возвращяем рабочих на место
 mysql_query("UPDATE countries SET workers = workers + $workers WHERE countryID='".$countryID."'");
 if ($id_m==TRUE){
    $a['workers'] = $a['workers'] + $workers;
    $memcache->set($key1,$a,false,86400);
    }

 //и посылаем сообщение:
 if($resKind=="grain"){
  $resKind_="зерна";
 }elseif($resKind=="stone"){
  $resKind_="камня";
 }elseif($resKind=="iron"){
  $resKind_="железа";
 }elseif($resKind=="arbor"){
  $resKind_="дерева";
 }elseif($resKind=="oil"){
  $resKind_="нефти";
 }else{
  $resKind_="какой-то херотени";
 }

 $freeplace=max(0,free_place($countryID));

 if($res>$freeplace){
  $res_gone=$res-$freeplace;
  sendMessage($countryID, "fullMessage", "Ваши рабочие добыли <b>$res</b> $resKind_, но для хранения не хватило места и пришлось выкинуть <b>$res_gone</b> $resKind_.");
  $res=$freeplace;
 }else{
  sendMessage($countryID, "fullMessage", "Ваши рабочие добыли <b>$res</b> $resKind_!");
 }

 //добавляем добытый ресурс:
 mysql_query("UPDATE countries SET $resKind = $resKind + $res, land = land + $land_taken WHERE countryID='".$countryID."' LIMIT 1");

 if ($id_m==TRUE){
    $a["$resKind"] = $a["$resKind"] + $res;
    $a['land'] = $a['land'] + $land_taken;
    //$memcache->set($key1,$a,false,86400);
    }

 //земля изменилась:

 //прекращаем работу:
 $query="delete from `works` where countryID='$countryID' and kind='working' and what='$resKind' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 if ($works_m==TRUE){
    $newworks=array();
    for ($i=0;$i<count($c);$i++){
        if ($c[$i]['kind']=='working'&&$c[$i]['what']==$resKind){
           }else array_push($newworks,$c[$i]);
        }
    $memcache->set($key3,$newworks,false,86400);
    }
 if ($id_m==TRUE) $memcache->set($key1,$a,false,86400);

}

//Разработано месторождение
function PlaceMade($countryID,$what,$peopleatwork,$var1,$var2){
global $memcache;

//прекращаем работу:
$query="delete from `works` where countryID='$countryID' and kind='newplace' and what='oil' limit 1";
$result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
$key=_PREFIKS.':works'.$countryID;
if (($mem=$memcache->get($key))!==FALSE){
$newworks=array();
    for ($i=0;$i<count($mem);$i++){
        if ($mem[$i]['kind']=='newplace'&&$mem[$i]['what']=='oil'){
           }else array_push($newworks,$mem[$i]);
        }
    $memcache->set($key,$newworks,false,86400);
}

//возвращаем рабочих:
 mysql_query("UPDATE `countries` SET workers = workers + $peopleatwork WHERE countryID='".$countryID."' LIMIT 1");
 $key=_PREFIKS.':id'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $mem['workers'] = $mem['workers'] + $peopleatwork;
    $memcache->set($key,$mem,false,86400);
    }

//Обновляем нефтевышку
mysql_query("UPDATE `buildings` SET var1 = ".time().", var2 = ".$var1." WHERE countryID='".$countryID."' and building = 'neftevxwka' LIMIT 1");
 $key=_PREFIKS.':buildings'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='neftevxwka'){
    $mem[$i]['var1'] = time();  //Время последнего сбора
    $mem[$i]['var2'] = $var1;   //Кол-во нефти в местророждении
    break;
    }
    $memcache->set($key,$mem,false,86400);
    }

 sendMessage($countryID, "fullMessage", "Разработка нефтяного месторождения емкостью $var1 едениц закончена!");

}

//Обновление проводимых работ

function worksRefresh($countryID){

 global $memcache;
 $key3=_PREFIKS.':works'.$countryID;
 if (($c=$memcache->get($key3))!==FALSE) $works_m = TRUE; else $works_m = FALSE;

 $countryID=addslashes($countryID);
 $tm = time();
 if ($works_m==TRUE){
    $num=count($c);
    }else{
 $query="select * from `works` where countryID='$countryID' and finished<$tm";
 $result=@MYSQL_QUERY($query);
 $num=@mysql_num_rows($result);
 }

 for($i=0;$i<$num;$i++){

  if ($works_m==TRUE){
  $kind=$c[$i]["kind"];
  $what=$c[$i]["what"];
  $var1=$c[$i]["var1"];
  $var2=$c[$i]["var2"];
  $peopleatwork=$c[$i]["peopleatwork"];
  $finished=$c[$i]["finished"];
     }else{
  $a = mysql_fetch_array($result);
  $kind=$a["kind"];
  $what=$a["what"];
  $var1=$a["var1"];
  $var2=$a["var2"];
  $peopleatwork=$a["peopleatwork"];
  $finished=$a["finished"];
  }

  if($finished<=time()){
   switch($kind):
   case('building'):
    createBuilding($countryID,$what,$var1,$var2);
   break;
   case('repairing'):
    repaireBuilding($countryID,$what);
   break;
   case('teaching'):
    teachPeople($countryID,$what,$peopleatwork,$var1);
   break;
   case('science'):
    upgradeScience($countryID,$what,$peopleatwork,$var1,$var2);
   break;
   case('working'):
    ResourceMade($countryID,$what,$peopleatwork,$var1,$var2);
   break;
   case('newplace'):   //Разработано новое месторождение нефти
    PlaceMade($countryID,$what,$peopleatwork,$var1,$var2);
   break;
   endswitch;
  }
 }

}

//А строится ли это здание?
function builds($countryID,$bld){

 global $memcache;
 $key3=_PREFIKS.':works'.$countryID;
 if (($c=$memcache->get($key3))!==FALSE) $works_m = TRUE; else $works_m = FALSE;

 $countryID=addslashes($countryID);
 $bld=addslashes($bld);

 if ($works_m==TRUE){
 $num=0;
 for ($i=0;$i<count($c);$i++){
     if ($c[$i]['kind']=='building'&&$c[$i]['what']==$bld){$num=1;break;}
     }
    }else{
 $query="select count(*) as num from `works` where countryID='$countryID' and kind='building' and what='$bld' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 $num = $a['num'];
 }

 if($num>0) return true;
 return false;

}

//А есть ли такое здание в стране?
function building_exists($countryID,$bld){

 global $memcache;
 $key2=_PREFIKS.':buildings'.$countryID;
 if (($b=$memcache->get($key2))!==FALSE) $build_m = TRUE; else $build_m = FALSE;

 $countryID=addslashes($countryID);
 $bld=addslashes($bld);

 if ($build_m==TRUE){
 $num=0;
 for ($i=0;$i<count($b);$i++){
     if ($b[$i]['building']==$bld){$num=1;break;}
     }
    }else{

 $query="select count(*) as num from `buildings` where countryID='$countryID' and building='$bld' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 $num=$a['num'];
 }

 if($num>0){
  return true;
 }else{
  return false;
 }
}

//Добавление соседа в список соседей
function setNeighbour($countryID,$neighbourID){

 global $memcache;
 $key1=_PREFIKS.':neighs'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $neigh_1 = TRUE; else $neigh_1 = FALSE;
 $key2=_PREFIKS.':neighs'.$neighbourID;
 if (($b=$memcache->get($key2))!==FALSE) $neigh_2 = TRUE; else $neigh_2 = FALSE;

 $countryID=addslashes($countryID);
 $neighbourID=addslashes($neighbourID);

 $query="INSERT INTO `neighbours` VALUES('$countryID','$neighbourID')";
 $result=MYSQL_QUERY($query);
 if ($neigh_1==TRUE){
    array_push($a,$neighbourID);
    $memcache->set($key1,$a,false,86400);
    }

 $query="INSERT INTO `neighbours` VALUES('$neighbourID','$countryID')";
 $result=MYSQL_QUERY($query);
 if ($neigh_2==TRUE){
    array_push($b,$countryID);
    $memcache->set($key2,$b,false,86400);
    }

}

//Удаление соседа из списка соседей
function remNeighbour($countryID,$neighbourID){

 global $memcache;
 $key1=_PREFIKS.':neighs'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $neigh_1 = TRUE; else $neigh_1 = FALSE;
 $key2=_PREFIKS.':neighs'.$neighbourID;
 if (($b=$memcache->get($key2))!==FALSE) $neigh_2 = TRUE; else $neigh_2 = FALSE;

 $countryID=addslashes($countryID);
 $neighbourID=addslashes($neighbourID);

 $query="DELETE FROM `neighbours` WHERE countryID='$countryID' AND neighbourID='$neighbourID'";
 $result=@MYSQL_QUERY($query);

 if ($neigh_1==TRUE){
    $newn = array();
    for ($i=0;$i<count($a);$i++){
        if ($a[$i]!=$neighbourID)array_push($newn,$a[$i]);
        }
    $memcache->set($key1,$newn,false,86400);
    }

 $query="DELETE FROM `neighbours` WHERE countryID='$neighbourID' AND neighbourID='$countryID'";
 $result=@MYSQL_QUERY($query);

 if ($neigh_2==TRUE){
    $newn = array();
    for ($i=0;$i<count($b);$i++){
        if ($b[$i]!=$countryID)array_push($newn,$b[$i]);
        }
    $memcache->set($key2,$newn,false,86400);
    }

}

//Добавление соседа в список союзников
function setUnitee($countryID,$uniteeID){

 global $memcache;
 $key1=_PREFIKS.':unite'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $unite_1 = TRUE; else $unite_1 = FALSE;
 $key2=_PREFIKS.':unite'.$uniteeID;
 if (($b=$memcache->get($key2))!==FALSE) $unite_2 = TRUE; else $unite_2 = FALSE;

 $countryID=addslashes($countryID);
 $uniteeID=addslashes($uniteeID);

 $query="INSERT INTO `unite` VALUES('$countryID','$uniteeID')";
 $result=@MYSQL_QUERY($query);

 if ($unite_1==TRUE){
    array_push($a,$uniteeID);
    $memcache->set($key1,$a,false,86400);
    }

 $query="INSERT INTO `unite` VALUES('$uniteeID','$countryID')";
 $result=@MYSQL_QUERY($query);

 if ($unite_2==TRUE){
    array_push($b,$countryID);
    $memcache->set($key2,$b,false,86400);
    }

}

//Удаление соседа из списка союзников
function remUnitee($countryID,$uniteeID){

 global $memcache;
 $key1=_PREFIKS.':unite'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $unite_1 = TRUE; else $unite_1 = FALSE;
 $key2=_PREFIKS.':unite'.$uniteeID;
 if (($b=$memcache->get($key2))!==FALSE) $unite_2 = TRUE; else $unite_2 = FALSE;

 $countryID=addslashes($countryID);
 $uniteeID=addslashes($uniteeID);

 $query="DELETE FROM `unite` WHERE countryID='$countryID' AND uniteeID='$uniteeID'";
 $result=MYSQL_QUERY($query);

 if ($unite_1==TRUE){
    $newn = array();
    for ($i=0;$i<count($a);$i++){
        if ($a[$i]!=$uniteeID)array_push($newn,$a[$i]);
        }
    $memcache->set($key1,$newn,false,86400);
    }

 $query="DELETE FROM `unite` WHERE countryID='$uniteeID' AND uniteeID='$countryID'";
 $result=MYSQL_QUERY($query);

 if ($unite_2==TRUE){
    $newn = array();
    for ($i=0;$i<count($b);$i++){
        if ($b[$i]!=$countryID)array_push($newn,$b[$i]);
        }
    $memcache->set($key2,$newn,false,86400);
    }

}

//Получаем соседей
//Все из базы, т.к. ф-я запускается только после создания страны и никогда больше
function getNeighbours($countryID){
 $neighcount=5;
 $countryID=addslashes($countryID);

 $query="SELECT countries.countryID FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)and(countries.countryID!='".$countryID."') ORDER BY reggedTime desc LIMIT 3";
 $result=@mysql_query($query);

 $country=checkCountryID($countryID);
 //Возвращает имя страны
 while (($a=mysql_fetch_array($result))!==FALSE){
         setNeighbour($countryID,$a[0]);
         sendMessage($a[0],"newNeighbour","$country");
         }

}


//Возвращаем id по имени страны
//Все из базы, т.к. не задан ключ ID
function getCountryID($countryName){

 //Функция возвращает ID страны по ее WIN-имени (имени в кодировке win)
 //$countryName=iconv('utf-8','cp1251',addslashes($countryName));

 $query="select countryID from `countries` where countryName='$countryName' LIMIT 1";
 $result=@MYSQL_QUERY($query);
 $ret=@mysql_result($result,0,"countryID");
 return $ret;

}

//Идет ли война или нет?
function war_between($countryID,$targetID){

 global $memcache;
 $key1=_PREFIKS.':wars'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $war_m = TRUE; else $war_m = FALSE;

 $countryID=addslashes($countryID);
 $targetID=addslashes($targetID);

 if ($war_m==TRUE){
    $num=0;
    for ($i=0;$i<count($a);$i++){
        if ($a[$i]['targetID']==$targetID){$num=1;break;}
        }
    }else{
 $query="select count(*) as num from `wars` where (countryID='$countryID' and targetID='$targetID') or (countryID='$targetID' and targetID='$countryID') LIMIT 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 $num=$a['num'];
 }

 if($num>0){
  return true;
 }else{
  return false;
 }


}

//Возвращаем список соседей
function returnNeighbours($countryID,$dfg=''){

 global $memcache;
 $key1=_PREFIKS.':neighs'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $neigh_m = TRUE; else $neigh_m = FALSE;
 $neigh_m = FALSE;
 $countryID=addslashes($countryID);
 $arrNeigh = array();

 /*if ($neigh_m==TRUE){
    for ($i=0;$i<count($a);$i++){
        $cname = checkCountryID($a[$i]);
        array_push($arrNeigh,$cname);
        }
    }else{*/
 $query = "SELECT countries.countryName,countries.countryID FROM countries,`neighbours` WHERE (neighbours.countryID = '".$countryID."')and(countries.countryID=neighbours.neighbourID)";
 $result = mysql_query($query);
 while (($a=mysql_fetch_array($result))!==FALSE){

         if($dfg=='')$cname = $a[0];
         else $cname = $a[1];
         array_push($arrNeigh,$cname);
         }

// }

 return $arrNeigh;

}

//А не союзное ли ето государство?
function is_unitee($countryID,$uniteeID){

 global $memcache;
 $key1=_PREFIKS.':unite'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $unite_m = TRUE; else $unite_m = FALSE;

 $countryID=addslashes($countryID);
 $uniteeID=addslashes($uniteeID);

 if ($unite_m==TRUE){
    $num=0;
    for ($i=0;$i<count($a);$i++){
        if ($a[$i]==$uniteeID){$num=1;break;}
        }
    }else{

 $query="select count(*) as num from `unite` where countryID='$countryID' and uniteeID='$uniteeID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 $num=$a['num'];
 }

 if($num>0){
  return true;
 }else{
  return false;
 }

}

//А не соседнее ли ето государство?
function neighbour_exists($countryID,$neighbourID){

 global $memcache;
 $key1=_PREFIKS.':neighs'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $neigh_m = TRUE; else $neigh_m = FALSE;

 $countryID=addslashes($countryID);
 $neighbourID=addslashes($neighbourID);

 if ($neigh_m==TRUE){
    $num=0;
    for ($i=0;$i<count($a);$i++){
        if ($a[$i]==$neighbourID){$num=1;break;}
        }
    }else{

 $query="select count(*) as num from `neighbours` where countryID='$countryID' and neighbourID='$neighbourID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 $num=$a['num'];
 }

 if($num>0){
  return true;
 }else{
  return false;
 }

}

//получаем уровень профессиональности юнита
function get_unit_lvl($countryID,$unit){

 $countryID=addslashes($countryID);

 $query="select $unit from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $unit_lvl=@mysql_result($result,0,"$unit");
 //$unit_lvl = $_SESSION["$unit"];

 return $unit_lvl;

}

//Инфа о генерале
function general_info($countryID){

 global $memcache;
 $key1=_PREFIKS.':general'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $gen_m = TRUE; else $gen_m = FALSE;

 $countryID=addslashes($countryID);

 if ($gen_m==TRUE){
  $ret = $a;
  if ($ret!='')return $ret;
  else return FALSE;
    }else{
 $query="select * from `general` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $num=@mysql_num_rows($result);

 if($num>0){
  $ret = mysql_fetch_array($result);
  return $ret;
 }else{
  return false;
 }
 }



}

//А действует ли на страну мараторий ненападения
function maratory($countryID){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($a=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

 $countryID=addslashes($countryID);

 if ($id_m==TRUE){
 $regged_time = $a['reggedTime'];
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 $regged_time=$a["reggedTime"];
 $query="select maratory from `uzers` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 $a['mrt'] = $b['maratory'];
 }

 $regged_time=$regged_time+21600;

 //Ночной мараторий
 $nightmar = FALSE;
 if ($a['mrt']>18){
    if (date("G")+0>=$a['mrt']||date("G")+0<($a['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$a['mrt']&&date("G")+0<=($a['mrt']+5)) $nightmar = TRUE;
    }
 if ($a['mrt']==25) $nightmar=FALSE;

 if ($nightmar==TRUE){
    if (date("G")+0>=$a['mrt']) $tleft = 3600*6-((date("G")-$a['mrt'])*3600+date("i")*60+date("s"));
    if (date("G")+0<$a['mrt']) $tleft = (($a['mrt']+6)%24-1-date("G"))*3600+(59-date("i"))*60+59-date("s");
    $regged_time = time()+$tleft;
    }

 //Покупной мораторий
 if ($a['moratory']>time()) $regged_time = $a['moratory'];

 if(time()<=$regged_time){
  return ($regged_time-time());
 }else{
  return false;
 }

}

//Проиграл!
function looser($countryID,$killerID=""){

 global $memcache;

 $countryID=addslashes($countryID);

 $country=checkCountryID($countryID);
 //Если у страны есть сохранение, пишем время удаления/проигрыша страны
 mysql_query("UPDATE `saves` SET lastDied = '".time()."' WHERE countryID = '$countryID' LIMIT 1");

 //Получаем имя страны

 $query="delete from `market` where countryID='$countryID'";
 $result=@MYSQL_QUERY($query);
 $key=_PREFIKS.':market'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $query="delete from `works` where countryID='$countryID'";
 $result=@MYSQL_QUERY($query);
 $key=_PREFIKS.':works'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 $key=_PREFIKS.':neighs'.$countryID;
 if (($a=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($a);$i++){
        $neighbourID = $a[$i];
 //Пишем в лог, что был такой сосед:
 $open=fopen("logs/sos".$neighbourID,"a+");
 if ($open==FALSE) $open=fopen("../logs/sos".$neighbourID,"a+");
 if ($open==FALSE) $open=fopen(_ROOT."/logs/sos".$neighbourID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$country."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

        sendMessage($neighbourID,"fullMessage","Соседа <u>$country</u> больше нет!");
        //Удаляем из соседей проигравшую страну (из мемкеша)
        $key2=_PREFIKS.':neighs'.$neighbourID;
        if (($b=$memcache->get($key2))!==FALSE){
           $newn=array();
           for ($j=0;$j<count($b);$j++)if ($b[$j]!=$countryID)array_push($newn,$b[$j]);
           $memcache->set($key2,$newn,false,86400);
           }
        }
    $memcache->delete($key);
    }else{

 $query="select neighbourID from neighbours where countryID='$countryID'";
 $result=@MYSQL_QUERY($query);
 while (($a=mysql_fetch_array($result))!==FALSE){
         $neighbourID = $a['neighbourID'];
 //Пишем в лог, что был такой сосед:
 $open=fopen("logs/sos".$neighbourID,"a+");
 if ($open==FALSE) $open=fopen("../logs/sos".$neighbourID,"a+");
 if ($open==FALSE) $open=fopen(_ROOT."/logs/sos".$neighbourID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$country."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

         sendMessage($neighbourID,"fullMessage","Соседа <u>$country</u> больше нет!");
         //Удаляем из соседей проигравшую страну (из мемкеша)
        $key2=_PREFIKS.':neighs'.$neighbourID;
        if (($b=$memcache->get($key2))!==FALSE){
           $newn=array();
           for ($j=0;$j<count($b);$j++)if ($b[$j]!=$countryID)array_push($newn,$b[$j]);
           $memcache->set($key2,$newn,false,86400);
           }
         }
 }

 $query="delete from `neighbours` where countryID='$countryID'";
 $result=@MYSQL_QUERY($query);
 $query="delete from `neighbours` where neighbourID='$countryID'";
 $result=@MYSQL_QUERY($query);

 $key=_PREFIKS.':wars'.$countryID;
 if (($a=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($a);$i++){
        $targetID = $a[$i]['targetID'];
        sendMessage($targetID,"fullMessage","Ваш противник <u>$country</u> проиграл!");
        }
    $memcache->delete($key);
    //Удаляем войны, которые вела страна (ее нападения)
    }else{
 $query="select targetID from `wars` where countryID='$countryID'";
 $result=@MYSQL_QUERY($query);
 while (($a=mysql_fetch_array($result))!==FALSE){
         $targetID = $a['targetID'];
         sendMessage($targetID,"fullMessage","Ваш противник <u>$country</u> проиграл!");
         }

 }


 $query="delete from `wars` where countryID='$countryID'";
 $result=MYSQL_QUERY($query);

 //Тут на мемкеше никак, т.к. не задать ключ

 $query="select countryID,wariors,wariors_2,wariors_3,wariors_4,wariors_5,wariors_6,wariors_7,wariors_8 from `wars` where targetID='$countryID'";
 $result=MYSQL_QUERY($query);
 while (($a=mysql_fetch_array($result))!==FALSE){
         $attackerID=$a['countryID'];
         $wariors=$a['wariors'];
         $wariors_2=$a['wariors_2'];
         $wariors_3=$a['wariors_3'];
         $wariors_4=$a['wariors_4'];
         $wariors_5=$a['wariors_5'];
         $wariors_6=$a['wariors_6'];
         $wariors_7=$a['wariors_7'];
         $wariors_8=$a['wariors_8'];
         mysql_query("UPDATE countries SET wariors_free = wariors_free + $wariors,
         wariors_free_2 = wariors_free_2 + $wariors_2, wariors_free_3 = wariors_free_3 + $wariors_3,
         wariors_free_4 = wariors_free_4 + $wariors_4, wariors_free_5 = wariors_free_5 + $wariors_5,
         wariors_free_6 = wariors_free_6 + $wariors_6, wariors_free_7 = wariors_free_7 + $wariors_7,
         wariors_free_8 = wariors_free_8 + $wariors_8
         WHERE countryID='".$attackerID."' LIMIT 1");
         $key=_PREFIKS.':id'.$attackerID;
         if (($b=$memcache->get($key))!==FALSE){
            //$b['wariors_atall'] = $b['wariors_atall'] + $wariors;
            //$b['wariors_atall_2'] = $b['wariors_atall_2'] + $wariors_2;
            //$b['wariors_atall_3'] = $b['wariors_atall_3'] + $wariors_3;
            $b['wariors_free'] = $b['wariors_free'] + $wariors;
            $b['wariors_free_2'] = $b['wariors_free_2'] + $wariors_2;
            $b['wariors_free_3'] = $b['wariors_free_3'] + $wariors_3;
            $b['wariors_free_4'] = $b['wariors_free_4'] + $wariors_4;
            $b['wariors_free_5'] = $b['wariors_free_5'] + $wariors_5;
            $b['wariors_free_6'] = $b['wariors_free_6'] + $wariors_6;
            $b['wariors_free_7'] = $b['wariors_free_7'] + $wariors_7;
            $b['wariors_free_8'] = $b['wariors_free_8'] + $wariors_8;
            $memcache->set($key,$b,false,86400);
            }
         $key=_PREFIKS.':wars'.$attackerID;
         if (($b=$memcache->get($key))!==FALSE){
            $neww=array();
            for ($i=0;$i<count($b);$i++){
                if ($b[$i]['targetID']!=$countryID) array_push($neww,$b[$i]);
                }
            $memcache->set($key,$neww,false,86400);
            }
         sendMessage($attackerID,"fullMessage","Ваш противник <u>$country</u> проиграл! Воинов вернулось:<br/>".print_voisko(array($wariors,$wariors_2,$wariors_3,$wariors_4,$wariors_5,$wariors_6,$wariors_7,$wariors_8)));
         }

 $query="delete from `wars` where targetID='$countryID'";
 $result=MYSQL_QUERY($query);

 $query="delete from `general` where countryID='$countryID'";
 $result=MYSQL_QUERY($query);
 $key=_PREFIKS.':general'.$countryID;
 if (($a=$memcache->get($key))!==FALSE)$memcache->delete($key);

 $key=_PREFIKS.':unite'.$countryID;
 if (($a=$memcache->get($key))!==FALSE){
 for ($i=0;$i<count($a);$i++){
     $uniteeID=$a[$i];
     sendMessage($uniteeID,"fullMessage","Ваш союзник <u>$country</u> проиграл!");
     }
 $memcache->delete($key);
    }else{

 $query="select uniteeID from `unite` where countryID='$countryID'";
 $result=MYSQL_QUERY($query);
 while (($a=mysql_fetch_array($result))!==FALSE){
         $uniteeID=$a['uniteeID'];
         sendMessage($uniteeID,"fullMessage","Ваш союзник <u>$country</u> проиграл!");
         }

 }

 $r = mysql_query("SELECT * FROM `unite` WHERE uniteeID = '$countryID'");
 while (($a=mysql_fetch_array($r))!==FALSE){
       $uniteeID = $a['countryID'];
       $key=_PREFIKS.':unite'.$uniteeID;
       if (($b=$memcache->get($key))!==FALSE){
          $newu = array();
          for ($i=0;$i<count($b);$i++) if ($b[$i]!=$countryID) array_push($newu,$b[$i]);
          $memcache->set($key,$newu,false,86400);
          }
       }

 $query="delete from `unite` where countryID='$countryID' or uniteeID='$countryID'";
 $result=MYSQL_QUERY($query);

 //Удаляем гос-во из клана
 $key=_PREFIKS.':clans'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
 $clanID=$mem;
    }else{
 $r=mysql_query("SELECT * FROM `uzers` WHERE countryID = '$countryID' LIMIT 1");
 $b=mysql_fetch_array($r);
 $clanID=$b['clanID'];
 }

 if ($clanID!=0){
    //Удаляем войска из осады/защиты замка, если они есть:
    mysql_query("DELETE FROM `zamok_defence` WHERE countryID = '$countryID'");
    mysql_query("DELETE FROM `zamok_attack` WHERE countryID = '$countryID'");

    //mysql_query("UPDATE `uzers` SET clanID = 0 WHERE countryID = '$countryID'");
   /* $key=_PREFIKS.':clans'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       $mem = 0;
       $memcache->set($key,$mem,false,86400);
       } */
    $r = mysql_query("SELECT count(*) as num FROM `uzers` WHERE clanID = '$clanID'");
    $s = mysql_fetch_array($r);
    if ($s['num']==0){
            //Клана больше нет
       mysql_query("DELETE FROM `clans` WHERE id = '$clanID'");
       }
    }

 if ($killer=@checkCountryID($killerID)){
  sendMessage($countryID,"loose",$killer);
 }else{
  sendMessage($countryID,"loose","");
 }
}



























































//work_func.php (РАБОЧИЕ ФУНКЦИИ)
//Транслитерация в утф
function translit($str){
        //из транслита в русский (утф)
                $str=str_replace("ch","С‡",$str);
                $str=str_replace("sc","С‰",$str);
                $str=str_replace("ye","СЌ",$str);
                $str=str_replace("yu","СЋ",$str);
                $str=str_replace("ya","СЏ",$str);
                $str=str_replace("CH","Р§",$str);
                $str=str_replace("SC","Р©",$str);
                $str=str_replace("YE","Р­",$str);
                $str=str_replace("YU","Р®",$str);
                $str=str_replace("YA","РЇ",$str);
                $str=str_replace("\'\'","Р¬",$str);
                $str=str_replace("\"","СЉ",$str);
                $str=str_replace("\'","СЊ",$str);
$str=strtr($str,array("a"=>"Р°","b"=>"Р±","v"=>"РІ","g"=>"Рі","d"=>"Рґ","e"=>"Рµ","q"=>"С‘","j"=>"Р¶","z"=>"Р·","i"=>"Рё","y"=>"Р№","k"=>"Рє","l"=>"Р»","m"=>"Рј","n"=>"РЅ","o"=>"Рѕ","p"=>"Рї","r"=>"СЂ","s"=>"СЃ","t"=>"С‚","u"=>"Сѓ","f"=>"С„","h"=>"С…","c"=>"С†","w"=>"С€","x"=>"С‹","A"=>"Рђ","B"=>"Р‘","V"=>"Р’","G"=>"Р“","D"=>"Р”","E"=>"Р•","Q"=>"РЃ","J"=>"Р–","Z"=>"Р—","I"=>"Р?","Y"=>"Р™","K"=>"Рљ","L"=>"Р›","M"=>"Рњ","N"=>"Рќ","O"=>"Рћ","P"=>"Рџ","R"=>"Р ","S"=>"РЎ","T"=>"Рў","U"=>"РЈ","F"=>"Р¤","H"=>"РҐ","C"=>"Р¦","W"=>"РЁ","X"=>"Р«"));
                return $str;
                }


//Критерий развитости страны
function is_developed($countryID){

 global $memcache;
 $key=_PREFIKS.':id'.$countryID;
 $whole = FALSE;

 if (($a=$memcache->get($key))!==FALSE){
 if ($a['spy']>15&&$a['grabber']>15&&$a['sabotage']>15&&$a['verb']>=15&&$a['land']>2000) $whole=TRUE;
 return $whole;
         }else{
 $r = mysql_query("SELECT spy,grabber,sabotage,verb,land FROM `countries` WHERE countryID = '$countryID'");
 $a = mysql_fetch_array($r);
 if ($a['spy']>15&&$a['grabber']>15&&$a['sabotage']>15&&$a['verb']>=15&&$a['land']>2000) $whole=TRUE;
 return $whole;
 }
        }


function getmicrotime(){
        list($usec, $sec) = explode(chr(32), microtime());
        return ((float)$usec + (float)$sec);
        }

		function getmicrotime_new(){
        list($usec, $sec) = explode(chr(32), microtime());
        return ((float)$usec + (float)$sec);
        }



function getInfo($countryID){
        //Получение инфы о стране с id=countryID на основе БД
        $countryID = addslashes($countryID);
        $query = "SELECT * FROM countries WHERE countryID = '".$countryID."'";
        $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
        $a = mysql_fetch_array($result);
        return $a;
        }

function sesinit(){
global $mgates_data, $mgates_info;


	if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' AND $_GET['qtest'] == 1)
	{
	/*session_unset();
	session_destroy();
	print "destroyeed";
	die("ok.");
	*/
	if ($_GET['qtest'] == 1)
	print_r($_SERVER);

	session_start();

	if (!isset($_SESSION['id_user']))
		$_SESSION['id_user'] = 0;
	if (!isset($_SESSION['user_info']))
		$_SESSION['user_info'] = array();
	if (!isset($_SESSION['sid_value']))
		$_SESSION['sid_value'] = '';
	if (!isset($_SESSION['sid_expire']))
		$_SESSION['sid_expire'] = time()+24*60*60;

	if (!empty($_GET['logout']))
	{
		$_SESSION['id_user'] = 0;
		$_SESSION['user_info'] = array();
		$_SESSION['sid_value'] = '';
	}

	if (!empty($_GET['sid']))
	{
		$_SESSION['id_user'] = 0;
		$_SESSION['sid_value'] = $_GET['sid'];
		$_SESSION['sid_expire'] = time()+24*60*60;
		$_SESSION['user_info'] = array();
	}
	if ($_SESSION['id_user'] && $_SESSION['sid_value'] && ($_SESSION['sid_expire'] < time()))
	{
		$_SESSION['id_user'] = 0;
		$_SESSION['user_info'] = array();
	}
	include_once '/var/www/imperia/data/www/imperia.mobi/api/mgates-class.php';
	global $mgates;
	$mgates = new MGates($mgates_params);

	if (!$_SESSION['id_user'] && $_SESSION['sid_value'])
	{
		$res = $mgates->getUserInfo($_SESSION['sid_value']);
		$_SESSION['sid_value'] = "";
		if ($res)
		{
			$_SESSION['id_user'] = $res['id'];
			$_SESSION['sid_value'] = $res['sid'];
			$_SESSION['sid_expire'] = time()+24*60*60;
			$_SESSION['user_info'] = $res;
			$_SESSION['mgates_info'] = $mgates->getMiscInfo($_SESSION['sid_value']);
		}
	}

	if (empty($_SESSION['mgates_info']))
		$_SESSION['mgates_info'] = $mgates->getMiscInfo();

?>


<?php
	if ($_SESSION['id_user'])
	{
?>


	<?php
	$mtt=time();
	if ($_SESSION['mgates_data']=='' OR $_SESSION['mgates_last']+180 < $mtt)
	{
	$mgates_data= $mgates->getWidgets($_SESSION['sid_value']);
	$_SESSION['mgates_data']=$mgates_data;
	$_SESSION['mgates_last']=$mtt;
	}
	else{
	$mgates_data=$_SESSION['mgates_data'];
	}

//	printrus($mgates_data[header]);
	//$mgates_info= $mgates->getUserInfo($_SESSION['sid_value']);

		//print_r($_SESSION);
		$mid=$_SESSION[user_info][id];

		$mc=mysql_fetch_array(mysql_query("SELECT COUNT(id) AS cc FROM mgates WHERE mgates_sid='$mid'"));
		//print "SELECT COUNT(id) AS cc FROM mgates WHERE mgates_sid='". $_SESSION['sid_value'] ."'";
		//print "mc -";
		//print_r($mc);
		if ($mc['cc'] == 0)
		{
		if ($_SESSION['userID'] <> '' AND $_SESSION['countryID'] <> '')
		mysql_query("INSERT INTO mgates(mgates_sid, user_id, country_id) VALUES('$mid', '". $_SESSION['userID'] ."', '". $_SESSION['countryID'] ."' )");
		}
		else
		{
		$ms=mysql_fetch_array(mysql_query("SELECT * FROM mgates WHERE mgates_sid='$mid'"));
		//print "SELECT * FROM mgates WHERE mgates_sid='". $_SESSION['sid_value'] ."'";
		//print "ms  - ";
		//print_r($ms);
		//$_SESSION['countryID']=$ms['country_id'];
		$_SESSION['auth']='1';
		$_SESSION['userID']=$ms['user_id'];
		}

	?>


<?php
	}
?>












	<?php

	}


        // Инициализация сессии
GLOBAL $ses;
GLOBAL $memcache;
         $ref = rand(0,999999999);
         setcookie("civilla","true");

          if($_COOKIE['civilla']!=true){
         ini_set('session.use_cookies','0');
         ini_set('session.use_trans_sid','0');
         ini_set('url_rewriter.tags','');
         session_name("clv");
         session_start();
         $ses=SID;
         $ses="$ses&amp;$ref"; }
         else{
         ini_set('session.use_cookies','1');
         ini_set('session.use_trans_sid','0');
         ini_set('url_rewriter.tags','');
         ini_set('session.cookie_lifetime', '0');
         session_name("clv");
         session_start();
         $ses="$ref";
         }

if($_SESSION['time_control']>microtime(1))
sleep(1);
$_SESSION['time_control']=microtime(1)+1;
//Проверка, есть ли данные мемкеша:
if (isset($_SESSION['auth']) && isset($_SESSION['countryID'])){
$countryID = $_SESSION['countryID'];


$key=_PREFIKS.':id'.$countryID;
if (($mem=$memcache->get($key))===FALSE || ($mem2=$memcache->get(_PREFIKS.':clans'.$countryID))===FALSE){
$query="SELECT maratory,countryID,inv,noob,clanID,userID,blocked FROM uzers WHERE countryID='$countryID' LIMIT 1";
$result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
$a = mysql_fetch_array($result);
$mrt = $a['maratory'];
$clanID = $a['clanID'];

$info = getInfo($countryID);
//Получаем всю инфу о стране из базы
$info['inv']=$a['inv'];
$info['blocked']=$a['blocked'];

$info['mrt']=$mrt;
$memcache->set($key,$info,false,86400);
//На сутки все в мемкеш
$key=_PREFIKS.':clans'.$countryID;
$memcache->set($key,$clanID,false,86400);
}

$key=_PREFIKS.':neighs'.$countryID;
if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу о соседях
  $r = mysql_query("SELECT neighbourID FROM `neighbours` WHERE countryID = '$countryID'");
  $neighs = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($neighs,$a['neighbourID']);
          }
 // $memcache->set($key,$neighs,false,86400);
}


  $key=_PREFIKS.':unite'.$countryID;
  if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу о союзах
  $r = mysql_query("SELECT uniteeID FROM `unite` WHERE countryID = '$countryID'");
  $un = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($un,$a['uniteeID']);
          }
  $memcache->set($key,$un,false,86400);
  }

  $key=_PREFIKS.':works'.$countryID;
  if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу о работах
  $r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID'");
  $works = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($works,$a);
          }
  $memcache->set($key,$works,false,86400);
  }

  $key=_PREFIKS.':wars'.$countryID;
  if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу о войнах (на таблицу атак забиваем - нах не нужна)
  $r = mysql_query("SELECT * FROM `wars` WHERE countryID = '$countryID'");
  $wars = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($wars,$a);
          }
  $memcache->set($key,$wars,false,86400);
  }

  $key=_PREFIKS.':buildings'.$countryID;
  if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу о зданиях
  $r = mysql_query("SELECT * FROM `buildings` WHERE countryID = '$countryID'");
  $buildings = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($buildings,$a);
          }
  $memcache->set($key,$buildings,false,86400);
  }

  $key=_PREFIKS.':messages'.$countryID;
  if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу о сообщениях
  $r = mysql_query("SELECT * FROM `messages` WHERE countryID = '$countryID' order by tm asc");
  $messages = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($messages,$a);
          }
  $memcache->set($key,$messages,false,86400);
  }

  $key=_PREFIKS.':general'.$countryID;
  if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу о генерале
  $r = mysql_query("SELECT * FROM `general` WHERE countryID = '$countryID' LIMIT 1");
  $a = mysql_fetch_array($r);
  if ($a===FALSE) $a='';
  $memcache->set($key,$a,false,86400);
  }

  $key=_PREFIKS.':market'.$countryID;
  if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу о рынке
  $r = mysql_query("SELECT * FROM `market` WHERE countryID = '$countryID'");
  $market = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($market,$a);
          }
  $memcache->set($key,$market,false,86400);
  }

  $key=_PREFIKS.':otkrytiya'.$countryID;
  if (($mem=$memcache->get($key))===FALSE){
  //Вставляем в мемкеш инфу об случайных открытиях
  $r = mysql_query("SELECT * FROM `otkrytiya` WHERE countryID = '$countryID'");
  $ot = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($ot,$a);
          }
  $memcache->set($key,$ot,false,86400);
  }

   }
		if(isset($_SESSION['dies']) AND $_SERVER['PHP_SELF'] <> '/profile.php' AND $_SERVER['PHP_SELF'] <> '/bonus.php') {

			if ($_SERVER[HTTP_HOST] == 'imperia2.mgates.ru')
			{
			setcookie('PHPSESSID', '');
			header('Location: http://spaces.ru/app/?sid=&enter=48');
			die();
			unset($_SESSION['dies']);
			}else{

		global $dddd; header("Location: profile.php$dddd");
		}

		}
        }

function CountryInfo($countryID){
//Получение инфы о стране с id=countryID на основе мемкеш или БД
//в $id_m пишется TRUE, если данные взяты из мемкеша и FALSE, если из БД
//global $memcache,$id_m,$key1,$lnk;
global $memcache,$lnk;

  $key1=_PREFIKS.':id'.$countryID;
  if(($a=$memcache->get($key1))!==FALSE){
  //$id_m=TRUE;
  $lnk=TRUE;
  return $a;
  }else{
  //$id_m=FALSE;
  $lnk=FALSE;
  //Получаем всю инфу о стране из базы
  $info = getInfo($countryID);
  //Инфа о маратории
  $query="select maratory from `uzers` where countryID='$countryID' limit 1";
  $result=@MYSQL_QUERY($query);
  $a = mysql_fetch_array($result);
  $info['mrt'] = $a['maratory'];
  return $info;
  }

}

//Авторизован ли юзер?
function isAuthed(){
global $b,$ses,$id_m,$key1,$lnk; //В $b - инфа о стране

$key1=_PREFIKS.':id'.$_SESSION['countryID'];
$id_m=$lnk;

if(isset($_SESSION['auth'])){
  $tm = time();
  if (isset($_COOKIE['cl']))$cl = base64_decode($_COOKIE['cl']); else $cl='';
  mysql_query("UPDATE `uzers` SET onlineFlag = ($tm+3600), lastsessid = '$ses', cnts = '$cl' WHERE countryID = '".$b['countryID']."' LIMIT 1");
//
//printrus ("В 00:30 сервер будет временно недоступен в связи с переездом на новый.<br/>");
//
/*  $r = mysql_query("SELECT * FROM uzers WHERE countryID = '".$_SESSION['countryID']."'");
  $a = mysql_fetch_array($r);
  $email = $a['Email']; //email игрока
  if($email=='' && $_SERVER['SCRIPT_NAME']!='/profil.php') printrus ("<a href=\"profile.php?$ses&amp;m=ch_email\" class=\"green\"><span>Сохранить персонажа!</span></a><br/>");*/
//
/*  printrus (date("H:i")."-<u>[".$b['countryName']."]</u>");*/
 /*printrus
("
<a href='http://"._MAINSITE."/game.php?$ses'>обновить</a>
");*/
//  print "<br/>\r\n";
 }else{
  if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru'){  $spid=$_SESSION[user_info][login];
   $regform=
"<div class=\"a\"><img src=\"/img/pic/logo2.png\" alt=\"\" /><br/>
<div class=\"dot\"><b>Великая Империя</b> - бесплатная онлайн игра<br/>
<span style=\"font-family:Georgia\">Онлайн: <b>".online("c")."</b>, всего регистраций: <b>".$num2."</b></span><br/>
</div><br/>
<form name=\"\" action=\"reg.php?sawform=1&amp;sid=$_GET[sid]\" method=\"get\">
<div style=\"text-align : left; \">
<span class=\"green\">Логин (название страны)</span><br/>
<span class=\"low\"><small>Разрешены латинские или русские знаки, цифры кроме 0, символы: !, - и пробел.</small></span></div>
<input class=\"text\" type='text' value='".iconv('utf-8', 'cp1251',$username)."' name='username'/>
<input class=\"button_medium\" type=\"submit\" value=\"Начать игру\"/>
</form>
<small>Я согласен с</small> <a href=\"rules.php\"><small>правилами</small></a> <small>игры</small><br/></div>
";
printrus ($regform);
  }
  else{


$ps = strpos($_SERVER[HTTP_HOST], 'pumpit');
$pumpit=$ps;




	if($pumpit <> 0){
	$tpos=strpos($_SERVER[HTTP_HOST], '.');
	$to_pumpit=substr($_SERVER[HTTP_HOST], $tpos+1);
	header("Location: http://$to_pumpit");
	die();
	}

  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");
  }

  if ( $_SERVER[HTTP_HOST] <> 'imperia.mgates.ru')
  printrus ("<a href='http://"._MAINSITE."/index.php'>Главная</a><br/>\r\n");
  //футер страницы:
  global $mgates_data;
  include_once(_ROOT."/other_inc/footer.php");

  die("");
 }

}

//функа авторизации юзера(возвращает id страны или false)

function authorize($username,$password){

 global $memcache;
 //$username=iconv('utf-8','cp1251',$username);
 if(!cnameisok(iconv('cp1251','utf-8',$username)) or !VALUE_isOK($password)){

  return false;
 }
 $password=md5($password);

 //создаем и отправляем запрос:
 $query="SELECT maratory,countryID,inv,noob,clanID,userID,blocked FROM uzers WHERE UserName='$username' AND Password='$password' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $countryID = $a['countryID'];

 $usersCount=@MYSQL_NUM_ROWS($result);

 if($usersCount>0){
  $ip = getIp2();
  $soft = addslashes(htmlspecialchars(getenv("HTTP_USER_AGENT")));
  //Апдейтим базу на ip+soft:
  mysql_query("UPDATE `countries` SET ip='$ip', soft='$soft' WHERE countryID = '".$a['countryID']."' LIMIT 1");

  //Загоняем в мемкеш данные юзера + в сессию настройки всякие:
  $_SESSION['auth']=1;
  //Авторизировался
  $_SESSION['noob']=$a['noob'];
  //Помощь
  //$_SESSION['inv']=$a['inv'];
  //1-Полный игнор в ассамблее, 2-модер там же, 0-обычный юзер
  $_SESSION['countryID']=$a['countryID'];
  //ID страны
  $clanID=$a['clanID'];
  //ID клана, если он есть
  $_SESSION['userID']=$a['userID'];
  //ID юзера
  $mrt = $a['maratory'];

  mem_connect();
  if(memcache_get($memcache,_PREFIKS.':id'.$countryID) && memcache_get($memcache,_PREFIKS.':messages'.$countryID) && memcache_get($memcache,_PREFIKS.':wars'.$countryID) && memcache_get($memcache,_PREFIKS.':market'.$countryID) && memcache_get($memcache,_PREFIKS.':general'.$countryID) && memcache_get($memcache,_PREFIKS.':works'.$countryID) && memcache_get($memcache,_PREFIKS.':buildings'.$countryID) /*&& memcache_get($memcache,_PREFIKS.':neighs'.$countryID)*/ && memcache_get($memcache,_PREFIKS.':unite'.$countryID) && memcache_get($memcache,_PREFIKS.':clans'.$countryID)){
  //Ночной мараторий
  $key=_PREFIKS.':id'.$countryID;
  $mem = $memcache->get($key);
  $mem['mrt']=$mrt;
  $memcache->set($key,$mem,false,86400);

  //Вставляем в мемкеш инфу о сообщениях
  $r = mysql_query("SELECT * FROM `messages` WHERE countryID = '$countryID' order by tm asc");
  $messages = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($messages,$a);
          }
  $key=_PREFIKS.':messages'.$countryID;
  $memcache->set($key,$messages,false,86400);
  return TRUE;
  }else{

  $info = getInfo($countryID);
  //Получаем всю инфу о стране из базы
  //На основе сессий смотрим, с каких стран сидит
  if (isset($_COOKIE['cl'])){
  $nicks = explode(".",base64_decode($_COOKIE['cl']));
  if (!in_array($info['countryName'],$nicks)){
     $pc = base64_decode($_COOKIE['cl']);
     $nc = $pc.".".$info['countryName'];
     setcookie('cl',base64_encode($nc),time()+3600*24*20);
     }
  }else{
  setcookie('cl',base64_encode($info['countryName']),time()+3600*24*20);
  }

  $info['inv']=$a['inv'];
  $info['blocked']=$a['blocked'];
  if ($info['countryID']==''||!isset($info['countryID'])){
          //Две авторизации - для профайла и для игры
     unset($_SESSION['auth']);
     $_SESSION['auth2'] = 1;
     return TRUE;
     }else{

  $key=_PREFIKS.':id'.$countryID;
  $info['mrt']=$mrt;
  $memcache->set($key,$info,false,86400);
  //На сутки все в мемкеш

  //Вставляем в мемкеш инфу о соседях
  $r = mysql_query("SELECT neighbourID FROM `neighbours` WHERE countryID = '$countryID'");
  $neighs = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($neighs,$a['neighbourID']);
          }
  /*$key=_PREFIKS.':neighs'.$countryID;
  $memcache->set($key,$neighs,false,86400);
  */
  //Вставляем в мемкеш инфу о союзах
  $r = mysql_query("SELECT uniteeID FROM `unite` WHERE countryID = '$countryID'");
  $un = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($un,$a['uniteeID']);
          }
  $key=_PREFIKS.':unite'.$countryID;
  $memcache->set($key,$un,false,86400);

  //Вставляем в мемкеш инфу о работах
  $r = mysql_query("SELECT * FROM `works` WHERE countryID = '$countryID'");
  $works = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($works,$a);
          }
  $key=_PREFIKS.':works'.$countryID;
  $memcache->set($key,$works,false,86400);

  //Вставляем в мемкеш инфу о войнах (на таблицу атак забиваем - нах не нужна)
  $r = mysql_query("SELECT * FROM `wars` WHERE countryID = '$countryID'");
  $wars = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($wars,$a);
          }
  $key=_PREFIKS.':wars'.$countryID;
  $memcache->set($key,$wars,false,86400);
  //Вставляем в мемкеш инфу о зданиях
  $r = mysql_query("SELECT * FROM `buildings` WHERE countryID = '$countryID'");
  $buildings = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($buildings,$a);
          }
  $key=_PREFIKS.':buildings'.$countryID;
  $memcache->set($key,$buildings,false,86400);
  //Вставляем в мемкеш инфу о сообщениях
  $r = mysql_query("SELECT * FROM `messages` WHERE countryID = '$countryID' order by tm asc");
  $messages = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($messages,$a);
          }
  $key=_PREFIKS.':messages'.$countryID;
  $memcache->set($key,$messages,false,86400);
  //Вставляем в мемкеш инфу о генерале
  $r = mysql_query("SELECT * FROM `general` WHERE countryID = '$countryID' LIMIT 1");
  $a = mysql_fetch_array($r);
  if ($a===FALSE) $a='';
  $key=_PREFIKS.':general'.$countryID;
  $memcache->set($key,$a,false,86400);
  //Вставляем в мемкеш инфу о рынке
  $r = mysql_query("SELECT * FROM `market` WHERE countryID = '$countryID'");
  $market = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($market,$a);
          }
  $key=_PREFIKS.':market'.$countryID;
  $memcache->set($key,$market,false,86400);

  //Вставляем в мемкеш инфу об случайных открытиях
  $r = mysql_query("SELECT * FROM `otkrytiya` WHERE countryID = '$countryID'");
  $ot = array();
  while (($a=mysql_fetch_array($r))!==FALSE){
          array_push($ot,$a);
          }
  $key=_PREFIKS.':otkrytiya'.$countryID;
  $memcache->set($key,$ot,false,86400);

  $key=_PREFIKS.':clans'.$countryID;
  $memcache->set($key,$clanID,false,86400);

  }
  return TRUE;
  }

 }else{
  //возвращаем фигу с маргарином)
  return false;
 }

}


//
//создание страны
//$newcountryName - в Вин
function createCountry($oldcountryID,$newcountryName){

 //создаем и отправляем запрос:
 $query="SELECT * FROM uzers WHERE countryID='$oldcountryID' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 //Получаем инфу об юзвере
 $username=@MYSQL_RESULT($result,0,"userName");
 $password=@MYSQL_RESULT($result,0,"Password");
 $userID=@MYSQL_RESULT($result,0,"userID");

 //генерируем id новой страны:
 $newcountryID=generateCountryID($userID,$password,$username,$newcountryName);

 //серия запросов на создание записей в таблицах:
 $query="UPDATE uzers SET countryID='$newcountryID' WHERE countryID='$oldcountryID' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $query="delete from countries where countryID='$oldcountryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $query="delete from messages where countryID='$oldcountryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 unset($_SESSION['dies']);
 $_SESSION['countryID']=$newcountryID;

 if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' ){
 mysql_query ("UPDATE mgates SET country_id = '$newcountryID' WHERE user_id=$_SESSION[userID]");
 }

 @include_once("other_inc/startres.php");
 //$query="INSERT INTO countries VALUES('$newcountryID','$newcountryName',".time().",1,0,".time().",$land,$mountains,$forest,$money,$arbor,$stone,$iron,$grain,$workers,$scientists,'10','10','3','10','10','10','10','10','10',10,10,10,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,0,0,0,0,0,1,0,'','',2)";
 $query="INSERT INTO countries SET countryID = '$newcountryID', countryName = '$newcountryName',
 reggedTime='".time()."', nalog=1, napr=0, lastNal = '".time()."', lastWar = '".time()."', land = $land, mountains=$mountains,
 forest=$forest, money=$money, arbor=$arbor, stone=$stone, iron=$iron, grain=$grain, oil=$oil,
 workers=$workers, scientists=$scientists, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=10, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, weapon_force=1, weapon_force_2=1,
 weapon_force_3=1, weapon_force_4=1, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($newcountryID);

 //Пустышки-соседи
 //1-ый

 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'sysreg'.rand(0,99999999999);
 $countryName = 'Пустынные территории '.$newcountryName;
 $password = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$countryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(0,3);
 $speed = rand(1,3);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$countryName',
 reggedTime='".(time()+1)."', nalog=1, napr=0, lastNal = '".(time()+1)."', lastWar = '".(time()+1)."', land = $land, mountains=$mountains,
 forest=$forest, money=$money, arbor=$arbor, stone=$stone, iron=$iron, grain=$grain, oil=$oil,
 workers=$workers, scientists=$scientists, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=10, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, weapon_force=$force, weapon_force_2=1,
 weapon_force_3=1, weapon_force_4=1, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(5,15);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, space = 100, hits = 100");

 getNeighbours($countryID);
 /*
 //2-ой
 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'sysreg'.rand(0,99999999999);
 $countryName = 'Заброшенные территории '.$newcountryName;
 $password = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$countryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(0,3);
 $speed = rand(1,3);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$countryName',
 reggedTime='".(time()+2)."', nalog=1, napr=0, lastNal = '".(time()+2)."', lastWar = '".(time()+2)."', land = $land, mountains=$mountains,
 forest=$forest, money=$money, arbor=$arbor, stone=$stone, iron=$iron, grain=$grain, oil=$oil,
 workers=$workers, scientists=$scientists, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=10, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, weapon_force=$force, weapon_force_2=1,
 weapon_force_3=1, weapon_force_4=1, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(3,10);
 $guard_2 = rand(1,3);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 getNeighbours($countryID);

  * //gf конец второго
*/

}


//функа замены пароля

function changePassword($countryID,$newpassword){

 //эмдэпятим пароль:
 $newpassword=md5($newpassword);

 //отправляем запрос
 $query="UPDATE uzers SET password='$newpassword', lastMail = '".time()."' WHERE countryID='$countryID' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

}

//
//функа замены мыла

function changeEmail($countryID,$newemail){

 //отправляем запрос
 $query="UPDATE uzers SET Email='$newemail' WHERE countryID='$countryID' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

}

//
//функа замены мыла

function getMail($username,$m='firstEmail'){

 switch($m):
 default:
  $emailkind="Email";
 break;
 case("first"):
  $emailkind="firstemail";
 break;
 endswitch;

 //отправляем запрос
 $query="select $emailkind from uzers where username='$username' LIMIT 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 return @mysql_result($result,0);

}

//Проверка валидности id страны
//Возвращает имя страны в случае, если ID верен и FALSE в противном случае

function checkCountryID($countryID){

 global $memcache;

 $key=_PREFIKS.':id'.$countryID;
  if(($a=$memcache->get($key))!==FALSE){
  return $a['countryName'];
  }else{

 $query="select countryName from `countries` where countryID='$countryID' LIMIT 1";
 $result=MYSQL_QUERY($query);

 if(@mysql_num_rows($result)>0){
  return @mysql_result($result,0);
 }else{
  return false;
 }
 }

}

//Устанавливаем значение для ресурса

function setValue($where,$table,$row,$val,$limit="limit 1",$secure=true){

 $query="update `$table` set $row=$val where $where $limit";
 if($secure){
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 }else{
  $result=MYSQL_QUERY($query);
 }
 $res=@mysql_result($result,0,"$res");

}

//Ползунок для показа позиции в страницах

function bar($max,$value,$lenght=10,$line_mask=":",$bar_mask="|"){

 $err_string="<u>РћС€РёР±РєР°!</u> [function: bar()]";

 $pos=round($lenght*($value/$max));
 if($pos>$lenght){ return $err_string; }

 $positions=round($lenght/$max);

// $ret_string="$pos/".(($value/$max));
 for($i=1;$i<=$lenght;$i++){
  if($i==$pos){
   $ret_string.=$bar_mask;
  }else{
   $ret_string.=$line_mask;
  }
 }
 return $ret_string;

}










































//war_func.php (ФУНКЦИИ ДЛЯ ВОЙНЫ)

//Разрушения здания
function kill_build($countryID,$targetID,$bld){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;
 $key3=_PREFIKS.':wars'.$targetID;
 if (($mc=$memcache->get($key3))!==FALSE) $warst_m = TRUE; else $warst_m = FALSE;
 $key4=_PREFIKS.':general'.$targetID;
 if (($md=$memcache->get($key4))!==FALSE) $gent_m = TRUE; else $gent_m = FALSE;

 if ($idt_m==TRUE){
 $a=$mb;
    }else{
 $r = mysql_query("SELECT * FROM countries WHERE countryID = '".$targetID."'");
 $a = mysql_fetch_array($r);
 }

 if ($id_m==TRUE){
 $b=$ma;
    }else{
 $r = mysql_query("SELECT * FROM countries WHERE countryID = '".$targetID."'");
 $b = mysql_fetch_array($r);
 }
 //$bld=addslashes($bld);

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//замочили науку::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 if($bld=='university' or $bld=='scientificcenter'){
  $b['grain_making'] = max($b['grain_making'],round($a["grain_making"]*0.70));
  $b['arbor_making'] = max($b['arbor_making'],round($a["arbor_making"]*0.70));
  $b['iron_making'] = max($b['iron_making'],round($a["iron_making"]*0.70));
  $b['stone_making'] = max($b['stone_making'],round($a["stone_making"]*0.70));
  $b['forest_adding'] = max($b['forest_adding'],round($a["forest_adding"]*0.70));
  $b['forest_max'] = max($b['forest_max'],round($a["forest_max"]*0.70));
  $b['mountains_max'] = max($b['mountains_max'],round($a["mountains_max"]*0.70));
  $b['oil_making'] = max($b['oil_making'],round($a["oil_making"]*0.70));
  $b['science'] = max($b['science'],round($a["science"]*0.70));
  $b['plotn_people'] = max($b['plotn_people'],round($a["plotn_people"]*0.70));
  $b['plotn_wariors'] = max($b['plotn_wariors'],round($a["plotn_wariors"]*0.70));
  $b['people_adding'] = max($b['people_adding'],round($a["people_adding"]*0.70));
  mysql_query("UPDATE countries SET grain_making = '".$b['grain_making']."', arbor_making = '".$b['arbor_making']."', iron_making = '".$b['iron_making']."', stone_making = '".$b['stone_making']."', forest_adding = '".$b['forest_adding']."', oil_making = '".$b['oil_making']."', forest_max = '".$b['forest_max']."', mountains_max = '".$b['mountains_max']."', science = '".$b['science']."', plotn_people = '".$b['plotn_people']."', plotn_wariors = '".$b['plotn_wariors']."', people_adding = '".$b['people_adding']."' WHERE countryID = '".$countryID."'");
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  $a["grain_making"] = round($a["grain_making"]*4/5);
  $a["arbor_making"] = round($a["arbor_making"]*4/5);
  $a["iron_making"] = round($a["iron_making"]*4/5);
  $a["stone_making"] = round($a["stone_making"]*4/5);
  $a["oil_making"] = round($a["oil_making"]*4/5);
  mysql_query("UPDATE countries SET grain_making = '".$a["grain_making"]."', arbor_making = '".$a["arbor_making"]."', iron_making = '".$a["iron_making"]."', stone_making = '".$a["stone_making"]."', oil_making = '".$a['oil_making']."' WHERE countryID='".$targetID."'");
  if ($idt_m==TRUE){
     $memcache->set($key2,$a,false,86400);
     }

  if($bld=='scientificcenter'){
   $a["forest_adding"] = round($a["forest_adding"]*4/5);
   $a["forest_max"] = round($a["forest_max"]*4/5);
   $a["mountains_max"] = round($a["mountains_max"]*4/5);
   $a["science"] = round($a["science"]*4/5);
   $a["plotn_people"] = round($a["plotn_people"]*4/5);
   $a["plotn_wariors"] = round($a["plotn_wariors"]*4/5);
   $a["people_adding"] = round($a["people_adding"]*4/5);
   mysql_query("UPDATE countries SET forest_adding = '".$a["forest_adding"]."', forest_max = '".$a['forest_max']."', mountains_max='".$a['mountains_max']."', science = '".$a["science"]."', plotn_people = '".$a["plotn_people"]."', plotn_wariors = '".$a["plotn_wariors"]."', people_adding = '".$a["people_adding"]."' WHERE countryID='".$targetID."'");

   if ($idt_m==TRUE){
     $memcache->set($key2,$a,false,86400);
     }
   }

  printrus ("Вы получили доступ к 70% научных разработок этого гос-ва!<br/>\r\n");
  sendMessage($targetID,"fullMessage","Все ваши научные разработки упали на <b>20 %</b>!");


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//замочили здание управления::::::::::::::::::::::::::::::::::::::::::::::::::::
 }elseif($bld=='ratusha' or $bld=='citadel'){

  $money=$a['money'];
  $money_get=round($money*2/5);
  if($money_get>0){
   mysql_query("UPDATE countries SET money = money + $money_get WHERE countryID = '".$countryID."'");
   if ($id_m==TRUE){
      $b['money'] = $b['money'] + $money_get;
      $memcache->set($key1,$b,false,86400);
      }
   mysql_query("UPDATE countries SET money = money - $money_get WHERE countryID = '".$targetID."'");
   if ($idt_m==TRUE){
      $a['money'] = $a['money'] - $money_get;
      $memcache->set($key2,$a,false,86400);
      }

   printrus ("Вы украли <b>$money_get</b>(<b>40 %</b>) денег этого гос-ва!<br/>\r\n");
   sendMessage($targetID,"fullMessage","Вы потеряли <b>$money_get</b>(<b>40 %</b>) своих денег!");

   //Пишем в лог
 @$open=fopen("logs/zah".$b['countryID'],"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName'].'(ip='.$b['ip'].',soft='.$b['soft'].') разрушило ратушу/цитадель '.$a['countryName']."(ip=".$a['ip'].",soft=".$a['soft']."). Денег: ".$a['money']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }
  if ($warst_m==TRUE){
   for ($i=0;$i<count($mc);$i++){
       $wariors = $mc[$i]['wariors'];
       $wariors_2 = $mc[$i]['wariors_2'];
       $wariors_3 = $mc[$i]['wariors_3'];
       $wariors_4 = $mc[$i]['wariors_4'];
       $wariors_5 = $mc[$i]['wariors_5'];
       $wariors_6 = $mc[$i]['wariors_6'];
       $wariors_7 = $mc[$i]['wariors_7'];
       $wariors_8 = $mc[$i]['wariors_8'];
       $t_targetID = $mc[$i]['targetID'];
       sendMessage($t_targetID,"fullMessage","Войско гос-ва <u>".$a['countryName']."</u> покинуло территорию вашего гос-ва!");
       mysql_query("UPDATE countries SET wariors_free = wariors_free + $wariors,
       wariors_free_2 = wariors_free_2 + $wariors_2, wariors_free_3 = wariors_free_3 + $wariors_3,
       wariors_free_4 = wariors_free_4 + $wariors_4, wariors_free_5 = wariors_free_5 + $wariors_5,
       wariors_free_6 = wariors_free_6 + $wariors_6, wariors_free_7 = wariors_free_7 + $wariors_7,
       wariors_free_8 = wariors_free_8 + $wariors_8
       WHERE countryID = '".$targetID."' LIMIT 1");
       if ($idt_m==TRUE){
          $a['wariors_free']=$a['wariors_free'] + $wariors;
          $a['wariors_free_2']=$a['wariors_free_2'] + $wariors_2;
          $a['wariors_free_3']=$a['wariors_free_3'] + $wariors_3;
          $a['wariors_free_4']=$a['wariors_free_4'] + $wariors_4;
          $a['wariors_free_5']=$a['wariors_free_5'] + $wariors_5;
          $a['wariors_free_6']=$a['wariors_free_6'] + $wariors_6;
          $a['wariors_free_7']=$a['wariors_free_7'] + $wariors_7;
          $a['wariors_free_8']=$a['wariors_free_8'] + $wariors_8;
          //Почему не прибавляется общее число военных!? - исправил
          //$a['wariors_atall']=$a['wariors_atall'] + $wariors;
          //$a['wariors_atall_2']=$a['wariors_atall_2'] + $wariors_2;
          //$a['wariors_atall_3']=$a['wariors_atall_3'] + $wariors_3;
          }
       }
  if ($idt_m==TRUE){
  $memcache->set($key2,$a,false,86400);
  }
     }else{

  $query="select wariors,wariors_2,wariors_3,wariors_4,wariors_5,wariors_6,wariors_7,wariors_8,targetID from `wars` where countryID='$targetID'";
  $result=@MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);

  while(($s=mysql_fetch_array($result))!==FALSE){
   $wariors=$s['wariors'];
   $wariors_2=$s['wariors_2'];
   $wariors_3=$s['wariors_3'];
   $wariors_4=$s['wariors_4'];
   $wariors_5=$s['wariors_5'];
   $wariors_6=$s['wariors_6'];
   $wariors_7=$s['wariors_7'];
   $wariors_8=$s['wariors_8'];
   $t_targetID=$s['targetID'];
   sendMessage($t_targetID,"fullMessage","Войско гос-ва <u>".$a['countryName']."</u> покинуло территорию вашего гос-ва!");

   mysql_query("UPDATE countries SET wariors_free = wariors_free + $wariors,
   wariors_free_2 = wariors_free_2 + $wariors_2, wariors_free_3 = wariors_free_3 + $wariors_3,
   wariors_free_4 = wariors_free_4 + $wariors_4, wariors_free_5 = wariors_free_5 + $wariors_5,
   wariors_free_6 = wariors_free_6 + $wariors_6, wariors_free_7 = wariors_free_7 + $wariors_7,
   wariors_free_8 = wariors_free_8 + $wariors_8
   WHERE countryID = '".$targetID."' LIMIT 1");
   if ($idt_m==TRUE){
          $a['wariors_free']=$a['wariors_free'] + $wariors;
          $a['wariors_free_2']=$a['wariors_free_2'] + $wariors_2;
          $a['wariors_free_3']=$a['wariors_free_3'] + $wariors_3;
          $a['wariors_free_4']=$a['wariors_free_4'] + $wariors_4;
          $a['wariors_free_5']=$a['wariors_free_5'] + $wariors_5;
          $a['wariors_free_6']=$a['wariors_free_6'] + $wariors_6;
          $a['wariors_free_7']=$a['wariors_free_7'] + $wariors_7;
          $a['wariors_free_8']=$a['wariors_free_8'] + $wariors_8;
          //$a['wariors_atall']=$a['wariors_atall'] + $wariors;
          //$a['wariors_atall_2']=$a['wariors_atall_2'] + $wariors_2;
          //$a['wariors_atall_3']=$a['wariors_atall_3'] + $wariors_3;
          //То же самое, что и выше: не прибавлялось wariors_atall!
          }

  }
  if ($idt_m==TRUE){
          $memcache->set($key2,$a,false,86400);
          }

  }
  $query="delete from `wars` where countryID='$targetID'";
  $result=@MYSQL_QUERY($query);
  if ($warst_m==TRUE){
     $neww = array();
     $memcache->set($key3,$neww,false,86400);
     }

  //!!!!! Генерал не умирает, когда захватывают ратушу или цитадель

  //if($general=general_info($targetID)){
  // $query="delete from `general` where countryID='$targetID'";
  // $result=@MYSQL_QUERY($query);
  //
  // sendMessage($targetID,"fullMessage","Ваш генерал <b>".addslashes($general['name'])."</b> погиб защищая себя! Теперь вы не можете вести войну!");
  //}


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//замочили военное здание:::::::::::::::::::::::::::::::::::::::::::::::::::::::
 }elseif($bld=='barracks' or $bld=='warhouse'){

  //Данные захватываемой страны
  $weapon_force=$a["weapon_force"];
  $weapon_force_2=$a["weapon_force_2"];
  $weapon_force_3=$a["weapon_force_3"];
  $weapon_speed=$a["weapon_speed"];
  $weapon_speed_2=$a["weapon_speed_2"];
  $weapon_speed_3=$a["weapon_speed_3"];

  //Данные страны-захватчика
  $weapon_force_=$b["weapon_force"];
  $weapon_force__2=$b["weapon_force_2"];
  $weapon_force__3=$b["weapon_force_3"];
  $weapon_speed_=$b["weapon_speed"];
  $weapon_speed__2=$b["weapon_speed_2"];
  $weapon_speed__3=$b["weapon_speed_3"];

  //$b["weapon_force"] = max(round($weapon_force*0.75),$weapon_force_);
  //$b["weapon_force_2"] = max(round($weapon_force_2*0.75),$weapon_force__2);
  //$b["weapon_force_3"] = max(round($weapon_force_3*0.75),$weapon_force__3);
  //$b["weapon_speed"] = max(round($weapon_speed*0.75),$weapon_speed_);
  //$b["weapon_speed_2"] = max(round($weapon_speed_2*0.75),$weapon_speed__2);
  //$b["weapon_speed_3"] = max(round($weapon_speed_3*0.75),$weapon_speed__3);

  $wallboom_protection=$a["protection"];
  $wallboom_protection_=$b["protection"];
  $b['protection'] = max(round($wallboom_protection*0.85),$wallboom_protection_);

  mysql_query("UPDATE countries SET protection = '".$b['protection']."',
  weapon_speed = '".$b["weapon_speed"]."', weapon_speed_2 = '".$b['weapon_speed_2']."',
  weapon_speed_3 = '".$b["weapon_speed_3"]."', weapon_force = '".$b["weapon_force"]."',
  weapon_force_2 = '".$b["weapon_force_2"]."', weapon_force_3 = '".$b["weapon_force_3"]."'
  WHERE countryID = '".$countryID."' LIMIT 1");
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  $mns = $a["wariors"];
  $mns_2 = $a["wariors_2"];
  $mns_3 = $a["wariors_3"];
  $mns_4 = $a["wariors_4"];
  $mns_5 = $a["wariors_5"];
  $mns_6 = $a["wariors_6"];
  $mns_7 = $a["wariors_7"];
  $mns_8 = $a["wariors_8"];
  //Число свободных военных вражеского гос-ва
  mysql_query("UPDATE countries SET
  wariors_free=0, wariors_free_2=0, wariors_free_3=0, wariors_free_4=0, wariors_free_5=0,
  wariors_free_6=0,wariors_free_7=0,wariors_free_8=0,`count`=0
  WHERE countryID = '".$targetID."'");
  if ($idt_m==TRUE){
     $a['wariors_free'] = 0;
     $a['wariors_free_2'] = 0;
     $a['wariors_free_3'] = 0;
     $a['wariors_free_4'] = 0;
     $a['wariors_free_5'] = 0;
     $a['wariors_free_6'] = 0;
     $a['wariors_free_7'] = 0;
     $a['wariors_free_8'] = 0;
     $a['count'] = 0;
     $memcache->set($key2,$a,false,86400);
     }

  printrus ("Вы получили доступ к 85% защиты стенобиток этого гос-ва и уничтожили всех свободных военных и все стенобитные орудия!<br/>\r\n");
  sendMessage($targetID,"fullMessage","Враги уничтожили всех ваших свободных военных и все ваши стенобитные орудия!");


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//замочили торговое здание:::::::::::::::::::::::::::::::::::::::::::::::::::::::
 }elseif($bld=='keeping' or $bld=='market'){

  $max=free_place($countryID);
  $arbor=0;
  $stone=0;
  $iron=0;
  $grain=0;
  $arbor_m=0;
  $stone_m=0;
  $iron_m=0;
  $grain_m=0;
  $oil_m=0;
  if($max>0) {$arbor=min($max,round($a['arbor']*2/5)); $max=$max-$arbor;}
  if($max>0) {$stone=min($max,round($a['stone']*2/5)); $max=$max-$stone;}
  if($max>0) {$iron=min($max,round($a['iron']*2/5)); $max=$max-$iron;}
  if($max>0) {$grain=min($max,round($a['grain']*2/5)); $max=$max-$grain;}
  if($max>0) {$oil=min($max,round($a['oil']*2/5)); $max=$max-$oil;}


  //Если есть место, воруем с рынка:
  if ($max>0){

  $key=_PREFIKS.':market'.$targetID;
  if (($mrkt=$memcache->get($key))!==FALSE){
     for ($i=0;$i<count($mrkt);$i++){
         if ($mrkt[$i]['what']=='arbor'&&$max>0) {$arbor_m=min($max,round($mrkt[$i]['count']*2/5)); $max=$max-$arbor_m;}
         if ($mrkt[$i]['what']=='stone'&&$max>0) {$stone_m=min($max,round($mrkt[$i]['count']*2/5)); $max=$max-$stone_m;}
         if ($mrkt[$i]['what']=='iron'&&$max>0) {$iron_m=min($max,round($mrkt[$i]['count']*2/5)); $max=$max-$iron_m;}
         if ($mrkt[$i]['what']=='grain'&&$max>0) {$grain_m=min($max,round($mrkt[$i]['count']*2/5)); $max=$max-$grain_m;}
         if ($mrkt[$i]['what']=='oil'&&$max>0) {$oil_m=min($max,round($mrkt[$i]['count']*2/5)); $max=$max-$oil_m;}
         }
     $newm=array();
     $memcache->set($key,$newm,false,86400);
     }else{
     $r = mysql_query("SELECT * FROM `market` WHERE countryID = '$targetID'");
     while (($s=mysql_fetch_array($r))!==FALSE){
           if ($s['what']=='arbor'&&$max>0) {$arbor_m=min($max,round($s['count']*2/5)); $max=$max-$arbor_m;}
           if ($s['what']=='stone'&&$max>0) {$stone_m=min($max,round($s['count']*2/5)); $max=$max-$stone_m;}
           if ($s['what']=='iron'&&$max>0) {$iron_m=min($max,round($s['count']*2/5)); $max=$max-$iron_m;}
           if ($s['what']=='grain'&&$max>0) {$grain_m=min($max,round($s['count']*2/5)); $max=$max-$grain_m;}
           if ($s['what']=='oil'&&$max>0) {$oil_m=min($max,round($s['count']*2/5)); $max=$max-$oil_m;}
           }

     }

  }
  $arbor=min($a['arbor'],$arbor);
  $stone=min($a['stone'],$stone);
  $iron=min($a['iron'],$iron);
  $grain=min($a['grain'],$grain);
  $oil=min($a['oil'],$oil);
  mysql_query("UPDATE countries SET arbor = arbor - $arbor,
  stone = stone - $stone, iron = iron - $iron, grain = grain - $grain,
  oil = oil - $oil
  WHERE countryID = '".$targetID."' LIMIT 1");
  if ($idt_m==TRUE){
     $a['arbor'] = max(0,($a['arbor'] - $arbor));
     $a['stone'] = max(0,($a['stone'] - $stone));
     $a['iron'] = max(0,($a['iron'] - $iron));
     $a['grain'] = max(0,($a['grain'] - $grain));
     $a['oil'] = max(0,($a['oil'] - $oil));
     $memcache->set($key2,$a,false,86400);
     }

  $b['arbor'] = $b['arbor'] + $arbor + $arbor_m;
  $b['stone'] = $b['stone'] + $stone + $stone_m;
  $b['iron'] = $b['iron'] + $iron + $iron_m;
  $b['grain'] = $b['grain'] + $grain + $grain_m;
  $b['oil'] = $b['oil'] + $oil + $oil_m;
  mysql_query("UPDATE countries SET arbor = arbor + $arbor + $arbor_m,
  stone = stone + $stone + $stone_m, iron = iron + $iron + $iron_m, grain = grain + $grain + $grain_m,
  oil = oil + $oil + $oil_m
  WHERE countryID = '".$countryID."' LIMIT 1");
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  $query="delete from `market` where countryID='$targetID'";
  $result=@MYSQL_QUERY($query);

  //Пишем в лог
 @$open=fopen("logs/zah".$b['countryID'],"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName'].'(ip='.$b['ip'].',soft='.$b['soft'].') разрушило рынок '.$a['countryName']."(ip=".$a['ip'].",soft=".$a['soft']."). Развитие: nalog=".$a['nalog'].",napr=".$a['napr']."%, money=".$a['money'].", arbor=".$a['arbor'].", stone=".$a['stone'].", grain=".$a['grain'].", iron=".$a['iron'].", oil=".$a['oil']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  printrus ("Вы украли <b>40 %</b> всех ресурсов этого гос-ва!<br/>\r\n");
  sendMessage($targetID,"fullMessage","Враги украли <b>40 %</b> всех ваших ресурсов! Вы потеряли представительство на рынке (включая товар)!");


//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//замочили деревню::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
 }elseif($bld=='village'){

  $people=$a['workers'];
  $people_plen=round($people*2/5);

  if($people_plen>0){

   mysql_query("UPDATE countries SET workers = ($people - $people_plen) WHERE countryID = '".$targetID."'");
   if ($idt_m==TRUE){
      $a['workers'] = $a['workers'] - round($a['workers']*2/5);
      $memcache->set($key2,$a,false,86400);
      }

   mysql_query("UPDATE countries SET workers = workers + $people_plen WHERE countryID = '".$countryID."'");
   if ($id_m==TRUE){
      $b['workers'] = $b['workers'] + $people_plen;
      $memcache->set($key1,$b,false,86400);
      }

   printrus ("В плен захвачено <b>$people_plen</b>(<b>40%</b>) рабочих!<br/>\r\n");
   sendMessage($targetID,"fullMessage","В плен захвачено <b>$people_plen</b>(<b>40 %</b>) ваших рабочих!");
 //Пишем в лог
 @$open=fopen("logs/zah".$b['countryID'],"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName'].'(ip='.$b['ip'].',soft='.$b['soft'].') разрушило деревню '.$a['countryName']." ip=".$a['ip'].", soft=".$a['soft'].". Рабочие: ".$a['workers'].",napr=".$a['napr']."%\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
  }

 }

}


//Функция битвы. Обсчитывает потери сторон и, т.о., и победителя
//general - массив с параметрами генерала
//params - массив с параметрами армии
//warriors - массив с численностью войска
function battle($att_general,$att_params,$att_wariors,$def_general,$def_params,$def_wariors,$home=FALSE,$berserk=FALSE,$fk=1){
require (_ROOT.'/units.php'); //Инфа о юнитах
//echo ($_SERVER['DOCUMENT_ROOT'].'/new2/units.php');

//коэффициент силы:
 $kk=1*$fk;

 if ($def_params['bronya_kind']==$att_params['weapon_kind'] && $def_params['weapon_kind']!=$att_params['bronya_kind']){
    $kk=$kk*0.6;
 }

 if ($def_params['weapon_kind']==$att_params['bronya_kind'] && $def_params['bronya_kind']!=$att_params['weapon_kind']){
    $kk=$kk*1.4;
 }
//$att_general есть всегда, иначе бы не мог напасть. Проверка, есть ли генерал у защиты:
if (count($def_general)>0){
//В игру вступает мораль генералов:
$kk=$kk*sqrt($att_general['moral']/$def_general['moral']);
//теперь опыт и навык:
$kk=$kk*sqrt(($att_general['expiriense']+200*$att_general['study'])/($def_general['expiriense']+200*$def_general['study']));
if ($kk>10)$kk=10;
if ($kk<0.1)$kk=0.1;
}else{
$kk=$kk*rand(200,300)/100;
}

//фактор случайности:
$kk=$kk*rand(90,110)/100;

$bers = rand(0,1);
//Если есть открытие берсерка, оно сработало и битва идет "дома"

if ($berserk==TRUE && $bers==0 && $home==TRUE){
$kk=$kk*1.5;
//Атакуем с берсерком!
printrus("Благодаря открытию \"берсерк\", ваши воины атаковали противника с полуторной яростью!<br/>\n");
}

if ($kk>10)$kk=10;
if ($kk<0.1)$kk=0.1;

//Обсчет повреждений юнитов
$att_damage=array(0,0,0,0,0,0,0);
for ($i=0;$i<=6;$i++){
if ($att_wariors[$i]>0){  //В атаке есть такой тип юнитов
   for ($j=0;$j<=6;$j++){
       if ($def_wariors[$j]>0){  //У защиты есть такой тип юнитов
               if($j==6)$gg=$kk/2; else $gg=$kk;
          $dmg = $gg*$att_wariors[$i]*($units[$i]["dmg"]*((1+$att_params["weapon_speed"][$i])*2+$att_params["weapon_force"][$i]*3))*$units[$i]["koef"][$j];
          //$dmg = $kk*($units[$i]["dmg"]*(1+$att_params["weapon_speed"][$i]+$att_params["weapon_force"][$i]))*$units[$i]["koef"][$j];
          //$dmg = $kk*sqrt($att_wariors[$i])*($units[$i]["dmg"]*(1+$att_params["weapon_speed"][$i]+$att_params["weapon_force"][$i]))*$units[$i]["koef"][$j];
          $att_damage[$j]=$att_damage[$j]+$dmg;
          }
       }
   }
}
//echo $att_damage[6].'\n';

//Обсчет части войск, убиваемых "одним ударом"
$att_part = array(-1,-1,-1,-1,-1,-1,-1);
//$att_part_min=-1;
//$att_part_num=-1;
for ($i=0;$i<=6;$i++){
if ($def_wariors[$i]>0){
   $att_part[$i]=$att_damage[$i]/($units[$i]['life']*$def_wariors[$i]);
   }
}
//echo $att_part[6].'\n';
$att_m = array();     //В массиве части войск, убиваемых "одним" ударом
$att_left = array();  //В массиве оставшаяся часть войск
for ($i=0;$i<count($att_part);$i++) if($att_part[$i]!=-1){
    array_push($att_m,$att_part[$i]);
    array_push($att_left,1);
    }
rsort($att_m);
//echo $att_m[0].':'.$att_m[1].'\n';

//Аналогично для другой стороны
//Обсчет повреждений юнитов
$def_damage=array(0,0,0,0,0,0,0);
for ($i=0;$i<=6;$i++){
if ($def_wariors[$i]>0){  //В атаке есть такой тип юнитов
   for ($j=0;$j<=6;$j++){
       if ($att_wariors[$j]>0){  //У защиты есть такой тип юнитов
                if($i==6)$gg=$kk/2; else $gg=$kk;
          $dmg = (1/$gg)*$def_wariors[$i]*($units[$i]["dmg"]*((1+$def_params["weapon_speed"][$i])*2+$def_params["weapon_force"][$i]*3))*$units[$i]["koef"][$j];
          //$dmg = (1/$kk)*($units[$i]["dmg"]*(1+$def_params["weapon_speed"][$i]+$def_params["weapon_force"][$i]))*$units[$i]["koef"][$j];
          //$dmg = (1/$kk)*sqrt($def_wariors[$i])*($units[$i]["dmg"]*(1+$def_params["weapon_speed"][$i]+$def_params["weapon_force"][$i]))*$units[$i]["koef"][$j];
          $def_damage[$j]=$def_damage[$j]+$dmg;
          //echo $dmg.':';
          }
       }
   }
}
//Обсчет части войск, убиваемых "одним ударом"
$def_part = array(-1,-1,-1,-1,-1,-1,-1);
for ($i=0;$i<=6;$i++){
if ($att_wariors[$i]>0){
   $def_part[$i]=$def_damage[$i]/($units[$i]['life']*$att_wariors[$i]);
   //echo $def_part[$i].':';
   }
}
$def_m = array();      //В массиве части войск, убиваемых "одним" ударом
$def_left = array();   //В массиве оставшаяся часть войск
for ($i=0;$i<count($def_part);$i++) if($def_part[$i]!=-1){
    array_push($def_m,$def_part[$i]);
    array_push($def_left,1);
    }
rsort($def_m);
//echo '\n'.$def_m[0].':'.$def_m[1].'\n';

//Кто победил?
$k=count($att_m);
$att_udar=0;
for ($i=0;$i<count($att_m);$i++){
//Сколько "удара" потребуется, чтобы убить самую слабую часть войск?
$plus_udar=($att_left[$i]/$att_m[$i])*$k;
for ($j=($i+1);$j<count($att_left);$j++) $att_left[$j]=$att_left[$j]-$att_m[$j]*($att_left[$i]/$att_m[$i]);
$att_udar=$att_udar+$plus_udar;
$k--;
}
//То же, защита:
$k=count($def_m);
$def_udar=0;
for ($i=0;$i<count($def_m);$i++){
//Сколько "удара" потребуется, чтобы убить самую слабую часть войск?
$plus_udar=($def_left[$i]/$def_m[$i])*$k;
for ($j=($i+1);$j<count($def_left);$j++) $def_left[$j]=$def_left[$j]-$def_m[$j]*($def_left[$i]/$def_m[$i]);
$def_udar=$def_udar+$plus_udar;
$k--;
}

if ($att_udar>$def_udar)$win="def";
else $win="att";
//echo ($att_udar.'-'.$def_udar);
$result[0]=$win;
$result[1]=sqrt($att_udar);
$result[2]=sqrt($def_udar);
return $result;

}

//начисление опыта генералам
//$lost - потери countryID, $lost2 - потери attackerID
function general_exp($countryID,$attackerID,$lost,$lost2){
global $memcache;
require (_ROOT.'/units.php'); //Инфа о юнитах

$sum=0;
if (general_info($attackerID)){
//Суммарный урон, нанесенный стороне $countryID
$uron=0;
for ($i=0;$i<=7;$i++) $uron = $uron+$units[$i]['life']*$lost[$i];
$g_exp_up=max(1,round(2*$uron/3));
$sum = $uron;
$maxExp=$g_exp_up;
sendMessage($attackerID,"fullMessage","Опыт генерала: <b>+$g_exp_up ед.</b>.");
mysql_query("UPDATE `general` SET expiriense = expiriense + $g_exp_up WHERE countryID='$attackerID' LIMIT 1");
$key=_PREFIKS.':general'.$attackerID;
if (($mem=$memcache->get($key))!==FALSE){
   $mem['expiriense'] = $mem['expiriense'] + $g_exp_up;
   $memcache->set($key,$mem,false,86400);
   }
}

//Суммарный урон, нанесенный стороне $attackerID:
$uron=0;
for ($i=0;$i<=7;$i++) $uron = $uron+$units[$i]['life']*$lost2[$i];
$g_exp_up=max(1,round(2*$uron/3));
$sum += $uron;
//$uron=$uron*$koef;
//$g_exp_up=max(1,round($uron/15));
$maxExp=$maxExp+$g_exp_up;
sendMessage($countryID,"fullMessage","Опыт генерала: <b>+$g_exp_up ед.</b>.");
mysql_query("UPDATE `general` SET expiriense = expiriense + $g_exp_up WHERE countryID='$countryID' LIMIT 1");
$key=_PREFIKS.':general'.$countryID;
if (($mem=$memcache->get($key))!==FALSE){
   $mem['expiriense'] = $mem['expiriense'] + $g_exp_up;
   $memcache->set($key,$mem,false,86400);
   }

//Самая большая битва
$liders = file($_SERVER['DOCUMENT_ROOT'].'/liders/battle.dat');
$par = split('\*',$liders[0]);
if ($maxExp>$par[2]){   //Новая самая большая битва
$open=fopen($_SERVER['DOCUMENT_ROOT'].'/liders/battle.dat',"w+");
@flock ($open,LOCK_EX);
@fwrite($open,checkCountryID($countryID).'*'.checkCountryID($attackerID).'*'.$maxExp."\n");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);
}

}

//******************************************************************************
//Битва людей*******************************************************************
function battle_people($countryID,$attackerID,$att_wariors){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$attackerID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;
 $key3=_PREFIKS.':wars'.$attackerID;
 if (($mc=$memcache->get($key3))!==FALSE) $warst_m = TRUE; else $warst_m = FALSE;

 if ($idt_m==TRUE){
    $a=$mb;
    }else{
 $query="select * from `countries` where countryID='$attackerID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 }

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }
 $attacker=$a["countryName"];
 $country=$b["countryName"];

 //инфа о вражеском войске:
 if ($warst_m==TRUE){
    for ($i=0;$i<count($mc);$i++){
        if ($mc[$i]['targetID']==$countryID) {
                $def_wariors=array($mc[$i]['wariors'],$mc[$i]['wariors_2'],$mc[$i]['wariors_3'],$mc[$i]['wariors_4'],$mc[$i]['wariors_5'],$mc[$i]['wariors_6'],$mc[$i]['wariors_7'],$mc[$i]['wariors_8']);
                break;
                }
        }
    }else{
 $r2 = mysql_query("SELECT wariors, wariors_2, wariors_3, wariors_4, wariors_5, wariors_6, wariors_7, wariors_8 FROM `wars` WHERE targetID='$countryID' and countryID='$attackerID' LIMIT 1");
 $a2 = mysql_fetch_array($r2);
 $def_wariors=array($a2['wariors'],$a2['wariors_2'],$a2['wariors_3'],$a2['wariors_4'],$a2['wariors_5'],$a2['wariors_6'],$a2['wariors_7'],$a2['wariors_8']);
 }

 //Инфа о войске вторгшегося:
 $def_params['bronya_kind']=$a["bronya_kind"];
 $def_params['weapon_kind']=$a["weapon_kind"];

 $def_params['weapon_speed'][0]=$a["weapon_speed"];
 $def_params['weapon_speed'][1]=$a["weapon_speed_2"];
 $def_params['weapon_speed'][2]=$a["weapon_speed_3"];

 $def_params['weapon_speed'][3]=$a["weapon_speed_4"];
 $def_params['weapon_speed'][4]=$a["weapon_speed_5"];
 $def_params['weapon_speed'][5]=$a["weapon_speed_6"];
 $def_params['weapon_speed'][6]=$a["weapon_speed_7"];
 $def_params['weapon_speed'][7]=$a["weapon_speed_8"];
 $def_params['weapon_force'][0]=$a["weapon_force"];
 $def_params['weapon_force'][1]=$a["weapon_force_2"];
 $def_params['weapon_force'][2]=$a["weapon_force_3"];
 $def_params['weapon_force'][3]=$a["weapon_force_4"];
 $def_params['weapon_force'][4]=$a["weapon_force_5"];
 $def_params['weapon_force'][5]=$a["weapon_force_6"];
 $def_params['weapon_force'][6]=$a["weapon_force_7"];
 $def_params['weapon_force'][7]=$a["weapon_force_8"];

 //инфа о своем войске:
 $att_params['bronya_kind']=$b["bronya_kind"];
 $att_params['weapon_kind']=$b["weapon_kind"];
 $att_params['weapon_speed'][0]=$b["weapon_speed"];
 $att_params['weapon_speed'][1]=$b["weapon_speed_2"];
 $att_params['weapon_speed'][2]=$b["weapon_speed_3"];
 $att_params['weapon_speed'][3]=$b["weapon_speed_4"];
 $att_params['weapon_speed'][4]=$b["weapon_speed_5"];
 $att_params['weapon_speed'][5]=$b["weapon_speed_6"];
 $att_params['weapon_speed'][6]=$b["weapon_speed_7"];
 $att_params['weapon_speed'][7]=$b["weapon_speed_8"];
 $att_params['weapon_force'][0]=$b["weapon_force"];
 $att_params['weapon_force'][1]=$b["weapon_force_2"];
 $att_params['weapon_force'][2]=$b["weapon_force_3"];
 $att_params['weapon_force'][3]=$b["weapon_force_4"];
 $att_params['weapon_force'][4]=$b["weapon_force_5"];
 $att_params['weapon_force'][5]=$b["weapon_force_6"];
 $att_params['weapon_force'][6]=$b["weapon_force_7"];
 $att_params['weapon_force'][7]=$b["weapon_force_8"];

$x=2;
 //Влияние артефактов
 if (isArtefact($attackerID, 'sapog'))
 {
    $def_params['weapon_speed'][0]*=1.25*$x;
    $def_params['weapon_force'][0]*=1.25*$x;
 }
 if (isArtefact($attackerID, 'podkova'))
 {
    $def_params['weapon_speed'][1]*=1.25*$x;
    $def_params['weapon_force'][1]*=1.25*$x;
 }
 if (isArtefact($attackerID, 'puli'))
  {
    $def_params['weapon_speed'][2]*=1.15*$x;
    $def_params['weapon_force'][2]*=1.15*$x;
 }

 if (isArtefact($attackerID, 'yadro'))
  {
    $def_params['weapon_speed'][3]*=1.15*$x;
    $def_params['weapon_force'][3]*=1.15*$x;
 }

  if (isArtefact($attackerID, 'podrivnoe_delo'))
  {
    $def_params['weapon_speed'][4]*=1.15*$x;
    $def_params['weapon_force'][4]*=1.15*$x;
 }

  if (isArtefact($attackerID, 'pult'))
  {
    $def_params['weapon_speed'][4]*=1.5*$x;
    $def_params['weapon_force'][4]*=1.5*$x;
 }

  if (isArtefact($attackerID, 'avia_pulemet'))
  {
    $def_params['weapon_speed'][5]*=1.1*$x;
    $def_params['weapon_force'][5]*=1.1*$x;
 }



 if (isArtefact($countryID, 'sapog'))
 {
    $att_params['weapon_speed'][0]*=1.25*$x;
    $att_params['weapon_force'][0]*=1.25*$x;
 }
 if (isArtefact($countryID, 'podkova'))
  {
    $att_params['weapon_speed'][1]*=1.25*$x;
    $att_params['weapon_force'][1]*=1.25*$x;
 }
 if (isArtefact($countryID, 'puli'))
 {
    $att_params['weapon_speed'][2]*=1.15*$x;
    $att_params['weapon_force'][2]*=1.15*$x;
 }

  if (isArtefact($countryID, 'yadro'))
 {
    $att_params['weapon_speed'][3]*=1.15*$x;
    $att_params['weapon_force'][3]*=1.15*$x;
 }

  if (isArtefact($countryID, 'yadro'))
  {
    $att_params['weapon_speed'][3]*=1.15*$x;
    $att_params['weapon_force'][3]*=1.15*$x;
 }

  if (isArtefact($countryID, 'podrivnoe_delo'))
  {
    $att_params['weapon_speed'][4]*=1.15*$x;
    $att_params['weapon_force'][4]*=1.15*$x;
 }

  if (isArtefact($countryID, 'pult'))
  {
    $att_params['weapon_speed'][4]*=1.5*$x;
    $att_params['weapon_force'][4]*=1.5*$x;
 }

  if (isArtefact($countryID, 'avia_pulemet'))
  {
    $att_params['weapon_speed'][5]*=1.1*$x;
    $att_params['weapon_force'][5]*=1.1*$x;
 }


 $att_general=general_info($countryID);
 if (general_info($attackerID)){
 $def_general = general_info($attackerID);
 }else $def_general=array();

 //Артефакт учебник тактики
  if (isArtefact($countryID, 'kniga_taktiki'))
  $att_general['study']+=250;

  if (isArtefact($attackerID, 'kniga_taktiki'))
  $def_general['study']+=250;

  //Артефакт погон
  if (isArtefact($countryID, 'pogon')){
  $att_general['moral']=30;
}
  if (isArtefact($attackerID, 'pogon')){
  $def_general['moral']+=30;
}
 //Артефакт техническое волшебство
  if (isArtefact($countryID, 'teh_volshebstvo'))
  $teh_volshba_att=1;

  if (isArtefact($attackerID, 'teh_volshebstvo'))
  $teh_volshba_def=1;

 $br = battle($att_general,$att_params,$att_wariors,$def_general,$def_params,$def_wariors,TRUE,otkr_exists($countryID,'BERS'),1.2);

 //Пишем в лог:
 @$open=fopen("logs/war".$attackerID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."$country пыталось выбить Вас со своей территории.
 Генералы: ".$att_general['study'].":".$att_general['moral'].":".$att_general['expiriense'].",
 ".$def_general['study'].":".$def_general['moral'].":".$def_general['expiriense'].". Армии:
 ".print_voisko($att_wariors).",".print_voisko($def_wariors).". Выиграл:".$br[0].".Коэф.:
 ".$br[1]."-".$br[2]."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 //Пишем в лог тому кто напал:
 @$open=fopen("logs/war".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date_new("H:i j.m:")."$country пыталось выбить $attacker со своей территории.
 Генералы: ".$att_general['study'].":".$att_general['moral'].":".$att_general['expiriense'].",
 ".$def_general['study'].":".$def_general['moral'].":".$def_general['expiriense'].". Армии:
 ".print_voisko($att_wariors).",".print_voisko($def_wariors).". Выиграл:".$br[0].".Коэф.:
 ".$br[1]."-".$br[2]."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 //конец сражения:
 if($br[0]=="att"){
 //мы победили
  //Выбили врага с территории
  $query="delete from `wars` where countryID='$attackerID' and targetID='$countryID' limit 1";
  $result=@MYSQL_QUERY($query);
  if ($warst_m==TRUE){
     $neww=array();
     for ($i=0;$i<count($mc);$i++) if ($mc[$i]['targetID']!=$countryID) array_push($neww,$mc[$i]);
     $memcache->set($key3,$neww,false,86400);
     }

  $wariors_end = round($att_wariors[0]*(1-$br[1]/$br[2]));
  $w_d = round($att_wariors[0]*($br[1]/$br[2]));
  $wariors_end_2 = round($att_wariors[1]*(1-$br[1]/$br[2]));
  $w_d_2 = round($att_wariors[1]*($br[1]/$br[2]));
  $wariors_end_3 = round($att_wariors[2]*(1-$br[1]/$br[2]));
  $w_d_3 = round($att_wariors[2]*($br[1]/$br[2]));
  $wariors_end_4 = round($att_wariors[3]*(1-$br[1]/$br[2]));
  $w_d_4 = round($att_wariors[3]*($br[1]/$br[2]));
  $wariors_end_5 = round($att_wariors[4]*(1-$br[1]/$br[2]));
  $w_d_5 = round($att_wariors[4]*($br[1]/$br[2]));
  $wariors_end_6 = round($att_wariors[5]*(1-$br[1]/$br[2]));
  $w_d_6 = round($att_wariors[5]*($br[1]/$br[2]));
  $wariors_end_7 = round($att_wariors[6]*(1-$br[1]/$br[2]));
  $w_d_7 = round($att_wariors[6]*($br[1]/$br[2]));
  $wariors_end_8 = round($att_wariors[7]*(1-$br[1]/$br[2]));
  $w_d_8 = round($att_wariors[7]*($br[1]/$br[2]));
  mysql_query("UPDATE countries SET
  wariors_free = wariors_free + $wariors_end, wariors_free_2 = wariors_free_2 + $wariors_end_2,
  wariors_free_3 = wariors_free_3 + $wariors_end_3, wariors_free_4 = wariors_free_4 + $wariors_end_4,
  wariors_free_5 = wariors_free_5 + $wariors_end_5, wariors_free_6 = wariors_free_6 + $wariors_end_6,
  wariors_free_7 = wariors_free_7 + $wariors_end_7, wariors_free_8 = wariors_free_8 + $wariors_end_8
  WHERE countryID = '".$countryID."'");
  echo mysql_error();
  $b['wariors_free'] = $b['wariors_free'] + $wariors_end;
  $b['wariors_free_2'] = $b['wariors_free_2'] + $wariors_end_2;
  $b['wariors_free_3'] = $b['wariors_free_3'] + $wariors_end_3;
  $b['wariors_free_4'] = $b['wariors_free_4'] + $wariors_end_4;
  $b['wariors_free_5'] = $b['wariors_free_5'] + $wariors_end_5;
  $b['wariors_free_6'] = $b['wariors_free_6'] + $wariors_end_6;
  $b['wariors_free_7'] = $b['wariors_free_7'] + $wariors_end_7;
  $b['wariors_free_8'] = $b['wariors_free_8'] + $wariors_end_8;
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  printrus ("Вы разбили войско гос-ва <u>$attacker</u>. Уцелело воинов:<br/>".print_voisko(array($wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8)));
  sendMessage($attackerID,"fullMessage","Гос-во <u>$country</u> разбило все ваше войско на своей территории. Потери противника:<br/>".print_voisko(array($w_d,$w_d_2,$w_d_3,$w_d_4,$w_d_5,$w_d_6,$w_d_7,$w_d_8)));
 general_exp($countryID,$attackerID,array($w_d,$w_d_2,$w_d_3,$w_d_4,$w_d_5,$w_d_6,$w_d_7,$w_d_8),$def_wariors);
 }else{
 //Запишем время последней атаки
 $query="UPDATE `wars` SET time3='".time_new()."' where countryID='$attackerID' and targetID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 if ($warst_m==TRUE){
 for ($i=0;$i<count($mc);$i++) if ($mc[$i]['targetID']==$countryID){
         $mc[$i]['time3']=time_new();
         break;
    }
 $memcache->set($key3,$mc,false,86400);
 }

  //Проигрыш
  $att_end = round($def_wariors[0]*(1-$br[2]/$br[1]));
  $w_d = round($def_wariors[0]*$br[2]/$br[1]);
  $att_end_2 = round($def_wariors[1]*(1-$br[2]/$br[1]));
  $w_d_2 = round($def_wariors[1]*$br[2]/$br[1]);
  $att_end_3 = round($def_wariors[2]*(1-$br[2]/$br[1]));
  $w_d_3 = round($def_wariors[2]*$br[2]/$br[1]);
  $att_end_4 = round($def_wariors[3]*(1-$br[2]/$br[1]));
  $w_d_4 = round($def_wariors[3]*$br[2]/$br[1]);
  $att_end_5 = round($def_wariors[4]*(1-$br[2]/$br[1]));
  $w_d_5 = round($def_wariors[4]*$br[2]/$br[1]);
  $att_end_6 = round($def_wariors[5]*(1-$br[2]/$br[1]));
  $w_d_6 = round($def_wariors[5]*$br[2]/$br[1]);
  $att_end_7 = round($def_wariors[6]*(1-$br[2]/$br[1]));
  $w_d_7 = round($def_wariors[6]*$br[2]/$br[1]);
  $att_end_8 = round($def_wariors[7]*(1-$br[2]/$br[1]));
  $w_d_8 = round($def_wariors[7]*$br[2]/$br[1]);

  //Должен остаться хотя бы 1 юнит:
  if ($att_end+$att_end_2+$att_end_3+$att_end_4+$att_end_5+$att_end_6+$att_end_7+$att_end_8<=0){
     if ($def_wariors[0]>0)$att_end=1;
     elseif ($def_wariors[1]>0)$att_end_2=1;
     elseif ($def_wariors[2]>0)$att_end_3=1;
     elseif ($def_wariors[3]>0)$att_end_4=1;
     elseif ($def_wariors[4]>0)$att_end_5=1;
     elseif ($def_wariors[5]>0)$att_end_6=1;
     elseif ($def_wariors[6]>0)$att_end_7=1;
     elseif ($def_wariors[7]>0)$att_end_8=1;
     }

  mysql_query("UPDATE `wars` SET wariors=$att_end, wariors_2 = $att_end_2, wariors_3 = $att_end_3,
  wariors_4 = $att_end_4, wariors_5 = $att_end_5, wariors_6 = $att_end_6, wariors_7 = $att_end_7,
  wariors_8 = $att_end_8 WHERE countryID = '$attackerID' and targetID='$countryID' LIMIT 1");
  if ($warst_m==TRUE){
     for ($i=0;$i<count($mc);$i++){
         if ($mc[$i]['targetID']==$countryID){
                 $mc[$i]['wariors']=$att_end;
                 $mc[$i]['wariors_2']=$att_end_2;
                 $mc[$i]['wariors_3']=$att_end_3;
                 $mc[$i]['wariors_4']=$att_end_4;
                 $mc[$i]['wariors_5']=$att_end_5;
                 $mc[$i]['wariors_6']=$att_end_6;
                 $mc[$i]['wariors_7']=$att_end_7;
                 $mc[$i]['wariors_8']=$att_end_8;
                 $memcache->set($key3,$mc,false,86400);
                 break;
            }
         }
     }

  printrus ("Ваше войско было разбито. Вам не удалось разбить войско гос-ва <u>$attacker</u>. Осталось:<br/>".print_voisko(array($att_end,$att_end_2,$att_end_3,$att_end_4,$att_end_5,$att_end_6,$att_end_7,$att_end_8)));
  sendMessage($attackerID,"fullMessage","Ваши войска на территории гос-ва <u>$country</u> были атакованы, но врагу не удалось вас разбить. Уцелело воинов:<br/>".print_voisko(array($att_end,$att_end_2,$att_end_3,$att_end_4,$att_end_5,$att_end_6,$att_end_7,$att_end_8)));
  general_exp($countryID,$attackerID,$att_wariors,array($w_d,$w_d_2,$w_d_3,$w_d_4,$w_d_5,$w_d_6,$w_d_7,$w_d_8));
 }

 //вот теперь совсем конец.

}





//******************************************************************************
//Битва под зданием*************************************************************
//$there характеризует, были ли войска на территории при атаке здания,
//соответственно, если не были, то атакуют стену
//$hole характеризует дыру в стене (то есть стена разломана до такой
//степени, что дальше ломать не надо, и войска спокойно проходят
function battle_bld($countryID,$targetID,$att_wariors,$bld,$there=true,$hole=false){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 require (_ROOT.'/b_params.php');

 $kill=$bld."_kill";
 $bld_kill=$$kill;

 $key=_PREFIKS.':buildings'.$targetID;

 if (($mem = $memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){
            $guard=$mem[$i]['guard'];
            $guard_2=$mem[$i]['guard_2'];
            $guard_3=$mem[$i]['guard_3'];
            $guard_4=$mem[$i]['guard_4'];
            $guard_5=$mem[$i]['guard_5'];
            $guard_6=$mem[$i]['guard_6'];
            $guard_7=$mem[$i]['guard_7'];
            $guard_8=$mem[$i]['guard_8'];
            $hits=$mem[$i]['hits'];
            break;
        }
 }else{
 $query="select * from `buildings` where countryID='$targetID' and building='$bld' limit 1";
 $result=@MYSQL_QUERY($query);
 $hits=@mysql_result($result,0,"hits");
 $guard=@mysql_result($result,0,"guard");
 $guard_2=@mysql_result($result,0,"guard_2");
 $guard_3=@mysql_result($result,0,"guard_3");
 $guard_4=@mysql_result($result,0,"guard_4");
 $guard_5=@mysql_result($result,0,"guard_5");
 $guard_6=@mysql_result($result,0,"guard_6");
 $guard_7=@mysql_result($result,0,"guard_7");
 $guard_8=@mysql_result($result,0,"guard_8");
 }

 if ($idt_m==TRUE){
 $a=$mb;
    }else{
 $query="select * from `countries` where countryID='$targetID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 }

 if ($id_m==TRUE){
 $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }


 $target=$a["countryName"];
 $country=$b["countryName"];

 //инфа о вражеском войске:
 //$guard=getValue("countryID='$targetID' and building='$bld'","buildings","guard");
 //^^ $guard получили ранее
 $def_params['bronya_kind']=$a["bronya_kind"];
 $def_params['weapon_kind']=$a["weapon_kind"];
 $def_params['weapon_speed'][0]=$a["weapon_speed"];
 $def_params['weapon_speed'][1]=$a["weapon_speed_2"];
 $def_params['weapon_speed'][2]=$a["weapon_speed_3"];
 $def_params['weapon_speed'][3]=$a["weapon_speed_4"];
 $def_params['weapon_speed'][4]=$a["weapon_speed_5"];
 $def_params['weapon_speed'][5]=$a["weapon_speed_6"];
 $def_params['weapon_speed'][6]=$a["weapon_speed_7"];
 $def_params['weapon_speed'][7]=$a["weapon_speed_8"];
 $def_params['weapon_force'][0]=$a["weapon_force"];
 $def_params['weapon_force'][1]=$a["weapon_force_2"];
 $def_params['weapon_force'][2]=$a["weapon_force_3"];
 $def_params['weapon_force'][3]=$a["weapon_force_4"];
 $def_params['weapon_force'][4]=$a["weapon_force_5"];
 $def_params['weapon_force'][5]=$a["weapon_force_6"];
 $def_params['weapon_force'][6]=$a["weapon_force_7"];
 $def_params['weapon_force'][7]=$a["weapon_force_8"];

$x=2;
 //Влияние артефактов
 if (isArtefact($targetID, 'sapog'))
 {
    $def_params['weapon_speed'][0]*=1.25*$x;
    $def_params['weapon_force'][0]*=1.25*$x;
 }
 if (isArtefact($targetID, 'podkova'))
 {
    $def_params['weapon_speed'][1]*=1.25*$x;
    $def_params['weapon_force'][1]*=1.25*$x;
 }
 if (isArtefact($targetID, 'puli'))
  {
    $def_params['weapon_speed'][2]*=1.15*$x;
    $def_params['weapon_force'][2]*=1.15*$x;
 }

 if (isArtefact($targetID, 'yadro'))
  {
    $def_params['weapon_speed'][3]*=1.15*$x;
    $def_params['weapon_force'][3]*=1.15*$x;
 }

  if (isArtefact($targetID, 'podrivnoe_delo'))
  {
    $def_params['weapon_speed'][4]*=1.15*$x;
    $def_params['weapon_force'][4]*=1.15*$x;
 }

  if (isArtefact($targetID, 'pult'))
  {
    $def_params['weapon_speed'][4]*=1.5*$x;
    $def_params['weapon_force'][4]*=1.5*$x;
 }

  if (isArtefact($targetID, 'avia_pulemet'))
  {
    $def_params['weapon_speed'][5]*=1.1*$x;
    $def_params['weapon_force'][5]*=1.1*$x;
 }








 setValue("countryID='$countryID' and targetID='$targetID'","wars","time2",time_new());
 $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++){
        if ($mem[$i]['targetID']==$targetID){
                $mem[$i]['time2']=time_new();
                break;
            }
        }
    $memcache->set($key,$mem,false,86400);
    }

 //а может и воевать не надо?:)... если нет охраны.
 if(($guard+$guard_2+$guard_3+$guard_4+$guard_5+$guard_6+$guard_7+$guard_8)<=0){
  if($there){
   $urdmj=$b['demontaj']-10;
  if($urdmj>0){
//СТроительство зданий
$building=$bld;
require (_ROOT.'/b_params.php');
$s=$building.'_money';
$money=$$s;
$s=$building.'_stone';
$stone=$$s;
$s=$building.'_iron';
$iron=$$s;
$s=$building.'_arbor';
$arbor=$$s;
$s=$building.'_grain';
$grain=$$s;
$s=$building.'_oil';
$oil=$$s;

  	$rez.='Благодаря разработке "демонтаж зданий", из разрушенного здания вы извлекли: ';
 $money=ceil($money*$urdmj/100);
 $stone=ceil($stone*$urdmj/100);
 $iron=ceil($iron*$urdmj/100);
 $arbor=ceil($arbor*$urdmj/100);
 $oil=ceil($oil*$urdmj/100);

$freeplace=max(0,free_place($countryID));
if($stone>$freeplace)
$stone=$freeplace;
//*************************************
$freeplace=$freeplace-$stone;
//*************************************
if($iron>$freeplace)
$iron=$freeplace;
//*************************************
$freeplace=$freeplace-$iron;
//*************************************
if($arbor>$freeplace)
$arbor=$freeplace;
//*************************************
$freeplace=$freeplace-$arbor;
//*************************************
if($oil>$freeplace)
$oil=$freeplace;


if($money>0)
$rez.="деньги: $money,";
if($stone>0)
$rez.="камень: $stone,";
if($iron>0)
$rez.="железо: $iron,";
if($arbor>0)
$rez.="дерево: $arbor,";
if($oil>0)
$rez.="нефть: $oil.";


//устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE countries SET arbor = arbor + $arbor, money = money + $money,
   stone = stone + $stone, iron = iron + $iron, oil = oil + $oil
   WHERE countryID = '".$b["countryID"]."'");
   $b['arbor'] = $b['arbor'] + $arbor;
   $b['stone'] = $b['stone'] + $stone;
   $b['iron'] = $b['iron'] + $iron;
   $b['money'] = $b['money'] + $money;
   $b['oil'] = $b['oil'] + $oil;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }



 }else{
 $rez='';


 }       //если войска были на территории:
   printrus ("Подойдя к незащищенному зданию <u>".printBuilding($bld)."</u> вы, не потеряв ни одного воина,
                  с легкостью его разрушили!".$rez."<br/>\r\n");
   sendMessage($targetID,"fullMessage","Войско гос-ва <u>$country</u> с легкостью разрушило незащищенное здание <u>".printBuilding($bld)."</u>!");
   kill_build($countryID,$targetID,$bld);

   $query="delete from `buildings` where countryID='$targetID' and building='$bld' limit 1";
   $result=@MYSQL_QUERY($query);
   $key=_PREFIKS.':buildings'.$targetID;
   if (($mem=$memcache->get($key))!==FALSE){
      $newb=array();
      for ($i=0;$i<count($mem);$i++){
          if ($mem[$i]['building']!=$bld) array_push($newb,$mem[$i]);
          }
      $memcache->set($key,$newb,false,86400);
      }

   mysql_query("UPDATE `wars` SET wariors = wariors + ".$att_wariors[0].",
   wariors_2 = wariors_2 + ".$att_wariors[1].", wariors_3 = wariors_3 + ".$att_wariors[2].",
   wariors_4 = wariors_4 + ".$att_wariors[3].", wariors_5 = wariors_5 + ".$att_wariors[4].",
   wariors_6 = wariors_6 + ".$att_wariors[5].", wariors_7 = wariors_7 + ".$att_wariors[6].",
   wariors_8 = wariors_8 + ".$att_wariors[7]."
   WHERE countryID = '".$countryID."' and targetID = '".$targetID."' LIMIT 1");

   $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++){
        if ($mem[$i]['targetID']==$targetID){
                $mem[$i]['wariors']=$mem[$i]['wariors']+$att_wariors[0];
                $mem[$i]['wariors_2']=$mem[$i]['wariors_2']+$att_wariors[1];
                $mem[$i]['wariors_3']=$mem[$i]['wariors_3']+$att_wariors[2];
                $mem[$i]['wariors_4']=$mem[$i]['wariors_4']+$att_wariors[3];
                $mem[$i]['wariors_5']=$mem[$i]['wariors_5']+$att_wariors[4];
                $mem[$i]['wariors_6']=$mem[$i]['wariors_6']+$att_wariors[5];
                $mem[$i]['wariors_7']=$mem[$i]['wariors_7']+$att_wariors[6];
                $mem[$i]['wariors_8']=$mem[$i]['wariors_8']+$att_wariors[7];
                break;
            }
        }
    $memcache->set($key,$mem,false,86400);
    }


  printrus(giveArtefact($b['countryID']) );


  }
  //конец разрушения здания


  else{
          //если войск на территории не было, и это - первая битва:
   printrus ("Вы не потеряв ни одного воина с легкостью прошли через незащищенную гранцу вражеского гос-ва!<br/>\r\n");
   sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> с легкостью прорвалось через незащищенную стену вашего гос-ва.
   На вашу территорию прорвалось:<br/>".print_voisko(array($att_wariors[0],$att_wariors[1],$att_wariors[2],$att_wariors[3],$att_wariors[4],$att_wariors[5],$att_wariors[6],$att_wariors[7])));

   $query="insert into `wars` values('$countryID','$targetID',".$att_wariors[0].",".$att_wariors[1].",".$att_wariors[2].",".$att_wariors[3].",".$att_wariors[4].",".$att_wariors[5].",".$att_wariors[6].",".$att_wariors[7].",".time_new().",".time_new().",".time_new().")";
   $result=MYSQL_QUERY($query);
  $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $neww = array("countryID"=>$countryID, "targetID"=>$targetID, "wariors"=>$att_wariors[0], "wariors_2"=>$att_wariors[1], "wariors_3"=>$att_wariors[2], "wariors_4"=>$att_wariors[3], "wariors_5"=>$att_wariors[4], "wariors_6"=>$att_wariors[5], "wariors_7"=>$att_wariors[6], "wariors_8"=>$att_wariors[7], "time1"=>time_new(), "time2"=>time_new(), "time3"=>time_new());
    array_push($mem,$neww);
    $memcache->set($key,$mem,false,86400);
    }

  }

  return true;
  //битва выиграна
  break;
 }

 //инфа о своем войске:
 $att_params['bronya_kind']=$b["bronya_kind"];
 $att_params['weapon_kind']=$b["weapon_kind"];
 $att_params['weapon_speed'][0]=$b["weapon_speed"];
 $att_params['weapon_speed'][1]=$b["weapon_speed_2"];
 $att_params['weapon_speed'][2]=$b["weapon_speed_3"];
 $att_params['weapon_speed'][3]=$b["weapon_speed_4"];
 $att_params['weapon_speed'][4]=$b["weapon_speed_5"];
 $att_params['weapon_speed'][5]=$b["weapon_speed_6"];
 $att_params['weapon_speed'][6]=$b["weapon_speed_7"];
 $att_params['weapon_speed'][7]=$b["weapon_speed_8"];

 $att_params['weapon_force'][0]=$b["weapon_force"];
 $att_params['weapon_force'][1]=$b["weapon_force_2"];
 $att_params['weapon_force'][2]=$b["weapon_force_3"];
 $att_params['weapon_force'][3]=$b["weapon_force_4"];
 $att_params['weapon_force'][4]=$b["weapon_force_5"];
 $att_params['weapon_force'][5]=$b["weapon_force_6"];
 $att_params['weapon_force'][6]=$b["weapon_force_7"];
 $att_params['weapon_force'][7]=$b["weapon_force_8"];

$x=2;

 if (isArtefact($countryID, 'sapog'))
 {
    $att_params['weapon_speed'][0]*=1.25*$x;
    $att_params['weapon_force'][0]*=1.25*$x;
 }
 if (isArtefact($countryID, 'podkova'))
  {
    $att_params['weapon_speed'][1]*=1.25*$x;
    $att_params['weapon_force'][1]*=1.25*$x;
 }
 if (isArtefact($countryID, 'puli'))
 {
    $attparams['weapon_speed'][2]*=1.15*$x;
    $att_params['weapon_force'][2]*=1.15*$x;
 }

 if (isArtefact($attackerID, 'yadro'))
  {
    $att_params['weapon_speed'][3]*=1.15*$x;
    $att_params['weapon_force'][3]*=1.15*$x;
 }

  if (isArtefact($attackerID, 'podrivnoe_delo'))
  {
    $att_params['weapon_speed'][4]*=1.15*$x;
    $att_params['weapon_force'][4]*=1.15*$x;
 }

  if (isArtefact($attackerID, 'pult'))
  {
    $att_params['weapon_speed'][4]*=1.5*$x;
    $att_params['weapon_force'][4]*=1.5*$x;
 }

  if (isArtefact($attackerID, 'avia_pulemet'))
  {
    $att_params['weapon_speed'][5]*=1.1*$x;
    $att_params['weapon_force'][5]*=1.1*$x;
 }




 if(!$general=general_info($targetID))$def_general=array();
 else $def_general=$general;

 $att_general = general_info($countryID);

 //Артефакт учебник тактики
  if (isArtefact($countryID, 'kniga_taktiki'))
  $att_general['study']+=250;

  if (isArtefact($targetID, 'kniga_taktiki'))
  $def_general['study']+=250;

 //Артефакт погон
  if (isArtefact($countryID, 'pogon'))
  $att_general['moral']+=30;

  if (isArtefact($targetID, 'pogon'))
  $def_general['moral']+=30;

  //Артефакт техническое волшебство
  if (isArtefact($countryID, 'teh_volshebstvo'))
  $teh_volshba_att=1;

  if (isArtefact($targetID, 'teh_volshebstvo'))
  $teh_volshba_def=1;

 $br = battle($att_general,$att_params,$att_wariors,$def_general,$def_params,array($guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8),FALSE,FALSE,0.67);

 //if($hole==FALSE){
 //конец сражения:
 if($br[0]=="att"){

  //защита разбита,
  //потери...
  $lost=array();
  $wariors_end = round($att_wariors[0]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[0]*($br[1]/$br[2])));
  $wariors_end_2 = round($att_wariors[1]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[1]*($br[1]/$br[2])));
  $wariors_end_3 = round($att_wariors[2]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[2]*($br[1]/$br[2])));
  $wariors_end_4 = round($att_wariors[3]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[3]*($br[1]/$br[2])));
  $wariors_end_5 = round($att_wariors[4]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[4]*($br[1]/$br[2])));
  $wariors_end_6 = round($att_wariors[5]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[5]*($br[1]/$br[2])));
  $wariors_end_7 = round($att_wariors[6]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[6]*($br[1]/$br[2])));
  $wariors_end_8 = round($att_wariors[7]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[7]*($br[1]/$br[2])));
  //Должен остаться хотя бы 1 юнит:
  if ($wariors_end+$wariors_end_2+$wariors_end_3+$wariors_end_4+$wariors_end_5+$wariors_end_6+$wariors_end_7+$wariors_end_8<=0){
     if ($att_wariors[0]>0)$wariors_end=1;
     elseif ($att_wariors[1]>0)$wariors_end_2=1;
     elseif ($att_wariors[2]>0)$wariors_end_3=1;
     elseif ($att_wariors[3]>0)$wariors_end_4=1;
     elseif ($att_wariors[4]>0)$wariors_end_5=1;
     elseif ($att_wariors[5]>0)$wariors_end_6=1;
     elseif ($att_wariors[6]>0)$wariors_end_7=1;
     elseif ($att_wariors[7]>0)$wariors_end_8=1;
     }

  //$kill_percent=round(($wariors+$wariors_2)/$bld_kill*10*$kk);
  //$hits_end=max(0,$hits-$kill_percent);
  //Здание полностью разрушается при превосходстве в 1.5 раза
  $hits_end=min(100,round(max(0,(1.5-$br[2]/$br[1]))*100));

  if($hits_end==0){
           //здание разрушено
           if ($there==TRUE){
           	$urdmj=$b['demontaj']-10;
  if($urdmj>0){
//СТроительство зданий
$building=$bld;
require (_ROOT.'/b_params.php');
$s=$building.'_money';
$money=$$s;
$s=$building.'_stone';
$stone=$$s;
$s=$building.'_iron';
$iron=$$s;
$s=$building.'_arbor';
$arbor=$$s;
$s=$building.'_grain';
$grain=$$s;
$s=$building.'_oil';
$oil=$$s;

  	$rez.='Благодаря разработке \"демонтаж зданий\", из разрушенного здания вы извлекли: ';
 $money=ceil($money*$urdmj/100);
 $stone=ceil($stone*$urdmj/100);
 $iron=ceil($iron*$urdmj/100);
 $arbor=ceil($arbor*$urdmj/100);
 $oil=ceil($oil*$urdmj/100);

$freeplace=max(0,free_place($countryID));
if($stone>$freeplace)
$stone=$freeplace;
//*************************************
$freeplace=$freeplace-$stone;
//*************************************
if($iron>$freeplace)
$iron=$freeplace;
//*************************************
$freeplace=$freeplace-$iron;
//*************************************
if($arbor>$freeplace)
$arbor=$freeplace;
//*************************************
$freeplace=$freeplace-$arbor;
//*************************************
if($oil>$freeplace)
$oil=$freeplace;


if($money>0)
$rez.="деньги: $money,";
if($stone>0)
$rez.="камень: $stone,";
if($iron>0)
$rez.="железо: $iron,";
if($arbor>0)
$rez.="дерево: $arbor,";
if($oil>0)
$rez.="нефть: $oil.";


//устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE countries SET arbor = arbor + $arbor, money = money + $money,
   stone = stone + $stone, iron = iron + $iron, oil = oil + $oil
   WHERE countryID = '".$b["countryID"]."'");
   $b['arbor'] = $b['arbor'] + $arbor;
   $b['stone'] = $b['stone'] + $stone;
   $b['iron'] = $b['iron'] + $iron;
   $b['money'] = $b['money'] + $money;
   $b['oil'] = $b['oil'] + $oil;
   if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }



 }else{
 $rez='';


 }
    printrus ("Вы одержали победу над вражеским войском! Здание <u>".printBuilding($bld)."</u> разрушено.".$rez."
 Уцелело воинов:<br/>".print_voisko(array($wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8)));
    sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> пробило оборону здания <u>".printBuilding($bld)."</u>. Здание разрушено!");
           }else{
           printrus ("Вы одержали победу над вражеским войском и прорвались на территорию противника! <u>Стена</u> разрушена.
 Уцелело воинов:<br/>".print_voisko(array($wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8)));
    sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> атаковало вас и пробило вашу оборону! Стена разрушена!");
           }
    kill_build($countryID,$targetID,$bld);
    $query="delete from `buildings` where countryID='$targetID' and building='$bld' limit 1";
    $result=@MYSQL_QUERY($query);

    $key=_PREFIKS.':buildings'.$targetID;
    if (($mem=$memcache->get($key))!==FALSE){
       $newb=array();
       for ($i=0;$i<count($mem);$i++){
           if ($mem[$i]['building']!=$bld) array_push($newb,$mem[$i]);
           }
       $memcache->set($key,$newb,false,86400);
       }

   }else{
           //здание не разрушено
           if ($there==TRUE){
    printrus ("Вы одержали победу над вражеским войском! Здание <u>".printBuilding($bld)."</u> разломано до <b>$hits_end %</b>.
          Уцелело воинов:<br/>".print_voisko(array($wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8)));
    sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> пробило оборону здания <u>".printBuilding($bld)."</u>.
                                                                             Здание разломано до <b>$hits_end %</b>.");
           }else{
           printrus ("Вы одержали победу над вражеским войском и прорвались на вражескую территорию! Стена разломана до <b>$hits_end %</b>.
          Уцелело воинов:<br/>".print_voisko(array($wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8)));
    sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> атаковало вас и пробило оборону!
                                                                             Стена разломана до <b>$hits_end %</b>.");
           }
    mysql_query("UPDATE buildings SET hits = $hits_end, guard = 0, guard_2=0, guard_3=0, guard_4=0, guard_5=0, guard_6=0, guard_7=0, guard_8=0 WHERE countryID='$targetID' and building='$bld' LIMIT 1");
    $key=_PREFIKS.':buildings'.$targetID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++){
           if ($mem[$i]['building']==$bld) {
                   $mem[$i]['guard']=0;
                   $mem[$i]['guard_2']=0;
                   $mem[$i]['guard_3']=0;
                   $mem[$i]['guard_4']=0;
                   $mem[$i]['guard_5']=0;
                   $mem[$i]['guard_6']=0;
                   $mem[$i]['guard_7']=0;
                   $mem[$i]['guard_8']=0;
                   $mem[$i]['hits']=$hits_end;
                   break;
            }
           }
       $memcache->set($key,$mem,false,86400);
       }

   }
   /*
   mysql_query("UPDATE `countries` SET wariors_atall = wariors_atall - $guard,
   wariors_atall_2 = wariors_atall_2 - $guard_2, wariors_atall_3 = wariors_atall_3 - $guard_3
   WHERE countryID = '".$targetID."' LIMIT 1");
   if ($idt_m==TRUE){
      $a['wariors_atall'] = $a['wariors_atall'] - $guard;
      $a['wariors_atall_2'] = $a['wariors_atall_2'] - $guard_2;
      $a['wariors_atall_3'] = $a['wariors_atall_3'] - $guard_3;
      $memcache->set($key2,$a,false,86400);
      }
   */
   if ($there==TRUE){
   mysql_query("UPDATE `wars` SET wariors = wariors + $wariors_end,
   wariors_2 = wariors_2 + $wariors_end_2, wariors_3 = wariors_3 + $wariors_end_3,
   wariors_4 = wariors_4 + $wariors_end_4, wariors_5 = wariors_5 + $wariors_end_5,
   wariors_6 = wariors_6 + $wariors_end_6, wariors_7 = wariors_7 + $wariors_end_7,
   wariors_8 = wariors_8 + $wariors_end_8
   WHERE countryID='$countryID' and targetID='$targetID' LIMIT 1");
   $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetID){
            $mem[$i]['wariors']=$mem[$i]['wariors']+$wariors_end;
            $mem[$i]['wariors_2']=$mem[$i]['wariors_2']+$wariors_end_2;
            $mem[$i]['wariors_3']=$mem[$i]['wariors_3']+$wariors_end_3;
            $mem[$i]['wariors_4']=$mem[$i]['wariors_4']+$wariors_end_4;
            $mem[$i]['wariors_5']=$mem[$i]['wariors_5']+$wariors_end_5;
            $mem[$i]['wariors_6']=$mem[$i]['wariors_6']+$wariors_end_6;
            $mem[$i]['wariors_7']=$mem[$i]['wariors_7']+$wariors_end_7;
            $mem[$i]['wariors_8']=$mem[$i]['wariors_8']+$wariors_end_8;
            break;
        }
    $memcache->set($key,$mem,false,86400);
    }
   }else{
   $query="insert into `wars` values('$countryID','$targetID',$wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8,".time_new().",".time_new().",".time_new().")";
   $result=@MYSQL_QUERY($query);

   $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $neww = array("countryID"=>$countryID, "targetID"=>$targetID, "wariors"=>$wariors_end, "wariors_2"=>$wariors_end_2, "wariors_3"=>$wariors_end_3, "wariors_4"=>$wariors_end_4, "wariors_5"=>$wariors_end_5, "wariors_6"=>$wariors_end_6, "wariors_7"=>$wariors_end_7, "wariors_8"=>$wariors_end_8, "time1"=>time_new(), "time2"=>time_new(), "time3"=>time_new());
    array_push($mem,$neww);
    $memcache->set($key,$mem,false,86400);
    }
   }

   //повышение опыта генералов:
   general_exp($countryID,$targetID,$lost,array($guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8));
   return true;
  //битва выиграна

 }else{   //Проигрыш

  //потери защиты...
  $lost2=array();
  $guard_end = round($guard*(1 - $br[2]/$br[1]));
  array_push($lost2,round($guard*$br[2]/$br[1]));
  $guard_end_2 = round($guard_2*(1 - $br[2]/$br[1]));
  array_push($lost2,round($guard_2*$br[2]/$br[1]));
  $guard_end_3 = round($guard_3*(1 - $br[2]/$br[1]));
  array_push($lost2,round($guard_3*$br[2]/$br[1]));
  $guard_end_4 = round($guard_4*(1 - $br[2]/$br[1]));
  array_push($lost2,round($guard_4*$br[2]/$br[1]));
  $guard_end_5 = round($guard_5*(1 - $br[2]/$br[1]));
  array_push($lost2,round($guard_5*$br[2]/$br[1]));
  $guard_end_6 = round($guard_6*(1 - $br[2]/$br[1]));
  array_push($lost2,round($guard_6*$br[2]/$br[1]));
  $guard_end_7 = round($guard_7*(1 - $br[2]/$br[1]));
  array_push($lost2,round($guard_7*$br[2]/$br[1]));
  $guard_end_8 = round($guard_8*(1 - $br[2]/$br[1]));
  array_push($lost2,round($guard_8*$br[2]/$br[1]));

          if($there==TRUE){
          //если войска были на территории:
   printrus ("Вы не смогли разбить оборону здания <u>".printBuilding($bld)."</u>.
  Ваши воины полегли на поле боя, оставив вражеское войско численностью:<br/>".print_voisko(array($guard_end,$guard_end_2,$guard_end_3,$guard_end_4,$guard_end_5,$guard_end_6,$guard_end_7,$guard_end_8)));
          }else
          printrus ("Вы не смогли разбить оборону стены.
  Ваши воины полегли на поле боя, оставив вражеское войско численностью:<br/>".print_voisko(array($guard_end,$guard_end_2,$guard_end_3,$guard_end_4,$guard_end_5,$guard_end_6,$guard_end_7,$guard_end_8)));
   //повышение опыта генералов:
   general_exp($countryID,$targetID,$att_wariors,$lost2);

   mysql_query("UPDATE `buildings` SET guard = $guard_end, guard_2 = $guard_end_2,
   guard_3 = $guard_end_3, guard_4 = $guard_end_4, guard_5 = $guard_end_5,
   guard_6 = $guard_end_6, guard_7 = $guard_end_7, guard_8 = $guard_end_8
   WHERE countryID = '$targetID' and building = '$bld' LIMIT 1");
   $key=_PREFIKS.':buildings'.$targetID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++){
           if ($mem[$i]['building']==$bld) {
                   $mem[$i]['guard']=$guard_end;
                   $mem[$i]['guard_2']=$guard_end_2;
                   $mem[$i]['guard_3']=$guard_end_3;
                   $mem[$i]['guard_4']=$guard_end_4;
                   $mem[$i]['guard_5']=$guard_end_5;
                   $mem[$i]['guard_6']=$guard_end_6;
                   $mem[$i]['guard_7']=$guard_end_7;
                   $mem[$i]['guard_8']=$guard_end_8;
                   break;
           }
           }
       $memcache->set($key,$mem,false,86400);
       }
   /*
   mysql_query("UPDATE countries SET wariors_atall = wariors_atall - $guard + $guard_end, wariors_atall_2 = wariors_atall_2 - $guard_2 + $guard_end_2, wariors_atall_3 = wariors_atall_3 - $guard_3 + $guard_end_3  WHERE countryID = '$targetID' LIMIT 1");
   if ($idt_m==TRUE){
      $a['wariors_atall'] = $a['wariors_atall'] - $guard + $guard_end;
      $a['wariors_atall_2'] = $a['wariors_atall_2'] - $guard_2 + $guard_end_2;
      $a['wariors_atall_3'] = $a['wariors_atall_3'] - $guard_3 + $guard_end_3;
      $memcache->set($key2,$a,false,86400);
      }
   */
   if ($there==TRUE){
   $key=_PREFIKS.':wars'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetID) {
              $wrs=$mem[$i]['wariors'];
              $wrs_2=$mem[$i]['wariors_2'];
              $wrs_3=$mem[$i]['wariors_3'];
              $wrs_4=$mem[$i]['wariors_4'];
              $wrs_5=$mem[$i]['wariors_5'];
              $wrs_6=$mem[$i]['wariors_6'];
              $wrs_7=$mem[$i]['wariors_7'];
              $wrs_8=$mem[$i]['wariors_8'];
              break;
      }
      }else{
      $rr = mysql_query("SELECT wariors, wariors_2, wariors_3, wariors_4, wariors_5, wariors_6, wariors_7, wariors_8 FROM `wars` WHERE countryID='$countryID' and targetID='$targetID' LIMIT 1");
      $aa = mysql_fetch_array($aa);
      $wrs = $aa['wariors'];
      $wrs_2 = $aa['wariors_2'];
      $wrs_3 = $aa['wariors_3'];
      $wrs_4 = $aa['wariors_4'];
      $wrs_5 = $aa['wariors_5'];
      $wrs_6 = $aa['wariors_6'];
      $wrs_7 = $aa['wariors_7'];
      $wrs_8 = $aa['wariors_8'];
      }

   if(($wrs+$wrs_2+$wrs_3+$wrs_4+$wrs_5+$wrs_6+$wrs_7+$wrs_8)==0){
    $query="delete from `wars` where countryID='$countryID' and targetID='$targetID' limit 1";
    $result=@MYSQL_QUERY($query);
    $key=_PREFIKS.':wars'.$countryID;
    if (($mem=$memcache->get($key))!==FALSE){
       $neww=array();
       for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']!=$targetID) array_push($neww,$mem[$i]);
       $memcache->set($key,$neww,false,86400);
       }

    sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> атаковало здание <u>".printBuilding($bld)."</u>, но не смогло пробить оборону.
    Вражеские войска полностью разбиты! Уцелело:<br/>".print_voisko(array($guard_end,$guard_end_2,$guard_end_3,$guard_end_4,$guard_end_5,$guard_end_6,$guard_end_7,$guard_end_8)));
    printrus ("Враги унчтожили все ваше войско! <u>Вы потеряли доступ к территории этого гос-ва!</u><br/>\r\n");
   }else{
    sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> атаковало здание <u>".printBuilding($bld)."</u>, но не смогло пробить оборону.
    Уцелело:<br/>".print_voisko(array($guard_end,$guard_end_2,$guard_end_3,$guard_end_4,$guard_end_5,$guard_end_6,$guard_end_7,$guard_end_8)));
   }

   }else{
   sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> атаковало защиту стены, но не смогло пробить оборону.
    Уцелело:<br/>".print_voisko(array($guard_end,$guard_end_2,$guard_end_3,$guard_end_4,$guard_end_5,$guard_end_6,$guard_end_7,$guard_end_8)));
   }


  return FALSE;
  //битва проиграна

 }
 /*
 }else{
 //Этот случай может быть только когда нападают на гос-во с уже
//разрушенной стеной. Охрану на стене оставляю (раньше она уничтож)
   printrus ("Вы без боя прошли на территорию вражеского гос-ва через дырки в разломанной стене.<br/>\r\n");
   sendMessage($targetID,"fullMessage","На вашу территорию прорвалось:<br/>".print_voisko($att_wariors)." гос-ва <u>$country</u> через дырки в вашей стене!");

   $query="insert into `wars` values('$countryID','$targetID',".$att_wariors[0].",".$att_wariors[1].",".$att_wariors[2].",".$att_wariors[3].",".$att_wariors[4].",".$att_wariors[5].",".$att_wariors[6].",".$att_wariors[7].",".time_new().",".time_new().",".time_new().")";
   $result=@MYSQL_QUERY($query);

   $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $neww = array("countryID"=>$countryID, "targetID"=>$targetID, "wariors"=>$att_wariors[0], "wariors_2"=>$att_wariors[1], "wariors_3"=>$att_wariors[2], "wariors_4"=>$att_wariors[3], "wariors_5"=>$att_wariors[4], "wariors_6"=>$att_wariors[5], "wariors_7"=>$att_wariors[6], "wariors_8"=>$att_wariors[7], "time1"=>time_new(), "time2"=>time_new(), "time3"=>time_new());
    array_push($mem,$neww);
    $memcache->set($key,$mem,false,86400);
    }
 }
 */

}



//******************************************************************************
//Битва под стеной**************************************************************
function battle_wall($countryID,$targetID,$att_wariors){

 global $memcache,$puwek_pogiblo;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 $key=_PREFIKS.':buildings'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++){
        if ($mem[$i]['building']=='wall'){
           $hits=$mem[$i]['hits'];
           $var1=$mem[$i]['var1'];
           $var2=$mem[$i]['var2'];
           $guard=$mem[$i]['guard'];
           $guard_2=$mem[$i]['guard_2'];
           $guard_3=$mem[$i]['guard_3'];
           $guard_4=$mem[$i]['guard_4'];
           $guard_5=$mem[$i]['guard_5'];
           $guard_6=$mem[$i]['guard_6'];
           $guard_7=$mem[$i]['guard_7'];
           $guard_8=$mem[$i]['guard_8'];
           break;
           }
        }
    }else{
 $query="select * from `buildings` where countryID='$targetID' and building='wall' limit 1";
 $result=@MYSQL_QUERY($query);
 $hits=@mysql_result($result,0,"hits");
 $var1=@mysql_result($result,0,"var1");
 $var2=@mysql_result($result,0,"var2");
 $guard=@mysql_result($result,0,"guard");
 $guard_2=@mysql_result($result,0,"guard_2");
 $guard_3=@mysql_result($result,0,"guard_3");
 $guard_4=@mysql_result($result,0,"guard_4");
 $guard_5=@mysql_result($result,0,"guard_5");
 $guard_6=@mysql_result($result,0,"guard_6");
 $guard_7=@mysql_result($result,0,"guard_7");
 $guard_8=@mysql_result($result,0,"guard_8");
 }

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }

 $count=$b["count"];
 $kind=$b["kind"];
 $protection=$b["protection"];

 $country=$b['countryName'];
 if ($idt_m==TRUE){
    $a=$mb;
    }else{
 $r = mysql_query("SELECT * FROM countries WHERE countryID = '".$targetID."'");
 $a = mysql_fetch_array($r);
 }

 $target=$a['countryName'];
 $stli = otkr_exists($targetID,"STLI");
 $hits_min=(40-30*$stli);

 $fvar2 = $var2;
 $guard_ = $guard;
 $guard__3 = $guard_3;

 while ($hits>$hits_min && $count>0){
 //На стене гибнут только пехотинцы и снайперы
 $count_=$count;
 $count=max(0,$count-max(1,round(3*$fvar2/max(1,$protection)/2)));
 $guard=max(0,$guard-(3-2*$var1));
 $guard_3=max(0,$guard_3-(2-1*$var1));
  //$hits=$hits-7*($kind*(2*$var1-1)-3*$var1+3)-1;
  if (max(1,round(3*$fvar2/max(1,$protection)/2))<=$count_){
  if ($kind!=$var1) $hits = $hits - 6;
  else $hits = $hits - 15;
  }else{
  if ($kind!=$var1) $mhits = round($count_/max(1,round(3*$fvar2/max(1,$protection)/2)));
  else $mhits = round($count_/max(1,round(3*$fvar2/max(1,$protection)/2))*(3/2));
  $hits=$hits-$mhits;
  }

  if ($count>0){
  if ($var2>=10){
          if ($kind==0)$var2=$var2-0.5;
          else $var2=$var2-1;
          }else{
                if ($kind==0)$var2=$var2-1;
                else $var2=$var2-0.5;
                  }
  }

 }
 //5 пушек = 1 стенобитка
 //Защита пушки - сумма ее параметров, деленная на 5
 $p_protection = round(($b['wariors_force_4']+$b['wariors_speed_4'])/5)+1;
 $count_p = round($att_wariors[3]/5);
 $tmp = $count_p; //Запомним, сколько было
 while ($hits>$hits_min && $count_p>0){
 //На стене гибнут только пехотинцы и снайперы
 $count_p_=$count_p;
 $count_p=max(0,$count_p-max(1,round(3*$fvar2/max(1,$p_protection)/2)));
 $guard=max(0,$guard-(3-2*$var1));
 $guard_3=max(0,$guard_3-(2-1*$var1));
  //$hits=$hits-7*($kind*(2*$var1-1)-3*$var1+3)-1;
  if (max(1,round(3*$fvar2/max(1,$p_protection)/2))<=$count_p_){
  if ($kind!=$var1) $hits = $hits - 6;
  else $hits = $hits - 15;
  }else{
  if ($kind!=$var1) $mhits = round($count_p_/max(1,round(3*$fvar2/max(1,$p_protection)/2)));
  else $mhits = round($count_p_/max(1,round(3*$fvar2/max(1,$p_protection)/2))*3/2);
  $hits=$hits-$mhits;
  }

  if ($count_p>0){
  if ($var2>=10){
          if ($kind==0)$var2=$var2-0.5;
          else $var2=$var2-1;
          }else{
                if ($kind==0)$var2=$var2-1;
                else $var2=$var2-0.5;
                  }
 }

 }
 if ($count_p<$tmp) $puwek_pogiblo = min($att_wariors[3],($tmp-$count_p)*5);
 else $puwek_pogiblo=0;

 if ($var2<0)$var2=0;
 $var2 = round($var2);
 $pogiblo = $guard_ - $guard;
 $pogiblo_3 = $guard__3 - $guard_3;
 //Погибло воинов на стене

 if($hits>$hits_min){
  mysql_query("UPDATE `buildings` SET guard = $guard, guard_3 = $guard_3, hits = $hits, var2 = $var2 WHERE countryID='$targetID' and building='wall' LIMIT 1");

  $key=_PREFIKS.':buildings'.$targetID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++){
           if ($mem[$i]['building']=='wall') {
                   $mem[$i]['guard']=$guard;
                   $mem[$i]['guard_3']=$guard_3;
                   $mem[$i]['hits']=$hits;
                   $mem[$i]['var2']=$var2;
                   break;
           }
           }
       $memcache->set($key,$mem,false,86400);
       }

  /*
  mysql_query("UPDATE `countries` SET wariors_atall = wariors_atall - $pogiblo, wariors_atall_3 = wariors_atall_3 - $pogiblo_3 WHERE countryID = '$targetID' LIMIT 1");
  if ($idt_m==TRUE){
      $a['wariors_atall'] = $a['wariors_atall'] - $pogiblo;
      $a['wariors_atall_3'] = $a['wariors_atall_3'] - $pogiblo_3;
      $memcache->set($key2,$a,false,86400);
      }
  */

  mysql_query("UPDATE countries SET `count` = 0, wariors_free = wariors_free + ".$att_wariors[0].",
  wariors_free_2 = wariors_free_2 + ".$att_wariors[1].", wariors_free_3 = wariors_free_3 + ".$att_wariors[2].",
  wariors_free_4 = wariors_free_4 + ".($att_wariors[3]-$puwek_pogiblo).", wariors_free_5 = wariors_free_5 + ".$att_wariors[4].",
  wariors_free_6 = wariors_free_6 + ".$att_wariors[5].", wariors_free_7 = wariors_free_7 + ".$att_wariors[6].",
  wariors_free_8 = wariors_free_8 + ".$att_wariors[7]."
  WHERE countryID = '$countryID' LIMIT 1");
  $b['count'] = 0;
  $b['wariors_free'] = $b['wariors_free'] + $att_wariors[0];
  $b['wariors_free_2'] = $b['wariors_free_2'] + $att_wariors[1];
  $b['wariors_free_3'] = $b['wariors_free_3'] + $att_wariors[2];
  $b['wariors_free_4'] = $b['wariors_free_4'] + $att_wariors[3] - $puwek_pogiblo;
  $b['wariors_free_5'] = $b['wariors_free_5'] + $att_wariors[4];
  $b['wariors_free_6'] = $b['wariors_free_6'] + $att_wariors[5];
  $b['wariors_free_7'] = $b['wariors_free_7'] + $att_wariors[6];
  $b['wariors_free_8'] = $b['wariors_free_8'] + $att_wariors[7];
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  if ($puwek_pogiblo==0){
  printrus ("В битве под стеной вы потеряли все стенобитные орудия и так и не смогли проломить оборону гос-ва <u>$target</u>!<br/>$pogiblo вражеских пехотинцев и $pogiblo_3 стрелков погибли, обороняя стену! Стена разломана до <b>$hits</b>%<br/>\r\n");
  sendMessage($targetID,"fullMessage","Войско гос-ва <u>$country</u> подошло к вашей стене, но в сражении потеряло все свои стенобитные орудия.<br/>$pogiblo ваших пехотинцев и $pogiblo_3 стрелков на стене погибли<br/>
                                                   <u>Стена</u> разломана до <b>$hits %</b>, укрепление до <b>$var2</b>.");
  }else{
  printrus ("В битве под стеной вы потеряли все стенобитные орудия, $puwek_pogiblo пушек и так и не смогли проломить оборону гос-ва <u>$target</u>!<br/>$pogiblo вражеских пехотинцев и $pogiblo_3 стрелков погибли, обороняя стену! Стена разломана до <b>$hits</b>%<br/>\r\n");
  sendMessage($targetID,"fullMessage","Войско гос-ва <u>$country</u> подошло к вашей стене, но в сражении потеряло все свои стенобитные орудия и $puwek_pogiblo пушек.<br/>$pogiblo ваших пехотинцев и $pogiblo_3 стрелков на стене погибли<br/>
                                                   <u>Стена</u> разломана до <b>$hits %</b>, укрепление до <b>$var2</b>.");
  }
  return false;
 }else{
  $count = max(0,$count);
  mysql_query("UPDATE countries SET `count` = $count WHERE countryID='$countryID' LIMIT 1");
  $b['count'] = $count;
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }
  mysql_query("UPDATE buildings SET hits = $hits, var2 = $var2, guard = $guard, guard_3 = $guard_3 WHERE countryID='$targetID' and building='wall' LIMIT 1");
  $key=_PREFIKS.':buildings'.$targetID;
    if (($mem=$memcache->get($key))!==FALSE){
       for ($i=0;$i<count($mem);$i++){
           if ($mem[$i]['building']=='wall') {
                   $mem[$i]['guard']=$guard;
                   $mem[$i]['guard_3']=$guard_3;
                   $mem[$i]['hits']=$hits;
                   $mem[$i]['var2']=$var2;
                   break;
            }
           }
       $memcache->set($key,$mem,false,86400);
       }
  /*
  mysql_query("UPDATE `countries` SET wariors_atall = wariors_atall - $pogiblo, wariors_atall_3 = wariors_atall_3 - $pogiblo_3 WHERE countryID='$targetID' LIMIT 1");
  if ($idt_m==TRUE){
      $a['wariors_atall'] = $a['wariors_atall'] - $pogiblo;
      $a['wariors_atall_3'] = $a['wariors_atall_3'] - $pogiblo_3;
      $memcache->set($key2,$a,false,86400);
      }
  */
  printrus ("Вам удалось проломить дыру в стене гос-ва <u>$target</u>!<br/>При штурме стены погибли $pogiblo вражеских пехотинцев и $pogiblo_3 стрелков, обороняющих стену!<br/>\r\n");
  sendMessage($targetID,"fullMessage","Войску гос-ва <u>$country</u> удалось проломить дыру в стене,
                                                   <u>Стена</u> разломана до <b>$hits %</b><br/>$pogiblo ваших пехотинцев и $pogiblo_3 стрелков на стене погибли!.");

  return true;
 }

}


//******************************************************************************
//Начало войны******************************************************************

function start_war($countryID,$targetID,$att_wariors){

 global $memcache,$puwek_pogiblo;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 if ($idt_m==TRUE){
 $a=$mb;
    }else{
 $query="select * from `countries` where countryID='$targetID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 }
 $target=$a["countryName"];

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }

 $country=$b["countryName"];

 $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $num=0;
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']==$targetID) {$num=1;break;}
    }else{
 $query="select * from `wars` where countryID='$countryID' and targetID='$targetID' limit 1";
 $result=@MYSQL_QUERY($query);
 $num=@mysql_num_rows($result);
 }

 $spy_lvl=$a["spy"];

 if ($num==0){
         $key=_PREFIKS.':unite'.$targetID;
         if (($mem=$memcache->get($key))!==FALSE){
         for ($i=0;$i<count($mem);$i++){
             $uniteeID = $mem[$i];
             sendMessage($uniteeID,"fullMessage","Государство <u>$country</u> атаковало вашего союзника <u>$target</u>!!!");
             }
            }else{
         $t = mysql_query("SELECT uniteeID FROM `unite` WHERE countryID = '$targetID'");
         while (($s=mysql_fetch_array($t))!==FALSE){
                 $uniteeID = $s['uniteeID'];
                 sendMessage($uniteeID,"fullMessage","Государство <u>$country</u> атаковало вашего союзника <u>$target</u>!!!");
                 }

                 }

         }

 mysql_query("UPDATE `countries` SET lastWar = '".time()."' WHERE countryID = '$countryID' LIMIT 1");
 $b['lastWar'] = time();
 if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

 if($num>0){
  printrus ("Вы уже ведете войну с гос-вом <u>$target</u>!<br/>\r\n");
  mysql_query("UPDATE `countries` SET wariors_free = wariors_free + ".$att_wariors[0].",
  wariors_free_2 = wariors_free_2 + ".$att_wariors[1].", wariors_free_3 = wariors_free_3 + ".$att_wariors[2].",
  wariors_free_4 = wariors_free_4 + ".$att_wariors[3].", wariors_free_5 = wariors_free_5 + ".$att_wariors[4].",
  wariors_free_6 = wariors_free_6 + ".$att_wariors[5].", wariors_free_7 = wariors_free_7 + ".$att_wariors[6].",
  wariors_free_8 = wariors_free_8 + ".$att_wariors[7]."
  WHERE countryID = '$countryID' LIMIT 1");
  $b['wariors_free'] = $b['wariors_free'] + $att_wariors[0];
  $b['wariors_free_2'] = $b['wariors_free_2'] + $att_wariors[1];
  $b['wariors_free_3'] = $b['wariors_free_3'] + $att_wariors[2];
  $b['wariors_free_4'] = $b['wariors_free_4'] + $att_wariors[3];
  $b['wariors_free_5'] = $b['wariors_free_5'] + $att_wariors[4];
  $b['wariors_free_6'] = $b['wariors_free_6'] + $att_wariors[5];
  $b['wariors_free_7'] = $b['wariors_free_7'] + $att_wariors[6];
  $b['wariors_free_8'] = $b['wariors_free_8'] + $att_wariors[7];

  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  }elseif(!building_exists($targetID,"wall")){

  printrus ("Ваши войска не встретили никакого сопротивления и беспрепятственно вошли на территорию гос-ва <u>$target</u><br/>\r\n");
  sendMessage($targetID,"fullMessage","На вас напало государство <u>$country</u>!
                                                                             Вражеское войско численностью:<br/>".print_voisko($att_wariors)." смогло беспрепятственно войти на вашу территорию.");
  $query="insert into `wars` values('$countryID','$targetID',".$att_wariors[0].",".$att_wariors[1].",".$att_wariors[2].",".$att_wariors[3].",".$att_wariors[4].",".$att_wariors[5].",".$att_wariors[6].",".$att_wariors[7].",".time().",".time().",".time().")";
  $result=@MYSQL_QUERY($query);
  $key=_PREFIKS.':wars'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
  $neww = array("countryID"=>$countryID, "targetID"=>$targetID, "wariors"=>$att_wariors[0],"wariors_2"=>$att_wariors[1],"wariors_3"=>$att_wariors[2],"wariors_4"=>$att_wariors[3],"wariors_5"=>$att_wariors[4],"wariors_6"=>$att_wariors[5],"wariors_7"=>$att_wariors[6],"wariors_8"=>$att_wariors[7], "time1"=>time(), "time2"=>time(), "time3"=>time());
  array_push($mem,$neww);
  $memcache->set($key,$mem,false,86400);
  }

 }elseif(($b["count"]+round($att_wariors[3]/5))==0){
  printrus ("Вы не можете атаковать гос-во <u>$target</u> без стенобитных орудий или хотя бы 3 пушек!<br/>\r\n");
  mysql_query("UPDATE countries SET wariors_free = wariors_free + ".$att_wariors[0].",
  wariors_free_2 = wariors_free_2 + ".$att_wariors[1].", wariors_free_3 = wariors_free_3 + ".$att_wariors[2].",
  wariors_free_4 = wariors_free_4 + ".$att_wariors[3].", wariors_free_5 = wariors_free_5 + ".$att_wariors[4].",
  wariors_free_6 = wariors_free_6 + ".$att_wariors[5].", wariors_free_7 = wariors_free_7 + ".$att_wariors[6].",
  wariors_free_8 = wariors_free_8 + ".$att_wariors[7]."
  WHERE countryID = '$countryID' LIMIT 1");
  $b['wariors_free'] = $b['wariors_free'] + $att_wariors[0];
  $b['wariors_free_2'] = $b['wariors_free_2'] + $att_wariors[1];
  $b['wariors_free_3'] = $b['wariors_free_3'] + $att_wariors[2];
  $b['wariors_free_4'] = $b['wariors_free_4'] + $att_wariors[3];
  $b['wariors_free_5'] = $b['wariors_free_5'] + $att_wariors[4];
  $b['wariors_free_6'] = $b['wariors_free_6'] + $att_wariors[5];
  $b['wariors_free_7'] = $b['wariors_free_7'] + $att_wariors[6];
  $b['wariors_free_8'] = $b['wariors_free_8'] + $att_wariors[7];

  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }
   }elseif(getValue("countryID='$targetID' and building='wall'","buildings","hits")<=(40-30*otkr_exists($countryID,"STLI"))){

  printrus ("Ваши войска подошли к уже разрушенной стене гос-ва <u>$target</u>. Видимо кто-то постарался до вас...<br/>\r\n");
  battle_bld($countryID,$targetID,$att_wariors,"wall",false,true);

 }else{
  if(battle_wall($countryID,$targetID,$att_wariors))
   battle_bld($countryID,$targetID,$att_wariors,"wall",false);
 }

}


//******************************************************************************
//Страна захвачена**************************************************************
function countryTaken($countryID,$targetID){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }

 $str="Награблено: ";

 //война закончилась...
 $query="delete from `wars` where countryID='$countryID' and targetID='$targetID' limit 1";
 $result=@MYSQL_QUERY($query);
 $key=_PREFIKS.':wars'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $neww=array();
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['targetID']!=$targetID) array_push($neww,$mem[$i]);
    $memcache->set($key,$neww,false,86400);
    }
 //забираем все ресурсы...

 $max=free_place($countryID);

 if ($idt_m==TRUE){
    $a=$mb;
    }else{
 $r = mysql_query("SELECT * FROM countries WHERE countryID = '$targetID'");
 $a = mysql_fetch_array($r);
 }

 //$people=min(round($a['workers']/5),round($a['grain']/10));
 $people=round(2*$a['workers']/5);
 //Берем только 40% часть рабочих
 if($max>0) {$arbor=min($max,$a['arbor']); $max=$max-$arbor;}else $arbor = 0;
 if($max>0) {$stone=min($max,$a['stone']); $max=$max-$stone;}else $stone = 0;
 if($max>0) {$iron=min($max,$a['iron']); $max=$max-$iron;}else $iron = 0;
 if($max>0) {$grain=min($max,$a['grain']); $max=$max-$grain;}else $grain = 0;
 if($max>0) {$oil=min($max,$a['oil']); $max=$max-$oil;}else $oil = 0;
 //Максимум со страны - 15000 денег
 $money=min(15000,$a['money']);
 $pr = rand(7,15);
 $forest=$a['forest'];
 $realland="select sum(var2) as num from `works` WHERE countryID = '$targetID'";
 $reals = mysql_query($realland);
 $alllands = mysql_fetch_array($reals);
 $allland=$alllands['num']+$a['land'];
 if($a['mountains']<1000 and  $allland>=5001)$a['mountains']=1000;         //+10% гор от всей земли
 $mountains=$a['mountains']+round($a['land']*$pr/100);
 $land=$a['land']+round($a['land']*$pr/100);
 $scientists=$a['scientists'];
 //И пятую часть ученых

 //Пишем в лог
 @$open=fopen("logs/zah".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName']."(ip=".$b['ip'].",soft=".$b['soft'].")->".$a['countryName']."(ip=".$a['ip'].", soft=".$a['soft']."). Развитие: nalog=".$a['nalog'].",napr=".$a['napr']."%, land=".$a['land'].", mountains=".$a['mountains']."(all=$mountains), forest=".$a['forest'].", money=".$a['money'].", arbor=".$a['arbor'].", stone=".$a['stone'].", grain=".$a['grain'].", iron=".$a['iron'].", oil=".$a['oil'].", workers=".$a['workers'].", scientists=".$a['scientists'].", sciencelvl=".$a['science'].", плотн.людей=".$a['plotn_people'].", плотн.войска=".$a['plotn_wariors'].", прирост насел.=".$a['people_adding'].", выращ.лесов=".$a['forest_adding'].", выращ.зерна=".$a['grain_making'].", доб.леса=".$a['arbor_making'].", доб.жел.=".$a['iron_making'].", доб.камня=".$a['stone_making'].", шпион./сабот./граб./верб.:".$a['spy']."/".$a['sabotage']."/".$a['grabber']."/".$a['verb'].", spyT=".$a['spyTime'].", sabT=".$a['sabTime'].", grabT=".$a['grbTime'].", verbT=".$a['vrbTime'].", военные:".$a['wariors_atall']."/".$a['wariors_free'].'-'.$a['wariors_atall_2'].'/'.$a['wariors_free_2'].'-'.$a['wariors_atall_3'].'/'.$a['wariors_free_3'].", параметры:".$a['weapon_force'].'/'.$a['weapon_speed'].'-'.$a['weapon_force_2'].'/'.$a['weapon_speed_2'].'-'.$a['weapon_force_3'].'/'.$a['weapon_speed_3'].", защ.стеноб.=".$a['protection']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

mysql_query("UPDATE countries SET workers=0, arbor=0, stone=0, iron=0, grain=0, oil=0, money=0, forest=0, mountains=0, land=0, scientists=0 WHERE countryID = '$targetID'");
if ($idt_m==TRUE){
   $a['workers']=$a['arbor']=$a['stone']=$a['iron']=$a['grain']=$a['oil']=$a['money']=$a['forest']=$a['mountains']=$a['land']=$a['scientists']=0;
   $memcache->set($key2,$a,false,86400);
   }

 //Ограничение на увеличение земли:
 $alll = countAllLand($countryID, TRUE);
 if ($alll>10000){
         $land = round($land/$alll*500);
         }

 mysql_query("UPDATE countries SET workers=workers+$people, arbor=arbor+$arbor, stone=stone+$stone, iron=iron+$iron, grain=grain+$grain, oil=oil+$oil, money=money+$money, forest=forest+$forest, mountains=mountains+$mountains, land=land+$land, scientists=scientists+$scientists WHERE countryID = '$countryID'");
 echo mysql_error();
 $b['workers'] = $b['workers'] + $people;
 $b['arbor'] = $b['arbor'] + $arbor;
 $b['stone'] = $b['stone'] + $stone;
 $b['iron'] = $b['iron'] + $iron;
 $b['grain'] = $b['grain'] + $grain;
 $b['oil'] = $b['oil'] + $oil;
 $b['money'] = $b['money'] + $money;
 $b['forest'] = $b['forest'] + $forest;
 $b['mountains'] = $b['mountains'] + $mountains;
 $b['land'] = $b['land'] + $land;
 $b['scientists'] = $b['scientists'] + $scientists;
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }

 $query="delete from `market` where countryID='$targetID'";
 $result=@MYSQL_QUERY($query);
 $key=_PREFIKS.':market'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
    $newm=array();
    $memcache->set($key,$newm,false,86400);
    }

 if($scientists>0){
  $str.=" ученые(<b>$scientists</b>)";
 }
 if($people>0){
  $str.=" рабочие(<b>$people</b>)";
 }
 if($money>0){
  $str.=" деньги(<b>$money</b>)";
 }
 if($iron>0){
  $str.=" железо(<b>$iron</b>)";
 }
 if($arbor>0){
  $str.=" дерево(<b>$arbor</b>)";
 }
 if($grain>0){
  $str.=" зерно(<b>$grain</b>)";
 }
 if($oil>0){
  $str.=" нефти(<b>$oil</b>)";
 }
 if($stone>0){
  $str.=" камень(<b>$stone</b>)";
 }
 if($forest>0){
  $str.=" лес(<b>$forest</b>)";
 }
 if($mountains>0){
  $str.=" горы(<b>$mountains</b>($pr % от общей территории захваченной земли))";
 }
 if($land>0){
  $str.=" земля(<b>$land</b>)";
 }

 //берем соседей
 $all = countAllLand($countryID,TRUE);
 if ($all<40000){
 $country=$b['countryName'];
 $neighs=returnNeighbours($targetID,1);
 //$neighs=returnNeighbours($targetID);
 //$yourn=returnNeighbours($countryID);
 $yourn=returnNeighbours($countryID,1);
 if (count($yourn)<20){
 for($i=0;$i<count($neighs);$i++){
  //$neighbourID=getCountryID($neighs[$i]);
  $neighbourID=$neighs[$i];
  //Пишем в лог, что был такой сосед:
 @$open=fopen("logs/sos".$neighbourID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$a['countryName']."(ID=".$a['countryID'].")\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  if(!neighbour_exists($countryID,$neighbourID) && $neighbourID!=$countryID && checkCountryID($neighbourID)){
   setNeighbour($countryID,$neighbourID);
   sendMessage($neighbourID,"newNeighbour","$country");
   sendMessage($countryID,"newNeighbour",checkCountryID($neighs[$i]));
  }
 }

  }else{
       $str=$str." У вас уже так много соседей, что вы не в состоянии контролировать всю территорию. Новые соседи не добавляются!";
          }
  }else $str=$str." У вас настолько большая территория, что вы не в состоянии контролировать все границы. Новые соседи не добавляются!";

 $key=_PREFIKS.':clans'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $clanID = $mem;
    }else{
    $r=mysql_query("SELECT clanID FROM `uzers` WHERE countryID = '$countryID'");
    $h=mysql_fetch_array($r);
    if ($h!==FALSE)
    $clanID = $h['clanID'];
    else $clanID=0;
    }

 if ($clanID!=0){
         //Приписываем клану победу над страной
    mysql_query("UPDATE `clans` SET c_killed = c_killed + 1 WHERE id = '".$clanID."'");
    }

 looser($targetID,$countryID);

 if($str=="Награблено: ") $str="hmmm..";
 return $str;

}


//******************************************************************************
//Захват страны*****************************************************************
function takecountry($countryID,$targetID,$att_wariors){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 if ($idt_m==TRUE){
 $a=$mb;
    }else{
 $query="select * from `countries` where countryID='$targetID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 }

 $target=$a["countryName"];

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }
 $country=$b["countryName"];

 //инфа о вражеском войске:
 $def_wariors=array($a["wariors_free"],$a["wariors_free_2"],$a["wariors_free_3"],$a["wariors_free_4"],$a["wariors_free_5"],$a["wariors_free_6"],$a["wariors_free_7"],$a["wariors_free_8"]);

 $def_params['bronya_kind']=$a["bronya_kind"];
 $def_params['weapon_kind']=$a["weapon_kind"];

 $def_params['weapon_speed']=array($a["weapon_speed"],$a["weapon_speed_2"],$a["weapon_speed_3"],$a["weapon_speed_4"],$a["weapon_speed_5"],$a["weapon_speed_6"],$a["weapon_speed_7"],$a["weapon_speed_8"]);
 $def_params['weapon_force']=array($a["weapon_force"],$a["weapon_force_2"],$a["weapon_force_3"],$a["weapon_force_4"],$a["weapon_force_5"],$a["weapon_force_6"],$a["weapon_force_7"],$a["weapon_force_8"]);

 //а может и воевать не надо?:)... если нет воинов.
 if(($def_wariors[0]+$def_wariors[1]+$def_wariors[2]+$def_wariors[3]+$def_wariors[4]+$def_wariors[5]+$def_wariors[6]+$def_wariors[7])<=0){

  $str=countryTaken($countryID,$targetID);
  printrus ("Вы не потеряв ни одного воина с захватили незащищенное гос-во <u>$target</u>! $str.<br/>\r\n");
  sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> с легкостью захватило ваше гос-во!");

  mysql_query("UPDATE countries SET wariors_free = wariors_free + ".$att_wariors[0].",
  wariors_free_2 = wariors_free_2 + ".$att_wariors[1].", wariors_free_3 = wariors_free_3 + ".$att_wariors[2].",
  wariors_free_4 = wariors_free_4 + ".$att_wariors[3].", wariors_free_5 = wariors_free_5 + ".$att_wariors[4].",
  wariors_free_6 = wariors_free_6 + ".$att_wariors[5].", wariors_free_7 = wariors_free_7 + ".$att_wariors[6].",
  wariors_free_8 = wariors_free_8 + ".$att_wariors[7]."
  WHERE countryID = '$countryID' LIMIT 1");

  $b=$memcache->get($key1);
  //Т.к. данные мемкеша изменила ф-я CountryTaken, надо синхронизовать
  $b['wariors_free'] = $b['wariors_free'] + $att_wariors[0];
  $b['wariors_free_2'] = $b['wariors_free_2'] + $att_wariors[1];
  $b['wariors_free_3'] = $b['wariors_free_3'] + $att_wariors[2];
  $b['wariors_free_4'] = $b['wariors_free_4'] + $att_wariors[3];
  $b['wariors_free_5'] = $b['wariors_free_5'] + $att_wariors[4];
  $b['wariors_free_6'] = $b['wariors_free_6'] + $att_wariors[5];
  $b['wariors_free_7'] = $b['wariors_free_7'] + $att_wariors[6];
  $b['wariors_free_8'] = $b['wariors_free_8'] + $att_wariors[7];

  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }
  mysql_query("UPDATE `uzers` SET counts = counts +1, credits = credits +1 WHERE countryID = '$countryID' LIMIT 1");

  return true;
  //битва выиграна
  break;
 }

 //инфа о своем войске:
 $att_params['bronya_kind']=$b["bronya_kind"];
 $att_params['weapon_kind']=$b["weapon_kind"];

 $att_params['weapon_speed']=array($b["weapon_speed"],$b["weapon_speed_2"],$b["weapon_speed_3"],$b["weapon_speed_4"],$b["weapon_speed_5"],$b["weapon_speed_6"],$b["weapon_speed_7"],$b["weapon_speed_8"]);
 $att_params['weapon_force']=array($b["weapon_force"],$b["weapon_force_2"],$b["weapon_force_3"],$b["weapon_force_4"],$b["weapon_force_5"],$b["weapon_force_6"],$b["weapon_force_7"],$b["weapon_force_8"]);

 $att_general = general_info($countryID);
 if(!$general=general_info($targetID))$def_general=array();
 else $def_general=$general;

 $br = battle($att_general,$att_params,$att_wariors,$def_general,$def_params,$def_wariors);

 //конец сражения:
 if($br[0]=="att"){
  //Расчет количества потерь, урон, нанесенный противником:
  $lost=array();
  $wariors_end = round($att_wariors[0]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[0]*($br[1]/$br[2])));
  $wariors_end_2 = round($att_wariors[1]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[1]*($br[1]/$br[2])));
  $wariors_end_3 = round($att_wariors[2]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[2]*($br[1]/$br[2])));
  $wariors_end_4 = round($att_wariors[3]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[3]*($br[1]/$br[2])));
  $wariors_end_5 = round($att_wariors[4]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[4]*($br[1]/$br[2])));
  $wariors_end_6 = round($att_wariors[5]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[5]*($br[1]/$br[2])));
  $wariors_end_7 = round($att_wariors[6]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[6]*($br[1]/$br[2])));
  $wariors_end_8 = round($att_wariors[7]*(1 - $br[1]/$br[2]));
  array_push($lost,round($att_wariors[7]*($br[1]/$br[2])));

  $str=countryTaken($countryID,$targetID);
  $b=$memcache->get($key1);
  //Т.к. данные мемкеша изменила ф-я CountryTaken, надо синхронизовать
  printrus ("Вы одержали победу над вражеским войском и захватили гос-во <u>$target</u>! Уцелело воинов:<br/>".print_voisko(array($wariors_end,$wariors_end_2,$wariors_end_3,$wariors_end_4,$wariors_end_5,$wariors_end_6,$wariors_end_7,$wariors_end_8))."$str.<br/>\r\n");
  sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> пробило защиту вашего гос-ва и захватило его!");

  mysql_query("UPDATE countries SET wariors_free = wariors_free + $wariors_end,
  wariors_free_2 = wariors_free_2 + $wariors_end_2, wariors_free_3 = wariors_free_3 + $wariors_end_3,
  wariors_free_4 = wariors_free_4 + $wariors_end_4, wariors_free_5 = wariors_free_5 + $wariors_end_5,
  wariors_free_6 = wariors_free_6 + $wariors_end_6, wariors_free_7 = wariors_free_7 + $wariors_end_7,
  wariors_free_8 = wariors_free_8 + $wariors_end_8
  WHERE countryID = '$countryID' LIMIT 1");
  $b['wariors_free'] = $b['wariors_free'] + $wariors_end;
  $b['wariors_free_2'] = $b['wariors_free_2'] + $wariors_end_2;
  $b['wariors_free_3'] = $b['wariors_free_3'] + $wariors_end_3;
  $b['wariors_free_4'] = $b['wariors_free_4'] + $wariors_end_4;
  $b['wariors_free_5'] = $b['wariors_free_5'] + $wariors_end_5;
  $b['wariors_free_6'] = $b['wariors_free_6'] + $wariors_end_6;
  $b['wariors_free_7'] = $b['wariors_free_7'] + $wariors_end_7;
  $b['wariors_free_8'] = $b['wariors_free_8'] + $wariors_end_8;

  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  //повышение опыта генералов:
  general_exp($countryID,$targetID,$lost,$def_wariors);
  mysql_query("UPDATE `uzers` SET counts = counts +1, credits = credits +1 WHERE countryID = '$countryID' LIMIT 1");

  return true;
  //битва выиграна

 }else{

  //Расчет количества потерь, урон, нанесенный противником:
  $lost2=array();
  $guard_end = $def_wariors[0]*(1 - $br[2]/$br[1]);
  array_push($lost2,round($def_wariors[0]*$br[2]/$br[1]));
  $guard_end_2 = $def_wariors[1]*(1 - $br[2]/$br[1]);
  array_push($lost2,round($def_wariors[1]*$br[2]/$br[1]));
  $guard_end_3 = $def_wariors[2]*(1 - $br[2]/$br[1]);
  array_push($lost2,round($def_wariors[2]*$br[2]/$br[1]));
  $guard_end_4 = $def_wariors[3]*(1 - $br[2]/$br[1]);
  array_push($lost2,round($def_wariors[3]*$br[2]/$br[1]));
  $guard_end_5 = $def_wariors[4]*(1 - $br[2]/$br[1]);
  array_push($lost2,round($def_wariors[4]*$br[2]/$br[1]));
  $guard_end_6 = $def_wariors[5]*(1 - $br[2]/$br[1]);
  array_push($lost2,round($def_wariors[5]*$br[2]/$br[1]));
  $guard_end_7 = $def_wariors[6]*(1 - $br[2]/$br[1]);
  array_push($lost2,round($def_wariors[6]*$br[2]/$br[1]));
  $guard_end_8 = $def_wariors[7]*(1 - $br[2]/$br[1]);
  array_push($lost2,round($def_wariors[7]*$br[2]/$br[1]));

  printrus ("Вы не смогли разбить оборону вражеского государства. <u>Вы потеряли доступ к территории этого гос-ва!</u>.<br/>\r\n");
  sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> приняло позиции для захвата вашей страны, но не смогло проломить оборону вашего гос-ва.
                                                                             Уцелело:<br/>".print_voisko(array($guard_end,$guard_end_2,$guard_end_3,$guard_end_4,$guard_end_5,$guard_end_6,$guard_end_7,$guard_end_8)));
  //повышение опыта генералов:
  general_exp($countryID,$targetID,$att_wariors,$lost2);

  mysql_query("UPDATE `countries` SET wariors_free = $guard_end, wariors_free_2 = $guard_end_2,
  wariors_free_3 = $guard_end_3, wariors_free_4 = $guard_end_4, wariors_free_5 = $guard_end_5,
  wariors_free_6 = $guard_end_6, wariors_free_7 = $guard_end_7, wariors_free_8 = $guard_end_8
  WHERE countryID = '$targetID' LIMIT 1");
  if ($idt_m==TRUE){
     $a['wariors_free'] = $guard_end;
     $a['wariors_free_2'] = $guard_end_2;
     $a['wariors_free_3'] = $guard_end_3;
     $a['wariors_free_4'] = $guard_end_4;
     $a['wariors_free_5'] = $guard_end_5;
     $a['wariors_free_6'] = $guard_end_6;
     $a['wariors_free_7'] = $guard_end_7;
     $a['wariors_free_8'] = $guard_end_8;
     $memcache->set($key2,$a,false,86400);
     }

  $query="delete from `wars` where countryID='$countryID' and targetID='$targetID' limit 1";
  $result=@MYSQL_QUERY($query);
  $key=_PREFIKS.':wars'.$countryID;
  if (($mem=$memcache->get($key))!==FALSE){
     $neww=array();
     for ($i=0;$i<count($mem);$i++){
         if ($mem[$i]['targetID']!=$targetID) array_push($neww,$mem[$i]);
         }
     $memcache->set($key,$neww,false,86400);
     }

  return false;
  //битва проиграна

 }
}


//******************************************************************************
//атомная бомба ****************************************************************
function atomic_bld($countryID,$targetID){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 if ($idt_m==TRUE){
 $a=$mb;
    }else{
 $query="select * from `countries` where countryID='$targetID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 }

 $target=$a["countryName"];

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 $query="select maratory from `uzers` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a2 = mysql_fetch_array($result);
 $b['mrt'] = $a2['maratory'];
 }

 $country=$b["countryName"];
 //Ночной мараторий
 $nightmar = FALSE;
 if ($b['mrt']>18){
    if (date("G")+0>=$b['mrt']||date("G")+0<($b['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$b['mrt']&&date("G")+0<=($b['mrt']+5)) $nightmar = TRUE;
    }
 if ($b['mrt']==25) $nightmar=FALSE;

 if($nightmar==TRUE){
 printrus ("Вы находитесь в ночном маратории и не можете применять атомную бомбу!<br/>\r\n");
 return false;
 }

 if($b['moratory']>time()){
 printrus ("Вы находитесь в купленном моратории и не можете применять атомную бомбу!<br/>\r\n");
 return false;
 }

 if($mar=maratory($targetID)){
  printrus ("На государство <u>$target</u> действует мараторий неприкосновенности! Повторите попытку через ".mkTimeStr($mar).".<br/>\r\n");
  return false;
 }

 $key=_PREFIKS.':buildings'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
 $newb=array();
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='wall') {
         /*
         $guard=$mem[$i]['guard'];
         $guard_2=$mem[$i]['guard_2'];
         $guard_3=$mem[$i]['guard_3'];
         */
         $var2=$mem[$i]['var2'];
    }
 else array_push($newb,$mem[$i]);
 //$memcache->set($key,$newb,false,86400);
    }else{
 $query="select * from `buildings` where countryID='$targetID' and building='wall' limit 1";
 $result=@MYSQL_QUERY($query);
 /*
 $guard=@mysql_result($result,0,"guard");
 $guard_2=@mysql_result($result,0,"guard_2");
 $guard_3=@mysql_result($result,0,"guard_3");
 */
 $var2=@mysql_result($result,0,"var2");
 }

 if (!otkr_exists($targetID,'STLI')||$var2<10){
 //Если нет стальной арматуры или укрепление стены меньше 10

 mysql_query("DELETE FROM `buildings` where countryID='$targetID' and building='wall' limit 1");
 $memcache->set($key,$newb,false,86400);
 mysql_query("DELETE FROM `works` where countryID='$targetID' and kind='repairing' and what = 'wall' limit 1");
 $key=_PREFIKS.':works'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
    $neww=array();
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='repairing'&&$mem[$i]['what']=='wall'){}
     else array_push($neww,$mem[$i]);
    $memcache->set($key,$neww,false,86400);
    }
 /*
 mysql_query("UPDATE `countries` SET wariors_atall = wariors_atall - $guard, wariors_atall_2 = wariors_atall_2 - $guard_2, wariors_atall_3 = wariors_atall_3 - $guard_3 WHERE countryID = '$targetID' LIMIT 1");
 if ($idt_m==TRUE){
    $a['wariors_atall'] = $a['wariors_atall'] - $guard;
    $a['wariors_atall_2'] = $a['wariors_atall_2'] - $guard_2;
    $a['wariors_atall_3'] = $a['wariors_atall_3'] - $guard_3;
    $memcache->set($key2,$a,false,86400);
    }
 */
 printrus ("Вы взорвали стену противника атомной бомбой!!! Погибла вся охрана и все рабочие, чинившие стену!<br/>\r\n");
 sendMessage($targetID,"fullMessage","Стена взорвана атомной бомбой гос-ва <u>$country</u>! Погибла вся охрана и все рабочие, чинившие стену!");
 }else{
 //Иначе только ломаем стену на 10 уровней
 mysql_query("UPDATE `buildings` SET var2=var2-10 WHERE countryID = '$targetID' and building = 'wall'");
 $key=_PREFIKS.':buildings'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']=='wall') {$mem[$i]['var2'] = $mem[$i]['var2']-10;break;}
 $memcache->set($key,$mem,false,86400);
    }
 printrus ("Вы взорвали стену противника атомной бомбой! Но стена оказалась со стальной арматурой, и вам удалось только уничтожить 10 уровней укреплений<br/>\r\n");
 sendMessage($targetID,"fullMessage","Стена взорвана атомной бомбой гос-ва <u>$country</u>! Но благодаря стальной арматуре, стена выдержала удар! Снесены 10 уровней укреплений.");

 }

 mysql_query("UPDATE `countries` SET atomic = 0 WHERE countryID = '$countryID'");
 $b['atomic'] = 0;
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }

}
//******************************************************************************
//саботаж **********************************************************************

function sabotage_bld($countryID,$targetID,$bld,$there=false){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 if ($idt_m==TRUE){
 $a = $mb;
    }else{
 $query="select * from `countries` where countryID='$targetID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a = mysql_fetch_array($result);
 }

 $target=$a["countryName"];

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 $query="select maratory from `uzers` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a2 = mysql_fetch_array($result);
 $b['mrt'] = $a2['maratory'];
 }

 $country=$b["countryName"];
 //Ночной мараторий
 $nightmar = FALSE;
 if ($b['mrt']>18){
    if (date("G")+0>=$b['mrt']||date("G")+0<($b['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$b['mrt']&&date("G")+0<=($b['mrt']+5)) $nightmar = TRUE;
    }
 if ($b['mrt']==25) $nightmar=FALSE;

 if($nightmar==TRUE){
 printrus ("Вы находитесь в ночном моратории и не можете саботажничать!<br/>\r\n");
 return false;
 }
 if($b['moratory']>time()){
 printrus ("Вы находитесь в купленном моратории и не можете саботажничать!<br/>\r\n");
 return false;
 }

 if($mar=maratory($targetID)){
  printrus ("На государство <u>$target</u> действует мораторий неприкосновенности! Повторите попытку через ".mkTimeStr($mar).".<br/>\r\n");
  return false;
 }

 $sab=$b["sabotage"];
 $spy=$a["spy"];

 $key=_PREFIKS.':buildings'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){

         $guard=$mem[$i]['guard'];
         $guard_2=$mem[$i]['guard_2'];
         $guard_3=$mem[$i]['guard_3'];
         $guard_4=$mem[$i]['guard_4'];
         $guard_5=$mem[$i]['guard_5'];
         $guard_6=$mem[$i]['guard_6'];
         $guard_7=$mem[$i]['guard_7'];
         $guard_8=$mem[$i]['guard_8'];

         $hits=$mem[$i]['hits'];
         break;
    }
    }else{
 $query="select * from `buildings` where countryID='$targetID' and building='$bld' limit 1";
 $result=@MYSQL_QUERY($query);

 $guard=@mysql_result($result,0,"guard");
 $guard_2=@mysql_result($result,0,"guard_2");
 $guard_3=@mysql_result($result,0,"guard_3");
 $guard_4=@mysql_result($result,0,"guard_4");
 $guard_5=@mysql_result($result,0,"guard_5");
 $guard_6=@mysql_result($result,0,"guard_6");
 $guard_7=@mysql_result($result,0,"guard_7");
 $guard_8=@mysql_result($result,0,"guard_8");

 $hits=@mysql_result($result,0,"hits");
 }

 if (time()<($b['sabTime']+5400)){
  printrus ("Ваши саботажники еще не готовы для новой работы! Подождите ".mkTimeStr($b['sabTime']+5400-time())."<br/>\r\n");
         }elseif($there){
  $tm = time();
  mysql_query("UPDATE countries SET sabTime = $tm WHERE countryID = '$countryID' LIMIT 1");
  $b['sabTime'] = $tm;
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  //Саботаж убивает часть охраны на здании
  $proc = max(0,$sab-$spy);
  $guard_end=round((100-$proc)/100*$guard);
  $guard_end_2=round((100-$proc)/100*$guard_2);
  $guard_end_3=round((100-$proc)/100*$guard_3);
  $guard_end_4=round((100-$proc)/100*$guard_4);
  $guard_end_5=round((100-$proc)/100*$guard_5);
  $guard_end_6=round((100-$proc)/100*$guard_6);
  $guard_end_7=round((100-$proc)/100*$guard_7);
  $guard_end_8=round((100-$proc)/100*$guard_8);

  //Теперь здание можно разрушить саботажем лишь до 1%
  $pminus=min($hits-1,round($hits*max(0,$sab-$spy)/100));
  if($pminus<$hits){  //Выполняется только этот случай
   $pend=$hits-$pminus;
   //setValue("countryID='$targetID' and building='$bld'","buildings","hits",$pend);
   mysql_query("UPDATE `buildings` SET hits = $pend, guard = $guard_end, guard_2 = $guard_end_2,
   guard_3 = $guard_end_3, guard_4 = $guard_end_4, guard_5 = $guard_end_5, guard_6 = $guard_end_6,
   guard_7 = $guard_end_7, guard_8 = $guard_end_8
   WHERE countryID = '$targetID' and building = '$bld' LIMIT 1
   ");

 $key=_PREFIKS.':buildings'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){
         $mem[$i]['hits']=$pend;
         $mem[$i]['guard']=$guard_end;
         $mem[$i]['guard_2']=$guard_end_2;
         $mem[$i]['guard_3']=$guard_end_3;
         $mem[$i]['guard_4']=$guard_end_4;
         $mem[$i]['guard_5']=$guard_end_5;
         $mem[$i]['guard_6']=$guard_end_6;
         $mem[$i]['guard_7']=$guard_end_7;
         $mem[$i]['guard_8']=$guard_end_8;
         break;
         }
 $memcache->set($key,$mem,false,86400);
    }
   printrus ("Здание <u>".printBuilding($bld)."</u> разломано до <b>$pend %</b>!
   <b>$proc</b>% охраны на здании погибло!<br/>\r\n");
   if ($pend==1) printrus ("Разрушить окончательно саботажем его нельзя.<br/>\r\n");
   sendMessage($targetID,"fullMessage","Здание <u>".printBuilding($bld)."</u> разломано до <b>$pend %</b> саботажником гос-ва <u>$country</u>! Погибло <b>$proc</b>% охраны.");
  }else{
   $query="delete from `buildings` where countryID='$targetID' and building='$bld' limit 1";
   $result=@MYSQL_QUERY($query);
 $key=_PREFIKS.':buildings'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
 $newb=array();
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']!=$bld) array_push($newb,$mem[$i]);
 $memcache->set($key,$newb,false,86400);
    }

   if(($guard+$guard_2+$guard_3)>0){
    printrus ("Здание <u>".printBuilding($bld)."</u> разрушено!<br/>\r\n");
    sendMessage($targetID,"fullMessage","Здание <u>".printBuilding($bld)."</u> разрушено саботажником гос-ва <u>$country</u>! Все охранники погибли под завалами.");
    /*
    mysql_query("UPDATE `countries` SET wariors_atall = wariors_atall - $guard, wariors_atall_2 = wariors_atall_2 - $guard_2, wariors_atall_3 = wariors_atall_3 - $guard_3 WHERE countryID = '$targetID' LIMIT 1");
    if ($idt_m==TRUE){
       $a['wariors_atall'] = $a['wariors_atall'] - $guard;
       $a['wariors_atall_2'] = $a['wariors_atall_2'] - $guard_2;
       $a['wariors_atall_3'] = $a['wariors_atall_3'] - $guard_3;
       $memcache->set($key2,$a,false,86400);
       }
    */

   }else{
    printrus ("Здание <u>".printBuilding($bld)."</u> разрушено!<br/>\r\n");
    sendMessage($targetID,"fullMessage","Здание <u>".printBuilding($bld)."</u> разрушено саботажником гос-ва <u>$country</u>!");
   }
  }
 }else{     //Саботируем стену
 $tm = time();
  mysql_query("UPDATE countries SET sabTime = $tm WHERE countryID = '$countryID' LIMIT 1");
  $b['sabTime'] = $tm;
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }
  //Есть ли у жертвы цитадель или ратуша?
  if (building_exists($targetID,"ratusha") || building_exists($targetID,"citadel")) $b_e=TRUE;
  else $b_e=FALSE;

  $pminus=min($hits-1,round($hits*max(0,$sab-$spy)/100));
  //Саботаж убивает часть охраны на здании
  $proc = max(0,$sab-$spy);
  $guard_end=round((100-$proc)/100*$guard);
  $guard_end_2=round((100-$proc)/100*$guard_2);
  $guard_end_3=round((100-$proc)/100*$guard_3);
  $guard_end_4=round((100-$proc)/100*$guard_4);
  $guard_end_5=round((100-$proc)/100*$guard_5);
  $guard_end_6=round((100-$proc)/100*$guard_6);
  $guard_end_7=round((100-$proc)/100*$guard_7);
  $guard_end_8=round((100-$proc)/100*$guard_8);


  if ( ($sab-($spy+1) <  0)  AND  ($spy>=0)  )
  $flag=1;

  if(          ( ($sab-$spy)<0 )   OR   ($flag==1)     ){
   if ($a["spy"]<50 && $b_e==TRUE)$s1 = min(100,$a["spy"]+1); else $s1 = $a["spy"];
   $s2 = max(0,$b["sabotage"]-1);
   mysql_query("UPDATE countries SET spy = $s1 WHERE countryID = '$targetID'");
   if ($idt_m==TRUE){
       $a['spy'] = $s1;
       $memcache->set($key2,$a,false,86400);
       }

  mysql_query("UPDATE countries SET sabotage = $s2 WHERE countryID = '$countryID'");
   $b['sabotage'] = $s2;
   if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }
   printrus ("Диверсия была предотвращена! Саботаж: <b>-1 %</b><br/>\r\n");
   if ($a["spy"]<50 && $b_e==TRUE) sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> отправило к вам саботажника, чтобы разрушить здание <u>".printBuilding($bld)."</u>! Диверсия была предотвращена! Шпионаж: <b>+1 %</b>.");
   else sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> отправило к вам саботажника, чтобы разрушить здание <u>".printBuilding($bld)."</u>! Диверсия была предотвращена!");

 //Пишем в лог:
 @$open=fopen("../logs/cit".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."пыталось сабот. стену $target. Саб.:".$b['sabotage'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //**********************
 //Пишем в лог:
 @$open=fopen("../logs/cit".$targetID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$country." пыталось сабот. стену $target. Саб.:".$b['sabotage'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }elseif((($sab-$spy)>=0 && $pminus<$hits)){ //Выполнится может только этот случай
   $pend=$hits-$pminus;
   if ($b['sabotage']<50 && $hits>1)$s1 = min(100,$b["sabotage"]+1); else $s1 = $b['sabotage'];
   $s2 = max(0,$a["spy"]-1);
   mysql_query("UPDATE countries SET sabotage = $s1 WHERE countryID = '$countryID'");
   $b['sabotage'] = $s1;
   if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }


 //  setValue("countryID='$targetID' and building='$bld'","buildings","hits",$pend);
 mysql_query("UPDATE `buildings` SET hits = $pend, guard = $guard_end, guard_2 = $guard_end_2,
   guard_3 = $guard_end_3, guard_4 = $guard_end_4, guard_5 = $guard_end_5, guard_6 = $guard_end_6,
   guard_7 = $guard_end_7, guard_8 = $guard_end_8
   WHERE countryID = '$targetID' and building = '$bld' LIMIT 1");

 $key=_PREFIKS.':buildings'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){
         $mem[$i]['hits']=$pend;
         $mem[$i]['guard']=$guard_end;
         $mem[$i]['guard_2']=$guard_end_2;
         $mem[$i]['guard_3']=$guard_end_3;
         $mem[$i]['guard_4']=$guard_end_4;
         $mem[$i]['guard_5']=$guard_end_5;
         $mem[$i]['guard_6']=$guard_end_6;
         $mem[$i]['guard_7']=$guard_end_7;
         $mem[$i]['guard_8']=$guard_end_8;
         break;
         }
 $memcache->set($key,$mem,false,86400);
    }

   mysql_query("UPDATE countries SET spy = $s2 WHERE countryID = '$targetID'");
   if ($idt_m==TRUE){
       $a['spy'] = $s2;
       $memcache->set($key2,$a,false,86400);
       }

   if ($b['sabotage']<50 && $hits>1)printrus ("Здание <u>".printBuilding($bld)."</u> разломано до <b>$pend %</b>! Саботаж: <b>+1 %</b><br/>\r\n");
   else printrus ("Здание <u>".printBuilding($bld)."</u> разломано до <b>$pend %</b>!<br/>\r\n");
   printrus("<b>$proc</b>% охраны на здании погибло.<br/>\r\n");
   sendMessage($targetID,"fullMessage","Здание <u>".printBuilding($bld)."</u> разломано до <b>$pend %</b> саботажником гос-ва <u>$country</u>! Шпионаж: <b>-1 %</b>. <b>$proc</b>% охраны на здании погибло.");

 //Пишем в лог:
 @$open=fopen("../logs/cit".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."сабот. стену $target. Саб.:".$b['sabotage'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //**********************
 //Пишем в лог:
 @$open=fopen("../logs/cit".$targetID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$country." сабот. стену $target. Саб.:".$b['sabotage'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }else{
   $query="delete from `buildings` where countryID='$targetID' and building='$bld' limit 1";
   $result=@MYSQL_QUERY($query);
 $key=_PREFIKS.':buildings'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
 $newb=array();
 for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']!=$bld) array_push($newb,$mem[$i]);
 $memcache->set($key,$newb,false,86400);
    }

   $s1 = min(100,$b["sabotage"]+1);
   $s2 = max(0,$a["spy"]-1);
   mysql_query("UPDATE countries SET sabotage = $s1 WHERE countryID = '$countryID'");
   $b['sabotage'] = $s1;
   if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }
   mysql_query("UPDATE countries SET spy = $s2 WHERE countryID = '$targetID'");
   if ($idt_m==TRUE){
       $a['spy'] = $s2;
       $memcache->set($key2,$a,false,86400);
       }

   printrus ("Здание <u>".printBuilding($bld)."</u> разрушено! Саботаж: <b>+1 %</b><br/>\r\n");
   if($guard>0){
    sendMessage($targetID,"fullMessage","Здание <u>".printBuilding($bld)."</u> разрушено саботажником гос-ва <u>$country</u>! Все охранники погибли под завалами. Шпионаж: <b>-1 %</b>.");
    mysql_query("UPDATE `countries` SET wariors_atall = wariors_atall - $guard, wariors_atall_2 = wariors_atall_2 - $guard_2, wariors_atall_3 = wariors_atall_3 - $guard_3 WHERE countryID = '$targetID' LIMIT 1");
    if ($idt_m==TRUE){
       $a['wariors_atall'] = $a['wariors_atall'] - $guard;
       $a['wariors_atall_2'] = $a['wariors_atall_2'] - $guard_2;
       $a['wariors_atall_3'] = $a['wariors_atall_3'] - $guard_3;
       $memcache->set($key2,$a,false,86400);
       }

   }else{
    sendMessage($targetID,"fullMessage","Здание <u>".printBuilding($bld)."</u> разрушено саботажником гос-ва <u>$country</u>! Шпионаж: <b>-1 %</b>.");
   }
  }
 }

}


//******************************************************************************
//Воровство*********************************************************************
//Во всех вызовах $countryID = $_SESSION['countryID']

function grab($countryID,$targetID,$there=false){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 $query="select maratory from `uzers` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a2 = mysql_fetch_array($result);
 $b['mrt'] = $a2['maratory'];
 }

 //$countryID=addslashes($countryID);
 //$targetID=addslashes($targetID);

 $country=$b['countryName'];

 if ($idt_m==TRUE){
    $a=$mb;
    }else{
 $r = mysql_query("SELECT * FROM countries WHERE countryID = '$targetID'");
 $a = mysql_fetch_array($r);
 }

 $target=$a['countryName'];
 //Ночной мараторий
 $nightmar = FALSE;
 if ($b['mrt']>18){
    if (date("G")+0>=$b['mrt']||date("G")+0<($b['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$b['mrt']&&date("G")+0<=($b['mrt']+5)) $nightmar = TRUE;
    }
 if ($b['mrt']==25) $nightmar=FALSE;

 if($nightmar==TRUE){
 printrus ("Вы находитесь в ночном моратории и не можете воровать!<br/>\r\n");
 return false;
 }
 if($b['moratory']>time()){
 printrus ("Вы находитесь в купленном моратории и не можете воровать!<br/>\r\n");
 return false;
 }

 if($mar=maratory($targetID)){
  printrus ("На государство <u>$target</u> действует мораторий неприкосновенности! Повторите попытку через ".mkTimeStr($mar).".<br/>\r\n");
  return false;
 }

  if(time()<($b['grbTime']+5400)){
  printrus ("Ваши грабители еще не готовы для новой работы! Подождите ".mkTimeStr($b['grbTime']+5400-time())."<br/>\r\n");
 }else{
  $tm = time();
  mysql_query("UPDATE countries SET grbTime = $tm WHERE countryID = '$countryID'");
  $b['grbTime'] = $tm;
  if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

 $key=_PREFIKS.':market'.$targetID;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++){
        if ($mem[$i]['what']=='iron') $mark_iron=$mem[$i]['count'];
        if ($mem[$i]['what']=='arbor') $mark_arbor=$mem[$i]['count'];
        if ($mem[$i]['what']=='grain') $mark_grain=$mem[$i]['count'];
        if ($mem[$i]['what']=='stone') $mark_stone=$mem[$i]['count'];
        if ($mem[$i]['what']=='oil') $mark_oil=$mem[$i]['oil'];
        }
    }else{

 $r1 = mysql_query("SELECT `count` FROM `market` WHERE countryID = '$targetID' and what = 'iron' LIMIT 1");
 $m = mysql_fetch_array($r1);
 $mark_iron = $m['count'];

 $r1 = mysql_query("SELECT `count` FROM `market` WHERE countryID = '$targetID' and what = 'arbor' LIMIT 1");
 $m = mysql_fetch_array($r1);
 $mark_arbor = $m['count'];

 $r1 = mysql_query("SELECT `count` FROM `market` WHERE countryID = '$targetID' and what = 'grain' LIMIT 1");
 $m = mysql_fetch_array($r1);
 $mark_grain = $m['count'];

 $r1 = mysql_query("SELECT `count` FROM `market` WHERE countryID = '$targetID' and what = 'stone' LIMIT 1");
 $m = mysql_fetch_array($r1);
 $mark_stone = $m['count'];

 $r1 = mysql_query("SELECT `count` FROM `market` WHERE countryID = '$targetID' and what = 'oil' LIMIT 1");
 $m = mysql_fetch_array($r1);
 $mark_oil = $m['count'];
 }

 $iron=$a["iron"];
 $arbor=$a["arbor"];
 $grain=$a["grain"];
 $oil=$a['oil'];
 $stone=$a["stone"];
 $money=$a["money"];

 $giron = 0;
 $gmarkiron = 0;
 $garbor = 0;
 $gmarkarbor = 0;
 $gstone = 0;
 $gmarkstone = 0;
 $ggrain = 0;
 $gmarkgrain = 0;
 $goil = 0;
 $gmarkoil = 0;

 $max=free_place($countryID);
 $kk=$b['grabber']-$a['spy']+1;
  if ($a['spy'] >= 0)
  $kk=$b['grabber']-$a['spy'];
  $kk=min($kk,100);




 $giron=round(min($max,$iron*$kk/100)); $max=$max-$giron;
 if($max>0) {$gmarkiron=round(min($max,$mark_iron*$kk/100)); $max=$max-$gmarkiron;}
 if($max>0) {$garbor=round(min($max,$arbor*$kk/100)); $max=$max-$garbor;}
 if($max>0) {$gmarkarbor=round(min($max,$mark_arbor*$kk/100)); $max=$max-$gmarkarbor;}
 if($max>0) {$ggrain=round(min($max,$grain*$kk/100)); $max=$max-$ggrain;}
 if($max>0) {$goil=round(min($max,$oil*$kk/100)); $max=$max-$goil;}
 if($max>0) {$gmarkoil=round(min($max,$mark_oil*$kk/100)); $max=$max-$gmarkoil;}
 if($max>0) {$gmarkgrain=round(min($max,$mark_grain*$kk/100)); $max=$max-$gmarkgrain;}
 if($max>0) {$gstone=round(min($max,$stone*$kk/100));$max=$max-$gstone;}

 //Теперь грабим с рынка:
 if($max>0) $gmarkstone=round(min($max,$mark_stone*$kk/100));

 $gmoney=round($money*$kk/100);

 if ($kk>0){

 $grabbed="Похищено: деньги(<b>$gmoney</b>)";
 if($giron+$gmarkiron+$garbor+$gmarkarbor+$ggrain+$gmarkgrain+$gstone+$gmarkstone+$gmoney+$goil+$gmarkoil>0){
  if($giron+$gmarkiron>0) $grabbed.=", железо(<b>$giron</b>, c рынка <b>$gmarkiron</b>)";
  if($garbor+$gmarkarbor>0) $grabbed.=", дерево(<b>$garbor</b>, c рынка <b>$gmarkarbor</b>)";
  if($ggrain+$gmarkgrain>0) $grabbed.=", зерно(<b>$ggrain</b>, c рынка <b>$gmarkgrain</b>)";
  if($gstone+$gmarkstone>0) $grabbed.=", камень(<b>$gstone</b>, c рынка <b>$gmarkstone</b>)";
  if($goil+$gmarkoil>0) $grabbed.=", нефть(<b>$goil</b>, c рынка <b>$gmarkoil</b>)";
  $grabbed_=$grabbed;
 }else{
  if(free_place($countryID)==0){
   $grabbed="Но у вас не хватило места для складирования награбленного";
  }else{
   printrus ("Вашим грабителям удалось проникнуть на склад гос-ва <u>$target</u>! Но им не удалось что-либо вынести оттуда (ресурсов у гос-ва слишком мало)<br/>\r\n");
   sendMessage($targetID,"fullMessage","Грабители гос-ва <u>$country</u> проникли на ваш склад! Но им не удалось что-либо вынести оттуда!");

   return false;
  }
  $grabbed_="Но им не удалось что-либо вынести оттуда";

 }

 }

  if($kk>0){

   if ($b['grabber']<50)printrus ("Вашим грабителям удалось проникнуть на склад гос-ва <u>$target</u>! $grabbed. Воровство: <b>+1 %</b><br/>\r\n");
   else printrus ("Вашим грабителям удалось проникнуть на склад гос-ва <u>$target</u>! $grabbed.<br/>\r\n");
   sendMessage($targetID,"fullMessage","Грабители гос-ва <u>$country</u> проникли на ваш склад! $grabbed_! Шпионаж: <b>-1 %</b>.");

   if ($b['grabber']<50) $s1 = min(100,$b["grabber"]+1); else $s1 = $b['grabber'];
   $s2 = max(0,$a["spy"]-1);
   mysql_query("UPDATE countries SET grabber = $s1 WHERE countryID = '$countryID'");
   $b['grabber'] = $s1;
   if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

   mysql_query("UPDATE countries SET spy=$s2, iron=($iron-$giron), arbor=($arbor-$garbor), grain=($grain-$ggrain), stone=($stone-$gstone), money=($money-$gmoney), oil=($oil-$goil) WHERE countryID='$targetID'");
   if ($idt_m==TRUE){
     $a['spy']=$s2;
     $a['iron']=$iron-$giron;
     $a['arbor']=$arbor-$garbor;
     $a['grain']=$grain-$ggrain;
     $a['stone']=$stone-$gstone;
     $a['oil']=$oil-$goil;
     $a['money']=$money-$gmoney;
     $memcache->set($key2,$a,false,86400);
     }
   //Что похитили с рынка:
   mysql_query("UPDATE `market` SET `count` = `count` - $gmarkiron WHERE countryID = '$targetID' and what = 'iron'");
   mysql_query("UPDATE `market` SET `count` = `count` - $gmarkarbor WHERE countryID = '$targetID' and what = 'arbor'");
   mysql_query("UPDATE `market` SET `count` = `count` - $gmarkstone WHERE countryID = '$targetID' and what = 'stone'");
   mysql_query("UPDATE `market` SET `count` = `count` - $gmarkgrain WHERE countryID = '$targetID' and what = 'grain'");
   mysql_query("UPDATE `market` SET `count` = `count` - $gmarkoil WHERE countryID = '$targetID' and what = 'oil'");

   $key=_PREFIKS.':market'.$targetID;
   if (($mem=$memcache->get($key))!==FALSE){
      for ($i=0;$i<count($mem);$i++){
          if ($mem[$i]['what']=='iron') $mem[$i]['count'] = $mem[$i]['count'] - $gmarkiron;
          if ($mem[$i]['what']=='arbor') $mem[$i]['count'] = $mem[$i]['count'] - $gmarkarbor;
          if ($mem[$i]['what']=='stone') $mem[$i]['count'] = $mem[$i]['count'] - $gmarkstone;
          if ($mem[$i]['what']=='grain') $mem[$i]['count'] = $mem[$i]['count'] - $gmarkgrain;
          if ($mem[$i]['what']=='oil') $mem[$i]['count'] = $mem[$i]['count'] - $gmarkoil;
          }
      $memcache->set($key,$mem,false,86400);
      }

   mysql_query("UPDATE countries SET iron=iron+$giron+$gmarkiron, arbor=arbor+$garbor+$gmarkarbor, grain=grain+$ggrain+$gmarkgrain, stone=stone+$gstone+$gmarkstone, oil=oil+$goil+$gmarkoil, money=money+$gmoney WHERE countryID='$countryID'");
   echo mysql_error();
   $b['iron'] = $b['iron'] + $giron + $gmarkiron;
   $b['arbor'] = $b['arbor'] + $garbor + $gmarkarbor;
   $b['grain'] = $b['grain'] + $ggrain + $gmarkgrain;
   $b['stone'] = $b['stone'] + $gstone + $gmarkstone;
   $b['oil'] = $b['oil'] + $goil + $gmarkoil;
   $b['money'] = $b['money'] + $gmoney;
   if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }

  //Пишем в лог:
 @$open=fopen("../logs/cit".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."ограбил $target. Граб.:".$b['grabber'].",шпион.:".$a['spy'].'.'.$grabbed."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //*********************
 @$open=fopen("../logs/cit".$targetID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$country." ограбил $target. Шпион.:".$a['spy'].",Граб.:".$b['grabber'].'.'.$grabbed."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }else{
   $s1 = max(0,$b["grabber"]-1);
   if ($a["spy"]<50)$s2 = min(100,$a["spy"]+1); else $s2 = $a["spy"];
   mysql_query("UPDATE countries SET grabber = $s1 WHERE countryID = '$countryID'");
   $b['grabber'] = $s1;
   if ($id_m==TRUE){
     $memcache->set($key1,$b,false,86400);
     }
   mysql_query("UPDATE countries SET spy = $s2 WHERE countryID = '$targetID'");
   if ($idt_m==TRUE){
     $a['spy']=$s2;
     $memcache->set($key2,$a,false,86400);
     }

   printrus ("Вашим грабителям не удалось проникнуть на склад гос-ва <u>$target</u>! Воровство: <b>-1 %</b>.<br/>\r\n");
   if ($a["spy"]<50) sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> отправило грабителей на ваш склад, но вам удалось предотвратить кражу! Шпионаж: <b>+1 %</b>.");
   else sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> отправило грабителей на ваш склад, но вам удалось предотвратить кражу!");

  //Пишем в лог:
 @$open=fopen("../logs/cit".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."пытался ограбить $target. Граб.:".$b['grabber'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //************************
 @$open=fopen("../logs/cit".$targetID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$country." пытался ограбить $target. Шпион.:".$a['spy'].",Граб.:".$b['grabber'].'.'.$grabbed."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
  }
 }
return TRUE;
}


//******************************************************************************
//Вербовка**********************************************************************
//$countryID = $_SESSION['countryID'] во всех вызовах
function verb($countryID,$targetID){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 $query="select maratory from `uzers` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a2 = mysql_fetch_array($result);
 $b['mrt'] = $a2['maratory'];
 }

 if(time()<($b['vrbTime']+5400)){
  printrus ("Ваши вербовщики еще не готовы для новой работы! Подождите ".mkTimeStr($b['vrbTime']+5400-time())."<br/>\r\n");
  return false;
 }
 $tm = time();
 $b['vrbTime'] = $tm;
 mysql_query("UPDATE countries SET vrbTime = $tm WHERE countryID = '$countryID'");
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }

 $country=$b['countryName'];

 if ($idt_m==TRUE){
    $a=$mb;
    }else{
 $r = mysql_query("SELECT * FROM countries WHERE countryID = '$targetID'");
 $a = mysql_fetch_array($r);
 }

 $target=$a['countryName'];
 //Ночной мараторий
 $nightmar = FALSE;
 if ($b['mrt']>18){
    if (date("G")+0>=$b['mrt']||date("G")+0<($b['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$b['mrt']&&date("G")+0<=($b['mrt']+5)) $nightmar = TRUE;
    }
 if ($b['mrt']==25) $nightmar=FALSE;

 if($nightmar==TRUE){
 printrus ("Вы находитесь в ночном маратории и не можете вербовать!<br/>\r\n");
 return false;
 }

 if($b['moratory']>time()){
 printrus ("Вы находитесь в купленном моратории и не можете вербовать!<br/>\r\n");
 return false;
 }

 if($mar=maratory($targetID)){
  printrus ("На государство <u>$target</u> действует мараторий неприкосновенности! Повторите попытку через ".mkTimeStr($mar).".<br/>\r\n");
  return false;
 }

 //$atall=$a["wariors_atall"];
 //$atall_2=$a["wariors_atall_2"];
 //$atall_3=$a["wariors_atall_3"];
 $free=$a["wariors_free"];
 $free_2=$a["wariors_free_2"];
 $free_3=$a["wariors_free_3"];
 $free_4=$a["wariors_free_4"];
 $free_5=$a["wariors_free_5"];
 $free_6=$a["wariors_free_6"];
 $free_7=$a["wariors_free_7"];
 $free_8=$a["wariors_free_8"];

 $kk=$b['verb']-$a['spy']+1;
 if ($a['spy'] >= 0)
      $kk=$b['verb']-$a['spy'];
 $kk=min($kk,100);

 $left=round($free*$kk/100);
 $left_2=round($free_2*$kk/100);
 $left_3=round($free_3*$kk/100);
 $left_4=round($free_4*$kk/100);
 $left_5=round($free_5*$kk/100);
 $left_6=round($free_6*$kk/100);
 $left_7=round($free_7*$kk/100);
 $left_8=round($free_8*$kk/100);

 if($kk>0){

  if ($b['verb']<50)printrus ("Вам удалось завербовать:<br/>".print_voisko(array($left,$left_2,$left_3,$left_4,$left_5,$left_6,$left_7,$left_8))." гос-ва <u>$target</u>! Вербовка: <b>+1 %</b><br/>\r\n");
  else printrus ("Вам удалось завербовать:<br/>".print_voisko(array($left,$left_2,$left_3,$left_4,$left_5,$left_6,$left_7,$left_8))." гос-ва <u>$target</u>!<br/>\r\n");
  sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> завербовало:<br/>".print_voisko(array($left,$left_2,$left_3,$left_4,$left_5,$left_6,$left_7,$left_8))."Шпионаж: <b>-1 %</b>.");

  if ($b['verb']<50) $s1 = min(100,$b["verb"]+1); else $s1 = $b['verb'];
  $s2 = max(0,$a["spy"]-1);
  mysql_query("UPDATE countries SET verb = $s1, wariors_free=wariors_free+$left,
  wariors_free_2=wariors_free_2+$left_2, wariors_free_3=wariors_free_3+$left_3,
  wariors_free_4=wariors_free_4+$left_4, wariors_free_5=wariors_free_5+$left_5,
  wariors_free_6=wariors_free_6+$left_6, wariors_free_7=wariors_free_7+$left_7,
  wariors_free_8=wariors_free_8+$left_8
  WHERE countryID = '$countryID' LIMIT 1");
   $b['verb'] = $s1;
   //$b['wariors_atall'] = $b['wariors_atall']+$left;
   //$b['wariors_atall_2'] = $b['wariors_atall_2']+$left_2;
   //$b['wariors_atall_3'] = $b['wariors_atall_3']+$left_3;
   $b['wariors_free'] = $b['wariors_free']+$left;
   $b['wariors_free_2'] = $b['wariors_free_2']+$left_2;
   $b['wariors_free_3'] = $b['wariors_free_3']+$left_3;
   $b['wariors_free_4'] = $b['wariors_free_4']+$left_4;
   $b['wariors_free_5'] = $b['wariors_free_5']+$left_5;
   $b['wariors_free_6'] = $b['wariors_free_6']+$left_6;
   $b['wariors_free_7'] = $b['wariors_free_7']+$left_7;
   $b['wariors_free_8'] = $b['wariors_free_8']+$left_8;
   if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }
  mysql_query("UPDATE countries SET spy = $s2, wariors_free=($free-$left),
  wariors_free_2=($free_2-$left_2), wariors_free_3=($free_3-$left_3),
  wariors_free_4=($free_4-$left_4), wariors_free_5=($free_5-$left_5),
  wariors_free_6=($free_6-$left_6), wariors_free_7=($free_7-$left_7),
  wariors_free_8=($free_8-$left_8)
  WHERE countryID = '$targetID' LIMIT 1");
  if ($idt_m==TRUE){
    $a['spy']=$s2;
    //$a['wariors_atall'] = $atall-$left;
    //$a['wariors_atall_2'] = $atall_2-$left_2;
    //$a['wariors_atall_3'] = $atall_3-$left_3;
    $a['wariors_free'] = $free-$left;
    $a['wariors_free_2'] = $free_2-$left_2;
    $a['wariors_free_3'] = $free_3-$left_3;
    $a['wariors_free_4'] = $free_4-$left_4;
    $a['wariors_free_5'] = $free_5-$left_5;
    $a['wariors_free_6'] = $free_6-$left_6;
    $a['wariors_free_7'] = $free_7-$left_7;
    $a['wariors_free_8'] = $free_8-$left_8;
    $memcache->set($key2,$a,false,86400);
    }

 //Пишем в лог:
 @$open=fopen("../logs/cit".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."завербовал часть войска $target. Верб.:".$b['verb'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //********************
 @$open=fopen("../logs/cit".$targetID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName']."завербовал часть войска $target. Верб.:".$b['verb'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }else{
  $s1 = max(0,$b["verb"]-1);
  if ($a["spy"]<50)$s2 = min(100,$a["spy"]+1); else $s2 = $a["spy"];
  mysql_query("UPDATE countries SET verb = $s1 WHERE countryID = '$countryID' LIMIT 1");
   $b['verb'] = $s1;
   if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }

   mysql_query("UPDATE countries SET spy = $s2 WHERE countryID = '$targetID' LIMIT 1");
   if ($idt_m==TRUE){
    $a['spy']=$s2;
    $memcache->set($key2,$a,false,86400);
    }

  printrus ("Вам не удалось завербовать ни одного война гос-ва <u>$target</u>! Вербовка: <b>-1 %</b>.<br/>\r\n");
  if ($a["spy"]<50) sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> тщетно пыталось переманить ваши войска на свою сторону! Шпионаж: <b>+1 %</b>.");
  else sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> тщетно пыталось переманить ваши войска на свою сторону!");

 //Пишем в лог:
 @$open=fopen("../logs/cit".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."пытался завербовать войско $target. Верб.:".$b['verb'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //*************************
 @$open=fopen("../logs/cit".$targetID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$b['countryName']." пытался завербовать войско $target. Верб.:".$b['verb'].",шпион.:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 }

}


//******************************************************************************
//Воруем науч. разработки*******************************************************
//$countryID = $_SESSION['countryID'] во всех вызовах
function sciencespy($countryID,$targetID){

 global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;
 $key2=_PREFIKS.':id'.$targetID;
 if (($mb=$memcache->get($key2))!==FALSE) $idt_m = TRUE; else $idt_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 $query="select maratory from `uzers` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $a2 = mysql_fetch_array($result);
 $b['mrt'] = $a2['maratory'];
 }

 if(time()<($b['spyTime']+3600)){
  printrus ("Ваши шпионы еще не готовы для новой работы! Подождите ".mkTimeStr($b['spyTime']+3600-time())."<br/>\r\n");
  return false;
 }
 $tm = time();
 $b['spyTime'] = $tm;
 mysql_query("UPDATE countries SET spyTime = $tm WHERE countryID = '$countryID'");
 if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }

 $country=$b['countryName'];
 if ($idt_m==TRUE){
    $a=$mb;
    }else{
 $r = mysql_query("SELECT * FROM countries WHERE countryID = '$targetID'");
 $a = mysql_fetch_array($r);
 }

 $target=$a['countryName'];
 //Ночной мараторий
 $nightmar = FALSE;
 if ($b['mrt']>18){
    if (date("G")+0>=$b['mrt']||date("G")+0<($b['mrt']+6)%24) $nightmar = TRUE;
    }else{
    if (date("G")+0>=$b['mrt']&&date("G")+0<=($b['mrt']+5)) $nightmar = TRUE;
    }
 if ($b['mrt']==25) $nightmar=FALSE;

 if($nightmar==TRUE){
 printrus ("Вы находитесь в ночном маратории и не можете воровать разработки!<br/>\r\n");
 return false;
 }
 if($b['moratory']>time()){
 printrus ("Вы находитесь в купленном моратории и не можете воровать разработки!<br/>\r\n");
 return false;
 }

 if($mar=maratory($targetID)){
  printrus ("На государство <u>$target</u> действует мараторий неприкосновенности! Повторите попытку через ".mkTimeStr($mar).".<br/>\r\n");
  return false;
 }

 $grain_making=$a["grain_making"];
 $arbor_making=$a["arbor_making"];
 $iron_making=$a["iron_making"];
 $stone_making=$a["stone_making"];
 $oil_making=$a["oil_making"];
 $forest_adding=$a["forest_adding"];
 $science=$a["science"];
 $plotn_people=$a["plotn_people"];
 $plotn_wariors=$a["plotn_wariors"];
 $people_adding=$a["people_adding"];
 $forest_max=$a["forest_max"];
 $mountains_max=$a["mountains_max"];
 $demontaj=$a["demontaj"];
 $arheol=$a["artefakt"];

 $_grain_making=$b["grain_making"];
 $_arbor_making=$b["arbor_making"];
 $_iron_making=$b["iron_making"];
 $_stone_making=$b["stone_making"];
 $_oil_making=$b["oil_making"];
 $_forest_adding=$b["forest_adding"];
 $_science=$b["science"];
 $_plotn_people=$b["plotn_people"];
 $_plotn_wariors=$b["plotn_wariors"];
 $_people_adding=$b["people_adding"];
 $_forest_max=$b["forest_max"];
 $_mountains_max=$b["mountains_max"];
 $_demontaj=$b["demontaj"];
 $_arheol=$b["artefakt"];

 $kk=max(0,$b['spy']-$a['spy']+1);
 if ($a['spy'] >= 0)
 $kk=max(0,$b['spy']-$a['spy']);
 $kk=min($kk,100);

 $grain_making_=max(0,round(($grain_making-$_grain_making)*$kk/100));
 $arbor_making_=max(0,round(($arbor_making-$_arbor_making)*$kk/100));
 $iron_making_=max(0,round(($iron_making-$_iron_making)*$kk/100));
 $stone_making_=max(0,round(($stone_making-$_stone_making)*$kk/100));
 $oil_making_=max(0,round(($oil_making-$_oil_making)*$kk/100));
 $forest_adding_=max(0,round(($forest_adding-$_forest_adding)*$kk/100));
 $science_=max(0,round(($science-$_science)*$kk/100));
 $plotn_people_=max(0,round(($plotn_people-$_plotn_people)*$kk/100));
 $plotn_wariors_=max(0,round(($plotn_wariors-$_plotn_wariors)*$kk/100));
 $people_adding_=max(0,round(($people_adding-$_people_adding)*$kk/100));

 $forest_max_=max(0,round(($forest_max-$_forest_max)*$kk/100));
 $mountains_max_=max(0,round(($mountains_max-$_mountains_max)*$kk/100));
 $demontaj_=max(0,round(($demontaj-$_demontaj)*$kk/100));
 $arheol_=max(0,round(($arheol-$_arheol)*$kk/100));

 if($kk>0){

  if(($grain_making_+$demontaj_+$arheol_+$arbor_making_+$iron_making_+$stone_making_+$oil_making_+$forest_adding_+$science_+$plotn_people_+$plotn_wariors_+$people_adding_+$forest_max_+$mountains_max_)>0){
   if ($b["spy"]<50)printrus ("Вам удалось похитить некоторые научные разработки гос-ва <u>$target</u>! Шпионаж: <b>+1 %</b><br/>\r\n");
   else printrus ("Вам удалось похитить некоторые научные разработки гос-ва <u>$target</u>!<br/>\r\n");

   if ($b["spy"]<50)$s1 = min(100,$b["spy"]+1);else $s1=$b["spy"];
   $s2 = max(0,$a["spy"]-1);
   mysql_query("UPDATE countries SET spy = $s1 WHERE countryID = '$countryID'");
   $b['spy'] = $s1;
   if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }
   mysql_query("UPDATE countries SET spy = $s2 WHERE countryID = '$targetID'");
   if ($idt_m==TRUE){
      $a['spy']=$s2;
      $memcache->set($key2,$a,false,86400);
      }

   mysql_query("UPDATE countries SET artefakt=artefakt+$arheol_, demontaj=demontaj+$demontaj_, grain_making=grain_making+$grain_making_, arbor_making=arbor_making+$arbor_making_, iron_making=iron_making+$iron_making_, stone_making=stone_making+$stone_making_, oil_making=oil_making+$oil_making_, forest_adding=forest_adding+$forest_adding_, science=science+$science_, plotn_people=plotn_people+$plotn_people_, plotn_wariors=plotn_wariors+$plotn_wariors_, people_adding=people_adding+$people_adding_, forest_max = forest_max + $forest_max_, mountains_max = mountains_max + $mountains_max_ WHERE countryID='$countryID'");
   $b['grain_making'] = min(100,$b['grain_making'] + $grain_making_);
   $b['arbor_making'] = min(100,$b['arbor_making'] + $arbor_making_);
   $b['iron_making'] = min(100,$b['iron_making'] + $iron_making_);
   $b['stone_making'] = min(100,$b['stone_making'] + $stone_making_);
   $b['oil_making'] = min(100,$b['oil_making'] + $oil_making_);
   $b['forest_adding'] = min(100,$b['forest_adding'] + $forest_adding_);
   $b['science'] = min(100,$b['science'] + $science_);
   $b['plotn_people'] = min(100,$b['plotn_people'] + $plotn_people_);
   $b['plotn_wariors'] = min(100,$b['plotn_wariors'] + $plotn_wariors_);
   $b['people_adding'] = min(100,$b['people_adding'] + $people_adding_);
   $b['forest_max'] = min(100,$b['forest_max'] + $forest_max_);
   $b['mountains_max'] = min(100,$b['mountains_max'] + $mountains_max_);
   $b['demontaj'] = min(100,$b['demontaj'] + $demontaj_);
   $b['artefakt'] = min(100,$b['artefakt'] + $arheol_);
   if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }

  }else{
   printrus ("У гос-ва <u>$target</u> нет научных разработок выше вашего уровня!<br/>\r\n");
   $s1 = max(0,$a["spy"]-1);
   mysql_query("UPDATE countries SET spy = $s1 WHERE countryID = '$targetID'");
   if ($idt_m==TRUE){
      $a['spy']=$s1;
      $memcache->set($key2,$a,false,86400);
      }

   }
  sendMessage($targetID,"fullMessage","Гос-ву <u>$country</u> удалось проникнуть в ваши лаборатории и похитить научные разработки! Шпионаж: <b>-1 %</b>.");

 //Пишем в лог:
 @$open=fopen("../logs/cit".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."похитил науч. разраб. $target. Шпион.:".$b['spy'].",шпион. жертвы:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //************************
 //Пишем в лог:
 @$open=fopen("../logs/cit".$targetID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$country." похитил науч. разраб. $target. Шпион.:".$b['spy'].",шпион. жертвы:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

 }else{
   $s1 = max(0,$b["spy"]-1);
   if ($a["spy"]<50) $s2 = min(100,$a["spy"]+1); else $s2=$a["spy"];
   mysql_query("UPDATE countries SET spy = $s1 WHERE countryID = '$countryID'");
   $b['spy'] = $s1;
   if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }
   mysql_query("UPDATE countries SET spy = $s2 WHERE countryID = '$targetID'");
   if ($idt_m==TRUE){
      $a['spy']=$s2;
      $memcache->set($key2,$a,false,86400);
      }

  printrus ("Вам не удалось украсть научные разработки гос-ва <u>$target</u>! Шпионаж: <b>-1 %</b>.<br/>\r\n");
  if ($a["spy"]<50)sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> тщетно пыталось похитить ваши научные разработки! Шпионаж: <b>+1 %</b>.");
  else sendMessage($targetID,"fullMessage","Гос-во <u>$country</u> тщетно пыталось похитить ваши научные разработки!");

 //Пишем в лог:
 @$open=fopen("../logs/cit".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."пытался похитить науч. разраб. $target. Шпион.:".$b['spy'].",шпион. жертвы:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 //************************
 //Пишем в лог:
 @$open=fopen("../logs/cit".$targetID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$country." пытался похитить науч. разраб. $target. Шпион.:".$b['spy'].",шпион. жертвы:".$a['spy']."\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);
 }

}






































//reg_func.php (ФУНКЦИИ ДЛЯ РЕГИСТРАЦИИ)

//******************************************************************************
//функа обеспечивающая запись инфы о юзере в базу*******************************

function addUSERtoBASE($username,$mail,$password,$countryName,$imya='',$about=''){

/*
 //вычисляем номер регающегося чувака
 $query="SELECT * FROM uzers WHERE 1";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $usersCount=MYSQL_NUM_ROWS($result);
 if($usersCount==0){
  $userID=1;
 }else{
  $userID=MYSQL_RESULT($result,$usersCount-1,"userID")+1;
 }
 */
 //Вместо этой хни нужно autoincrement в базу сделать. А пока так:
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = iconv('utf-8','cp1251',$username);
 $countryName = iconv('utf-8','cp1251',$countryName);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$countryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = getIp2();
 $soft = htmlspecialchars(addslashes(@getenv("HTTP_USER_AGENT")));

#Апдейтим базу на номер
$bee = @getenv("HTTP_X_NOKIA_MSISDN");
if (@$bee===false) $bee = @getenv("HTTP_X_MSISDN");
if (@$bee===false) $bee = @getenv("HTTP_MSISDN");
if (@$bee===false) $bee = @getenv("HTTP_X_NETWORK_INFO");
if (@$bee===false) $bee = @getenv("HTTP_X_CLIENT_ID");
//if (!preg_match("/^[0-9]{4,}$/",$bee)) $bee = false;
$bee = addslashes($bee);

 //Добавляем юзера в нужные базы:
 $partner=str_replace('.', '', $_SESSION['site']);
 //$query="INSERT INTO uzers VALUES($userID,'$countryID','$username','$mail','$mail','$password',0,2,'$ip','$soft','$bee',0,'',0,25,0,'',0,0,'".date("d M Y")."','$about','$imya',0,0,0)";
 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = '$mail', firstemail = '$mail', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = '$bee', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = '$about', imya = '$imya', counts = 0, credits = 0, spent=0, partner='".$partner."'";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 @include_once("other_inc/startres.php");

 //$query="INSERT INTO countries VALUES('$countryID','$countryName',".time().",1,0,".time().",$land,$mountains,$forest,$money,$arbor,$stone,$iron,$grain,$workers,$scientists,'10','10','3','10','10','10','10','10','10',10,10,10,10,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,0,0,0,0,0,1,0,'','',2)";
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$countryName',
 reggedTime='".time()."', nalog=1, napr=0, lastNal = '".time()."', lastWar = '".time()."', land = $land, mountains=$mountains,
 forest=$forest, money=$money, arbor=$arbor, stone=$stone, iron=$iron, grain=$grain, oil=$oil,
 workers=$workers, scientists=$scientists, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=10, sabotage=10, grabber=10, verb=10, spyTime=0, sabTime=0,
 grbTime=0, vrbTime=0, weapon_force=1, weapon_force_2=1, weapon_force_3=1, weapon_force_4=1,
 weapon_force_5=1, weapon_force_6=1, weapon_force_7=1, weapon_force_8=1, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 getNeighbours($countryID);

 //Пустышки-соседи
 //1-ый

 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'sysreg'.rand(0,99999999999);
 $acountryName = 'Пустынные территории '.$countryName;
 $password = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:
$partner=str_replace('.', '', $_SESSION['site']);
 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, partner='".$partner."'";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(0,3);
 $speed = rand(1,3);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()+1)."', nalog=1, napr=0, lastNal = '".(time()+1)."', lastWar = '".(time()+1)."', land = $land, mountains=$mountains,
 forest=$forest, money=$money, arbor=$arbor, stone=$stone, iron=$iron, grain=$grain, oil=$oil,
 workers=$workers, scientists=$scientists, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=10, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, weapon_force=$force, weapon_force_2=1,
 weapon_force_3=1, weapon_force_4=1, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(5,15);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, space = 100, hits = 100");

 getNeighbours($countryID);

    /*
 //2-ой
 //Определяем будущий ID
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'sysreg'.rand(0,99999999999);
 $acountryName = 'Заброшенные территории '.$countryName;
 $password = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password,$username,$acountryName);

 //эмдэпятируем пароль:)
 $password=md5($password);

 $ip = 'sysreg';
 $soft = 'sysreg';

 //Добавляем юзера в нужные базы:
$partner=str_replace('.', '', $_SESSION['site']);
 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '$ip', soft = '$soft', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, partner='".$partner."'";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $force = rand(0,3);
 $speed = rand(1,3);
 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '$acountryName',
 reggedTime='".(time()+2)."', nalog=1, napr=0, lastNal = '".(time()+2)."', lastWar = '".(time()+2)."', land = $land, mountains=$mountains,
 forest=$forest, money=$money, arbor=$arbor, stone=$stone, iron=$iron, grain=$grain, oil=$oil,
 workers=$workers, scientists=$scientists, science=10, plotn_people=10, plotn_wariors=3,
 people_adding=10, forest_adding=10, grain_making=10, arbor_making=10, iron_making=10,
 stone_making=10, oil_making=10, forest_max=10, mountains_max=10, spy=10, sabotage=10, grabber=10,
 verb=10, spyTime=0, sabTime=0, grbTime=0, vrbTime=0, weapon_force=$force, weapon_force_2=1,
 weapon_force_3=1, weapon_force_4=1, weapon_force_5=1, weapon_force_6=1, weapon_force_7=1,
 weapon_force_8=1, weapon_speed = $speed, protection=1, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $guard = rand(3,10);
 $guard_2 = rand(1,3);
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village',
 guard = $guard, guard_2 = $guard_2, space = 100, hits = 100");
 getNeighbours($countryID);

//конец второго
     */
}


//******************************************************************************
//функа проверяющая наличие пользователя с таким именем в таблице***************

function ThereIsSuchUserAlready($username){

 //посылаем запрос:
 $query="SELECT count(*) as num FROM uzers WHERE UserName='$username' LIMIT 1";
 //получаем результат
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 //узнаем количество таких чуваков
 $a = mysql_fetch_array($result);
 $suchUsersCount=$a['num'];
 //и если их больше нуля(а кроме как единица это не может быть:)),
 //то значит есть такой уже:)
 if($suchUsersCount==0){
  return false;
 }else{
  return true;
 }

}

//******************************************************************************
//функа проверяющая наличие пользователя с таким мылом в таблице****************

function ThereIsSuchEmailAlready($mail){

 //посылаем запрос:
 $query="SELECT count(*) as num FROM uzers WHERE Email='$mail' LIMIT 1";
 //получаем результат
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 //узнаем количество таких чуваков
 $suchUsersCount=$a['num'];
 //и если их больше нуля(а кроме как единица это не может быть:)),
 //то значит есть такой уже:)
 if($suchUsersCount==0){
  return false;
 }else{
  return true;
 }

}

//******************************************************************************
//функа проверяющая наличие пользователя с таким именем страны в таблице********

function ThereIsSuchCountryAlready($countryName){

 //посылаем запрос:
 $query="SELECT count(*) as num FROM countries WHERE countryName='$countryName' LIMIT 1";
 //получаем результат
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 //узнаем количество таких чуваков
 $suchUsersCount=$a['num'];
 //и если их больше нуля(а кроме как единица это не может быть:)),
 //то значит есть такой уже:)
 //есть ли названия в сохранениях
 $query="SELECT count(*) as num FROM countries_save WHERE countryName='$countryName' LIMIT 1";
 //получаем результат
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 $suchUsersCount+=$a['num'];

 if($suchUsersCount==0){
  return false;
 }else{
  return true;
 }

}


//Дополнительные функции (введены с версии 070225)******************************
//******************************************************************************

//Проверяет, есть ли здание и выводит в браузер результат
function build_exists_print($countryID,$bld){
global $ses;
if(!building_exists($countryID,$bld)){
  printrus ("<b>!</b>У ВАС НЕТ ТАКОГО ЗДАНИЯ<b>!</b><br/>\r\n");
  printrus
("
<a href='../game.php?$ses'>Назад</a>
<br/>
");
//  printrus ("<a href='../unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
  //футер страницы:
  include_once(_ROOT."/other_inc/footer.php");

  die("");
 }
}

//Проверяет, идет ли починка здания, а также считывает параметры здания
function is_repairing($countryID,$bld,$m=''){

global $is_rep,$memcache,$guard,$guard_2,$guard_3,$guard_4,$guard_5,$guard_6,$guard_7,$guard_8,$space,$hits,$var1,$var2,$ses;

//Считаем параметры здания:
$key=_PREFIKS.':buildings'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){
        $guard = $mem[$i]['guard'];
        $guard_2 = $mem[$i]['guard_2'];
        $guard_3 = $mem[$i]['guard_3'];
        $guard_4 = $mem[$i]['guard_4'];
        $guard_5 = $mem[$i]['guard_5'];
        $guard_6 = $mem[$i]['guard_6'];
        $guard_7 = $mem[$i]['guard_7'];
        $guard_8 = $mem[$i]['guard_8'];
        $space = $mem[$i]['space'];
        $hits = $mem[$i]['hits'];
        $var1 = $mem[$i]['var1'];
        $var2 = $mem[$i]['var2'];
        break;
        }
    }else{
 $query="select * from `buildings` where countryID='$countryID' and building='$bld' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $guard=mysql_result($result,0,'guard');
 $guard_2=mysql_result($result,0,'guard_2');
 $guard_3=mysql_result($result,0,'guard_3');
 $guard_4=mysql_result($result,0,'guard_4');
 $guard_5=mysql_result($result,0,'guard_5');
 $guard_6=mysql_result($result,0,'guard_6');
 $guard_7=mysql_result($result,0,'guard_7');
 $guard_8=mysql_result($result,0,'guard_8');
 $space=mysql_result($result,0,'space');
 $hits=mysql_result($result,0,'hits');
 $var1=mysql_result($result,0,'var1');
 $var2=mysql_result($result,0,'var2');
 }

//А чинится ли здание?
$key=_PREFIKS.':works'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    $is_rep = 0;
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['kind']=='repairing'&&$mem[$i]['what']==$bld) {
            $is_rep=1;
            $started=$mem[$i]['started'];
            $finished=$mem[$i]['finished'];
            break;
            }
    }else{
 $query="select * from `works` where countryID='$countryID' and kind='repairing' and what='$bld' limit 1";
 $result=@MYSQL_QUERY($query);
 $is_rep=mysql_num_rows($result);
 $started=@mysql_result($result,0,"started");
 $finished=@mysql_result($result,0,"finished");
 }

if($is_rep==1){  //Если идет починка
 switch($m):
 case(''):
 $percent=getWorkPercent($started,$finished,time());

  printrus ("Идет ремонт здания (<b>$percent</b>%)<br/>\r\n");
  printrus
("<anchor>
Прервать
<go href='".$bld.".php?$ses' method='post'>
<postfield name='m' value='break'/>
</go>
</anchor>
<br/>
");

 break;
 case('break'):

  $percent=getWorkPercent($started,$finished,time());

  printrus ("Вы уверены, что хотите прервать ремонтные работы?<br/>\r\n");
  printrus
("<anchor>
Да
<go href='".$bld.".php?$ses' method='post'>
<postfield name='m' value='breaksure'/>
</go>
</anchor>

");
  printrus
("
<a href='".$bld.".php?$ses'>Нет</a>
<br/>
");
 break;
 case('breaksure'):

 $hts=repaireBuildingStop($countryID,$bld,$hits);

  printrus ("Ремонт здания прерван!<br/>(Текущий уровень целостности - <b>$hts</b>%)<br/>\r\n");
  printrus
("
<a href='".$bld.".php?$ses'>Ок</a>
<br/>
");

 break;
 endswitch;

}

}

//Название здания в родительном падеже
function build_print_rod($bld){
if ($bld=='barracks')return 'казарм';
elseif($bld=='warhouse')return 'дома войны';
elseif($bld=='ratusha')return 'ратуши';
elseif($bld=='citadel')return 'цитадели';
elseif($bld=='keeping')return 'хранилища';
elseif($bld=='market')return 'рынка';
elseif($bld=='university')return 'университета';
elseif($bld=='scientificcenter')return 'научного центра';
elseif($bld=='village')return 'деревни';
elseif($bld=='wall')return 'стены';
elseif($bld=='fabrika')return 'фабрики';
elseif($bld=='zavod')return 'завода';
elseif($bld=='magictower')return 'башни магов';
elseif($bld=='gorodmagov')return 'города магов';
elseif($bld=='neftevxwka')return 'нефтяной вышки';
else return 'здания';
}

//Название здания в винительном падеже
function build_print_vin($bld){
if ($bld=='barracks')return 'казармы';
elseif($bld=='warhouse')return 'дом войны';
elseif($bld=='ratusha')return 'ратушу';
elseif($bld=='citadel')return 'цитадель';
elseif($bld=='keeping')return 'хранилище';
elseif($bld=='market')return 'рынок';
elseif($bld=='university')return 'университет';
elseif($bld=='scientificcenter')return 'научный центр';
elseif($bld=='village')return 'деревню';
elseif($bld=='wall')return 'стену';
elseif($bld=='fabrika')return 'фабрику';
elseif($bld=='zavod')return 'завод';
elseif($bld=='magictower')return 'башню магов';
elseif($bld=='gorodmagov')return 'город магов';
elseif($bld=='neftevxwka')return 'нефтяную вышку';
else return 'здание';
}


//Починка здания
function repair($countryID,$bld,$m){

//hits - целостность здания, peopleto - число рабочих, которые будут чинить здание,
//$workers - число рабочих гос-ва, $workers_max - константа, $space - место, занимаемое зданием,
//$ses - переменная сессии, $b - массив с инфой о гос-ве
global $hits,$peopleto,$workers,$workers_max,$space,$ses,$b,$var1,$var2,$memcache,$id_m,$key1;

$workers = $b['workers'];

require (_ROOT.'/b_params.php');

//ресурсы, необходимые для починки
$s = $bld.'_arbor';
$arbor=round($$s*(100-$hits)/100);
$s = $bld.'_stone';
$stone=round($$s*(100-$hits)/100);
$s = $bld.'_iron';
$iron=round($$s*(100-$hits)/100);

  if($hits>=100){
   printrus ("Нечего чинить!<br/>\r\n");
  }elseif($peopleto<=0 || empty($peopleto)){
   printrus ("дерево: <b>$arbor</b><br/>\r\n");
   printrus ("камень: <b>$stone</b><br/>\r\n");
   printrus ("железо: <b>$iron</b><br/>\r\n");
   printrus ("рабочие: <br/>\r\n");
   printrus ("<form action=\"".$bld.".php?$ses&amp;m=repaire\" method=\"post\">
<input format='*N' name='peopleto' /><br/>\r\n");
   printrus
("<input type=\"submit\" value=\"Чинить\"/></form>
<br/>
");
  }elseif($workers<15){
   printrus ("У вас нет 15 свободных рабочих для ремонта!<br/>\r\n");
  }elseif($peopleto>($workers_max*$space)){
   printrus ("Над ремонтом здания может работать только <b>".($workers_max*$space)."</b> рабочих!<br/>\r\n");
   if(($workers_max*$space)<=$workers){
    printrus
("<a href=\"".$bld.".php?$ses&amp;m=repaire&amp;peopleto=".($workers_max*$space)."\">К работе всех</a>
<br/>
");
    printrus
("<a href=\"".$bld.".php?$ses&amp;m=repaire\">Отмена</a>
<br/>
");
   }else{
    printrus ("Но у вас всего <b>$workers</b>.<br/>\r\n");
    printrus
("<a href=\"".$bld.".php?$ses&amp;m=repaire&amp;peopleto=$workers\">К работе всех</a>
<br/>
");
    printrus
("<a href=\"".$bld.".php?$ses&amp;m=repaire\">Отмена</a>
<br/>
");
   }
  }elseif($b['arbor']<$arbor){
   printrus ("Не хватает дерева для ремонта этого здания!<br/>(необходимо <b>$arbor</b>)<br/>\r\n");
  }elseif($b['stone']<$stone){
   printrus ("Не хватает камня для ремонта этого здания!<br/>(необходимо <b>$stone</b>)<br/>\r\n");
  }elseif($b['iron']<$iron){
   printrus ("Не хватает железа для ремонта этого здания!<br/>(необходимо <b>$iron</b>)<br/>\r\n");
  }elseif($peopleto<15){
   printrus ("Над ремонтом здания могут работать минимум 15 человек!<br/>\r\n");
  }elseif($b['workers']<$peopleto){
   printrus ("У вас нет столько рабочих!<br/>(всего: <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"".$bld.".php?$ses&amp;m=repaire&amp;peopleto=$workers\">К работе всех</a>
<br/>
");
   printrus
("<a href=\"".$bld.".php?$ses&amp;m=repaire\">Отмена</a>
<br/>
");
  }else{
   //устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE countries SET arbor = arbor - $arbor, stone = stone - $stone, iron = iron - $iron, workers = ($workers - $peopleto) WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['arbor'] = $b['arbor'] - $arbor;
   $b['stone'] = $b['stone'] - $stone;
   $b['iron'] = $b['iron'] - $iron;
   $b['workers'] = $workers - $peopleto;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   //просчитываем,скока понадобится времени для ремонта:
   $s = $bld.'_time';
   $work_time=round(((100-$hits)*$$s)/(100*$peopleto));

   //записываем в мускул, что идет ремонт:
   $query="insert into `works` values('$countryID','repairing','$bld',$peopleto,".date(U).",".($work_time+date(U)).", $var1, $var2)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'repairing', "what"=>$bld, "peopleatwork"=>$peopleto, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$var1, "var2"=>$var2);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Ремонт ".build_print_rod($bld)." будет завершен через ".mkTimeStr($work_time)."<br/>\r\n");

 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."ремонтирует $bld $peopleto рабочими.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }


}


//Выводит ресурсы
function res_print($money=0,$stone=0,$iron=0,$arbor=0,$grain=0,$oil=0){
$str='';
if ($money>0) $str.="Деньги: <b>$money</b>,";
if ($stone>0) $str.="Камень: <b>$stone</b>,";
if ($iron>0) $str.="Железо: <b>$iron</b>,";
if ($arbor>0) $str.="Дерево: <b>$arbor</b>,";
if ($grain>0) $str.="Зерно: <b>$grain</b>,";
if ($oil>0) $str.="Нефть: <b>$oil</b>,";
return $str;
}


//Форма для выбора войска
function print_form_voisko($bld,$wariors,$m='war',$n='attack',$neighbour=''){
global $ses;
printrus("<form name=\"\" action=\"$bld.php?$ses&amp;m=$m&amp;n=$n&amp;neighbour=$neighbour\" method=\"post\">");
for ($i=0;$i<count($wariors);$i++){
if ($i!=0)$s='wariorsto_'.($i+1);
else $s='wariorsto';
if ($wariors[$i]>0)printrus (get_unit_name($i).":<br/><input format='*N' name='$s' />(всего:<b>".$wariors[$i]."</b>)<br/>\r\n");
}

printrus
("<input type=\"submit\" value=\"Отправить\"/></form><br/>");

}


//Апгрейд здания
function build_upgrade($countryID,$bld,$oldbld){

global $ses,$b,$hits,$workers,$peopleto,$space,$workers_max,$id_m,$memcache,$var1,$var2,$key1;

$workers = $b['workers'];
require (_ROOT.'/b_params.php');

$s = $bld.'_arbor';
$arbor=$$s;
$s = $bld.'_stone';
$stone=$$s;
$s = $bld.'_iron';
$iron=$$s;
$s = $bld.'_money';
$money_nd=$$s;
$s = $bld.'_oil';
$oil=$$s;

  if(builds($b['countryID'],$bld)){
   printrus ("Улучшение уже строится! Имейте терпение.<br/>\r\n");
  }elseif($hits<100){
   printrus ("Здание разрушено! Нельзя строить улучшение!<br/>\r\n");
  }elseif($workers<=0){
   printrus ("У вас нет рабочих!<br/>\r\n");
  }elseif($peopleto<=0 || empty($peopleto)){
   printrus ("Улучшение: ".printBuilding($bld)."<br/>\r\n");
   printrus (res_print($money_nd,$stone,$iron,$arbor,0,$oil).'<br/>');
   printrus ("рабочие: <br/>\r\n");
   printrus ("<form name=\"\" action=\"".$oldbld.".php?$ses&amp;m=upgraide\" method=\"post\">
   <input format='*N' name='peopleto' /><br/>\r\n
   <input type=\"submit\" value=\"Строить\"/>
   </form>");

   printrus
("
<a href='".$oldbld.".php?$ses'>Отмена</a>
<br/>
");

  }elseif($peopleto>($workers_max*$space)){
   printrus ("Над улучшением может работать только <b>".($workers_max*$space)."</b> рабочих!<br/>\r\n");
   if(($workers_max*$space)<=$workers){
    printrus
("<a href=\"".$oldbld.".php?$ses&amp;m=upgraide&amp;peopleto=".($workers_max*$space)."\">К работе всех!</a>
<br/>
");
    printrus
("<a href=\"".$oldbld.".php?$ses&amp;m=upgraide\">Отмена</a>
<br/>
");
   }else{
    printrus ("Но у вас всего <b>$workers</b>.<br/>\r\n");
    printrus
("<a href=\"".$oldbld.".php?$ses&amp;m=upgraide&amp;peopleto=".$workers."\">К работе всех!</a>
<br/>
");
    printrus
("<a href=\"".$oldbld.".php?$ses&amp;m=upgraide\">Отмена</a>
<br/>
");
   }
  }elseif($b['money']<$money_nd){
   printrus ("Не хватает денег для постройки улучшения!<br/>(необходимо <b>$money_nd</b>)<br/>\r\n");
  }elseif($b['arbor']<$arbor){
   printrus ("Не хватает дерева для постройки улучшения!<br/>(необходимо <b>$arbor</b>)<br/>\r\n");
  }elseif($b['stone']<$stone){
   printrus ("Не хватает камня для постройки улучшения!<br/>(необходимо <b>$stone</b>)<br/>\r\n");
  }elseif($b['iron']<$iron){
   printrus ("Не хватает железа для постройки улучшения!<br/>(необходимо <b>$iron</b>)<br/>\r\n");
  }elseif($b['oil']<$oil){
   printrus ("Не хватает нефти для постройки улучшения!<br/>(необходимо <b>$oil</b>)<br/>\r\n");
  }elseif($b['workers']<$peopleto){
   printrus ("У вас нет столько рабочих!<br/>(всего: <b>$workers</b>)<br/>\r\n");
   printrus
("<a href=\"".$oldbld.".php?$ses&amp;m=upgraide&amp;peopleto=".$workers."\">К работе всех!</a>
<br/>
");
   printrus
("<a href=\"".$oldbld.".php?$ses&amp;m=upgraide\">Отмена</a>
<br/>
");
  }else{
   //устанавливаем изменившиеся значения ресурсов:
   mysql_query("UPDATE countries SET money = money - $money_nd, arbor = arbor - $arbor, stone = stone - $stone, iron = iron - $iron, workers = workers - $peopleto, oil = oil - $oil WHERE countryID = '".$b['countryID']."' LIMIT 1");
   $b['arbor'] = $b['arbor'] - $arbor;
   $b['stone'] = $b['stone'] - $stone;
   $b['iron'] = $b['iron'] - $iron;
   $b['oil'] = $b['oil'] - $oil;
   $b['workers'] = $b['workers'] - $peopleto;
   $b['money'] = $b['money'] - $money_nd;
   if($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }

   //просчитываем,скока понадобится времени для постройки:
   $s=$bld.'_time';
   $work_time=round($$s/$peopleto);

   //записываем в мускул, что идет постройка Дома Войны:
   $query="insert into `works` values('$countryID','building','$bld',$peopleto,".date(U).",".($work_time+date(U)).", $var1, $var2)";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $key=_PREFIKS.':works'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $neww = array("countryID"=>$countryID, "kind"=>'building', "what"=>$bld, "peopleatwork"=>$peopleto, "started"=>time(), "finished"=>($work_time+time()), "var1"=>$var1, "var2"=>$var2);
      array_push($mem,$neww);
      $memcache->set($key,$mem,false,86400);
      }

   printrus ("Постройка будет завершена через ".mkTimeStr($work_time)."<br/>\r\n");
 //Пишем в лог работ:
 @$open=fopen("../logs/works".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:")."строит апгрейд: $bld $peopleto рабочими.\n");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

  }

}


//Возвращает название ресурса в именительном падеже
function get_res_name($res){
if ($res=='money')return 'деньги';
elseif ($res=='arbor')return 'древесина';
elseif ($res=='stone')return 'камень';
elseif ($res=='oil')return 'нефть';
elseif ($res=='iron')return 'железо';
else return 'зерно';
}

//Возвращает название ресурса в винительном падеже
function get_res_name_vin($res){
if ($res=='money')return 'деньги';
elseif ($res=='arbor')return 'древесину';
elseif ($res=='stone')return 'камень';
elseif ($res=='oil')return 'нефть';
elseif ($res=='iron')return 'железо';
else return 'зерно';
}

//Возвращает название ресурса в родительном падеже
function get_res_name_rod($res){
if ($res=='money')return 'денег';
elseif ($res=='arbor')return 'древесины';
elseif ($res=='stone')return 'камня';
elseif ($res=='oil')return 'нефти';
elseif ($res=='iron')return 'железа';
else return 'зерна';
}

//Возвращает апгредированный аналог здания
function get_upgrade_build($bld){
if ($bld=='ratusha')return 'citadel';
elseif ($bld=='barracks')return 'warhouse';
elseif ($bld=='keeping')return 'market';
elseif ($bld=='university')return 'scientificcenter';
elseif ($bld=='fabrika')return 'zavod';
elseif ($bld=='magictower')return 'gorodmagov';
else return $bld;
}

function stopgame($countryID){
 	 $b=CountryInfo($countryID);
     if ($b['inv']==-1 && $b['blocked']>time()){
    $r=mysql_query("SELECT * FROM `blocks` WHERE cid='".$_SESSION['userID']."' LIMIT 1");
    $a=mysql_fetch_array($r);
    printrus ("Модер <u>".$a['who']."</u> блокировал вам доступ к игре. Причина:<br/>".$a['why']."<br/>\r\n");
    session_destroy();
    printrus ("<a href='index.php'>&lt;&lt;Выход</a><br/>\r\n");
    //футер страницы:
    include_once(_ROOT."/other_inc/footer.php");
    exit;
 }
   $zz = mysql_query("SELECT count(*) as num FROM `messages` WHERE countryID = '$countryID' and `from` = 'loose'");
   $aa = mysql_fetch_array($zz);
   if ($aa['num']>0){
   	session_destroy();
  mysql_query("UPDATE uzers SET onlineflag = 0 WHERE countryID = '$countryID' LIMIT 1");


   include_once(_ROOT."/other_inc/footer.php");
    exit;}
 }
///////////////////////////////////////////////////////////////////////////////
// mail_ru data
$host = $_SERVER["HTTP_HOST"];
$soc_seti_add_data = array("url_params" => "");
$mail_ru_mode = false;
if(substr($host,0,2)=="mr" /*&& $udata[0]=="rabl"*/)
{
    global $mail_ru_mode;
    $mail_ru_mode = true;
    $secret_key = 'cae31ee99f7c9763d269138af3c1e08a';
    if(isset($_GET['session_key']))
    {
        $_SESSION['mr_session_key'] = $_GET['session_key'];
    }

    if(isset($_GET['vid']))
    {
        $_SESSION['mr_uid'] = $_GET['vid'];
    }
    if(isset($_GET['first_name']))
    {
        $_SESSION['mr_name'] = $_GET['first_name'];
    }

    $ses_key = $_SESSION['mr_session_key'];
    $params_url = 'app_id=643777&method=mobile.getCanvas&mobile_spec=smartphone&session_key='.$ses_key.'&format=xml&secure=1';

    $request_params = array(
        'app_id'=>'643777',
        'method' => 'mobile.getCanvas',
        'mobile_spec' => 'smartphone',
        'session_key' => $ses_key,
        'format' => 'xml',
        'secure' => 1
    );
    ksort($request_params);
    $params = '';
    foreach ($request_params as $key => $value)
    {
        $params .= "$key=$value";
    }
    $sig = md5($params . $secret_key);

    if(isset($_SESSION['mailru_data']))
    {
        $soc_seti_add_data['header'] = $_SESSION['mailru_data']['header'];
        $soc_seti_add_data['footer'] = $_SESSION['mailru_data']['footer'];
    }
    else
    {
        $get_canvas_url = 'http://www.appsmail.ru/platform/api?'.$params_url.'&sig='.$sig;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $get_canvas_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        curl_close($ch);
        $xml = new SimpleXMLElement($output);

        $soc_seti_add_data['header'] = '';//(string)$xml->header;
        $soc_seti_add_data['footer'] = '';//(string)$xml->footer;

        $_SESSION['mailru_data']['header'] = $soc_seti_add_data['header'];
        $_SESSION['mailru_data']['footer'] = $soc_seti_add_data['footer'];
    }


// login mail.ru user

    // check mail ru
    if(isset($_SESSION['mr_uid']))
    {
        // check dependence exists
        $r = mysql_query("select user_name,user_pass from mr_reg where mr_uid='".$_SESSION['mr_uid']."'");
        if($err && mysql_error()!='')    {        echo "_db_user_exists: ".mysql_error();    }
        if($r!=false)
        {
            if(mysql_num_rows($r)!=0)
            {
                $r_l = mysql_fetch_array($r);
//                $ctime=time()+864000;
//setcookie('clvus',base64_encode($r_l['user_name']),$ctime);
//setcookie('clvps',base64_encode($r_l['user_pass']),$ctime);
//                $_SESSION['log']=$r_l['user_name'];
//                $_SESSION['pas']=$r_l['user_pass'];
//                $username=iconv('utf-8','cp1251',$r_l['user_name']);

if(!isset($_SESSION['auth'])){header('Location: enter.php?username='.urlencode(iconv ('windows-1251', 'UTF-8', $r_l['user_name'])).'&password='.$r_l['user_pass'].'&sawform');}

// COOKKIE
//if(!isset($_SESSION['log']) && isset($_COOKIE['clvus'])){    $_SESSION['log'] = $_COOKIE['clvus'];    }
//if(!isset($_SESSION['pas']) && isset($_COOKIE['clvps'])){    $_SESSION['pas'] = $_COOKIE['clvps'];    }

//                setcookie($r_l['user_name']);
//                setcookie($r_l['user_pass']);
            }
        }
    }
    //exit;
}
// END mail ru

///////////////////////////////////////////////////////////////////////////////
// odnoklasniki data
$host = $_SERVER["HTTP_HOST"];
$soc_seti_add_data = array("url_params" => "");
$odnoklasniki_mode = false;
if(substr($host,0,1)=="o" /*&& $udata[0]=="rabl"*/)
{
    $odnoklasniki_mode = true;

    function calc_sig($arr,$sk)
    {
        $kv = array();
        foreach ($arr as $key => $val)
        {
            if ($key != 'sig')
            {
                $kv[] = "$key=".$val;
                //echo "$key=".$val."<br>";
            }
        }
        sort($kv);
        $res = join('', $kv);
        //echo $sk;
        //echo $res.$sk;
        return md5($res.$sk);
    }

    if(isset($_GET['session_key']))
    {
        $_SESSION['o_session_key'] = $_GET['session_key'];
    }

    if(isset($_GET['session_secret_key']))
    {
        $_SESSION['o_session_s_key'] = $_GET['session_secret_key'];
    }
    //
            if(isset($_GET['logged_user_id']))
    {
        $_SESSION['o_uid'] = $_GET['logged_user_id'];
    }
    //

    if(isset($_SESSION['odnoklasniki_data']))
    {
        $soc_seti_add_data['header'] = $_SESSION['odnoklasniki_data']['header'];
        $soc_seti_add_data['footer'] = $_SESSION['odnoklasniki_data']['footer'];
    }
    else
    {
        $secret_key  = '1A05AA0864B5BD3CB5364093';

        $api_server      = $_GET['api_server'];
        $application_key = $_GET['application_key'];
        $viewer_id       = $_GET['logged_user_id'];
        $sig             = $_GET['sig'];
        $session_key     = $_GET['session_key'];
        $_SESSION['apiconnection'] = $_GET['apiconnection'];

        # make sure that $viewer_id is not faked



        //    d41d8cd98f00b204e9800998ecf8427e
        $_SESSION['api_server'] = $api_server;
        $_SESSION['o_uid'] = $viewer_id;
        # XXX keep the args array alphabetically sorted! XXX

        //if ($sig != calc_sig($_GET,$secret_key)) exit('Wrong signature');

        $args = array(
                'application_key' => $application_key,
                'session_key'     => $session_key,
                'wid'            => 'mobile-header'
                //'format'          => 'xml'
        );

        $after_key = 'd41d8cd98f00b204e9800998ecf8427e';

        # construct the call to fetch first_name and pic_1
        $req = $api_server."api/widget/getWidgetContent?sig=" . calc_sig($args,$after_key);
        foreach ($args as $key => $val) {            $req .= "&$key=$val";    }
		//k
        $_SESSION['odnoklasniki_data']['header'] = file_get_contents($req);

        $args['wid'] = 'mobile-footer';
        $req = $api_server."api/widget/getWidgetContent?sig=" . calc_sig($args,$after_key);
        foreach ($args as $key => $val) {            $req .= "&$key=$val";    }
		//k
        $_SESSION['odnoklasniki_data']['footer'] = file_get_contents($req);

        $_SESSION['odnoklasniki_data']['header'] = $soc_seti_add_data['header'];
        $_SESSION['odnoklasniki_data']['footer'] = $soc_seti_add_data['footer'];
    }

    // login odnoklasniki.ru user
    // check odnoklasniki ru
    if(isset($_SESSION['o_uid']))
    {
        // check dependence exists
        $r = mysql_query("select user_name,user_pass from o_reg where o_uid='".$_SESSION['o_uid']."'");
        if($err && mysql_error()!='')    {        echo "_db_user_exists: ".mysql_error();    }
        if($r!=false)
        {
            if(mysql_num_rows($r)!=0)
            {
                $r_l = mysql_fetch_array($r);
                $_SESSION['log']=trim($r_l['od_name']);
                $_SESSION['pas']=trim($r_l['od_pass']);
                if(!isset($_SESSION['auth']) AND !isset($_SESSION['auth2']) ){header('Location: enter.php?username='.urlencode(iconv ('windows-1251', 'UTF-8', $r_l['user_name'])).'&password='.$r_l['user_pass'].'&sawform&redir=1');}
            }
        }
    }
    //exit;
}
// END odnoklasniki ru
///////////////////////////////////////////////////////////////////////////////

/*
// Allowed IP

$aAllowIP = array(

//	'109.87.170.207',	// Anton Musulezny/Home

//	'77.239.170.134',	// Andrey Rybets

//	'93.127.98.36',     // Sergey Vonsarovsky/Home

	'212.90.33.207',    // Vadim Didenko & Dmitry Dmitriev

//	'195.191.13.6',	    // Andrey Dzjaduk

//	'195.24.156.86',	// Dialog/Office (Trifle)

	'127.0.0.1'	,		// localhost

);

// Error reporting

if ( in_array($_SERVER['REMOTE_ADDR'], $aAllowIP) )

{

	error_reporting(E_ALL^E_NOTICE);

}

else

{

   	error_reporting(0);

}
*/



?>