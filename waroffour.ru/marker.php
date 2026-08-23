<?

//Данные коннекта к БД
define("_HOSTNAME","localhost");
define("_USERNAME","cv");
define("_DBPASS","DhmhF9EW");
define("_DBNAME","cv");

//адрес сайта
define("_MAINSITE","".$_SERVER["HTTP_HOST"]."");

//префикс мемкеш
define("_PREFIKS","cv");

//данные магазина
define("_SHOP","off"); //on - включен, off - выключен
define("_SERVICE_NUMBER_RUS","1125"); //короткий номер для России
define("_SERVICE_NUMBER_KAZ","7712"); //короткий номер для Казахстана
define("_SERVICE_NUMBER_UKR","7063"); //короткий номер для Украины
define("_PRICE","3"); //стоимость одной смс в долларах (сообщается пользователю в магазине)
define("_SHOP_PREFIKS","civil"); //префикс для смс (сообщается пользователю, а также используется скриптом обработки смс)



 $ip='';
 $dblink=@mysql_pconnect(_HOSTNAME,_USERNAME,_DBPASS) or (mySQLconnectERROR($ip,_HOSTNAME) and die("1"));
 mysql_query('SET NAMES cp1251');

 @mysql_select_db(_DBNAME,$dblink) or (mySQLselect_dbERROR($ip,_DBNAME) and die("2")) ;

 
 function mem_connect(){
Global $memcache;
if(!isset($memcache)||$memcache=='')$memcache = @memcache_pconnect('127.0.0.1', 11211) or die ('Connection to memory system failed!<br/><anchor>'.utf('Назад').'<prev/></anchor>');
}
 
 
 mem_connect();
 
//$logs=file_get_contents('logs.csv');

$q=mysql_query("SELECT pos FROM stop");
$data=mysql_fetch_array($q);

print "data:".$data[0] . "<br/>---<br/>";

$pos=$data[0];
$new=$data[0]+200000;

mysql_query("UPDATE stop SET pos=$new");

//die();
 
 
$q=mysql_query("SELECT countryID FROM `countries` WHERE (spy > 10) OR (grabber > 10) OR (sabotage > 10)  OR (verb > 10) ORDER BY countryID LIMIT 4000,1000");
while ($data=mysql_fetch_array($q) ){
mysql_query("DELETE FROM blacklist WHERE countryID = '$data[countryID]'");
}

 
 
 
 
die();
 
 
$q=mysql_query("SELECT countryID, countryName FROM countries ORDER BY countryID LIMIT $pos, 200000");
while ($data=mysql_fetch_array($q) ){

//$c=mysql_fetch_array(mysql_query("SELECT countryName FROM logs WHERE countryName='$data[countryName]' OR targetName='$data[countryName]'"));


if (1==1){
//print 'deleting...';
mysql_query("INSERT INTO blacklist SET countryID='$data[countryID]', countryName='$data[countryName]'");
}

//print "$data[countryID] : c - $c[0], p - $p <br/>";
}







