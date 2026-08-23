
<?php
function count_unite($countryID)
{
    $query="select count(*) as num from `unite` where countryID='$countryID' limit 1";
     $result=@MYSQL_QUERY($query);
    $a = mysql_fetch_array($result);
    $num=$a['num'];
    return $num;
}


function getAllArtefacts($countryID)
{
   $q=mysql_query("SELECT id,name,researched FROM artefacts WHERE countryID = '$countryID'");
   while ($t=mysql_fetch_array($q))
   {
       $allArts[]=$t;
   }

return $allArts;
}


function artefactName($artefact)
{
$names['sapog']='Кирзовый сапог';
$names['lions_shield_of_courage']='Львиный щит бесстрашия: +200% сила и +100% скорость пехоты';
$names['podkova']='Стальная подкова';
$names['puli']='Бронебойные пули';
$names['podrivnoe_delo']='Брошюра подрывное дело';
$names['avia_pulemet']='Авиа пулемёт';
$names['pogon']='Генеральский погон';
$names['yadro']='Чугунное ядро';
$names['the_artillery_fire']='Артиллерийская стрельба';
$names['pult']='Пульт с дистанционным управлением';
$names['angel_wings']='Ангельские крылья';
$names['dragon_scale_shield']='Щит из чешуи дракона';
$names['red_dragon_flame_tongue']='Языки пламени Красного Дракона';
$names['teh_volshebstvo']='Техническое волшебство';
$names['kniga_taktiki']='Учебник по тактике';
$names['medal']='Медаль за храбрость';
$names['crest_of_valor']='Герб Доблести';
$name=$names[$artefact];
    return $name;
}

function artefactById($id){
$a=mysql_fetch_array(mysql_query("SELECT name FROM artefacts WHERE id=$id"));
return $a[0];
}





function artefactFormat($artefact, $value)
{
global $ses;
return '<a href="/artefacts.php?' . $ses . '&amp;artefact='.$artefact.'">'. "(+" . round($value) . ")" .'</a>';
}



function giveArtefact($countryID)
{
global $b;



$x=$b['artefakt'] * 0.1;

     $r=mt_rand(0,5/$x);
    if ($r==0)
        $artefact='sapog';

     $r=mt_rand(0,10/$x);
    if ($r==0)
       $artefact='podkova';

     $r=mt_rand(0,10/$x);
    if ($r==0)
        $artefact='podrivnoe_delo';

     $r=mt_rand(0,10/$x);
    if ($r==0)
        $artefact='avia_pulemet';

    $r=mt_rand(0,10/$x);
    if ($r==0)
        $artefact='pogon';

    $r=mt_rand(0,15/$x);
    if ($r==0)
        $artefact='puli';

    $r=mt_rand(0,50/$x);
    if ($r==0)
        $artefact='yadro';

        $r=mt_rand(0,50/$x);
    if ($r==0)
        $artefact='the_artillery_fire';

    $r=mt_rand(0,100/$x);
    if ($r==0)
         $artefact='medal';

    $r=mt_rand(0,150/$x);
    if ($r==0)
         $artefact='pult';

         $r=mt_rand(0,150/$x);
    if ($r==0)
        $artefact='kniga_taktiki';
                                     //новые артефакты

    $r=mt_rand(0,30/$x);
    if ($r==0)
         $artefact='lions_shield_of_courage';

    $r=mt_rand(0,40/$x);
    if ($r==0)
         $artefact='teh_volshebstvo';

         $r=mt_rand(0,50/$x);
    if ($r==0)
         $artefact='dragon_scale_shield';

          $r=mt_rand(0,60/$x);
    if ($r==0)
         $artefact='red_dragon_flame_tongue';

         $r=mt_rand(0,70/$x);
    if ($r==0)
         $artefact='angel_wings';

         $r=mt_rand(0,80/$x);
    if ($r==0)
         $artefact='crest_of_valor';




    if ($artefact <> '')
    {
        $c=mysql_num_rows(mysql_query("SELECT * FROM artefacts WHERE name='$artefact' and countryID='$countryID'"));
        if ($c==0)
        {
            mysql_query("INSERT INTO artefacts SET name='$artefact', countryID='$countryID'");
            $name=artefactName($artefact);
            sendMessage($countryID,'fullMessage',"Разрушив вражеское здание, вы нашли в руинах артефакт $name");
            return ("Ваши археологи обнаружили в руинах здания неизвестный АРТЕФАКТ!<br/>");
        }
    }

return 0;
}



function isArtefact($countryID,$artefact)
{
    $c=mysql_num_rows( mysql_query("SELECT id FROM artefacts WHERE countryID = '$countryID' AND name = '$artefact' AND researched=1") );
    if ($c>1)
    $c=1;
    return $c;
}


/*
function time_new(){
    global $gametime;
    if ($gametime['type'] == 'back'){
        $nt=time()- $gametime[0];
    }
    else{
        $nt=time()+ $gametime[0];
    }
    return $nt;
}

function date_new($d){
return date($d,time_new());
}

function microtime_new(){
   list($usec, $sec) = explode(chr(32), microtime());
   return ((float)$usec . ' ' . time_new());
}
*/
function time_new(){
    return time();
}

function date_new($d){
return date($d);
}

function microtime_new(){
   return microtime();
}

function checkPassword($oldpassword){
	$uid=(int)$_SESSION['userID'];
	$oldpassword=md5($oldpassword);
	$data=mysql_fetch_array(mysql_query("SELECT COUNT(userID) AS c FROM uzers WHERE password='$oldpassword' AND userID='$uid'"));
	if ($data['c'] >= 1)
		return TRUE;

	return FALSE;
}







function FarmName()
{
$rand=rand(0,106);
$name=array('Абрикос','Агасфер','Акакий','Амфибрахий','Анискин','Апельсин','Арамис','Арахис','Арбузик','Ахиллес','Багет','Базиль','Бакс','Банан','Банкет','Бантик','Батон','Барон','Басик','Бегемот','Беляш','Бертрам','Бертран','Бином','Бифштекс','Блинчик','Болтик','Бонифаций','Борман','Борменталь','Ботан','Ботаник','Боцман','Бублик','Буффон','Брысь','Бьютик','Бэтмен','Василёк','Веник','Веник','Венчик','Веня','ВинДизель','Винтик','Винчестер','Вискас','Витас','Гаврош','Гамлет','Гарсон','Гермес','Гвоздик','Гоблин','Говорун','Гога','Гордей','Гоша','Гребешок','Гриня','Гриф','Градус','Гугол','Гудвин','Гуляш','Гюнтер','Дай','Дай','Демьян','Динамит','Джобс','Доллар','Дон','Дормидонт','Дукалис','Дымок','Евсей','Ёжик','Ершик','Живчик','Жоржик','Жюль','Жюльен','Заяц','Зайчик','Зеро','Зефир','Зонтик','Изюмчик','Иван Иваныч','Каспер','Карандаш','Кардан','Кащей','Квас','Кекс','Клаус','Коготок','Колокольчик','Коржик','Корнелиус','Костик','Котангенс','Коттон','Коша','Кочубей','Кроль');

return $name[$rand];
}

function ChatAntiSpam()
{
$rand=rand(0,10);
  $mess=array(
  'WarOFfouR  игра за с четырьмя расами, и классами?',
  'Говорят что Война Четырех это новая игра не похожая не на одну игру в стиле цивилизация )',
  'В Война Четырех есть классы?',
  'Я играю за расу Человек у них есть здание ферма? в помощи есть пойду почитаю Все о расах и классах',
  'Я играю за расу Демоны у них есть здание Алтарь Смерти? в помощи есть пойду почитаю Все о расах и классах',
  'Я играю за расу Гномы у них есть здание Подземелье? в помощи есть пойду почитаю Все о расах и классах',
  'Я играю за расу Нежить у них есть здание Некрополь? в помощи есть пойду почитаю Все о расах и классах',
  'Гномы могут делать артефакты',
  'Демоны могут приносить в жертву население за вознаграждения',
  'Нежить могут оживлять мертвых воинов',
  'Человек разводит скот  и продает сельхоз продукты'
  );

return $mess[$rand];
}









 function logs($countryName,$targetName,$log){
		$countryName=mysql_real_escape_string($countryName);
		$targetName=mysql_real_escape_string($targetName);
		$log=mysql_real_escape_string($log);
        mysql_query("INSERT INTO `logs` (`countryName`, `targetName`, `log`) VALUES  ('".$countryName."', '".$targetName."',  '".$log."')");
    }

//view log

	function countLogs(){
		$data=mysql_fetch_array(mysql_query("SELECT COUNT(*) AS c FROM logs"));
		return $data['c'];
	}

    function viewlogs(){
	global $b;
	$countryName=mysql_real_escape_string($b[1]);
	$result = mysql_query("SELECT * FROM `logs` WHERE countryName = '$countryName' LIMIT 10");
    //$result = mysql_query("SELECT * FROM `logs` LIMIT 10");
    if($result){
        $i = 0;
            while($row = mysql_fetch_assoc($result)){
                switch ($row['check']){
                    case 0: $check = "<a style='color:#F4A460' href=logs_view.php?action=review&ID=".$row['ID']."> Отправить на проверку</a>";
                            break;
                    case 1: $check = " - <span style='color:#fffacd'>Запрос принят</span>";
                            break;
                    case 2: $check = " - <span style='color:#7fffd4'>Проверено</span>";
                            break;
                }
                $data[$i++] = array('targetName'=>$row['targetName'],
                                    'check'=>$check,
                                    'log'=>$row['log']);
            }
        }
    return $data;
    }
//change column check = 1
    function review($IDlogs){
		global $b;
		$countryName=mysql_real_escape_string($b[1]);
		$IDlogs=mysql_real_escape_string($IDlogs);
        mysql_query("UPDATE `logs` SET `check` = 1 WHERE `ID` = '$IDlogs' AND countryName = '$countryName'");
		if (mysql_affected_rows() == 0){
			printrus("Ошибка! Заявка не проверку захвата не была отправлена модератору.");
			die();
		}

        header("Location: logs_view.php?action=view");
    }

//view logs
function checked($IDlogs = null){
	$IDlogs=mysql_real_escape_string($IDlogs);
    if($IDlogs){
        mysql_query("UPDATE `logs` SET `check` = 2 WHERE `ID` = '$IDlogs'");

		if (mysql_affected_rows() == 0){
			printrus("Ошибка! Этот захват уже проверил другой модератор.");
			die();
		}
		$result = mysql_query("SELECT `countryID` FROM `countries` LEFT JOIN `logs` USING(`countryName`) WHERE `ID` = ".$IDlogs);
        $row = mysql_fetch_assoc($result);
        sendMessage($row['countryID'],"Admin","Ваш лог проверен");
		printrus("<b>Захват проверен.</b><br/><br/>");
    }
    $result = mysql_query("SELECT * FROM `logs` WHERE `check` = 1");
    if($result){
        $i = 0;
        while($row = mysql_fetch_assoc($result)){
            $data[$i++] = array('ID' => $row['ID'],
                                'countryName' => $row['countryName'],
                                'targetName' => $row['targetName'],
                                'log' => $row['log']);
        }
    return $data;
    }
}


 function UzersInfo($countryID){
 //Получение инфы о профиле с id=countryID на основе БД
 $countryID = addslashes($countryID);
 $query = "SELECT * FROM uzers WHERE countryID = '".$countryID."'";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $a = mysql_fetch_array($result);
 return $a;
 }


function isNewBuildings($countryID,$bld)
{
global $memcache;

$key=_PREFIKS.':buildings'.$countryID;
 if (($mem=$memcache->get($key))!==FALSE){
    for ($i=0;$i<count($mem);$i++) if ($mem[$i]['building']==$bld){
    $z['time_uz'] = $mem[$i]['time_uz'];
    $z['time_sac'] = $mem[$i]['time_sac'];
    $z['un_1'] = $mem[$i]['un_1'];
    $z['un_2'] = $mem[$i]['un_2'];
    $z['un_3'] = $mem[$i]['un_3'];
    $z['un_4'] = $mem[$i]['un_4'];
    $z['un_5'] = $mem[$i]['un_5'];
    $z['un_6'] = $mem[$i]['un_6'];
    $z['un_7'] = $mem[$i]['un_7'];
    $z['oun_1'] = $mem[$i]['oun_1'];
    $z['oun_2'] = $mem[$i]['oun_2'];
    $z['oun_3'] = $mem[$i]['oun_3'];
    $z['oun_4'] = $mem[$i]['oun_4'];
    $z['oun_5'] = $mem[$i]['oun_5'];
    $z['oun_6'] = $mem[$i]['oun_6'];
    $z['oun_7'] = $mem[$i]['oun_7'];
    break;
    }
 }
 else
 {
 $query="select * from `buildings` where countryID='$countryID' and building='$bld' limit 1";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));
 $z = mysql_fetch_array($result);
 }

return $z;
}

?>