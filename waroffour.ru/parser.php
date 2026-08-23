<?php
//define('IN_CLV',true);
//include_once("func/functions_clv.php");
//достаем все идентификаторы стран:
$query = mysql_query("SELECT countryID from `countries` WHERE (spy > 10) OR (sabotage > 10) OR (grabber > 10) OR (verb > 10)") or die("112");
mysql_query("CREATE TABLE `parser` (`name` CHAR(200))") or die("ne sozdal");
while($countIdArray = mysql_fetch_row($query)){
	mysql_query("INSERT INTO parser (`name`) VALUES('$countIdArray[0]')") or die("ne dobavil nikuya");
};
echo "tabte new<br>";
$query2 = mysql_query("SELECT * from `parser`") or die("113");
 while($countIdArray2 = mysql_fetch_row($query2)){
	echo $countIdArray2[0]."<br>";
 };

?>