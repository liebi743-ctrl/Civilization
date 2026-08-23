<?php
//!!! При необходимости поменять название переменных, которые передаются скрипту.
//!!! остальные настройки находятся в config.php

//Номер транзакции
if (isset($_REQUEST['transaction']))$transaction = $_REQUEST['transaction'];
//Короткий номер
if (isset($_REQUEST['service_number']))$service_number = $_REQUEST['service_number'];
//Полный номер
if (isset($_REQUEST['account']))$account = $_REQUEST['account'];
//Время
if (isset($_REQUEST['time']))$time = $_REQUEST['time'];
//Номер оператора
if (isset($_REQUEST['company']))$company = $_REQUEST['company'];
//Сообщение абонента с префиксом в утф8
if (isset($_REQUEST['message']))$message = $_REQUEST['message'];

$message = strtolower($message);

define('IN_CLV',true);
require ('func/functions_clv.php');

mem_connect();

$t = $message;
$message = str_replace(_PREFIKS,'',$message);
$message = str_replace(' ','',$message);
$id = $message;
$id = round ( (int) $id);
$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".addslashes($id)."' LIMIT 1");
$a = mysql_fetch_array($r);
if ($a!==FALSE){    //Успешное пополнение счета
mysql_query("UPDATE `uzers` SET credits=credits+100 WHERE userID = '".addslashes($id)."' LIMIT 1");

header("http/1.1 200 Ok");
echo 'Balans igroka '.iconv('cp1251','utf-8',$a['username']).' v online-igre "Civilizaciya" uspeshno popolnen na 100 kreditov';
}else{  //Пользователя с таким id не существует
header("http/1.1 200 Ok");
echo 'Oshibochnxy id! Bud\'te vnimatel\'nee pri nabore!';
}

?>