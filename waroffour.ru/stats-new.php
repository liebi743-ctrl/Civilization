<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];

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
//  printrus ("<u>[".$b['countryName']."]</u><br/>\r\n");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }

if (!isset($go)){

printrus("Сейчас на карте мира:<br/>\n");
$r = mysql_query("SELECT count(*) as num FROM `wars`");
$a = mysql_fetch_array($r);
printrus("<b>".$a['num']."</b> войн<br/>\n");

$r = mysql_query("SELECT count(*) as num FROM `clans`");
$a = mysql_fetch_array($r);
printrus("<b>".$a['num']."</b> <a href=\"stats.php?go=clans&amp;$ses\">кланов</a><br/>\n");

$r = mysql_query("SELECT count(*) as num FROM `unite`");
$a = mysql_fetch_array($r);
printrus("<b>".round($a['num']/2)."</b> союзов<br/>\n");

$r = mysql_query("SELECT count(*) as num FROM `buildings`");
$a = mysql_fetch_array($r);
printrus("<b>".$a['num']."</b> зданий<br/>\n");
printrus("<a href=\"sites.php?$ses\">клан-сайты</a><br/>\n");
}elseif ($go=='clans'){

    printrus("Кланы империи:<br/>\n");
$r = mysql_query("SELECT id,name FROM `clans` WHERE id > 0");
    while (($a=mysql_fetch_array($r))!==FALSE){
        $query = "SELECT count(*) FROM uzers WHERE clanID = $a[id]";

        $result = mysql_query($query);
        if(mysql_fetch_assoc($result)){

            $clanName = $a['name'];
            require_once('other_inc/klans.php');
            if(in_array($a['id'],$klan))printrus($znak[$a['id']]);

    /*
     *  Этот код удаляет clanID у всех uzers у которых нет country
     *
    $querys = "SELECT * from uzers WHERE clanID = $a[id]";
    $results = mysql_query($querys);

    while($row = mysql_fetch_assoc($results)){
        //print_r($row['countryID']."<br/>");
        $countryID = $row['countryID'];
        $username = $row['username'];
        $query = "SELECT countryID from countries WHERE countryID = '$countryID'";
        $result = mysql_query($query);
        printrus($username."<br/>");
        if($roww = mysql_fetch_assoc($result)){
            printrus("GOOD"."<br/>");

         //print_r($roww);
        } else {
            $query = "UPDATE uzers SET clanID = '' WHERE username = '$username'";
            mysql_query($query);
            print $query."<br/>";
        }
    }
    */
      printrus
("<img src=\"/img/ico/moder.png\" alt=\"\" /> <a href=\"viewclan.php?$ses&amp;cid=".$a['id']."\">$clanName</a><br/>
");
        }
   }

}

//printrus ("---<br/><a href='game.php?$ses'>&lt;&lt;В игру</a><br/>\r\n");
//printrus ('<b>&#169;</b> <a href="http://getwap.ru">GETWAP.RU</a><br/>');

//ботинки:
include_once("other_inc/footer.php");

?>
