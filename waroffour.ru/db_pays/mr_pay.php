<?php

// подключаемся
define('IN_CLV',true);
require ('../func/functions_clv.php');
mem_connect();
echo mysql_error();

$secret_key= 'cae31ee99f7c9763d269138af3c1e08a';
$app_id = '643777';


function end_processing($result)
{
    echo json_encode($result);
    exit;
}

$t_id = $_GET['transaction_id'];
$s_id = $_GET['service_id'];
$uid = $_GET['uid'];
$sms_p = $_GET['sms_price'];
$profit = $_GET['profit'];
$sig = $_GET['sig'];
$a_id = $_GET['app_id'];

$result = array();

// check sig
$request_params = array(
        'transaction_id'=>$t_id,
        'service_id' => $s_id,
        'uid' => $uid,
        'sms_price' => $sms_p,
        'profit' => $prfit,
        'app_id' => $a_id
    );
ksort($request_params);
$params = '';
foreach ($request_params as $key => $value)
{
    $params .= "$key=$value";
}
$my_sig = md5($params . $secret_key);
/*
echo $my_sig;
echo "\n";
echo $sig;
echo "\n";
*/
if(/*$my_sig!=$sig || */$app_id!=$a_id)
{
    $result["status"] = '2';
    $result["error_code"] = '702';
    end_processing($result);
}
// check user
$user_id = '';
$q = mysql_query("select user_id from mr_reg where mr_uid='".$uid."' order by id desc");
if($q!=false){  if(mysql_num_rows($q)>0){ $r = mysql_fetch_array($q);  $user_id = $r['user_id'];  }      }
if($user_id =='' /*|| !_db_user_exists($user_id)*/)
{
    $result["status"] = '0';
    $result["error_code"] = '701';
    end_processing($result);
}

// check transaction
$q = mysql_query("select id form mrpay_data where transaction_id='$t_id'");
//echo mysql_error();
if($q!=false)
{
    if(mysql_num_rows($q)>0)
    {
        $result["status"] = '2';
        $result["error_code"] = '702';
        end_processing($result);
    }
}

// pay type
$sum = 0;
switch($sms_p)
{
case 1:
    $sum = 15;
    break;
case 3:
    $sum = 55;
    break;
case 5:
    $sum = 95;
    break;
}

if($sms_p == 0)
{
    $result["status"] = '2';
    $result["error_code"] = '702';
    end_processing($result);
}

// save payment data
$q = mysql_query("select user_id from mr_reg where mr_uid='".$uid."' order by id desc");
if($q!=false){  if(mysql_num_rows($q)>0){ $r = mysql_fetch_array($q);  $user_id = $r['user_id'];  

$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".$user_id."' LIMIT 1");
$a = mysql_fetch_array($r);
$suma = $a['credits']; //Число кредитов
$sums = $suma + $sum; 
	if ($a!=false){    //Успешное пополнение счета

mysql_query("UPDATE `uzers` SET credits='".$sums."' WHERE userID = '".$user_id."' LIMIT 1");

$q = mysql_query("insert into mrpay_data (transaction_id,service_id,sms_price,profit,uid,reg) values ('$t_id','$s_id','$sms_p','$profit','$uid','$user_name')");
}
}}
// answer
$result["status"] = '1';
end_processing($result);

?>
