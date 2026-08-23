<?
if ($_GET['key'] <> '674')
die();

 $dblink=@mysql_pconnect(localhost,'cv','DhmhF9EW') or (mySQLconnectERROR($ip,_HOSTNAME) and die("1"));
 mysql_query('SET NAMES cp1251');

 @mysql_select_db('cv',$dblink) or (mySQLselect_dbERROR($ip,_DBNAME) and die("2")) ;

 
$q=mysql_query("SELECT * FROM pumpit_pay_log");

while ($a = mysql_fetch_array($q))
print $a[query] . '<br/>'; 
 
print "ok";
 
?>