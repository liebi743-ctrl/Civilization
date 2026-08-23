<?php
// подключаемся
define('IN_CLV',true);
require ('../func/functions_clv.php');
mem_connect();
echo mysql_error();

//add log start
	$file = fopen('input.log', 'a+');
	$log = date("d.m.Y G:i:s ");
	foreach ($_GET as $key=>$value)
		$log .= $key.":".$value.";";
	$log .= "\r\n";
	fwrite($file, $log);
	fclose($file);
//add log end

$SecretKey="Fg4Z7nSv53B";

if (isset($_REQUEST['text'])) $text = $_REQUEST['text'];
if (isset($_REQUEST['phone'])) $phone = $_REQUEST['phone'];
if (isset($_REQUEST['sphone'])) $sphone = $_REQUEST['sphone'];
if (isset($_REQUEST['sms_id'])) $sms_id = $_REQUEST['sms_id'];
if (isset($_REQUEST['md5key'])) $md5key = $_REQUEST['md5key'];

		// Request validation
		$md5CheckSrc=$sphone.$SecretKey;
		$md5Check=md5($md5CheckSrc);

		// Validate md5key
		if(strcasecmp($md5Check,$md5key) == 0) {

//$smsRequest = urldecode($text);
$id = substr($text, 4);
// construct SMS response            
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
                // зачисляем кредиты
                    if ($sphone == "6907") //1
                    {
                        $sum = $sum + 12;
                    }
                    if ($sphone == "576") //3
                    {
                        $sum = $sum + 23;
                    }
                    if ($sphone == "6915") //5
                    {
                        $sum = $sum + 34;
                    }
                    if ($sphone == "7914") //6
                    {
                        $sum = $sum + 19;
                    }
                    if ($sphone == "7913") //9
                    {
                        $sum = $sum + 24;
                    }
                    if ($sphone == "7915") //14
                    {
                        $sum = $sum + 43;
                    }
                    if ($sphone == "7916") //23
                    {
                        $sum = $sum + 106;
                    }

mysql_query("UPDATE `uzers` SET credits='".$sum."' WHERE userID = '".addslashes($id)."' LIMIT 1");
                /*
                // логи
                $if_sms=''.$sphone.'||'.$phone.'||'.$operator.'||'.time().'||'.$sum.'||'.$smsRequest.'||';
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
                    fputs($fp,"$id||$sphone||$operator||$phone||$sum||$dta/$time\r\n");
                    flock($fp,LOCK_UN);
                    fclose ($fp);
                    chmod ('../data/partner/'.$partner.'_sms.dat', 0666);
                }*/
/////////////////
                    if ($sphone == "6907") //30
                    {
                        $smsResponse = "Счет пользователя пополнен на 12 золотых. imperia.mobi";
                    }
                    if ($sphone == "576") //90
                    {
                        $smsResponse = "Счет пользователя пополнен на 23 золотых. imperia.mobi";
                    }
                    if ($sphone == "6915") //150
                    {
                        $smsResponse = "Счет пользователя пополнен на 34 золотых. imperia.mobi";
                    }
                    if ($sphone == "7914") //180
                    {
                        $smsResponse = "Счет пользователя пополнен на 19 золотых. imperia.mobi";
                    }
                    if ($sphone == "7913") //270
                    {
                        $smsResponse = "Счет пользователя пополнен на 24 золотых. imperia.mobi";
                    }
                    if ($sphone == "7915") //420
                    {
                        $smsResponse = "Счет пользователя пополнен на 43 золотых. imperia.mobi";
                    }
                    if ($sphone == "7916") //690
                    {
                        $smsResponse = "Счет пользователя пополнен на 106 золотых. imperia.mobi";
                    }
            }
		}else{
		echo 'Error!';
		}

mysql_close($db);

header ("Content-Type: text/plain");
echo $smsResponse;
?>