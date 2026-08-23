<?php
//foreach($_REQUEST as $key => $var){
//$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
//}
//Обработка переменных:
if (isset($_REQUEST['msg'])) $msg = $_REQUEST['msg'];
//if (isset($_REQUEST['clv'])) $clv = $_REQUEST['clv'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];
if (isset($_REQUEST['p'])) $p = $_REQUEST['p'];
if ($p!='F0DFwLT0')exit;
$ref = rand(0,1000000);

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

@include_once("other_inc/header.php");


if (isset($go)){
      //$msg = str_replace("$",'',$msg);
      $message = iconv('utf-8','cp1251',$msg);
      $date = date("d M(H:i)");
      $idd = time();
      mysql_query("INSERT into news SET tm = '".$idd."', mes = '".$message."', date = '".$date."'");
      $a = mysql_query("SELECT * FROM uzers WHERE ip!='sysreg'");
        while($d = mysql_fetch_array($a))
        {
        mysql_query("UPDATE `uzers` SET forum_news=forum_news+'1' WHERE userID = '$d[userID]' LIMIT 1");
        }
      printrus ("Новость добавлена!<br/>");
        }

printrus ("<u>Новость:</u> (действуют html-теги!)<br/>");

 printrus ("<form name=\"\" action=\"addnews.php?go=add&amp;p=$p\" method=\"post\">
<input name='msg' /><br/>");
printrus("<input type=\"submit\" value=\"Добавить\"/></form><br/>");

echo "------<br/>";
printrus ("<a href=\"admm.php?p=FyspO\">Админка</a><br/>");

//футер страницы:
include_once("other_inc/footer.php");
?>
