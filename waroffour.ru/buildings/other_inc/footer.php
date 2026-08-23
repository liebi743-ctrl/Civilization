<?
global $memcache;
//
if (isset($_SESSION['auth'])){
printrus('<div class="event">');
printrus ("<hr/>");
// выводим чат
printrus ("<ul class=\"nav\"><li><a href='/chat.php?$ses'><img src=\"/img/ico/chat.png\" class=\"menu\" alt=\"\" />Чат</a></li></ul>");
if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' ) {}else{
printrus ("<ul class=\"nav\"><li><a href='/forum.php?$ses'><img src=\"/img/ico/chat.png\" class=\"menu\" alt=\"\" />Форум</a></li></ul>");
}

$countryID=$_SESSION['countryID'];
//
$key=_PREFIKS.':clans'.$countryID;
$memcache->delete($key);
//if (($mem=$memcache->get($key))!==FALSE){
//   $clanID=$mem;
//   }

   $testclan = mysql_query("SELECT clanID FROM `uzers` where userID = '".$_SESSION['userID']."' LIMIT 1");
   $test2clanID = mysql_fetch_array($testclan);
   $clanID=$test2clanID['clanID'];
   /*$newt=CountryInfo($countryID);
// printrus("<ul class=\"nav\"><li><a href='http://"._MAINSITE."/profile.php?$ses'><img src=\"/img/ico/town.png\" height=\"20\" width=\"20\" class=\"menu\" alt=\"\"/>Моя страна</a></li></ul>");
if ($clanID==0 && $newt['land']>=70000 && $newt['spy']>=69 && $newt['sabotage']>=69 && $newt['grabber']>=69 && $newt['verb']>=69){
   //Новый клан
   $r = mysql_query("SELECT max(clanID) as num FROM `uzers`");
   $a = mysql_fetch_array($r);
   if($a['num']=='')$a['num']=0;
   $newc = $a['num']+1;
   mysql_query("DELETE FROM `guestbook_clans` WHERE clanid='$newc'");
   $img = "../clans/$newc.gif";
   $img2 = "../clans/$newc.jpg";
   unlink($img);
   unlink($img2);
   mysql_query("UPDATE `uzers` SET clanID='$newc' WHERE userID = '".$_SESSION['userID']."' LIMIT 1");
$key=_PREFIKS.':clans'.$countryID;
if (($mem=$memcache->get($key))!==FALSE){
   $mem = $newc;
   $memcache->set($key,$mem,false,86400);
   }
   $clanID = $newc;
   }
    */
//Клан
if ($clanID==0){
   printrus
("<br/>");}
if ($clanID!=0){
   printrus
("<ul class=\"nav\"><li>
<a href='http://"._MAINSITE."/clan.php?$ses'><img src=\"/img/ico/uzers.png\" class=\"menu\" alt=\"\" />Клан</a>
</li></ul><br/>
");
   }
//
printrus("<ul class=\"nav\"><li><a href='/profile.php?$ses'><img src=\"/img/ico/town.png\" class=\"menu\" alt=\"\" />Моя страна</a></li></ul>");
printrus("<ul class=\"nav\"><li><a href=\"/game.php?$ses\"><img src=\"/img/ico/point.png\" class=\"menu\" alt=\"\" />Главная</a></li></ul>");

if ($b['inv']==2 && $_SERVER['SCRIPT_NAME']=='/game.php'){
   printrus ("<img src=\"/img/ico/moder.png\" alt=\".\" /> <a href='mpan.php?$ses' class='green'><span>Модер-панель</span></a><br/>");
   }
}
//
printrus('</div>');
if (isset($_SESSION['auth'])){
printrus('</div>');}
//
if (isset($_SESSION['auth'])){
//printrus('<div class="block small event">');
// выводим данные по стране
$key1=_PREFIKS.':id'.$countryID;
if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

if ($id_m==TRUE){
$b=$ma;
}else{
$query="select * from `countries` where countryID='".$_SESSION['countryID']."' limit 1";
$result=@MYSQL_QUERY($query);
$b = mysql_fetch_array($result);
}}

$gtime = round(getmicrotime() - $headtime,4);
printrus('
<div style="text-align:center;" class="pt small minor">');
//Возраст страны
$timecnt=time()-$b['reggedTime'];
if ($_SERVER['SCRIPT_NAME']=='/game.php'){
printrus("<span class=\"low\">Возраст страны: ".mkTimeStr($timecnt)."</span><br/>");
}
//группа
//
if(isset($_SESSION['o_uid'])){
printrus("<a href=\"http://m.odnoklassniki.ru/group/51864812912874\">Официальная группа</a> игры<br/>");
}
//
if ($_SERVER['SCRIPT_NAME']=='/game.php'){
printrus("<br/><a href=\"faq.php?m=ratusha&amp;n=helper&amp;$ses\" class=\"admin\"><span>Новичку! Как играть?</span></a><br/>");
}
// ссылки в футере

if ($_SERVER['SCRIPT_NAME']=='/rules.php') {printrus ("<a href='dell.php?$ses' class=\"footer\"><span>Удаления</span></a> | ");}
if (isset($_SESSION['auth'])){
printrus("<a href=\"faq.php?$ses\" class=\"admin\"><span>Помощь</span></a> | <a href=\"rules.php?$ses\" class=\"footer\"><span>Правила</span></a>");
if ($ps != '' || $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' || $_SERVER[HTTP_HOST] == 'm.imperia.mail.ru' || isset($_SESSION['o_uid'])){
printrus('<img width="1" height="1" src="http://c.waplog.net/460965.cnt" alt="" />');}
printrus('<br/>');
}
else{printrus("<a href=\"howtoplay.php\" class=\"admin\"><span>Помощь</span></a> | <a href=\"rules.php?$ses\" class=\"footer\"><span>Правила</span></a>");
if ($ps != '' || $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' || $_SERVER[HTTP_HOST] == 'm.imperia.mail.ru' || isset($_SESSION['o_uid'])){
printrus('<img width="1" height="1" src="http://c.waplog.net/460965.cnt" alt="" />');}
printrus('<br/>');
}
printrus(''.$gtime.' сек, '.date("H:i:s").'<br/><br/>');

if ($_SERVER[HTTP_HOST] == 'imperia.mgates.ru' ) {}else {
printrus('&#169; <a href="http://'.$_SERVER["HTTP_HOST"].'" class="footer"><span>'.$_SERVER["HTTP_HOST"].'</span></a>, '.date("Y").'<br/>');}

printrus('Онлайн игра Империя<br/>');

if (isset($_SESSION['site'])){
printrus('<a href="http://'.$_SESSION["site"].'" class="footer"><span>'.$_SESSION['site'].'</span></a><br/>');}
if(isset($_SESSION['mr_uid']) || $_SERVER["HTTP_HOST"]=='imperia.wapos.ru')
{}else{if(isset($_SESSION['o_uid']))
{printrus('<a href="http://odkl.vportale.ru" class="footer"><span>Другие игры</span></a><br/>');}
else {if ( $_SERVER[HTTP_HOST] == 'imperia.mgates.ru' ) {printrus('<a href="http://my.mgates.spaces.ru?sid=' . $_SESSION['sid_value'] . '" class="footer"><span>Другие игры</span></a><br/>');} else {

if ($ps == 0)
printrus('<a href="http://vportale.ru" class="footer"><span>Другие игры</span></a><br/>');

}}}

if(isset($_SESSION['s_uid'])){printrus('</div>');}else{

	if ($ps == '' and !isset($_SESSION['o_uid'])){
		printrus('<a href="http://waplog.net/c.shtml?460965"><img src="http://c.waplog.net/460965.cnt" alt="waplog" /></a> <script type="text/javascript" src="http://mobtop.ru/c/41141.js"></script><noscript><a href="http://mobtop.ru/in/41141"><img src="http://mobtop.ru/41141.gif" alt=""/></a></noscript><br/><br/>');
	}

	print '</div>';
}
// Mail.ru output
//global $mail_ru_mode;
//if($mail_ru_mode)
if(isset($_SESSION['mr_uid']))
{
    //global $mail_ru_data;
    //echo $mail_ru_data['footer'];
printrus('<div class="footer">
	<p><a href="http://tel.my.mail.ru/cgi-bin/logout">Выход</a></p>
	<form action="http://tel.my.mail.ru/my/redir" method="post">
		<p>
			<select name="project">
				<option value="1" selected="selected">Mail.Ru</option>
				<option value="2">Почта</option>
				<option value="3">Новости</option>
				<option value="4">Знакомства</option>
				<option value="5">Афиша</option>
				<option value="6">Игры</option>
				<option value="7">Погода</option>
				<option value="8">Гороскопы</option>
				<option value="9">Курсы валют</option>
			</select>
			<input type="submit" value="Перейти" />
		</p>
	</form>
	<p>Мобильная версия&nbsp;| <a href="http://my.mail.ru/cgi-bin/my/redir?type">Полная</a><br />
	&copy;&nbsp;Mail.Ru, 1999-2011</p></div>');
}
// END Mail.ru output
if(isset($_SESSION['o_uid']))
{
    //global $soc_seti_add_data;
    //echo $soc_seti_add_data['footer'];
    printrus('<div style="font-family:arial,helvetica,sans-serif;">
 <div style="background-color:#f93;">
  <a href="http://m.odnoklassniki.ru" style="display:block;font-size:medium;padding:.4em .3em .6em;color:#fff;">Моя страница</a>
 </div>
 <div style="padding:1em 0;background-color:#fff;color:#777E5D;text-align:center;font-size:medium;">
  <nobr>© 2006–2011</nobr> Одноклассники
 </div> </div>');
}
// END Odnoklasniki output


// Mgates output:
if (  ($_SERVER[HTTP_HOST] == 'imperia.mgates.ru')  OR  ($_GET['qtest'] == 1) )
{
print($mgates_data[footer]);
}


if ($ps <> 0)
{
print $_SESSION['pumpit_footer'];
}

?>