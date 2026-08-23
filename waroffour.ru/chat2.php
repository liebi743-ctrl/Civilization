<?php
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['msg'])) $msg = $_REQUEST['msg'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['prvt'])) $prvt = $_REQUEST['prvt'];
//if (isset($_REQUEST['clv'])) $clv = $_REQUEST['clv'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($pg)&&!is_numeric($pg))$pg=0;
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['vl'])) $vl = $_REQUEST['vl'];
if (isset($_REQUEST['bvl'])) $bvl = $_REQUEST['bvl'];
$ref = rand(0,1000000);

function check($str,$hsc=1){
$str=strtr($str,array(chr("0")=>"",chr("1")=>"",chr("2")=>"",chr("3")=>"",chr("4")=>"",chr("5")=>"",chr("6")=>"",chr("7")=>"",chr("8")=>"",chr("9")=>"",chr("10")=>"",chr("11")=>"",chr("12")=>"",chr("13")=>"",chr("14")=>"",chr("15")=>"",chr("16")=>"",chr("17")=>"",chr("18")=>"",chr("19")=>"",chr("20")=>"",chr("21")=>"",chr("22")=>"",chr("23")=>"",chr("24")=>"",chr("25")=>"",chr("26")=>"",chr("27")=>"",chr("28")=>"",chr("29")=>"",chr("30")=>"",chr("31")=>"","Р?"=>"И","вЂ¦"=>" ","вЂ©-"=>" ","вЂњ"=>" ","вЂќ"=>" ","вЂ©"=>" ","вЂ“"=>"-","\n"=>" ","$"=>"$$"));
if($hsc==1)$str = HtmlSpecialChars($str);
$str = ereg_replace(" +"," ",$str);
$str = trim($str);
return $str;
}


//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
$countryID = $_SESSION['countryID'];
//шапка:
include_once("other_inc/header.php");
stopgame($_SESSION['countryID']);
/*
$headtime = getmicrotime();
header("Cache-Control: no-cache");
header ("Content-type:text/vnd.wap.wml");

$title="Р¦РёРІРёР»РёР·Р°С†РёСЏ";
$align="left";

print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>
<!DOCTYPE wml PUBLIC \"-//WAPFORUM//DTD WML 1.2//EN\" \"http://www.wapforum.org/DTD/wml12.dtd\">
<wml><head><meta http-equiv=\"Cache-Control\" content=\"no-cache\" forua=\"true\"/></head>
<card title='$title'>
<do type=\"options\" name=\"game\" label=\"Р’ РёРіСЂСѓ\"><go href=\"game.php?$ses\"/></do>
<do type=\"options\" name=\"game2\" label=\"РђСЃСЃР°РјР±Р»РµСЏ\"><go href=\"chat.php?$ses\"/></do>
<do type=\"options\" name=\"refresh\" label=\"РћР±РЅРѕРІРёС‚СЊ\"><go href=\"chat2.php?$ses\"/></do>
<p align='$align'>
<small>
";  */

//==============================================================================
//Рабочая часть скрипта=========================================================

//global $memcache;
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }
 if ($b['countryName']==''){
@$open=fopen("mod/test.dat","a+");
@flock ($open,LOCK_EX);
$str = date("H:i ->")."ID=$countryID, userID=".$_SESSION['userID'].", SESSIONID=".$ses."\n\r";
@fwrite ($open,$str);
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);
    }


//******************************************************************************
//проверка на валидность идентификатора:****************************************
 if(isset($_SESSION['auth'])){
  //syncses($_SESSION['countryID']);
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u>(".date("H:i").")");
  print "<br/>\r\n";
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='index.php'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 $countryID = $b['countryID'];

printrus ("<a href=\"chat2.php?$ses\">Обновить</a><br/>\n");
printrus ("<a href='chat.php?$ses'>Чат</a><br/>\n");
printrus ("<a href='game.php?$ses'>Страна</a><br/>\n");
printrus ("<a href=\"chat.php?pw&amp;$ses\">Приват</a><br/><br/>\n");



if (!isset($pg))$pg=0;
if (!is_numeric($pg))$pg=0;
if (isset($pg)) $pg=$pg*10-10;
if ($pg<0)$pg=0;
$pg = addslashes($pg);

//Умник:
$key_um=_PREFIKS.':umnik';
if (($mem=$memcache->get($key_um))===FALSE){
        $newum = array("number"=>5,"time"=>0,"question"=>'',"answer"=>'',"tran"=>'',"nv"=>0);
        $memcache->set($key_um,$newum,false,86400);
}

$mem_u=$memcache->get($key_um);
$nom = $mem_u["number"];
$vr = $mem_u["time"];
$answ = $mem_u["answer"];
$tran = $mem_u["tran"];
//echo "$vr-$nom";
if (time()>=$vr){

if ($nom == 5){
$st = time()+240;

$mem_u['time']=$st;
$memcache->set($key_um,$mem_u,false,86400);

//Выбираем новый вопрос
do{
$rnd = mt_rand(1,170144);
}while ($rnd>=45170 && $rnd<=51567);

$qu = mysql_query ("Select * from `bots` where number='".$rnd."' limit 1");
$re = mysql_fetch_array ($qu);
$answ = $re["answer"];
$tran = $re["tran"];
$nom = 0;
$vr = $st;

$i = strlen($answ);
$vp = $re["vopros"]." ($i букв)";

$mem_u['number']=$nom;
$mem_u['question']=$vp;
$mem_u['answer']=$answ;
$mem_u['tran']=$tran;
$memcache->set($key_um,$mem_u,false,86400);

$st = getmicrotime();

$date=date ("[H:i]");

mysql_query("INSERT into guestbook2 SET id = '".$st."', nick = 'Умник', message = '".$vp."', date = '".$date."', inv = '0', countryID = '0'");

} else { //Верного ответа не последовало
$st = time()+30; //Время след. вопроса - через 1 минуту

$mem_u['time']=$st;
$memcache->set($key_um,$mem_u,false,86400);

$answ = " ";
$tran = " ";
$nom = 5;
$vr = $st;

$mem_u['answer']=$answ;
$mem_u['tran']=$tran;
$mem_u['number']=$nom;
$mem_u['time']=$st;
$memcache->set($key_um,$mem_u,false,86400);

 //Запись реакции Умника в файл:

$st = getmicrotime();
$vp = "Время истекло! Следующий вопрос через 30 сек.";
$date=date ("[H:i]");

mysql_query("INSERT into guestbook2 SET id = '".$st."', nick = 'Умник', message = '".$vp."', date = '".$date."', inv = '0', countryID = '0'");

 }
 }  else
            //1-ая подсказка:
 if ((($vr-time())<180)&&($nom == 0)){
 $nom = 1;

 $mem_u['number']=$nom;
 $mem_u['answer']=$answ;
 $memcache->set($key_um,$mem_u,false,86400);

 $st = getmicrotime();

 $v = $answ;
 $v = substr($v,0,1);
 $vp = "Подсказка: $v...";
 $date=date("[H:i]");

  mysql_query("INSERT into guestbook2 SET id = '".$st."', nick = 'Умник', message = '".$vp."', date = '".$date."', inv = '0', countryID = '0'");

 } else
        //Вторая подсказка:
         if ((($vr-time())<90)&&($nom < 2)){
         $nom = 2;
 $mem_u['number']=$nom;
 $mem_u['answer']=$answ;
 $memcache->set($key_um,$mem_u,false,86400);
 $st = getmicrotime();

$v = $answ;
$i = strlen($v)/3;
if ($i<2) $i=2;
$v = substr($v,0,$i);
$vp = "Подсказка: $v...";
$date=date("[H:i]");
mysql_query("INSERT into guestbook2 SET id = '".$st."', nick = 'Умник', message = '".$vp."', date = '".$date."', inv = '0', countryID = '0'");

         }

//Конец викторины

if (isset($go)){
      $msg = str_replace("$",'',$msg);
      setlocale(LC_CTYPE, 'ru_RU.CP1251');
      if ($t1=='1') $msg=translit($msg);
      $message = iconv('utf-8','cp1251',check($msg));
      $message = preg_replace("/([а-яa-z0-9\.\-]{3,25})+(\.(su|ru|ua|kz|com|net|biz|info|lt|org|il|be|uа|сom|cоm|coм|соm|сoм|cом|nеt|neт|nет|infо|оrg|bе|It))/i", 'imperia.mobi',$message);

      $yname = $b['countryName'];
      $date = date("[H:i]");
      $idd = getmicrotime();
      $r = mysql_query("SELECT message FROM guestbook2 WHERE nick = '".$yname."' order by id desc LIMIT 1");
      $a = mysql_fetch_array($r);
      if ($message!='' && $a['message']!=$message){
      if (isset($prvt))mysql_query("INSERT into guestbook2 SET id = '".$idd."', nick = '".$yname."', message = '".$message."', date = '".$date."', inv = '".$b['inv']."', countryID = '".$b['countryID']."', tocountryID = '".$prvt."'");
      else mysql_query("INSERT into guestbook2 SET id = '".$idd."', nick = '".$yname."', message = '".$message."', date = '".$date."', inv = '".$b['inv']."', countryID = '".$b['countryID']."'");
      }
      printrus ("Ваше сообщение добавлено!<br/>");
 //Умник - проверка на правильность
 //Перевопрос

if ($message=="!вопрос"||$message=="!vopros"){
$key_um=_PREFIKS.':umnik';
$mem_u=$memcache->get($key_um);
$vp = "Повторяю вопрос. ".$mem_u["question"];
$i = $mem_u["number"];
if ($i!=5){
$st = getmicrotime()+0.05;
$date=date("[H:i]");
mysql_query("INSERT into guestbook2 SET id = '".$st."', nick = 'Умник', message = '".$vp."', date = '".$date."', inv = '0', countryID = '0'");

}
}
//Конец перевопроса
$key_um=_PREFIKS.':umnik';
$mem_u=$memcache->get($key_um);
$nom = $mem_u["number"];
$vr = $mem_u["time"];
$answ = $mem_u["answer"];
$tran = $mem_u["tran"];

$accept = @getenv("HTTP_Accept");
if($b['inv']==2)$accept=0;

if ((strtolower($message)==$answ||strtolower($message)==$tran)&&$nom!=6&& strpos ($accept,"x-xbitmap") == false && $b['inv']!=1){
$st = time()+30; //Время след. вопроса - через 1 минуту
$mem_u['number']=6;
$mem_u['time']=$st;
$mem_u['answer']=" ";
$mem_u['tran']=" ";
$memcache->set($key_um,$mem_u,false,86400);

$rnd=rand(0,6);
if ($rnd==0) {
        $vle = rand(3,10);
        mysql_query("UPDATE `countries` SET iron=iron+$vle WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b['iron']=$b['iron']+$vle;
    $memcache->set($key1,$b,false,86400);
    $s="$vle железа";
}elseif($rnd==1){
        $vle = rand(70,150);
        mysql_query("UPDATE `countries` SET money=money+$vle WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b['money']=$b['money']+$vle;
    $memcache->set($key1,$b,false,86400);
    $s="$vle денег";
}elseif($rnd==2){
        $rnd1=rand(0,200);
        if($rnd1!=10){
        $vle = rand(7,14);
        mysql_query("UPDATE `countries` SET arbor=arbor+$vle WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b['arbor']=$b['arbor']+$vle;
    $memcache->set($key1,$b,false,86400);
    $s="$vle дерева";
        }else{
        if (!otkr_exists($b['countryID'])){
        mysql_query("INSERT INTO `otkrytiya` SET otkr='PERJ', countryID = '".$b['countryID']."'");
    //$b['arbor']=$b['arbor']+2;
    //$memcache->set($key1,$b,false,86400);
    $key=_PREFIKS.':otkrytiya'.$b['countryID'];
    if (($mem=$memcache->get($key))!==FALSE){
            $newo = array("countryID"=>$b['countryID'],"otkr"=>'PERJ');
            array_push($mem,$newo);
            $memcache->set($key,$mem,false,86400);
    }
        }
    $s='переплавку железа';
        }
}elseif($rnd==3){
        $vle = rand(7,14);
        mysql_query("UPDATE `countries` SET stone=stone+$vle WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b['stone']=$b['stone']+$vle;
    $memcache->set($key1,$b,false,86400);
    $s="$vle камня";
}elseif($rnd==4){
        $vle = rand(12,24);
        mysql_query("UPDATE `countries` SET grain=grain+$vle WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b['grain']=$b['grain']+$vle;
    $memcache->set($key1,$b,false,86400);
    $s="$vle зерна";
}elseif($rnd==5){
        $rnd1=rand(0,10);
        if($rnd1!=10){
    mysql_query("UPDATE `countries` SET wariors_free=wariors_free+2 WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $b['wariors_free']=$b['wariors_free']+2;
    $memcache->set($key1,$b,false,86400);
    $s='2 пехотинца';
        }else{
      mysql_query("UPDATE `uzers` SET credits=credits+2 WHERE countryID = '".$b['countryID']."' LIMIT 1");
    $s='2 алмаза';
        }
}



$st = getmicrotime()+0.01;
$date=date("[H:i]");
$mes = "Молодец, ".$b['countryName']."! Правильный ответ: $answ. Вы получаете $s. Следующий вопрос через 30 сек";
mysql_query("INSERT into guestbook2 SET id = '".$st."', nick = 'Умник', message = '".$mes."', date = '".$date."', inv = '0', countryID = '0'");
echo mysql_error();
}

//Конец викторины

}

printrus ("<u>Сообщение:</u><br/>");
if (isset($vl)) $vlnm = checkCountryID($vl);
printrus ("<form name=\"\" action=\"chat2.php?go=add&amp;$ses\" method=\"post\">
<input name=\"msg\" maxlength=\"700\" title=\"Text\" value=\"$vlnm\"/>");
printrus("
<br/><input name=\"t1\" type=\"checkbox\" value=\"1\"/>Транслитеровать\n<br/>\n");
if (isset($vl)){printrus("
<input name=\"prvt\" type=\"checkbox\" value=\"$vl\"/>Приват\n<br/>\n");
}
printrus ("<input type=\"submit\" value=\"Написать\"/></form>\n");

if (isset($bvl)&&$b['inv']!=2)exit;

if (isset($bvl)){
        $bvl = iconv('utf-8','cp1251',$bvl);
        $r = mysql_query("SELECT countryID FROM `countries` WHERE countryName = '$bvl'");
        $a = mysql_fetch_array($r);
        $bc = $a['countryID'];
        $g = mysql_query("SELECT inv FROM `uzers` WHERE countryID = '$bc'");
        $gg = mysql_fetch_array($g);
        if ($gg['inv']!=2){
        mysql_query("UPDATE `uzers` SET inv = 1 WHERE countryID = '$bc'");
        //Удаляем сообщения заигноренного из чата
        mysql_query("DELETE FROM `guestbook2` WHERE countryID = '$bc'");

        $key=_PREFIKS.':id'.$bc;
        if (($mem=$memcache->get($key))!==FALSE){
           $mem['inv'] = 1;
           $memcache->set($key,$mem,false,86400);
           }

        if (mysql_affected_rows()!=0)printrus("<br/>$bvl в игноре!<br/>\n");
        else printrus("Ошибка!<br/>\n");
        }else printrus("Модера нельзя отправить в игнор!<br/>\n");

        }

if (!isset($vl)){
echo "<br/>\n";
$r = mysql_query("SELECT count(*) as num FROM guestbook2");
$a = mysql_fetch_array($r);
$num = $a['num'];
$p_q = ($num+9)/10;
$pn = round(($pg+10)/10);
if ($num>0) printrus ("<u>Стр. $pn</u><br/>");

echo "----<br/>";
//Выводим сообщения
$r = mysql_query("SELECT countryID,tocountryID,nick,message,date,inv FROM guestbook2 WHERE ((inv != 1)or(nick = '".$b['countryName']."'))and(tocountryID='".$b['countryID']."' or tocountryID='' or countryID = '".$b['countryID']."')   ORDER BY id desc LIMIT $pg,10");
echo " ".mysql_error()." ";
while (($a=mysql_fetch_array($r))!==FALSE){
        $name = stripslashes($a['nick']);
        $message = $a['message'];
        $date = $a['date'];
        if ($a['tocountryID']!='') print "<b>(P!)</b>";
        if ($b['inv']!=2) if ($a['inv']!=2)printrus ("$date&gt;$name:");
                                 else printrus ("$date&gt;<u>$name</u>:");
        else {
              $nu = iconv('cp1251','utf-8',$name);
              print ("<a href=\"chat2.php?$ses&amp;bvl=$nu\">+</a>\n");
              if ($a['inv']!=2)printrus ("$date&gt;$name:");
              else printrus ("$date&gt;<u>$name</u>:");
                }
         print "<a href=\"chat2.php?$ses&amp;vl=".$a['countryID']."\">&gt;</a><br />\n";
        $nu = iconv('cp1251','utf-8',$name);
        printrus ("$message<br/>");
        echo "----<br/>";
        }
printrus ("<form name=\"\" action=\"chat2.php?$ses\" method=\"post\">
<input type=\"submit\" value=\"Перейти\"/>
к <input name=\"pg\" maxlength=\"4\" format=\"*N\" value=\"$pn\" title=\"Page\"/>стр. (из $p_q)<br/>
</form>\n");

$pg = $pn + 1;
echo "<a href=\"chat2.php?pg=$pg&amp;$ses\">&gt;&gt;&gt;</a>";
}else{

        }

//echo "<br/>-------<br/>\n";
//printrus ("<a href=\"chat.php?$ses\">Чат</a><br/>\n");
//printrus ("<a href=\"game.php?$ses\">В игру</a><br/>\n");
//футер страницы:
include_once("other_inc/footer.php");
?>