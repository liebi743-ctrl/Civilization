<?php
header('Content-Type: application/xml; charset=utf-8');
error_reporting(E_ERROR);
//параметры приложения
$appId="5296128";
$appKey="CBABNBFBABABABABA";
$application_secret_key = "1A05AA0864B5BD3CB5364093";

//читаем переданные параметры 
$method = $_REQUEST["method"];
$application_key = $_REQUEST["application_key"];
$call_id = $_REQUEST["call_id"];
$sig = $_REQUEST["sig"];
$uid = $_REQUEST["uid"];
$amount = $_REQUEST["amount"];
$transaction_time = $_REQUEST["transaction_time"];
$product_code = $_REQUEST["product_code"];
$transaction_id = $_REQUEST["transaction_id"];

//проверяем метод
if($method != "callbacks.payment") {
header('invocation-error: 3');
print('<?xml version="1.0" encoding="UTF-8"?>');
?>
<ns2:error_response xmlns:ns2='http://api.forticom.com/1.0/'>
    <error_code>3</error_code>
    <error_msg>Method does not exist.</error_msg>
</ns2:error_response>
<?php
die();
}

//проверяем appId
if($appKey != $application_key) {
header('invocation-error: 101');
print('<?xml version="1.0" encoding="UTF-8"?>');
?>
<ns2:error_response xmlns:ns2='http://api.forticom.com/1.0/'>
    <error_code>101</error_code>
    <error_msg>Parameter application_key not specified or invalid</error_msg>
</ns2:error_response>
<?php
die();
}

//собираем переданные параметры без учета sig
$params = array();
foreach ($_GET as $key => $value) {
	if($key != "sig") {
		$params[$key] = "$key=$value";
	}
}
sort($params);
$params = join('', $params);
$mySig = md5($params . $application_secret_key);

//проверяем подпись
if($sig != $mySig) {
header('invocation-error: 104');
print('<?xml version="1.0" encoding="UTF-8"?>');
?>
<ns2:error_response xmlns:ns2='http://api.forticom.com/1.0/'>
    <error_code>104</error_code>
    <error_msg>Invalid signature.</error_msg>
</ns2:error_response>
<?php
die();
}

// подключаемся
define('IN_CLV',true);
require ('../func/functions_clv.php');
mem_connect();
echo mysql_error();
//TODO: 1) Transaction ID is unique and Application/Game server must ignore transactions with duplicated ID. 
//TODO: It must return positive result, if transaction was processed successfully earlier.

//TODO: 2) Cообщаем серверу о поступившем платеже

//TODO: 3) Cохраняем в БД успешную транзакцию

// get player name
$name = '';
$r = mysql_query("select user_id from o_reg where o_uid='".$uid."'");
if($err && mysql_error()!='')
{
    echo "_db_user_exists: ".mysql_error();
}
if($r!=false)
{
    if(mysql_num_rows($r)!=0)
    {
        $r_l = mysql_fetch_array($r);
        $name=trim($r_l['user_id']);
//        $_SESSION['pas']=trim($r_l['user_pass']);
    }
}

if($name!='')
{
$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".$name."' LIMIT 1");
$a = mysql_fetch_array($r);
$suma = $a['credits']; //Число кредитов
$sums = $suma + $amount;
//if($amount == '1') {$sums = $suma + 7;}
if($amount == '25') {$sums = $suma + 30;}
if($amount == '100') {$sums = $suma + 120;}
if($amount == '500') {$sums = $suma + 600;}
	if ($a!=false){    //Успешное пополнение счета

mysql_query("UPDATE `uzers` SET credits='".$sums."' WHERE userID = '".$name."' LIMIT 1");
	}
/*
// логи
$od_pay=''.$name.'||'.$udat[83].'||'.$sum.'||'.time().'||'.$transaction_time.'||'.$uid.'||'.$transaction_id.'||'.$amount.'||';
$fp=fopen("../gros/logs/od_pay.dat","a+");
flock($fp,LOCK_EX);
fputs($fp,"$od_pay\r\n");
fflush($fp);
flock($fp,LOCK_UN);
fclose($fp);
chmod ("../gros/logs/od_pay.dat", 0666);
// конец логов*/
    // report access
    print('<?xml version="1.0" encoding="UTF-8"?>');
    echo '<callbacks_payment_response xmlns="http://api.forticom.com/1.0/">true</callbacks_payment_response>';
    mysql_close($db);
}
else
{
    //repor error "User dosent exist"    
    header('invocation-error: 3');
    print('<?xml version="1.0" encoding="UTF-8"?>');
    echo "<ns2:error_response xmlns:ns2='http://api.forticom.com/1.0/'>
        <error_code>3</error_code>
        <error_msg>User does not exist.</error_msg>
         </ns2:error_response>";
    die();    
}

?>