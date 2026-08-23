<?
//Обработка переменных:
if (isset($_REQUEST['m'])) $m = $_REQUEST['m'];
if (isset($_REQUEST['go'])) $go = $_REQUEST['go'];

if (isset($_REQUEST['days'])) $days = $_REQUEST['days'];
if (isset($days)&&!is_numeric($days)) $days=0;
if (isset($days)&&$days<0) $days=0;
if (isset($days))$days = round($days);
if (isset($days) && $days>100)$days=0;

if (isset($_REQUEST['amount'])) $amount = $_REQUEST['amount'];
if (isset($amount)&&!is_numeric($amount)) $amount=0;
if (isset($amount)&&$amount<0) $amount=0;
if (isset($amount))$amount = round($amount);
if (isset($amount) && $amount>1000000)$amount=0;

if (isset($_REQUEST['sure'])) $sure = $_REQUEST['sure'];
if (isset($_REQUEST['res'])) $res = $_REQUEST['res'];
if (isset($_REQUEST['cnt'])) $see = $_REQUEST['cnt']; else $see =0;
//if (isset($_REQUEST['building'])) $building = $_REQUEST['building'];

//==============================================================================
//подключаем скрипты

 $peopleto=round( (int) $peopleto);

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();

//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

$b=CountryInfo($countryID);
isAuthed();
VIP_settings();
$us=UzersInfo($countryID);

printrus("<u>Магазин</u><br/>");

if (_SHOP!="on"&&$_SESSION['userID']!=1588593){
printrus("Извините, услуги магазина временно недоступны.<br/>\r\n");
/*printrus
("
<a href='game.php?$ses'>&lt;&lt;В игру</a>
<br/>
");
printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");*/
//футер страницы:
include_once("other_inc/footer.php");
exit;
}

$r = mysql_query("SELECT credits,userID,username,spent,vip FROM `uzers` WHERE countryID = '".$countryID."' LIMIT 1");
$a = mysql_fetch_array($r);
$credits = $a['credits']; //Число кредитов на счету
$userID = $a['userID']; //ID юзера
$login = $a['username'];
$spent = $a['spent']; //На какую сумму сделано покупок в день
$vip = $a['vip'];
printrus("У вас на счету: <b>$credits</b> кредитов<br/>");
if (($b['reggedTime']+43200*2>time())&&$_SESSION['userID']!=13&&$_SESSION['userID']!=1588593){
printrus("Извините, воспользоваться услугами магазина могут только страны, зарегистрировавшиеся более 24 часов назад!<br/>\r\n");
}else{

switch($m):

default:

  if($vip == 0){
 if($us['noob']>=1){printrus("<font color='#EE7621'>[<a href=\"../faq.php?m=vip_inf&amp;$ses\"><font color='#EE7621'>?</font></a>]</font>");}
 printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
  printrus("<a href='https://unitpay.ru/pay/24940-5fcf8?sum=10&account=".$userID."&hideHint=true&hideBackUrl=true&hideLogo=true&hideOrderCost=true&desc=VIP+статус+для+".$userID." (".$login.")'><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Приобрести вечный VIP статус за 10 рублей</a><br/>\r\n");
  }else{
  printrus("<a href=\"shop.php?m=addfunds&amp;$ses\">Пополнить счет</a><br/>\r\n");
  printrus("<a href=\"shop.php?m=moratory&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Купить мораторий</a><br/>\r\n");
  //printrus("<a href=\"shop.php?m=moratory_chas&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Купить часовой мораторий</a><br/>\r\n");
  printrus("<a href=\"shop.php?m=res&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Купить ресурсы, деньги или рабочих</a><br/>\r\n");
  printrus("<a href=\"shop.php?m=save&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Сохранить страну</a><br/>\r\n");
  printrus("<a href=\"shop.php?m=addznc&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Поставить значок в ассамблее</a><br/>\r\n");
  printrus("<a href=\"shop.php?m=unite&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Купить союз</a><br/>\r\n");
  printrus("<a href=\"shop.php?m=gena&amp;$ses\"><img src=\"/img/ico/arrow-right.png\" alt=\"\" /> Эликсир молодости для генерала</a><br/>\r\n");
  }

break;

case('addfunds'):
printrus("<a href='https://unitpay.ru/pay/24940-5fcf8?sum=10&account=".$userID."&hideHint=true&hideBackUrl=true&hideLogo=true&hideOrderCost=true&desc=10+кредитов+для+".$userID." (".$login.")'>Купить 10 кредитов</a><br/>");

printrus("<a href='https://unitpay.ru/pay/24940-5fcf8?sum=20&account=".$userID."&hideHint=true&hideBackUrl=true&hideLogo=true&hideOrderCost=true&desc=20+кредитов+для+".$userID." (".$login.")'>Купить 20 кредитов</a><br/>");

printrus("<a href='https://unitpay.ru/pay/24940-5fcf8?sum=50&account=".$userID."&hideHint=true&hideBackUrl=true&hideLogo=true&hideOrderCost=true&desc=50+кредитов+для+".$userID." (".$login.")'>Купить 50 кредитов</a><br/>");

printrus("<a href='https://unitpay.ru/pay/24940-5fcf8?sum=100&account=".$userID."&hideHint=true&hideBackUrl=true&hideLogo=true&hideOrderCost=true&desc=100+кредитов+для+".$userID." (".$login.")'>Купить 100 кредитов</a><br/>");

printrus("<a href='https://unitpay.ru/pay/24940-5fcf8?sum=450&account=".$userID."&hideHint=true&hideBackUrl=true&hideLogo=true&hideOrderCost=true&desc=500+кредитов+для+".$userID." (".$login.")'>Купить 500 кредитов</a><br/>");

printrus("<a href='https://unitpay.ru/pay/24940-5fcf8?sum=900&account=".$userID."&hideHint=true&hideBackUrl=true&hideLogo=true&hideOrderCost=true&desc=1000+кредитов+для+".$userID." (".$login.")'>Купить 1000 кредитов</a><br/>");
printrus("------<br/>Имейте в виду, что закупиться в магазине можно максимум на 1000 кредитов в день.<br/>");

break;


case('moratory'):

if($vip == 0){
printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
}else{
if (isset($go)){
if ($days<=3)$need=$days*4;
else $need=round($days*4*1);
}

if (!isset($go)){
printrus("Стоимость часового моратория - 4 золота за час. При покупке более, чем на 3 часа действует
скидка 10%. Обратите внимание, что мораторий будет действовать также, как и ночной, т.е., если
у вас в стране есть вторжение, атакующий сможет атаковать вас и дальше, но никто другой
напасть на вас не сможет. Снять мораторий до истечения его срока вы не сможете. Купить новый мораторий
можно только через час после окончания старого!<br/>\r\n");
printrus("На сколько часов покупаем?<br/>\r\n");
printrus
("<form action='shop.php?$ses' method='post'>
<input format='*N' maxlength='4' name='days' /><br/>
<button type='submit'>Купить</button>
<input type='hidden' name='m' value='moratory'/>
<input type='hidden' name='go' value='go'/>
</form><br/>
");
}elseif($days<=0||!isset($days)){
printrus("Укажите целое положительное число часов<br/>");
}elseif($b['moratory']>time()-3600){
printrus("Мораторий можно вновь купить только по прошествии часа после окончания предыдущего!<br/>");
}elseif(!isset($sure)){
printrus("Вы уверены, что хотите приобоести мораторий на $days час (это будет стоить $need золота)?<br/>");
printrus
("<form action='shop.php?sure&amp;$ses' method='post'>
<button type='submit'>Да</button>
<input type='hidden' name='m' value='moratory'/>
<input type='hidden' name='go' value='go'/>
<input type='hidden' name='days' value='$days'/>
</form><br/>
");
printrus
("<form action='shop.php?$ses' method='post'>
<button type='submit'>Отмена</button>
<input type='hidden' name='m' value='moratory'/>
</form><br/>
");
}elseif($credits<$need){
printrus("У вас недостаточно золота на счету (необходимо $need)!<br/>");
}elseif($spent+$need>1000){
printrus("Извините, вы не можете сделать покупок более, чем на 1000 золота в сутки! Сумма за сутки обнуляется в 5 утра по Москве.<br/>");
}else{
mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");

mysql_query("UPDATE `countries` SET moratory = '".(time()+$days*3600)."' WHERE countryID = '".$countryID."' LIMIT 1");
$b['moratory'] = time()+$days*3600;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,3600);
      }
printrus("Вы купили мораторий на <b>$days</b> час! С вашего счета списано <b>$need</b> золота.<br/>");

$open=fopen("logs/magaz".$countryID,"a+");
@flock ($open,LOCK_EX);
@fwrite($open,$b['countryName']."купил мораторий на $days суток. Потратил $need золота.\n");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);

}
}

break;



case('unite'):
if($vip == 0){
printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
}else{
$need=100;

    if (isset($go)){

  if($spent+$need>1000)
    {printrus('Вы исчерпали суточный лимит! Максимально разрешается потратить не более <b>1000</b> золота в сутки.<br />'); $error++;}
  if($credits<$need AND $error == 0)
    {printrus('У Вас недостаточно золота, требуется <b>'.$need.'</b> золота!<br />');  $error++;}
  if ( (count_unite($countryID) + $b['unites'] > 1 ) AND $error == 0)
    {printrus('Союз можно купить, только если у вас остался 1 незаключенный союз или 1 союзник, но не всё вместе. Либо если ничего не осталось.');  $error++;}

if ($error == 0)
{
    mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");
    $query="UPDATE `countries` SET unites = unites + 1 WHERE countryID = '$countryID' LIMIT 1";
    $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
    $b['unites']++;
    if ($id_m==TRUE){
    $memcache->set($key1,$b,false,86400);
    }
    printrus("Дополнительный союз куплен.");
}

    }
else
{
    printrus("Союз стоит 100 золота, покупаем?<br/>\r\n");
    printrus("<a href=\"shop.php?m=unite&amp;go=go&amp;$ses\">Да.</a><br/>\r\n");
}
}

break;




case('gena'):

if($vip == 0){
printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
}else{
if (isset($go)){
    $price = 20;
    $need = round(0.49999+$amount*$price);
    $general=general_info($countryID);
}

if (!isset($go))
{
    printrus("На сколько лет будем омолаживать генерала:<br/>\r\n");
    printrus("Стоимость 1 года 20 золота!:<br/>\r\n");
    printrus("<form name=\"\" action=\"shop.php?m=gena&amp;go=go&amp;$ses\" method=\"post\">
    <input format='*N' maxlength='7' name='amount' /><br/>");
    printrus("<input type=\"submit\" value=\"Омолодить\"/>
    </form>");
}
elseif (!isset($amount)||$amount<=0){
printrus("Укажите целое положительное количество лет, на которые омолодить генерала!<br/>");
}
elseif($general[age] == 0)
{
    printrus("У вас нет генерала!<br/>");
}
elseif($general[age] - $amount < 16)
{
    printrus("Извините, вы не можете омолодить генерала младше 16 лет!<br/>");
}
elseif($credits<$need)
{
    printrus("У вас недостаточно золота на счету (необходимо $need)!<br/>");
}
elseif($spent+$need>1000)
{
    printrus("Извините, вы не можете сделать покупок более, чем на 1000 золота в сутки! Сумма за сутки обнуляется в 5 утра по Москве.<br/>");
}
else
{


    mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");




    mysql_query("UPDATE general SET age = age - $amount WHERE countryID = '".$b['countryID']."'");
   $key=_PREFIKS.':general'.$countryID;
   if (($mem=$memcache->get($key))!==FALSE){
      $mem['age'] = $mem['age']-$amount;
      $memcache->set($key,$mem,false,86400);
      }



    printrus("Вы омолодили генерала($general[age]) на <b>$amount</b> лет. Потрачено золота: <b>$need</b><br/>\r\n");

    $open=fopen("logs/magaz".$countryID,"a+");
    @flock ($open,LOCK_EX);
    @fwrite($open,$b['countryName']." омолодил генерала на $amount лет в магазине. Потратил $need золота.\r");
    @fflush($open);
    @flock ($open,LOCK_UN);
    @fclose($open);


}
}

break;




case('addznc'):

if($vip == 0){
printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
}else{
printrus("<a href=\"shop.php?m=seeznc&amp;$ses\">Посмотреть доступные значки</a><br/>\r\n");
printrus("<a href=\"shop.php?m=takeznc&amp;$ses\">Поставить значок</a><br/>\r\n");
}

break;
case('seeznc'):
if($vip == 0){
printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
}else{
//ВЫводим значки из каталога /znc

$directory = _ROOT.'/znc/'; //папка, которую сканируем
$array = array('.', '..','lapa.gif','index.php','106.gif','13.gif'); //массив со значениями, которые нужно исключить из результатов сканирования папки
$contents = array_diff(scandir($directory), $array);
$cnt=count($contents);
$g=0;
for($i=$see;$i<$cnt;$i++){

if($g<10){
if($contents[$i]!=''){
	$g++;
	$cx=explode(".",$contents[$i]);
echo '<img src="../znc/'.$contents[$i].'"/>-(<i><b>'.$cx[0].'</b></i>)<br />';
}
}else{
printrus("<a href=\"shop.php?m=seeznc&amp;cnt=$i&amp;$ses\">Далее</a><br/>\r\n");
break;
}
}

}

break;


case('takeznc'):

if($vip == 0){
printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
}else{
if(isset($_REQUEST['yes']))$gooo=2;else $gooo=1;
if($gooo==1){
if($vip == 0){printrus("Установка картинки = 100 золота!<br/><br/>");}
printrus("Введите номер понравившейся Вам картинки:<br/>\n");
printrus ("<form name=\"\" action=\"shop.php?m=takeznc&amp;yes&amp;$ses\" method=\"post\">
<input name=\"indeximg\" maxlength=\"10\" title=\"Text\" value=\"\"/><br/>\n
<input type=\"submit\" value=\"Поставить значок\"/>
</form>");

}else{
	$need=100;

	$_REQUEST['indeximg']=addslashes($_REQUEST['indeximg']);
 if(!is_readable(''._ROOT.'/znc/'.$_REQUEST['indeximg'].'.gif') or $_REQUEST['indeximg']=='index'){printrus('Этого значка не существует!<br />');}
  elseif($spent+$need>1000){printrus('Вы исчерпали суточный лимит! Максимально разрешается потратить не более <b>1000</b> золота в сутки.<br />');}
  elseif($credits<$need){printrus('У Вас недостаточно золота, требуется <b>'.$need.'</b> золота!<br />');}
   else{
printrus('Значок поставлен.<br />');

mysql_query("delete from `znc`  WHERE id=".$userID." LIMIT 1");
mysql_query("insert into `znc` SET url='".$_REQUEST['indeximg']."',id='".$userID."'");
if($vip == 0){mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");}

}

}
}

break;



case('res'):

if($vip == 0){
printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
}else{
if (isset($go)){
if ($res==0) $price = 300;
elseif($res==1) $price = 20;
elseif($res==2) $price = 35;
elseif($res==3) $price = 50;
elseif($res==4) $price = 200;
elseif($res==5) $price = 13;
elseif($res==6) $price = 10;
else $price=9999;
$need = round(0.49999+$amount/$price);
$free_place = free_place($countryID);
}

if (!isset($go)){
printrus("Установленная банковская стоимость ресурсов, за 1 кредит:<br/>");
printrus("<b>300</b> денег<br/>");
printrus("<b>20</b> железа<br/>");
printrus("<b>35</b> камня<br/>");
printrus("<b>50</b> дерева<br/>");
printrus("<b>200</b> зерна<br/>");
printrus("<b>13</b> нефти<br/>");
printrus("<b>10</b> рабочих<br/>");
printrus("<form action='shop.php?$ses' method='post'>");
printrus("Количество покупаемых ресурсов:<br/>\r\n");
printrus("<input format='*N' maxlength='7' name='amount' /><br/>");

printrus ("Ресурс:<select name='res'>\n");
printrus ("<option value=\"0\">деньги</option>\n");
printrus ("<option value=\"1\">железо</option>\n");
printrus ("<option value=\"2\">камень</option>\n");
printrus ("<option value=\"3\">дерево</option>\n");
printrus ("<option value=\"4\">зерно</option>\n");
printrus ("<option value=\"5\">нефть</option>\n");
printrus ("<option value=\"6\">рабочие</option>\n");
printrus ("</select><br/>\n");

printrus
("
<button type='submit'>Купить</button>
<input type='hidden' name='m' value='res'/>
<input type='hidden' name='go' value='go'/>
</form><br/>
");
}elseif ((!isset($res)||($res!=0&&$res!=1&&$res!=2&&$res!=3&&$res!=4&&$res!=5&&$res!=6))||(!isset($amount)||$amount<=0)){
printrus("Выберите ресурс и укажите целое положительное его количество!<br/>");
}elseif($credits<$need){
printrus("У вас недостаточно кредитов на счету (необходимо $need)!<br/>");
}elseif($spent+$need>1000){
printrus("Извините, вы не можете сделать покупок более, чем на 1000 кредитов в сутки! Сумма за сутки обнуляется в 5 утра по Москве.<br/>");
}elseif(($free_place<$amount)&&($res==1||$res==2||$res==3||$res==4||$res==5)){
printrus("У вас недостаточно места на складе. Освободите место.<br/>");
}else{

mysql_query("UPDATE `uzers` SET credits = credits - $need, spent = spent + $need WHERE userID = '$userID' LIMIT 1");

if ($res==0){
mysql_query("UPDATE `countries` SET money=money+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['money'] = $b['money']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='денег';
}

if ($res==1){
mysql_query("UPDATE `countries` SET iron=iron+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['iron'] = $b['iron']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='железа';
}

if ($res==2){
mysql_query("UPDATE `countries` SET stone=stone+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['stone'] = $b['stone']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='камня';
}

if ($res==3){
mysql_query("UPDATE `countries` SET arbor=arbor+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['arbor'] = $b['arbor']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='дерева';
}

if ($res==4){
mysql_query("UPDATE `countries` SET grain=grain+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['grain'] = $b['grain']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='зерна';
}

if ($res==5){
mysql_query("UPDATE `countries` SET oil=oil+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['oil'] = $b['oil']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='нефти';
}

if ($res==6){
mysql_query("UPDATE `countries` SET workers=workers+$amount WHERE countryID = '".$countryID."' LIMIT 1");
$b['workers'] = $b['workers']+$amount;
  if ($id_m==TRUE){
      $memcache->set($key1,$b,false,86400);
      }
$s='рабочих';
}

printrus("Вы купили <b>$amount</b> $s. Потрачено кредитов: <b>$need</b><br/>\r\n");

$open=fopen("logs/magaz".$countryID,"a+");
@flock ($open,LOCK_EX);
@fwrite($open,$b['countryName']."купил $amount $s в магазине. Потратил $need кредов.\r");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);


}
}

break;

case('save'):

if($vip == 0){
printrus("Вам нужен VIP статус для совершения покупок в магазине.<br/>\r\n");
}else{
if (!isset($go)){
printrus("Эта опция позволяет вам \"сохранить\" страну на любом этапе развития. Далее, если вашу
страну убьют, вы через некоторое время сможете восстановить те параметры страны, которые были на
момент сохранения, и появитесь среди приблизительно так же развитых стран. Стоимость сохранения
- 50 кредитов.<br/>");
printrus("<a href=\"shop.php?m=about_save&amp;$ses\">Подробнее</a><br/>\r\n");
printrus("********<br/>");
printrus("<a href=\"shop.php?m=save&amp;go&amp;$ses\">Сохранить</a><br/>\r\n");
}elseif($credits<50){
printrus("У вас недостаточно кредитов на счету (необходимо 50)!<br/>");
}else{
$r = mysql_query("SELECT * FROM `saves` WHERE userID = '".$_SESSION['userID']."' LIMIT 1");
$a = mysql_fetch_array($r);
$num = mysql_num_rows($r);
if($us['vip'] == 1){$time_save=172800-(172800*$vip_save/100);}else{$time_save=172800;}
if (time()-$a['lastSave']>$time_save){

if ($num!=0){
//Удаляем предыдущее сохранение
mysql_query("DELETE FROM `buildings_save` WHERE countryID = '".$a['countryID']."'");

mysql_query("DELETE FROM `countries_save` WHERE countryID = '".$a['countryID']."'");

mysql_query("DELETE FROM `general_save` WHERE countryID = '".$a['countryID']."'");

mysql_query("DELETE FROM `works_save` WHERE countryID = '".$a['countryID']."'");
}
//Сохраняем здания
mysql_query("INSERT INTO `buildings_save` (SELECT * FROM `buildings` WHERE countryID = '".$countryID."')");
//Меняем времена
mysql_query("UPDATE `buildings_save` SET var1 = ".time()." - var1 WHERE countryID = '".$countryID."' and building = 'neftevxwka' LIMIT 1");
//Сохраняем основные параметры страны:
mysql_query("INSERT INTO `countries_save` (SELECT * FROM `countries` WHERE countryID = '".$countryID."' LIMIT 1)");
//Меняем в сохранении необходимые времена
mysql_query("UPDATE `countries_save` SET reggedTime = ".(time()-$b['reggedTime']).", lastNal = ".(time()-$b['lastNal']).", lastWar = ".(time()-$b['lastWar'])." WHERE countryID = '".$countryID."' LIMIT 1");
//Сохраняем генерала
mysql_query("INSERT INTO `general_save` (SELECT * FROM `general` WHERE countryID = '".$countryID."' LIMIT 1)");
//Сохраняем работы
mysql_query("INSERT INTO `works_save` (SELECT * FROM `works` WHERE countryID = '".$countryID."')");
//Меняем времена
mysql_query("UPDATE `works_save` SET started = ".time()." - started, finished = finished - ".time()." WHERE countryID = '".$countryID."'");

if ($num==0){
mysql_query("INSERT INTO `saves` SET userID = '".$_SESSION['userID']."', countryID = '$countryID', lastSave = '".time()."'");
}else{
mysql_query("UPDATE `saves` SET countryID = '$countryID', lastSave = '".time()."' WHERE userID = '".$_SESSION['userID']."' LIMIT 1");
}
mysql_query("UPDATE `uzers` SET credits = credits - 50, spent = spent + 50 WHERE userID = '$userID' LIMIT 1");
$open=fopen("logs/magaz".$countryID,"a+");
@flock ($open,LOCK_EX);
@fwrite($open,date("H:i j.m:").$b['countryName']."сохранил страну. Потратил 50 кредов.\r");
@fflush($open);
@flock ($open,LOCK_UN);
@fclose($open);
printrus("Ваша страна успешно сохранена!<br/>");
}else{
printrus("Сохранение возможно только по прошествии минимум 2 суток после последнего сохранения! Подождите ".mkTimeStr($time_save-(time()-$a['lastSave']))."<br/>");
}

}
}

break;

case('about_save'):
printrus("При сохранении <u>НЕ</u> запишутся следующие параметры страны:<br/>
1. Ваши войны. Позаботьтесь о том, чтобы в момент сохранения как можно меньше военных находилось
в войнах на территории других государств, эти военные <u>не сохранятся</u><br/>
2. Ваши союзы. Также общее число возможных союзов не изменится (то есть, если вы потратили до
сохранения оба союза, новых не прибавится после восстановления).<br/>
3. Ваши соседи. Естественно, они поменяются при восстановлении, и следующим образом: если, допустим,
у вас была при сохранении страна 10-ти дневного развития, то вам дадут соседей также 10-ти дневного
развития <u>на момент восстановления</u> страны<br/>
4. Открытия и мораторий. Случайные открытия и купленный мораторий не сохраняются.<br/>
5. Клан. Клановая принадлежность не сохранится.<br/>
ВСЕ остальные параметры страны будут точно такими же, как и на момент сохранения. Обратите внимание,
что восстановление стоит 50 кредитов и оно возможно лишь по прошествии некоторого времени после
убийства страны (это время зависит от того, насколько развита была ваша страна). Повторное сохранение
возможно минимум через 2ое суток после предыдущего.<br/>");
break;

endswitch;

}

//=============================================================================//Конец скрипту================================================================print "---<br/>\r\n";
/*printrus
("
<a href='game.php?$ses'>&lt;&lt;В игру</a>
<br/>
");
printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");*/
//футер страницы:
include_once("other_inc/footer.php");
?>