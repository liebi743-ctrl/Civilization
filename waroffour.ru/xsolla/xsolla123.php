<?php
define('IN_CLV',true);
@include_once("../func/functions_clv.php");
//mem_connect();

@include_once("../other_inc/header.php");

$key = "AZRVyTOaLPr7kmug"; // ключ
$command = $_GET['command']; // команда
$v1 = $_GET['v1']; // id пользователя
$id = $_GET['id']; // id  транзакции
$sum = $_GET['sum']; // кол-во валюты


  switch($command)
  {
  /*------------------------------------------------------------------ отмена платежа ---------------------------------------------------------------------*/
  case 'cancel':

  $pod=$command.$id.$key;
  $md5=md5($pod);

    if($_GET['md5']!==$md5) /*Неверная подпись*/
    {
    printrus('<?xml version="1.0" encoding="UTF-8"?>
    <response>
    <result>INVALID_SIGNATURE</result>
    </response>');
    exit;
    }


  $e = 1;

    if($e=='0') /* заказ с таким идентификатором xsolla не найден в БД */
    {
    printrus('<?xml version="1.0" encoding="UTF-8"?>
    <response>
    <result>2</result>
    </response>');
    exit;
    }

  printrus('<?xml version="1.0" encoding="UTF-8"?>
  <response>
  <result>0</result>
  </response>');
  /* тут дальше по идее надо отменить покупку и забрать креды*/

  break;

  /*------------------------------------------------------------------ зачисление кредитов -----------------------------------------------------------------*/
  case 'pay':

  $pod=$command.$v1.$id.$key;
  $md5=md5($pod);

    if($_GET['md5']!==$md5) /*Неверная подпись*/
    {
    printrus('<?xml version="1.0" encoding="UTF-8"?>
    <response>
    <id_shop>'.$id.'</id_shop>
    <result>INVALID_SIGNATURE</result>
    <comment>Temporary database error</comment>
    </response>');
    exit;
    }
    $e=1;


    if($e=='0') /*Пользователь не найден*/
    {
    printrus('<?xml version="1.0" encoding="UTF-8"?>
    <response>
    <id_shop>'.$id.'</id_shop>
    <result>2</result>
    </response>');
    exit;
    }


  if($sum >= 1){$kred=round($sum);}
  if($sum >= 200 and $sum < 500){$kred=round($sum+($sum*10/100));}
  if($sum >= 500 and $sum < 900){$kred=round($sum+($sum*20/100));}
  if($sum >= 900){$kred=round($sum+($sum*30/100));}


 // mysql_query("UPDATE `zakaz` SET otvet='1', xsolla_id='$id' WHERE id='$v1'");

  printrus('<?xml version="1.0" encoding="UTF-8"?>
  <response>
  <id_shop>'.$id.'</id_shop>
  <result>0</result>
  </response>');

  break;

  /*-------------------------------------------------------- проверка на существование юзера ----------------------------------------------------------------*/
  case 'check':

  $pod=$command.$v1.$key;
  $md5=md5($pod);

    if($_GET['md5']!==$md5) /*Неверная подпись*/
    {
    printrus('<?xml version="1.0" encoding="UTF-8"?>
    <response>
    <result>INVALID_SIGNATURE</result>
    </response>');
    exit;
    }


    $e=0;


    if($e=='0') /*Пользователь не найден*/
    {
    printrus("<?xml version=\"1.0\" encoding=\"UTF-8\"?>
    <response>
    <result>INVALID_USER</result>
    </response>");
    }
    else
    {
    printrus("<?xml version=\"1.0\" encoding=\"UTF-8\"?>
    <response>
    <result>0</result>
    </response>");
    }

  break;
  }
?>