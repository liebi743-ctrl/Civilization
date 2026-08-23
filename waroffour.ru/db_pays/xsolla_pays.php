<?php

// подключаемся
define('IN_CLV',true);
require ('../func/functions_clv.php');
mem_connect();
echo mysql_error();

              
$secret_key= ']-Nw#m5YU#y+%=Q,d9KD]xJYJb';

function check_user_ip()
{
    return ( $_SERVER['REMOTE_ADDR']=='82.146.40.60' ||
        $_SERVER['REMOTE_ADDR']=='188.120.245.101' ||
        $_SERVER['REMOTE_ADDR']=='188.120.245.102' || $_SERVER['REMOTE_ADDR']=='94.103.26.178' || $_SERVER['REMOTE_ADDR']=='94.103.26.179' || $_SERVER['REMOTE_ADDR']=='94.103.26.180' || $_SERVER['REMOTE_ADDR']=='94.103.26.181' || $_SERVER['REMOTE_ADDR']=='94.103.26.182')? true : false;
}

// check request
function check_request()
{
    //if(!check_user_ip()){return;}

    $com = $_GET['command'];
    $v1 = $_GET['v1'];
    $v2 = $_GET['v2'];
    $v3 = $_GET['v3'];

    global $secret_key;    
    $md = $com.$v1.$secret_key;
    if($_GET['md5']==md5($md))
    {
        
$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".$v1."'");
        if($r!=false)
        {              
        echo '<?xml version="1.0" encoding="windows-1251"?>
            <response>
                 <result>0</result>
            </response> ';
        return ;
        }

    }    
// if we are here than error occured
    echo '<?xml version="1.0" encoding="windows-1251"?>
        <response>
          <result>7</result>
          <comment>Account is disabled or not present.</comment>
        </response>';
    

}

// pay request
function pay_request()
{
    //if(!check_user_ip()){return;}

    $com = $_GET['command'];
    $id = $_GET['id'];
    $id_shop = $_GET['id_shop'];
    $sum = $_GET['sum'];
    $date = $_GET['date'];
    $v1 = $_GET['v1'];
    /*
    $v2 = $_GET['v2'];
    $v3 = $_GET['v3'];
     */

    global $secret_key;
    $md = $com.$v1.$id.$secret_key;

    if($_GET['md5']==md5($md))
    {
        // if success
$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".$v1."'");
        if($r!=false)
        {
            // check if payment alredy done
            $q = mysql_query("select id,sum,id_shop from pay2_data where id='$id'");
            //echo mysql_error();
            if($q!=false)
            {
                if(mysql_num_rows($q)>0)
                {
                    $r = mysql_fetch_array($q);
                    echo '<?xml version="1.0" encoding="windows-1251"?>
                            <response>
                                 <id>'.$id.'</id>
                                 <id_shop>'.$r['id_shop'].'</id_shop>
                                 <sum>'.$r['sum'].'</sum>
                                 <result>0</result>
                                 <comment>Request alredy done</comment>
                            </response>
                            ';
                    return;
                }

            }
//$sum1 = $sum*0.25;
if ($sum<'100') {$sum_new = $sum;}
if ($sum>='100') {$sum_new = $sum + round($sum*0.10);}
if ($sum>='300') {$sum_new = $sum + round($sum*0.15);}
if ($sum>='900') {$sum_new = $sum + round($sum*0.30);}
            $q = mysql_query("insert into pay2_data (id,v1,sum,dat) values ('$id','$v1','$sum_new','$date')");
            if($q!=false)
            {
//$sum1 = $sum*0.25;
//$sum_new = $sum + round($sum1);
if ($sum<'100') {$sum_new = $sum;}
if ($sum>='100') {$sum_new = $sum + round($sum*0.10);}
if ($sum>='300') {$sum_new = $sum + round($sum*0.15);}
if ($sum>='900') {$sum_new = $sum + round($sum*0.30);}

                $id = $v1;
$id = round ( (int) $id);
$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".addslashes($id)."' LIMIT 1");
$a = mysql_fetch_array($r);
$partner = $a['partner']; //от партнера
if ($a!=false){    //Успешное пополнение счета
mysql_query("UPDATE `uzers` SET credits=credits+'".$sum_new."' WHERE userID = '".addslashes($id)."' LIMIT 1");
}
//для партнерских программ
                $time=date('H:i:s');
                $dta=date('d.m.y');
                if($partner!='')
                {
                    $fp=fopen("../data/partner/".$partner."_sms.dat","a+");
                    flock ($fp,LOCK_EX);
                    fputs($fp,"$id||no||other||other||$sum||$dta/$time\r\n");
                    flock($fp,LOCK_UN);
                    fclose ($fp);
                    chmod ('../data/partner/'.$partner.'_sms.dat', 0666);
                }
/////////////////

                echo '<?xml version="1.0" encoding="windows-1251"?>
                    <response>
                         <id>'.$id.'</id>
                         <id_shop>'.$id_shop.'</id_shop>
                         <sum>'.$sum_new.'</sum>
                         <result>0</result>
                    </response>
                     ';
                return ;
            }
        }
    }
//$sum1 = $sum*0.25;
//$sum_new = $sum + round($sum1);
if ($sum<'100') {$sum_new = $sum;}
if ($sum>='100') {$sum_new = $sum + round($sum*0.10);}
if ($sum>='300') {$sum_new = $sum + round($sum*0.15);}
if ($sum>='900') {$sum_new = $sum + round($sum*0.30);}
// if we are here than error occured
        echo '<?xml version="1.0" encoding="windows-1251"?>
            <response>
                <id>'.$id.'</id>
                 <id_shop>'.$id_shop.'</id_shop>
                 <sum>'.$sum_new.'</sum>
                <result>1</result>
                <comment>Temporarily error</comment>
            </response>
            ';
}

// cancel request
function cancel_request()
{
//    if(!check_user_ip()){return;}

    $com = $_GET['command'];
    $id = $_GET['id'];
    
    global $secret_key;
    $md = $com.$v1.$id.$secret_key;

    if($_GET['md5']==md5($md))
    {
//        if(_db_user_exists($v1))
$r = mysql_query("SELECT * FROM `uzers` WHERE userID='".$v1."'");
        if($r!=false)
        {
        echo
            '<?xml version="1.0" encoding="windows-1251"?>
            <response>
                 <result>0</result>
            </response>
            ';
        return ;
        }

    }
    
// if we are here than error occured
        echo
            '<?xml version="1.0" encoding="windows-1251"?>
            <response>
                          <result>7</result>
                          <comment>Account is disabled or not present.</comment>
            </response>';

}


function execute()
{
    $com = $_GET['command'];

    switch($com)
    {
    case 'check':        
        check_request();
        break;
    case 'pay':        
        pay_request();
        break;
    case 'cancel':
        cancel_request();
        break;
    }
}

header ("Content-Type:text/xml");

execute();
mysql_close($db);

?>
