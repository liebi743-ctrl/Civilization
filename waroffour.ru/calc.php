<?
 foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['w_level'])) $w_level = $_REQUEST['w_level'];
if (isset($w_level) && !is_numeric($w_level)) $w_level=0;
if ($w_level<0) $w_level=0;
if (isset($_REQUEST['w_type'])) $w_type = $_REQUEST['w_type'];
if (isset($w_type) && !is_numeric($w_type)) $w_type=0;
if ($w_type!=0 && $w_type!=1) $w_type=0;
if (isset($_REQUEST['w_hits'])) $w_hits = $_REQUEST['w_hits'];
if (isset($w_hits) && !is_numeric($w_hits)) $w_hits=100;
if ($w_hits<=0 || $w_hits>100) $w_hits=100;
if (isset($_REQUEST['b_level'])) $b_level = $_REQUEST['b_level'];
if (isset($b_level) && !is_numeric($b_level)) $b_level=1;
if ($b_level<1) $b_level=1;
if (isset($_REQUEST['b_type'])) $b_type = $_REQUEST['b_type'];
if (isset($b_type) && !is_numeric($b_type)) $b_type=0;
if ($b_type!=0 && $b_type!=1) $b_type=0;
if (isset($_REQUEST['b_count'])) $b_count = $_REQUEST['b_count'];
if (isset($b_count) && !is_numeric($b_count)) $b_count=1;
if ($b_count<1) $b_count=1;


//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
include_once("func/functions_clv.php");
mem_connect();

sesinit();
//шапка:
include_once("other_inc/header.php");

$countryID = $_SESSION['countryID'];
 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

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
  //syncses($_SESSION['countryID']);
  $tm = date(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
  printrus ("<u>[".$b['countryName']."]</u><br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

 if (!isset($m)){
 printrus("Калькулятор стенобиток:<br/>\n");
 printrus ("Уровень стены:<br/><form name=\"\" action=\"calc.php?m=go&amp;$ses\" method=\"post\">
<input format='*N' name='w_level' /><br/>\r\n");

 printrus ("Тип стены:<br/>\r\n");
 printrus ("<select name=\"w_type\">\n");
 printrus ("<option value=\"0\">Дерево</option>\n");
 printrus ("<option value=\"1\">Камень</option>\n");
 printrus ("</select><br/>\n");

 printrus ("Целостность:<br/><input format='*N' name='w_hits' value='100' />%<br/>\r\n");
 printrus ("Число стенобиток:<br/><input format='*N' name='b_count' /><br/>\r\n");
 printrus ("Уровень стенобиток:<br/><input format='*N' name='b_level' /><br/>\r\n");

 printrus ("Тип стенобиток:<br/>\r\n");
 printrus ("<select name=\"b_type\">\n");
 printrus ("<option value=\"0\">Огонь</option>\n");
 printrus ("<option value=\"1\">Камень</option>\n");
 printrus ("</select><br/>\n");

   printrus
("<input type=\"submit\" value=\"Рассчитать\"/>
</form><br/>
");

 }elseif(!isset($w_level)||!isset($w_type)||!isset($w_hits)||!isset($b_count)||!isset($b_level)||!isset($b_type)){
 printrus("Ошибка ввода! Необходимо заполнить все поля.<br/>\n");
 }else{

 $hits_min=40;

 $fvar2 = $w_level;
 $var1 = $w_type;
 $var2 = $w_level;
 $hits = $w_hits;
 $count = $b_count;
 $protection=$b_level;
 $kind=$b_type;

 while ($hits>$hits_min && $count>0){
 $count_=$count;
 $count=max(0,$count-max(1,round(3*$fvar2/max(1,$protection)/2)));

  if (max(1,round(3*$fvar2/max(1,$protection)/2))<=$count_){
  if ($kind!=$var1) $hits = $hits - 6;
  else $hits = $hits - 15;
  }else{
  if ($kind!=$var1) $mhits = round($count_/max(1,round(3*$fvar2/max(1,$protection)/2)));
  else $mhits = round($count_/max(1,round(3*$fvar2/max(1,$protection)/2))*3/2);
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
 if ($var2<0)$var2=0;
 $var2 = round($var2);

 printrus("Результат:<br/>\n\r");
 printrus("Стена будет разрушена до <b>$hits</b>%, ");
 if ($hits>$hits_min) printrus("без дыры в стене.<br/>\n\r");
 else printrus("в стене образуется дыра.<br/>\n\r");
 printrus("Останется стенобиток: <b>$count</b><br/>\n\r");
 printrus("Остаточный уровень укрепления стены: <b>$var2</b><br/>---<br/>\n");
 printrus("<a href=\"calc.php?$ses\">еще!</a><br/>\n\r");
 }

//printrus ("---<br/><a href='game.php?$ses'>&lt;&lt;В игру</a><br/>\r\n");
//printrus ('<b>&#169;</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
