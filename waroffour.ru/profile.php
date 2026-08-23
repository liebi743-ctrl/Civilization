<?
$ps = strpos($_SERVER[HTTP_HOST], 'pumpit');

foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];
if (isset($_REQUEST['sawform'])) $sawform = $_REQUEST['sawform'];
if (isset($_REQUEST['username'])) $username = $_REQUEST['username'];
if (isset($_REQUEST['password'])) $password = $_REQUEST['password'];
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['hour'])) $hour = $_REQUEST['hour'];
if (isset($hour)&&!is_numeric($hour)) $hour=25;
if (isset($_REQUEST['newcountryName'])) $newcountryName = $_REQUEST['newcountryName'];
if (isset($newcountryName)){
$newcountryName = trim($newcountryName);
$newcountryName = ereg_replace(" +"," ",$newcountryName);
$newCN=iconv('utf-8','cp1251',$newcountryName);
}
if (isset($_REQUEST['newpassword'])) $newpassword = $_REQUEST['newpassword'];
if (isset($_REQUEST['newpasswordagain'])) $newpasswordagain = $_REQUEST['newpasswordagain'];
if (isset($_REQUEST['oldpassword'])) $oldpassword = $_REQUEST['oldpassword'];
if (isset($_REQUEST['newemail'])) $newemail = $_REQUEST['newemail'];
if (isset($_REQUEST['ras'])) $ras = $_REQUEST['ras'];
if (isset($ras)&&!is_numeric($ras)) $ras=1;
if (isset($ras)&&$ras<0) $ras=1;
if (!isset($ras)) $ras=1;
if (isset($_REQUEST['clas'])) $clas = $_REQUEST['clas'];
if (isset($clas)&&!is_numeric($clas)) $clas=1;
if (isset($clas)&&$class<0) $clas=1;
if (!isset($clas)) $clas=1;
//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
@include_once("other_inc/header.php");
//if(time()-3000>$regtime && $meil=='') printrus ("<a href=\"profile.php?$ses&amp;m=ch_email\" class=\"green\"><span>Установи E-mail - сохрани персонажа!</span></a><br/><br/>");
 $profline="<u>Профиль</u>\r\n";

//==============================================================================
//рабочая часть скрипта=========================================================

//******************************************************************************
//авторизация*******************************************************************

 if(isset($_SESSION['auth'])||isset($_SESSION['auth2'])){
  $r = mysql_query("SELECT * FROM uzers WHERE countryID = '".$_SESSION['countryID']."'");
  $a = mysql_fetch_array($r);
  $username = $a['username'];
  $create=$a['useit'];
  $email = $a['Email']; //email игрока
      if(isset($_SESSION['mr_uid']) || $_SERVER[HTTP_HOST] == 'imperia.mgates.ru'){}else
  {
  if($email=='' && $_SERVER['SCRIPT_NAME']!='/profil.php')

	if ($pumpit == 0){
  printrus ("<a href=\"profile.php?$ses&amp;m=ch_email\" class=\"green\"><span>Сохранить персонажа!</span></a><br/>");
  }

 }
//  printrus ("<b>[</b>".$username."<b>]</b><br/>\r\n");
  $countryID = $_SESSION['countryID'];
  $query="SELECT * FROM countries WHERE countryID='$countryID' LIMIT 1";
  $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $countryName=@MYSQL_RESULT($result,0,"countryName");
  $countrys=$result[0];
  //$query="select `noob` from `uzers` where countryID='$countryID' limit 1";
  //$result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
  $noob=$a['noob'];

//******************************************************************************
//создаем страну****************************************************************

  if($m=="cr_country"){
   //если надо создать страну
   //проверяем, а нет ли у юзера страны уже:
   $query="SELECT * FROM countries WHERE countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $CountryCount=@MYSQL_NUM_ROWS($result);
   $dteu=mysql_fetch_array($result);
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если страна еще жива, то посылаем дибила нахер:)
   if($CountryCount>0 and $dteu['status'] != 0){
    printrus ("<u>У вас уже есть страна!</u><br/>\r\n");
    printrus
("
<a href='profile.php?$ses'>Назад</a>
<br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//а если нет, то создаем страну:::::::::::::::::::::::::::::::::::::::::::::::::
   }elseif(empty($newcountryName) and $dteu['status'] == 0){

   printrus ("Название страны:<br/>
<form name=\"\" action=\"profile.php?$ses&amp;m=cr_country\" method=\"post\">
<input type='text' name='newcountryName' value=''/><br/>
Раса:<br /><select name=\"ras\">
      <option value=\"1\">Демоны</option>
      <option value=\"2\">Люди</option>
      <option value=\"3\">Нежить</option>
      <option value=\"4\">Гномы</option>
      </select><br />
      Класс:<br /><select name=\"clas\">
      <option value=\"1\">Воин</option>
      <option value=\"2\">Торговец</option>
      <option value=\"3\">Странник</option>
      <option value=\"4\">Ремесленник</option>
      <option value=\"5\">Вор</option>
      <option value=\"6\">Дипломат</option>
      <option value=\"7\">Адмирал</option>
      <option value=\"8\">Разбойник</option>
      </select><br />
<input type=\"submit\" value=\"Создать\"/>
</form><br/>
");
    printrus
("
<a href='profile.php?$ses'>Назад</a>
<br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//а нет ли такой страны уже в игре?:::::::::::::::::::::::::::::::::::::::::::::
   }elseif(ThereIsSuchCountryAlready(iconv('utf-8','cp1251',$newcountryName)) && trim($newCN)!=trim($countryName)){
    printrus ("<u>Страна с таким именем уже зарегистрирована в игре (либо есть в сохранениях)!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=cr_country\">Назад</a><br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//если в имени страны есть недопустимые символы:
   }elseif(!cnameisok($newcountryName)){
    printrus ("<u>В названии страны использованы недопустимые символы!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=cr_country\">Назад</a><br/>
");
   }elseif(!cnameisok(chs($newcountryName))){
    printrus ("<u>В названии страны использованы недопустимые символы!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=cr_country\">Назад</a><br/>
");
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//проверяем длину названия страны:::::::::::::::::::::::::::::::::::::::::::::::
   }elseif(!VARLEN_isOK(iconv('utf-8','cp1251',$newcountryName))){
    printrus ("<u>Название страны слишком длинное!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=cr_country\">Назад</a><br/>");
   }elseif($ras<1 or $ras>4){   printrus ("<u>Вы не выбрали расу!</u><br/>\r\n");
   printrus("<a href=\"profile.php?$ses&amp;m=cr_country\">Назад</a><br/>");
   }elseif($clas<1 or $clas>8){   printrus ("<u>Вы не выбрали класс!</u><br/>\r\n");
   printrus("<a href=\"profile.php?$ses&amp;m=cr_country\">Назад</a><br/>");
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Если с именем все нормально, то регаем страну:::::::::::::::::::::::::::::::::
   }else{

    createCountry($countryID,iconv('utf-8','cp1251',$newcountryName),$ras);

    $countryID = $_SESSION['countryID']; //Т.к. зарегили новую страну, то ИД поменялся
    printrus ("<u>Новая страна успешно зарегистрирована!</u><br/>\r\n");
    //unset($_SESSION['auth2']);
    //$_SESSION['auth']=1;
    //session_destroy();
    //authorize($username,$password);
    $tm = time();
    mysql_query("UPDATE `uzers` SET useit='0', race='$ras', class='$clas' WHERE username = '".$username."' LIMIT 1");

    printrus
("
Вход в игру!
<br/>
");

    printrus
("
<a href='game.php?$ses'>Ок</a>
<br/>
");
   }

//******************************************************************************
//Меняем пароль юзера***********************************************************

  }elseif($m=="ch_password" AND $pumpit == 0){

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//показываем форму для ввода пароля:::::::::::::::::::::::::::::::::::::::::::::
   if(empty($newpassword) || empty($newpasswordagain)){
    printrus
("<form name=\"\" action=\"profile.php?$ses&amp;m=ch_password\" method=\"post\">
Старый пароль:<br/>
<input type='text' name='oldpassword' value=''/><br/>
Новый пароль:<br/>
<input type='text' name='newpassword' value=''/><br/>
Подтверждение:<br/>
<input type='text' name='newpasswordagain' value=''/><br/>
<input type=\"submit\" value=\"Ok\"/></form><br/>
");
    printrus(
"
<a href='profile.php?$ses'>Назад</a>
<br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//проверяем их на соответствие::::::::::::::::::::::::::::::::::::::::::::::::::
   }elseif($newpassword != $newpasswordagain){
    printrus ("<u>Пароли должны совпадать!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=ch_password\">Назад</a><br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//проверяем пароль на наличие спец символов:::::::::::::::::::::::::::::::::::::
   }elseif(!VALUE_isOK($newpassword)){
    printrus ("<u>В пароле использованы недопустимые символы!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=ch_password\">Назад</a><br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//проверяем длину пароля(короткость)::::::::::::::::::::::::::::::::::::::::::::
   }elseif(!PASSLEN_isOK($newpassword)){
    printrus ("<u>Пароль слишком короткий (минимум 4 символа)!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=ch_password\">Назад</a><br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//проверяем длину пароля(длинность):::::::::::::::::::::::::::::::::::::::::::::
   }elseif(!VARLEN_isOK($newpassword)){
    printrus ("<u>Пароль слишком длинный! (максимум 25 символов)</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=ch_password\">Назад</a><br/>
");

   }
//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//2013:  Проверяем, чтобы старый пароль совпадал с введенным.
   elseif(!checkPassword($oldpassword)){
    printrus ("<u>Старый пароль введён неверно!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?$ses&amp;m=ch_password\">Назад</a><br/>
");

   }

 //::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Пароль успешно заменен!:::::::::::::::::::::::::::::::::::::::::::::::::::::::
   else{
    changePassword($countryID,$newpassword);
    $password=$newpassword;
    printrus ("<u>Пароль успешно заменен!</u><br/>\r\n");
    printrus
("
<a href='profile.php?$ses'>Назад</a>
<br/>
");
   } //Меняем имя
  }elseif($m=="ch_name"){


        if(empty($_REQUEST[name])) {
           printrus
		("Сейчас:[".$a[imya]."]<br />
		Как Вас зовут?:<br/>
		<form name=\"\" action=\"profile.php?m=ch_name&amp;$ses\" method=\"post\">
		<input type='text' name='name' value=''/><br/>
		<input type=\"submit\" value=\"Ok\"/>
		</form><br/>
		");
		    printrus
		("
		<a href='profile.php?$ses'>Назад</a>
		<br/>
		");
        }elseif(!cnameisok($_REQUEST[name])){
        printrus("В имени использованы недопустимые символы.<br />");
        }else{
        printrus("Имя изменено.<br />");
        mysql_query("UPDATE `uzers` SET imya='".iconv('utf-8','cp1251',$_REQUEST[name])."' WHERE countryID = '".$_SESSION['countryID']."'");
        }









    // О себе
   }elseif($m=="ch_self"){
         if(empty($_REQUEST[self])) {
           printrus
		("Сейчас:[".$a[about]."]<br />
		О себе:<br/>
		<form name=\"\" action=\"profile.php?m=ch_self&amp;$ses\" method=\"post\">
		<input type='text' name='self' value=''/><br/>
		<input type=\"submit\" value=\"Ok\"/>
		</form><br/>
		");
		    printrus
		("
		<a href='profile.php?$ses'>Назад</a>
		<br/>
		");
        }elseif(!cselfisok($_REQUEST['self'])){
        printrus("В тексте использованы недопустимые символы.<br />");
        }else{
        printrus("Информация изменена.<br />");
        mysql_query("UPDATE `uzers` SET about='".iconv('utf-8','cp1251',$_REQUEST['self'])."' WHERE countryID = '".$_SESSION['countryID']."'");
        }

//******************************************************************************
//Меняем мыло юзера*************************************************************

  }elseif($m=="ch_email"){

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//показываем форму для ввода мыла:::::::::::::::::::::::::::::::::::::::::::::::
   if(empty($newemail)){

    //$query="select * from uzers where countryID='$countryID' limit 1";
    //$result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
    $oldEmail=$a["Email"];

    printrus
("Текущий Email:<br/>
<u><b>$oldEmail</b></u><br/>
Новый Email:<br/>
<form name=\"\" action=\"profile.php?m=ch_email&amp;$ses\" method=\"post\">
<input type='text' name='newemail' value=''/><br/>
<input type=\"submit\" value=\"Ok\"/>
</form><br/>
");
    printrus
("
<a href='profile.php?$ses'>Назад</a>
<br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//проверяем мыло на правильность ввода::::::::::::::::::::::::::::::::::::::::::
   }elseif(!EMAIL_isBAD($newemail)){
    printrus ("<u>Вы ввели неправильный Email адрес!</u><br/>\r\n");
    printrus
("<a href=\"profile.php?m=ch_email&amp;$ses\">Назад</a><br/>
");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//проверяем длину мыла::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//   }elseif(!VARLEN_isOK($newemail)){
//    printrus ("<b>Email слишком длинный! Пожалуйста, используите другой адрес.</b><br/>\r\n");
//    printrus
//("<anchor>Назад
//<go href='profile.php?sawform' method='post'>
//<postfield name='username' value='$username'/>
//<postfield name='password' value='$password'/>
//<postfield name='m' value='ch_email'/>
//</go>
//</anchor><br/>
//");

//::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::
//Пароль успешно заменен!:::::::::::::::::::::::::::::::::::::::::::::::::::::::
   }else{
    changeEmail($countryID,$newemail);
    printrus ("<u>Ваш Email успешно заменен!</u><br/>\r\n");
    printrus
("
<a href='profile.php?$ses'>Назад</a>
<br/>
");
   }

//******************************************************************************
//показываем главную форму управления*******************************************

  }elseif($m=='offhelp'){
   //setValue("countryID='$countryID'","uzers","noob",0);
   mysql_query("UPDATE `uzers` SET noob=0 WHERE countryID = '".$_SESSION['countryID']."'");
   printrus ("<u>Подсказки отключены!</u><br/>\r\n");
   printrus
("
<a href='profile.php?$ses'>Ок</a>
<br/>
");
  }elseif($m=='onhelp'){
   //setValue("countryID='$countryID'","uzers","noob",2);
   mysql_query("UPDATE `uzers` SET noob=2 WHERE countryID = '".$_SESSION['countryID']."'");
   printrus ("<u>Подсказки включены!</u><br/>\r\n");
   printrus
("
<a href='profile.php?$ses'>Ок</a>
<br/>
");
  }elseif($m=='maratory'){
  printrus("<u>Установка ночного моратория</u><br/>\n");
  printrus("Здесь вы указываете час <u>по Москве</u> (в соответствии с часами в игре и в ассамблее), начиная с которого каждый день действует мораторий на 6 часов<br/>\n");

   $r=mysql_query("SELECT maratory,lastMaratory FROM `uzers` WHERE countryID = '$countryID' LIMIT 1");
   $a=mysql_fetch_array($r);
   $mrt = $a['maratory'];
   $lastm = $a['lastMaratory'];

   if ($lastm>time()-86400*3){
      printrus("Мораторий уже задан! Вы сможете изменить его только через ".mkTimeStr(86400*3-time()+$lastm)."<br/>\n");
      }else{
      if (!isset($go)){ //Форма
      printrus
("Начальный час (от 0 до 23, 25 - мораторий отключен):<br/>
<form name=\"\" action=\"profile.php?$ses&amp;m=maratory&amp;go=1\" method=\"post\">
<input format='*N' name='hour' /><br/>
<input type=\"submit\" value=\"Задать\"/>
</form><br/>
");
         }else{
   if (!isset($hour) || ($hour!='0'&&$hour!='1'&&$hour!='2'&&$hour!='3'&&$hour!='4'&&$hour!='5'&&$hour!='6'&&$hour!='7'&&$hour!='8'&&$hour!='9'&&$hour!='10'&&$hour!='11'&&$hour!='12'&&$hour!='13'&&$hour!='14'&&$hour!='15'&&$hour!='16'&&$hour!='17'&&$hour!='18'&&$hour!='19'&&$hour!='20'&&$hour!='21'&&$hour!='22'&&$hour!='23'&&$hour!='25')){
      printrus("Неверно задан час!<br/>\n");
      }else{
      mysql_query("UPDATE `uzers` SET maratory=$hour, lastMaratory = '".time()."' WHERE countryID='$countryID'");
   $key=_PREFIKS.':id'.$countryID;
   if(($mem=$memcache->get($key))!==FALSE){
   $mem['mrt'] = $hour;
   $memcache->set($key,$mem,false,86400);
   }
   printrus("<u>Время Вашего ночного моратория:</u><br/>\n");
   if ($hour!=25){
   $last_hour = ($hour+6)%24-1;
   printrus("С <b>$hour</b> часов 0 минут 0 секунд до <b>$last_hour</b> часов 59 минут 59 секунд<br/>\n");
   printrus("В это время вы не можете начать войну, а также не могут начать войну против вас и применять саботаж, грабеж, воровство и вербовку.<br/>\n");
   }else printrus ("Ваш мораторий отключен!<br/>\r\n");
      }

         }

      }
printrus
("
<a href='profile.php?$ses'>Назад</a>
<br/>
");

  }elseif($m=='resurrect'){

  if (_SHOP!="off"){
  	printrus("Извините, услуги магазина временно недоступны.<br/>\r\n");
/*printrus
("
<a href='game.php?$ses'>&lt;&lt;В игру</a>
<br/>
");*/
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
exit;
  	exit;
  }

  $r = mysql_query("SELECT count(*) as num FROM `countries` WHERE countryID = '$countryID'");
  $a = mysql_fetch_array($r);
  //Проверка, действительно ли у юзера нет страны?
  //if (($a['num']==0) || ($create==1 && $a['num']>0)){
  //if ($a['num']==0 ){

    $query="SELECT * FROM countries WHERE countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $CountryCount=@MYSQL_NUM_ROWS($result);
  $dteu=mysql_fetch_array($result);
  $zzp = mysql_query("SELECT count(*) as num FROM `messages` WHERE countryID = '$countryID' and `from` = 'loose'");
  $aap = mysql_fetch_array($zzp);

  if ($aap['num']>0 and $dteu['status'] == 0){

  $r = mysql_query("SELECT * FROM `saves` WHERE userID = '".$_SESSION['userID']."' LIMIT 1");
  $a = mysql_fetch_array($r);
  $num = mysql_num_rows($r);
  //Проверка, есть ли сохранение
  if ($num>0){
  $r2 = mysql_query("SELECT * FROM `uzers` WHERE userID = '".$_SESSION['userID']."' LIMIT 1");
  $a2 = mysql_fetch_array($r2);
  //Проверка, есть ли на счету необходимая сумма
  if ($a2['credits']>=50){

  $r3=mysql_query("SELECT * FROM `countries_save` WHERE countryID='".$a['countryID']."' LIMIT 1");
  $a3=mysql_fetch_array($r3);

  //Проверка, можно ли восстановить страну (прошло ли необходимое время с момента смерти)
  if (time()-$a['lastDied']>min(10*3600*24,round($a3['reggedTime']/5))){

  if (!isset($go)){
  printrus("В сохранении имеется страна ".$a3['countryName']." с развитием ".mkTimeStr($a3['reggedTime'])."<br/>");
  printrus("Желаете восстановить? <a href=\"profile.php?m=resurrect&amp;go&amp;$ses\">Да</a> или <a href=\"profile.php?$ses\">отмена</a><br/>");
  }else{
  //Восстанавливаем страну
  mysql_query("UPDATE `uzers` SET credits = credits - 50, spent = spent + 50, countryID = '".$a['countryID']."', onlineflag=0, race = '".$a['race']."', class = '".$a['class']."' WHERE userID = '".$_SESSION['userID']."' LIMIT 1");

 $open=fopen("logs/magaz".$countryID,"a+");
 @flock ($open,LOCK_EX);
 @fwrite($open,date("H:i j.m:").$_SESSION['countryName']."восстановил страну. Потратил 50 золота.\r");
 @fflush($open);
 @flock ($open,LOCK_UN);
 @fclose($open);

$query="delete from countries where countryID='".$countryID."'";
mysql_query("DELETE FROM messages WHERE `countryID`='$countryID' AND `from`='loose'");
MYSQL_QUERY($query);
//Сохраняем здания
mysql_query("INSERT INTO `buildings` (SELECT * FROM `buildings_save` WHERE countryID = '".$a['countryID']."')");
//Меняем времена
mysql_query("UPDATE `buildings` SET var1 = ".time()." - var1 WHERE countryID = '".$a['countryID']."' and building = 'neftevxwka' LIMIT 1");
//Сохраняем основные параметры страны:
mysql_query("INSERT INTO `countries` (SELECT * FROM `countries_save` WHERE countryID = '".$a['countryID']."' LIMIT 1)");
//Меняем в сохранении необходимые времена
mysql_query("UPDATE `countries` SET reggedTime = ".(time()-$a3['reggedTime']).", lastNal = ".(time()-$a3['lastNal']).", lastWar = ".(time()-$a3['lastWar'])." WHERE countryID = '".$a['countryID']."' LIMIT 1");
//Сохраняем генерала
mysql_query("INSERT INTO `general` (SELECT * FROM `general_save` WHERE countryID = '".$a['countryID']."' LIMIT 1)");
//Сохраняем работы
mysql_query("INSERT INTO `works` (SELECT * FROM `works_save` WHERE countryID = '".$a['countryID']."')");
//Меняем времена
mysql_query("UPDATE `works` SET started = ".time()." - started, finished = finished + ".time()." WHERE countryID = '".$a['countryID']."'");

//Сохраняем ферму
mysql_query("INSERT INTO `farm` (SELECT * FROM `farm_save` WHERE countryID = '".$a['countryID']."')");
//Меняем времена в ферме
mysql_query("UPDATE `farm` SET time_buy = ".time()." - time_buy, time_kill = time_kill + ".time()." WHERE countryID = '".$a['countryID']."'");

echo mysql_error();


//Получаем соседей:
//С востока
$query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$a['countryID']."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$a['countryID']."'))
   and (reggedTime<".(time()-$a3['reggedTime']).") ORDER BY reggedTime DESC
   LIMIT 2";

   $result=@MYSQL_QUERY($query);
   //$k=0;
   while (($a4=mysql_fetch_array($result))!==FALSE){

    $neigh_=$a4["countryName"];
    $neighbourID=$a4["countryID"];

    setNeighbour($a['countryID'],$neighbourID);
    sendMessage($neighbourID,"newNeighbour",$a3['countryName']);
    sendMessage($a['countryID'],"newNeighbour",$neigh_);
    //$k++;
    //print "|";
   }

//С запада
$query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$a['countryID']."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$a['countryID']."'))
   and (reggedTime>".(time()-$a3['reggedTime']).") ORDER BY reggedTime ASC
   LIMIT 2";
   $result=@MYSQL_QUERY($query);
   //$k=0;
   while (($a4=mysql_fetch_array($result))!==FALSE){

    $neigh_=$a4["countryName"];
    $neighbourID=$a4["countryID"];

    setNeighbour($a['countryID'],$neighbourID);
    sendMessage($neighbourID,"newNeighbour",$a3['countryName']);
    sendMessage($a['countryID'],"newNeighbour",$neigh_);
    //$k++;
    //print "|";
   }

//mysql_query("UPDATE `saves` SET countryID = '$countryID', lastSave = '".time()."' WHERE userID = '".$_SESSION['userID']."' LIMIT 1");
printrus("Страна успешно восстановлена! Залогиньтесь заново и начинайте игру!<br/>");
session_destroy();


  }

  }else{
  printrus("Вы можете восстановить страну только по прошествии ".mkTimeStr(min(10*86400,round($a3['reggedTime']/5)))." с момента смерти.<br/>");
  printrus("Подождите еще ".mkTimeStr(min(10*86400,round($a3['reggedTime']/5))-(time()-$a['lastDied'])).'<br/>');
  }

  }else{
  printrus("У вас недостаточно золота для восстановления страны! Необходимо 50. Пополните счет.<br/>
  -------<br/>
  ");/*
  printrus("Как пополнить ваш лицевой счет:<br/>\r\n");
printrus("Отправить смс с текстом \""._SHOP_PREFIKS." ".$_SESSION['userID']."\" (без кавычек) на номер
"._SERVICE_NUMBER_RUS." для абонентов России, "._SERVICE_NUMBER_KAZ." для абонентов Казахстана и "._SERVICE_NUMBER_UKR." для абонентов Украины.
Другие страны пока не поддерживаются этим способом пополнения. Будьте внимательны при наборе
номера. Стоимость одной смс - "._PRICE." у.е. На ваш счет при этом зачисляется 100 золота. Этот
способ зачисления мгновенный, сразу после отправки смс, вам придет ответная смс и счет пополнится.<br/>
<u>Спамные запросы приведут к удалению страны!</u><br/>
------<br/>
Имейте в виду, что закупиться в магазине можно максимум на 400 золота в день.<br/>");*/
  }
  }else{
  printrus("У вас нет сохранения! Нечего восстанавливать!<br/>");
  }

  }else{
  printrus("У вас уже есть страна! Восстановление невозможно!<br/>");
  }

  }else{
   //Узнаем, чо за страна:
   $query="SELECT * FROM countries WHERE countryID='$countryID' LIMIT 1";
   $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
   $CountryCount=@MYSQL_NUMROWS($result);

   if($CountryCount>0 && $create==0){
    //если страна еще жива, то показываем ее название:
    $countryName=@MYSQL_RESULT($result,0,"countryName");
    printrus ("Страна: <u>$countryName</u><br/>\r\n");
    /*printrus
("<a href=\"profile.php?$ses&amp;m=cnamecountry\">Сменить название страны</a><br/>
");*/
   }else{
    //а если снесли нас, то даем возможност создать еще:
    printrus
("<a href=\"profile.php?$ses&amp;m=cr_country\">Создать страну</a><br/>
");
   $r = mysql_query("SELECT count(*) as num FROM `saves` WHERE userID = '".$_SESSION['userID']."'");
   $a = mysql_fetch_array($r);
   if ($a['num']!=0&&_SHOP=="off")printrus("У вас есть сохранение страны, вы можете <a href=\"profile.php?m=resurrect&amp;$ses\">восстановить</a>
   страну<br/>");
   }
   $key=_PREFIKS.':id'.$countryID;
   if(($mem=$memcache->get($key))!==FALSE){
   $mrt = $mem['mrt'];
   }else{
   $r=mysql_query("SELECT maratory FROM `uzers` WHERE countryID = '$countryID' LIMIT 1");
   $a=mysql_fetch_array($r);
   $mrt = $a['maratory'];
   }

   //if ($mrt==25){   //Если не задан мараторий
   printrus
("<img src=\"/img/ico/help.png\" alt=\".\" /> <a href=\"profile.php?$ses&amp;m=maratory\">Мораторий</a>: ");
//      }else{  //Выводим время маратория
//   printrus("<u>Время Вашего ночного маратория:</u><br/>\n");
   if ($mrt!=25){
   $last_hour = ($mrt+6)%24-1;
   printrus("c <b>$mrt</b>ч.0м.0c. до <b>$last_hour</b>ч.59м.59с.<br/>\n");
   }else printrus("отключен<br/>\r\n");

//      }

if(isset($_SESSION['mr_uid']) || isset($_SESSION['o_uid']) || $_SERVER[HTTP_HOST] == 'imperia.mgates.ru')
{}else{

	if ($pumpit == 0){
		printrus
		("<img src=\"/img/ico/set.png\" alt=\".\" /> <a href=\"profile.php?$ses&amp;m=ch_password\">Изменить пароль</a><br/>
		");}


	}
printrus ("<img src=\"/img/ico/cr3.png\" alt=\"\" /> <a href='bonus.php?$ses'>Купить золото</a><br/>");
if ($_SERVER[HTTP_HOST] == 'imperia.mgates.ru') {}else{
printrus ("<img src=\"/img/ico/message.png\" alt=\".\" /> <a href=\"forum.php?fid=8&amp;$ses\">Поддержка</a><br/>");}
//printrus ("<img src=\"/img/ico/message.png\" alt=\".\" /> <a href=\"testip.php?$ses\">Письмо админу</a><br/>");
printrus
("<img src=\"/img/ico/list.png\" alt=\".\" /> <a href=\"profile.php?$ses&amp;m=ch_name\">Изменить имя</a><br/>
");
printrus
("<img src=\"/img/ico/list.png\" alt=\".\" /> <a href=\"profile.php?$ses&amp;m=ch_self\">О себе</a><br/>
");
if(isset($_SESSION['o_uid']) || $_SERVER[HTTP_HOST] == 'imperia.mgates.ru')
{}else{

	if ($pumpit == 0){
		printrus
		("<img src=\"/img/ico/set.png\" alt=\".\" /> <a href=\"profile.php?$ses&amp;m=ch_email\">Изменить Email</a><br/>
		");}

}
   if($noob>=1){
    printrus
("<img src=\"/img/ico/help.png\" alt=\".\" /> <a href=\"profile.php?$ses&amp;m=offhelp\">Отключить подсказки</a><br/>
");
   }else{
    printrus
("<img src=\"/img/ico/help.png\" alt=\".\" /> <a href=\"profile.php?$ses&amp;m=onhelp\">Включить подсказки</a><br/>
");
    }
if ($_SERVER[HTTP_HOST] == 'imperia.mgates.ru' || isset($_SESSION['o_uid'])) {}else{
    printrus
("<br/><div class=\"a\"><div class=\"dot\">
<b>Рекомендовать в Социальных Сетях!</b><br/><a href=\"http://share.yandex.ru/go.xml?service=vkontakte&amp;url=http%3A%2F%2F$_SERVER[HTTP_HOST]&amp;title=Онлайн Игра Войны Четырех\"><img src=\"img/ico/vk.png\" alt=\"vk\" /></a>
<a href=\"http://share.yandex.ru/go.xml?service=facebook&amp;url=http%3A%2F%2F$_SERVER[HTTP_HOST]&amp;title=Онлайн Игра Войны Четырех\"><img src=\"img/ico/fb.png\" alt=\"fb\" /></a>
<a href=\"http://share.yandex.ru/go.xml?service=twitter&amp;url=http%3A%2F%2F$_SERVER[HTTP_HOST]&amp;title=Онлайн Игра Войны Четырех\"><img src=\"img/ico/tw.png\" alt=\"tw\" /></a>
<a href=\"http://share.yandex.ru/go.xml?service=odnoklassniki&amp;url=http%3A%2F%2F$_SERVER[HTTP_HOST]&amp;title=Онлайн Игра Войны Четырех\"><img src=\"img/ico/od.png\" alt=\"od\" /></a>
<a href=\"http://share.yandex.ru/go.xml?service=moimir&amp;url=http%3A%2F%2F$_SERVER[HTTP_HOST]&amp;title=Онлайн Игра Войны Четырех\"><img src=\"img/ico/mr.png\" alt=\"mr\" /></a>
<a href=\"http://share.yandex.ru/go.xml?service=lj&amp;url=http%3A%2F%2F$_SERVER[HTTP_HOST]&amp;title=Онлайн Игра Войны Четырех\"><img src=\"img/ico/lg.png\" alt=\"lg\" /></a>
</div></div>
");}
if(isset($_SESSION['mr_uid']) || isset($_SESSION['o_uid']) || $_SERVER[HTTP_HOST] == 'imperia.mgates.ru')
{}else{
if ($pumpit == 0){
printrus ("<br/><a href='unlogin.php?$ses'>Выйти</a><br/>");
}

}
if (isset($_SESSION['auth'])){
/*printrus
("
<a href='game.php?$ses'>Главная</a>
<br/>
");*/
}else printrus("<u>Вы не можете играть, т.к. у вас нет страны! Создайте страну!!!</u><br/>");

  }

//  print "---<br/>\r\n";
  if($CountryCount>0){}
   /*printrus
("
<a href='game.php?$ses'>В игру&gt;&gt;</a>
<br/>
");*/

 }else{
	if ($_SERVER[HTTP_HOST] == 'imperia.mgates.ru')
	{
		setcookie('PHPSESSID', '');
		header('Location: http://spaces.ru/app/?sid=&enter=48');
		die();
	}


  printrus ("<u>ВЫ НЕ АВТОРИЗОВАНЫ!</u><br/>\r\n");
printrus ("<a href='index.php?$ses'>Главная</a><br/>");
 }

//printrus ("<a href='unlogin.php?$ses'>Выйти</a><br/>");
//ботинки:
include_once("other_inc/footer.php");

?>
