<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['country1'])) $country1 = $_REQUEST['country1'];
if (isset($_REQUEST['country2'])) $country2 = $_REQUEST['country2'];
if (isset($_REQUEST['t1'])) $t1 = $_REQUEST['t1'];
if (isset($_REQUEST['t2'])) $t2 = $_REQUEST['t2'];
if (isset($_REQUEST['pg'])) $pg = $_REQUEST['pg'];
if (isset($pg)&&!is_numeric($pg)) $pg=0;
if (isset($_REQUEST['okr'])) $m ='okr';
if (isset($_REQUEST['view'])) $m ='view';
//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");

function check($str,$hsc=1){   //Проверка на спецсимволы
$str=strtr($str,array(chr("0")=>"",chr("1")=>"",chr("2")=>"",chr("3")=>"",chr("4")=>"",chr("5")=>"",chr("6")=>"",chr("7")=>"",chr("8")=>"",chr("9")=>"",chr("10")=>"",chr("11")=>"",chr("12")=>"",chr("13")=>"",chr("14")=>"",chr("15")=>"",chr("16")=>"",chr("17")=>"",chr("18")=>"",chr("19")=>"",chr("20")=>"",chr("21")=>"",chr("22")=>"",chr("23")=>"",chr("24")=>"",chr("25")=>"",chr("26")=>"",chr("27")=>"",chr("28")=>"",chr("29")=>"",chr("30")=>"",chr("31")=>"","Р?"=>"И","вЂ¦"=>" ","вЂ©-"=>" ","вЂњ"=>" ","вЂќ"=>" ","вЂ©"=>" ","вЂ“"=>"-","\n"=>" ","$"=>"$$"));
if($hsc==1)$str = HtmlSpecialChars($str);
$str = ereg_replace(" +"," ",$str);
//$str = ereg_replace("$","$$",$str);
$str = trim($str);
return $str;
}

mem_connect();
sesinit();
//шапка:
include_once("other_inc/header.php");
$countryID=$_SESSION['countryID'];

$key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE;
 else $id_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }


//******************************************************************************
//проверка на валидность идентификатора:****************************************

 if(isset($_SESSION['auth'])){
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
//  printrus ("<u>[".$b['countryName']."]</u><br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 printrus("КАРТА МИРА:<br/>\n");

 switch($m):

 //Смотрим в 1 раз
 default:
printrus("<a href=\"map.php?m=how&amp;$ses\">Как это работает?</a><br/>");

printrus("<br /><a href=\"map.php?m=z&amp;$ses\">На запад</a> - <a href=\"map.php?m=v&amp;$ses\">На восток</a><br/>");
printrus ("<form name=\"\" action=\"map.php?$ses\" method=\"post\">
Страна 1:<br/>
<input type='text' name='country1' value='' /><br/>
<input name=\"t1\" type=\"checkbox\" value=\"1\"/>Транслитеровать><br/>\n

Страна 2:<br/>
<input type='text' name='country2' value='' /><br/>
<input name=\"t2\" type=\"checkbox\" value=\"1\"/>Транслитеровать><br/>\n
<input  name=\"view\" type=\"submit\" value=\"Пошёл\"/><br />

<input  name=\"okr\" type=\"submit\" value=\"Окрестности страны1\"/>

</form>
");

  break;

  case('view'):
  $country1 = check($country1);
  $country2 = check($country2);

  if (isset($country1)) {
          if($t1=='1') $country1 = translit($country1);
          $country1 = iconv('utf-8','cp1251',$country1);
  }
  if (isset($country2)) {
          if($t2=='1') $country2 = translit($country2);
          $country2 = iconv('utf-8','cp1251',$country2);
  }

  if (!isset($country1) || !isset($country2) || $country1 == '' || $country2 == ''){
  printrus ("Вы должны ввести названия обеих стран!<br/>\n");
  printrus ("<a href='map.php?$ses'>&lt;назад</a><br/>\r\n");
  }elseif(($a = mysql_fetch_array(mysql_query("SELECT * FROM `countries` WHERE countryName = '$country1' LIMIT 1")))===FALSE){
          printrus ("Страны с названием $country1 нет на карте мира!<br/>\n");
          printrus ("<a href='map.php?$ses'>&lt;назад</a><br/>\r\n");
  }elseif(($b = mysql_fetch_array(mysql_query("SELECT * FROM `countries` WHERE countryName = '$country2' LIMIT 1")))===FALSE){
          printrus ("Страны с названием $country2 нет на карте мира!<br/>\n");
          printrus ("<a href='map.php?$ses'>&lt;назад</a><br/>\r\n");
  }elseif(neighbour_exists($a['countryID'],$b['countryID'])){
          printrus ("Эти страны являются соседями!<br/>\n");
          printrus ("<a href='map.php?$ses'>еще...</a><br/>\r\n");
  }else{
  if ($a['reggedTime']>$b['reggedTime'])
  $query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)and(countries.reggedTime>'".$b['reggedTime']."')and(countries.reggedTime<'".$a['reggedTime']."')";
  else $query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)and(countries.reggedTime>'".$a['reggedTime']."')and(countries.reggedTime<'".$b['reggedTime']."')";
  $result = mysql_query($query);
  //echo mysql_error();
  $c = mysql_fetch_array($result);
  if ($a['reggedTime']>$b['reggedTime']) printrus("Страна ".$a['countryName']." лежит через <b>".$c['num']."</b> государств к востоку от страны ".$b['countryName']."<br/>\n");
  else printrus("Страна ".$a['countryName']." лежит через <b>".$c['num']."</b> государств к западу от страны ".$b['countryName']."<br/>\n");
  //printrus("Между страной ".$a['countryName']." и страной ".$b['countryName']." лежит <b>".$c['num']."</b> государств!<br/>\n");
  printrus ("<a href='map.php?$ses'>еще...</a><br/>\r\n");
  }

  break;

  case('how'):
  printrus("Данная карта позволяет Вам определить, сколько стран лежит между двумя заданными государствами. Узнайте, как далеко вы находитесь от воротил Империи. Число примерное, т.к. страна1 может соседствовать со страной, соседней со страной2<br/>
  Можно также посмотреть окрестности страны1 - в первом поле вводите название интересующей Вас страны, и далее можно просматривать все страны к западу или востоку от нее по порядку.<br/>\n");
  printrus("
  <b>Правила транслита</b><br/>
а(А)-a(A)<br/>
б(Б)-b(B)<br/>
в(В)-v(V)<br/>
г(Г)-g(G)<br/>
д(Д)-d(D)<br/>
е(Е)-e(E)<br/>
ё(Ё)-q(Q)<br/>
ж(Ж)-j(J)<br/>
з(З)-z(Z)<br/>
и(И)-i(I)<br/>
й(Й)-y(Y)<br/>
к(К)-k(K)<br/>
л(Л)-l(L)<br/>
м(М)-m(M)<br/>
н(Н)-n(N)<br/>
о(О)-o(O)<br/>
п(П)-p(P)<br/>
р(Р)-r(R)<br/>
с(С)-s(S)<br/>
т(Т)-t(T)<br/>
у(У)-u(U)<br/>
ф(Ф)-f(F)<br/>
х(Х)-h(H)<br/>
ц(Ц)-c(C)<br/>
ч(Ч)-ch(CH)<br/>
ш(Ш)-w(W)<br/>
щ(Щ)-sc(SC)<br/>
ъ(Ъ)-\"(\"\")<br/>
ы(Ы)-x(X)<br/>
ь(Ь)-'('')<br/>
э(Э)-ye(YE)<br/>
ю(Ю)-yu(YU)<br/>
я(Я)-ya(YA)<br/>
  ");
  printrus ("<a href='map.php?$ses'>&lt;назад</a><br/>\r\n");
  break;

  case('okr'):
  $country1 = check($country1);
  //$country2 = check($country2);

  if (isset($country1)) {
          if($t1=='1') $country1 = translit($country1);
          $country1 = iconv('utf-8','cp1251',$country1);
  }

  if ((!isset($country1) || $country1 == '')&&!isset($pg)){
  printrus ("Вы должны ввести название первой страны!<br/>\n");
  printrus ("<a href='map.php?$ses'>&lt;назад</a><br/>\r\n");
  }elseif(($a = mysql_fetch_array(mysql_query("SELECT * FROM `countries` WHERE countryName = '$country1' LIMIT 1")))===FALSE&&!isset($pg)){
          printrus ("Страны с названием $country1 нет на карте мира!<br/>\n");
          printrus ("<a href='map.php?$ses'>&lt;назад</a><br/>\r\n");
  }else{
  if (!isset($pg)){
  //Высчитываем, сколько стран перед заданной страной
  $query="SELECT count(*) as num FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)and(countries.reggedTime<'".$a['reggedTime']."')";
  $result = mysql_query($query);
  echo mysql_error();
  $c = mysql_fetch_array($result);
  $num = $c['num'];
  $pg = $num-5;
  }
  if ($pg<0)$pg=0;

  $query="SELECT countryName FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL) order by reggedTime asc LIMIT ".$pg.",10";
  $r = mysql_query($query);
  echo mysql_error();
  $npg = $pg-9;
  if ($pg>0) printrus ("<a href='map.php?m=okr&amp;pg=$npg&amp;$ses'>&lt;&lt;запад</a> ");
  while(($a2=mysql_fetch_array($r))!==FALSE){
  if ($a2['countryName']!=$a['countryName'])printrus($a2['countryName'].", ");
  else printrus('<u>'.$a2['countryName']."</u>, ");
  }
  $npg = $pg+9;
  printrus ("<a href='map.php?m=okr&amp;pg=$npg&amp;$ses'>&gt;&gt;восток</a><br/>-------<br/>\r\n");

  printrus ("<a href='map.php?$ses'>еще...</a><br/>\r\n");
  }

  break;

  case('z'):
  if (!isset($pg)){$pg = 0;}
  if ($pg<0)$pg=0;

  $query="SELECT countryName FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL) order by reggedTime asc LIMIT ".$pg.",10";
  $r = mysql_query($query);
  echo mysql_error();
  $npg = $pg-9;
  if ($pg>0) printrus ("<a href='map.php?m=z&amp;pg=$npg&amp;$ses'>&lt;&lt;запад</a><br />");
  while(($a2=mysql_fetch_array($r))!==FALSE){
  if ($a2['countryName']!=$a['countryName'])printrus($a2['countryName'].",<br />");
  else printrus('<u>'.$a2['countryName']."</u>,<br />");
  }
  $npg = $pg+9;
  printrus ("<a href='map.php?m=z&amp;pg=$npg&amp;$ses'>&gt;&gt;восток</a><br/>-------<br/>\r\n");
  printrus ("<a href='map.php?$ses'>Назад</a><br/>\r\n");
  break;

  case('v'):
  if (!isset($pg)){  $query2=mysql_query("SELECT countryName FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL)");
  $r2 = mysql_num_rows($query2);
  $pg=$r2-9;
  }
  if ($pg<0)$pg=0;

  $query="SELECT countryName FROM `countries` LEFT JOIN `messages` ON countries.countryID=messages.countryID and messages.`from` = 'loose' WHERE (messages.countryID IS NULL) order by reggedTime asc LIMIT ".$pg.",10";
  $r = mysql_query($query);
  echo mysql_error();
  $npg = $pg-9;
  if ($pg>0) printrus ("<a href='map.php?m=v&amp;pg=$npg&amp;$ses'>&lt;&lt;запад</a><br />");

  while(($a2=mysql_fetch_array($r))!==FALSE){
  if ($a2['countryName']!=$a['countryName'])printrus($a2['countryName'].",<br />");
  else printrus('<u>'.$a2['countryName']."</u>,<br />");
  }
  $npg = $pg+9;
  printrus ("<a href='map.php?m=v&amp;pg=$npg&amp;$ses'>&gt;&gt;восток</a><br/>-------<br/>\r\n");
  printrus ("<a href='map.php?$ses'>Назад</a><br/>\r\n");
  break;
 endswitch;


//printrus ("---<br/><a href='game.php?$ses'>&lt;&lt;В игру</a><br/>\r\n");

//ботинки:
include_once("other_inc/footer.php");

?>