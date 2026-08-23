<?php
error_reporting (E_ALL);
//define('IN_CLV',true);
//include_once("func/functions_clv.php");
$query2 = mysql_query("SELECT name FROM `parser` LIMIT 0 , 160") or die("Не могу подключиться к таблице");
//перебираем строки с id страны из таблицы парсера
while($countIdArray2 = mysql_fetch_row($query2)){
	//находим здания для данного id и формируем для каждого из них ассоциативный массив
	$buildGet = mysql_query("SELECT * FROM  `buildings` WHERE countryID = '$countIdArray2[0]'") or die("not search");
	while($buildReplace = mysql_fetch_array($buildGet, MYSQL_NUM)){
	
	//записываем здания в таблицу
		if($buildReplace != false){
			mysql_query("INSERT INTO `buildings2` 
				
				VALUES(
				'$buildReplace[0]',
				'$buildReplace[1]',
				'$buildReplace[2]',
				'$buildReplace[3]',
				'$buildReplace[4]',
				'$buildReplace[5]',
				'$buildReplace[6]',
				'$buildReplace[7]',
				'$buildReplace[8]',
				'$buildReplace[9]',
				'$buildReplace[10]',
				'$buildReplace[11]',
				'$buildReplace[12]',
				'$buildReplace[13]')") or die("Не могу добавить здание");
		
		}; 
	};
	 
	//находим генерала для данного id и формируем из каждого из них ассоциативный массив
	$generalGet = mysql_query("SELECT * FROM  `general` WHERE countryID = '$countIdArray2[0]'");
	while($generalReplace = mysql_fetch_array($generalGet, MYSQL_NUM)){
	
		if($generalReplace != false){
			mysql_query("INSERT INTO `general2` 
				
				VALUES(
				'$generalReplace[0]',
				'$generalReplace[1]',
				'$generalReplace[2]',
				'$generalReplace[3]',
				'$generalReplace[4]',
				'$generalReplace[5]')") or die("Не могу добавить генерала");
		};
	};
	
	//находим сообщения для данного id и формируем из каждого из них ассоциативный массив
	$messagesGet = mysql_query("SELECT * FROM  `messages` WHERE countryID = '$countIdArray2[0]'");
	while($messagesReplace = mysql_fetch_array($messagesGet, MYSQL_NUM)){
	
		if($generalReplace != false){
			mysql_query("INSERT INTO `messages2` 
				
				VALUES(
				'$messagesReplace[0]',
				'$messagesReplace[1]',
				'$messagesReplace[2]',
				'$messagesReplace[3]')") or die("Не могу добавить сообщения");
		};
	};
	
	//находим открытия для данного id и формируем из каждого из них ассоциативный массив
	$otkrytiyaGet = mysql_query("SELECT * FROM  `otkrytiya` WHERE countryID = '$countIdArray2[0]'");
	while($otkrytiyaReplace = mysql_fetch_array($otkrytiyaGet, MYSQL_NUM)){
	
		if($otkrytiyaReplace != false){
			mysql_query("INSERT INTO `otkrytiya2` 
				
				VALUES(
				'$otkrytiyaReplace[0]',
				'$otkrytiyaReplace[1]')") or die("Не могу добавить открытия");
		};
	};
	
	//находим продажи для данного id и формируем из каждого из них ассоциативный массив
	$marketGet = mysql_query("SELECT * FROM  `market` WHERE countryID = '$countIdArray2[0]'");
	while($marketReplace = mysql_fetch_array($marketGet, MYSQL_NUM)){
	
		if($marketReplace != false){
			mysql_query("INSERT INTO `market2` 
				
				VALUES(
				'$marketReplace[0]',
				'$marketReplace[1]',
				'$marketReplace[2]',
				'$marketReplace[3]',
				'$marketReplace[4]')") or die("Не могу добавить продажи");
		};
	};
	
	//находим neighbourID для данного id и формируем из каждого из них ассоциативный массив
	$neighboursGet = mysql_query("SELECT * FROM  `neighbours` WHERE countryID = '$countIdArray2[0]'");
	while($neighboursReplace = mysql_fetch_array($neighboursGet, MYSQL_NUM)){
	
		if($neighboursReplace != false){
			mysql_query("INSERT INTO `neighbours2` 
				
				VALUES(
				'$neighboursReplace[0]',
				'$neighboursReplace[1]')") or die("Не могу добавить neighbourID");
		};
	};
	
	//находим юнитов для данного id и формируем из каждого из них ассоциативный массив
	$uniteGet = mysql_query("SELECT * FROM  `unite` WHERE countryID = '$countIdArray2[0]'");
	while($uniteReplace = mysql_fetch_array($uniteGet, MYSQL_NUM)){
		if($neighboursReplace != false){
		
			mysql_query("INSERT INTO `unite2` 
				VALUES(
				'$uniteReplace[0]',
				'$uniteReplace[1]')") or die("Не могу добавить юнитов");
		};
	};
	
	//находим войны для данного id и формируем из каждого из них ассоциативный массив
	$warsGet = mysql_query("SELECT * FROM  `wars` WHERE countryID = '$countIdArray2[0]'");
	while($warsReplace = mysql_fetch_array($warsGet, MYSQL_NUM)){
		if($neighboursReplace != false){
			mysql_query("INSERT INTO `wars2` 
				
				VALUES(
				'$warsReplace[0]',
				'$warsReplace[1]',
				'$warsReplace[2]',
				'$warsReplace[3]',
				'$warsReplace[4]',
				'$warsReplace[5]',
				'$warsReplace[6]',
				'$warsReplace[7]',
				'$warsReplace[8]',
				'$warsReplace[9]',
				'$warsReplace[10]',
				'$warsReplace[11]',
				'$warsReplace[12]')") or die("Не могу добавить войны");
		};
	};
	
	//переносим остальные данные страны
	$countriesGet = mysql_query("SELECT * FROM  `countries` WHERE countryID = '$countIdArray2[0]'");
	while($countriesReplace = mysql_fetch_array($countriesGet, MYSQL_NUM)){
		if($countriesReplace != false){
			mysql_query("INSERT INTO `countries2` 
				
				VALUES(
				'$countriesReplace[0]',
				'$countriesReplace[1]',
				'$countriesReplace[2]',
				'$countriesReplace[3]',
				'$countriesReplace[4]',
				'$countriesReplace[5]',
				'$countriesReplace[6]',
				'$countriesReplace[7]',
				'$countriesReplace[8]',
				'$countriesReplace[9]',
				'$countriesReplace[10]',
				'$countriesReplace[11]',
				'$countriesReplace[12]',
				'$countriesReplace[13]',
				'$countriesReplace[14]',
				'$countriesReplace[15]',
				'$countriesReplace[16]',
				'$countriesReplace[17]',
				'$countriesReplace[18]',
				'$countriesReplace[19]',
				'$countriesReplace[20]',
				'$countriesReplace[21]',
				'$countriesReplace[22]',
				'$countriesReplace[23]',
				'$countriesReplace[24]',
				'$countriesReplace[25]',
				'$countriesReplace[26]',
				'$countriesReplace[27]',
				'$countriesReplace[28]',
				'$countriesReplace[29]',
				'$countriesReplace[30]',
				'$countriesReplace[31]',
				'$countriesReplace[32]',
				'$countriesReplace[33]',
				'$countriesReplace[34]',
				'$countriesReplace[35]',
				'$countriesReplace[36]',
				'$countriesReplace[37]',
				'$countriesReplace[38]',
				'$countriesReplace[39]',
				'$countriesReplace[40]',
				'$countriesReplace[41]',
				'$countriesReplace[42]',
				'$countriesReplace[43]',
				'$countriesReplace[44]',
				'$countriesReplace[45]',
				'$countriesReplace[46]',
				'$countriesReplace[47]',
				'$countriesReplace[48]',
				'$countriesReplace[49]',
				'$countriesReplace[50]',
				'$countriesReplace[51]',
				'$countriesReplace[52]',
				'$countriesReplace[53]',
				'$countriesReplace[54]',
				'$countriesReplace[55]',
				'$countriesReplace[56]',
				'$countriesReplace[57]',
				'$countriesReplace[58]',
				'$countriesReplace[59]',
				'$countriesReplace[60]',
				'$countriesReplace[61]',
				'$countriesReplace[62]',
				'$countriesReplace[63]',
				'$countriesReplace[64]',
				'$countriesReplace[65]',
				'$countriesReplace[66]',
				'$countriesReplace[67]',
				'$countriesReplace[68]',
				'$countriesReplace[69]',
				'$countriesReplace[70]',
				'$countriesReplace[71]',
				'$countriesReplace[72]',
				'$countriesReplace[73]',
				'$countriesReplace[74]',
				'$countriesReplace[75]')") or die("Не могу добавить страну");
		};
	};	
	//после записи всех параметров удаляем id из таблицы.
mysql_query("DELETE FROM `parser` WHERE `name` = '$countIdArray2[0]'") or die("не удалил");
	

	
 };