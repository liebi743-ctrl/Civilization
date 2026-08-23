<?php
// подключаемся
define('IN_CLV',true);
require ('../func/functions_clv.php');
mem_connect();
echo mysql_error();

// Insert your secret key for this project from i-Free Partners System
$SecretKey="dUh9iGbF";

// Debug Secret Key. Used only when debuging service from i-Free Partners System interface
$DebugSecretKey="7387482";

// If parameter 'test' exists then send it's value or 'OK' if empty value. This code is necessary for checking accessibility of script.
if(isset($_REQUEST['test'])) {
	$smsResponse="OK";
	if(trim($_REQUEST['test'])!="")
		$smsResponse=$_REQUEST['test'];
} else {
	if (isset($_REQUEST['smsText'])) $smsRequestEncoded = $_REQUEST['smsText'];
	if (isset($_REQUEST['phone'])) $phone = $_REQUEST['phone'];
	if (isset($_REQUEST['abonentId'])) $abonentId = $_REQUEST['abonentId'];
	if (isset($_REQUEST['country'])) $country = $_REQUEST['country'];
	if (isset($_REQUEST['serviceNumber'])) $serviceNumber = $_REQUEST['serviceNumber'];
	if (isset($_REQUEST['operator'])) $operator = $_REQUEST['operator'];
	if (isset($_REQUEST['now'])) $now = $_REQUEST['now'];
	if (isset($_REQUEST['md5key'])) $md5key = $_REQUEST['md5key'];
	if (isset($_REQUEST['retry'])) $retry=$_REQUEST['retry'];
	if (isset($smsRequestEncoded) && isset($phone) && isset($abonentId) && isset($country) && isset($serviceNumber) && isset($now) && isset($md5key)) {
		// Place code here if you want log request into your database
		
		// Request validation
		$md5CheckSrc=$serviceNumber.$smsRequestEncoded.$country.$abonentId.$SecretKey.$now;
		if(isset($retry))
			$md5CheckSrc.=$retry;
		if(isset($_REQUEST['debug'])){
			$md5CheckSrc.=$_REQUEST['debug'];
			$md5CheckSrc.=$DebugSecretKey;
		}
		$md5Check=md5($md5CheckSrc);

		// Validate md5key
		if(strcasecmp($md5Check,$md5key) == 0) {
			// Get decoded sms message
			$smsRequest=base64_decode($smsRequestEncoded);

            $id = substr($smsRequest, 4);
			
			// Place your code here to construct SMS response
			// For example:
            
            $r = mysql_query("SELECT * FROM `uzers` WHERE userID='".$id."'");
        	if($r==false)// if user dosn't exist
            {
                $smsResponse="Игрока с ID$id не существует. imperia.mobi";
            }
            else// if user exists
            {                
                //$id = $v1;
//$id = round ( (int) $id);
$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".addslashes($id)."' LIMIT 1");
$a = mysql_fetch_array($r);
$sum = $a['credits']; //Число кредитов
$partner = $a['partner']; //от партнера
	if ($a!=false){    //Успешное пополнение счета
                // зачисляем кредиты
                if($serviceNumber=="4445") //6
                {$sum=$sum+6;}
                if($serviceNumber=="4446") //12
                {$sum=$sum+12;}
                if($serviceNumber=="4447") //15
                {$sum=$sum+15;}
                if($serviceNumber=="4448") //24
                {$sum=$sum+24;}
                if($serviceNumber=="4449") //36
                {$sum=$sum+48;}
                if($serviceNumber=="4161") //57
                {$sum=$sum+76;}

mysql_query("UPDATE `uzers` SET credits='".$sum."' WHERE userID = '".addslashes($id)."' LIMIT 1");
                
                // логи
                $if_sms=''.$serviceNumber.'||'.$phone.'||'.$operator.'||'.time().'||'.$sum.'||'.$smsRequest.'||';
$fp=fopen("../data/if_sms.dat","a+");
flock($fp,LOCK_EX);
fputs($fp,"$if_sms\r\n");
fflush($fp);
flock($fp,LOCK_UN);
fclose($fp);
chmod ("../data/if_sms.dat", 0666);
// конец логов
                //для партнерских программ
                $time=date('H:i:s');
                $dta=date('d.m.y');
                if($partner!='')
                {
                    $fp=fopen("../data/partner/".$partner."_sms.dat","a+");
                    flock ($fp,LOCK_EX);
                    fputs($fp,"$id||$serviceNumber||$operator||$phone||$sum||$dta/$time\r\n");
                    flock($fp,LOCK_UN);
                    fclose ($fp);
                    chmod ('../data/partner/'.$partner.'_sms.dat', 0666);
                }
/////////////////
                if($serviceNumber=="4445") //3
                {$smsResponse="Персонажу ID$id начислен 6 Coin of Luck. imperia.mobi";}
                if($serviceNumber=="4446") //5
                {$smsResponse="Персонажу ID$id начислен 12 Coin of Luck. imperia.mobi";}
                if($serviceNumber=="4447") //6
                {$smsResponse="Персонажу ID$id начислен 15 Coin of Luck. imperia.mobi";}
                if($serviceNumber=="4448") //9
                {$smsResponse="Персонажу ID$id начислен 24 Coin of Luck. imperia.mobi";}
                if($serviceNumber=="4449") //14
                {$smsResponse="Персонажу ID$id начислен 48 Coin of Luck. imperia.mobi";}
                if($serviceNumber=="4161") //23
                {$smsResponse="Персонажу ID$id начислен 76 Coin of Luck. imperia.mobi";}
                
            }
		}
            
		} else {
			// Validation failed. Construct security error to i-Free Service 
			$errorText="Security error: md5key check failed";
		}
   } else {
		// Construct general error to i-Free Service
		$errorText="General error: not all variables set";
   }
}
mysql_close($db);

// Construct response
$httpResponse="<Response>";

// Add sms message to response
if(isset($smsResponse))
	$httpResponse.="<SmsText><![CDATA[".$smsResponse."]]></SmsText>";

// Add error message to response
if(isset($errorText))
	$httpResponse.="<ErrorText><![CDATA[".$errorText."]]></ErrorText>";

$httpResponse.="</Response>";

// Send response
header ("Content-Type:text/xml");  
print $httpResponse;
?>