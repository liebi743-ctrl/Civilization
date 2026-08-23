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
 
 
 function delete_country($countryID){

 global $memcache;

 $countryID=addslashes($countryID);
  
  
  /*$query="select * from countries where countryID='$countryID'";
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
  */

 //$query="delete from countries where countryID='$countryID'";
 //$query="UPDATE countries SET $sets where countryID='$countryID'";
 //$result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':id'.$countryID;
 if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 

 $query="delete from buildings where countryID='$countryID'";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':buildings'.$countryID;
 //if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 /*
 $query="delete from general where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':general'.$countryID;
 //if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);
*/
 /*
 $query="delete from messages where countryID='$countryID' and `from`!='loose'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':messages'.$countryID;
 //if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);
 */
 
 /*
 $query="delete from otkrytiya where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':otkrytiya'.$countryID;
 //if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);
 */
 /*
 $query="delete from market where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':market'.$countryID;
 //if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);
 */
 $query="delete from neighbours where countryID='$countryID' or neighbourID='$countryID'";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':neighs'.$countryID;
 //if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

 /*
 $query="delete from unite where countryID='$countryID'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':unite'.$countryID;
 //if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);
 */
 $query="delete from wars where countryID='$countryID'";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $key=_PREFIKS.':wars'.$countryID;
 //if (($a=$memcache->get($key))!==FALSE) $memcache->delete($key);

    // Если страна удаляется то clanID в таблице uzers обнуляется (чтобы не отображался в кланах)
    //$query = "UPDATE uzers SET clanID = '' WHERE countryID = '$countryID'";
    //$result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
	
	//Удаление (профиля) игрока и страны окончательно
	$q=mysql_query("DELETE FROM countries WHERE countryID = '$countryID'");
	//$q=mysql_query("DELETE FROM uzers WHERE countryID = '$countryID'");
}





$q=mysql_query("SELECT countryID FROM blacklist LIMIT 0, 30");
while ($data=mysql_fetch_array($q)){
//print_r($data);

$target=$data['countryID'];
print "target $target ; <br/>";
mysql_query("DELETE FROM blacklist WHERE countryID = '$target'");
delete_country($target);
}





