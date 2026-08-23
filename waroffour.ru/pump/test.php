<?
$a1=("Location: http://imperia.mobi/reg_p.php?pumpit_login=&p_sid=&pumpit_login2=");
$a2=("Location: http://$_SERVER[HTTP_HOST]/reg_p.php?pumpit_login=$enc_login&p_sid=$realsid&pumpit_login2=$_GET[login]");\
$a3='';
if ($a1 == $a2)
{
$a3=$a2;
}
else{
header($a3);
}
