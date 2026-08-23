<?
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}
//Обработка переменных:
if (isset($_REQUEST['countryID'])) $countryID = $_REQUEST['countryID'];

//==============================================================================
//подключаем скрипты

define('IN_CLV',true);
@include_once("func/functions_clv.php");
mem_connect();

sesinit();
//worksRefresh($_SESSION['countryID']);

//шапка:
@include_once("other_inc/header.php");
$countryID = $_SESSION['countryID'];

//==============================================================================
//Рабочая часть скрипта=========================================================

 $key1=_PREFIKS.':id'.$countryID;
 if (($ma=$memcache->get($key1))!==FALSE) $id_m = TRUE; else $id_m = FALSE;

 if ($id_m==TRUE){
    $b=$ma;
    }else{
 $query="select * from `countries` where countryID='$countryID' limit 1";
 $result=@MYSQL_QUERY($query);
 $b = mysql_fetch_array($result);
 }


//******************************************************************************
//проверка на валидность идентификатора:****************************************

 if(isset($_SESSION['auth'])){
  //syncses($_SESSION['countryID']);
  $tm = date_new(U);
  mysql_query("UPDATE uzers SET onlineFlag = ($tm+600) WHERE countryID = '".$b['countryID']."' LIMIT 1");
 }else{
  printrus ("<b>!</b>ВЫ НЕ АВТОРИЗИРОВАНЫ!<b>!</b><br/>\r\n");

  printrus ("<a href='unlogin.php?$ses'>Главная</a><br/>\r\n");
  //футер страницы:
  include_once("other_inc/footer.php");

  die("");
 }


//******************************************************************************
//Выводим артефакты*****************************************

if ($_GET[cit] == 'art'){
printrus ("<u>Артефакты:</u><br/>\r\n");

$q=mysql_query("SELECT id,name,researched,expiriense,moral FROM artefacts WHERE researched='1' and countryID = '$countryID'");
   while ($t=mysql_fetch_array($q))
   {
   $allArts[]=$t;
   }
$c=count($allArts);

  for ($i=0; $i<$c; $i++)
  {
    if ($allArts[$i][name] == 'kniga_taktiki'){
	printrus("".($i+1).")Учебник по тактике [+200 к навыку]<br/>\r\n");
    }
    elseif ($allArts[$i][name] == 'medal'){
	printrus("".($i+1).")Медаль за храбрость [+30 морали]<br/>\r\n");
	}
	 elseif ($allArts[$i][name] == 'crest_of_valor'){
	printrus("".($i+1).")Герб Доблести:  +5000 опыта генералу<br/>\r\n");
    }
    elseif ($allArts[$i][name] == 'dragon_scale_shield'){
	printrus("".($i+1).")Щит из чешуи дракона [+50 морали]<br/>\r\n");
    }
    elseif ($allArts[$i][name] == 'pogon'){
	printrus("".($i+1).")Генеральский погон [+1..3 морали за крупную битву (больше 10000 опыта)]<br/>\r\n"); /*$artp=1;*/ $expirienseST=$allArts[$i][expiriense]; $moralST=$allArts[$i][moral];
	printrus("опыта ($expirienseST) добавлено морали ($moralST)<br/><br />\r\n");
    }
  }




//if ($artp == 1){printrus("<br />опыта ($expirienseST) добавлено морали ($moralST)<br/>\r\n");}

if ($c == 0)
printrus("У вас пока нет артефактов.<br/>\r\n");
}

//******************************************************************************
//Выводим артефакты***********цитадели******************************

elseif ($_GET[cits] == 'arts'){
printrus ("<u>Артефакты:</u><br/>\r\n");

$q=mysql_query("SELECT id,name,researched,expiriense,moral FROM artefacts WHERE researched='1' and countryID = '$countryID'");
   while ($t=mysql_fetch_array($q))
   {
   $allArts[]=$t;
   }
$c=count($allArts);

  for ($i=0; $i<$c; $i++)
  {
    if ($allArts[$i][name] == 'crest_of_valor'){
	printrus("".($i+1).")Сидит мальчик на травке играет в машинку. Как вдруг у машинки колёса отвалились. Мальчик сидит плачет. Мимо проходил наркоман, услышал плачь мальчика, подошёл и спросил: -Ты чё плачешь? -Я колёса потерял! -Ну пойдём со мной, я тебе свои дам! -Нет, мне мама сказала на травке сидеть! -Блин, мне бы такую маму.<br/>\r\n");
    }

  }



//if ($artp == 1){printrus("<br />опыта ($expirienseST) добавлено морали ($moralST)<br/>\r\n");}

if ($c == 0)
printrus("У вас пока нет артефактов.<br/>\r\n");
}

elseif ($_GET[artefact] == ''){

printrus ("<u>Артефакты:</u><br/>\r\n");
$allArts=getAllArtefacts($b['countryID']);

$c=count($allArts);


  $query="select * from `works` where countryID='$countryID' and kind='science' and what='art' limit 1";
  $result=MYSQL_QUERY($query);
  $num=@mysql_num_rows($result);
  $result=mysql_fetch_array($result);

for ($i=0; $i<$c; $i++)
{
	if ($allArts[$i][researched] == 1){
    $name=artefactName($allArts[$i][name]);
    printrus('<a href="/artefacts.php?artefact=' . $allArts[$i][name] . "&$ses" . '">' . $name . "</a><br/>\r\n");
	}
	else{
	printrus("Незвестный артефакт ");
	if ($num == 0)
	printrus('<a href="/buildings/scientificcenter.php?m=art&amp;aid=' . $allArts[$i][id] . "&$ses" . '">' . '[исследовать]' . "</a>");
	if ($result[var2] == $allArts[$i][id])
	printrus('(исследуется...)');
	printrus("<br/>\r\n");
	}
}

if ($c == 0)
printrus("У вас пока нет артефактов.<br/>\r\n");

//$k=giveArtefact($b['countryID']);

}

elseif ($_GET[artefact] == 'sapog'){
	printrus("Кирзовый сапог: +50% сила и +50% скорость пехоты<br/>\r\n");
}

elseif ($_GET[artefact] == 'lions_shield_of_courage'){
	printrus("Львиный щит бесстрашия: +200% сила и +100% скорость пехоты<br/>\r\n");
}

elseif ($_GET[artefact] == 'podkova'){
	printrus("Стальная подкова: +50% сила и +50% скорость кавалерии<br/>\r\n");
}
elseif ($_GET[artefact] == 'red_dragon_flame_tongue'){
	printrus("Языки пламени Красного Дракона: +100% скорости кавалерии<br/>\r\n");
}

elseif ($_GET[artefact] == 'puli'){
	printrus("Бронебойные пули: +30% сила и +30% скорость стрелков<br/>\r\n");
}

elseif ($_GET[artefact] == 'yadro'){
	printrus("Чугунное ядро: +30% маневренность и +30% мощность пушек<br/>\r\n");
}

elseif ($_GET[artefact] == 'the_artillery_fire'){
	printrus("Артиллерийская стрельба: +20% маневренность и +50% мощность пушек<br/>\r\n");
}

elseif ($_GET[artefact] == 'avia_pulemet'){
	printrus("Авиа пулемет: +20% маневренность и +20% мощность самолетов<br/>\r\n");
}

elseif ($_GET[artefact] == 'angel_wings'){
	printrus("Ангельские крылья: +30% маневренность и +15% мощность самолетов<br/>\r\n");
}

elseif ($_GET[artefact] == 'podrivnoe_delo'){
	printrus("Брошюра подрывное дело: +30% маневренность и +30% мощность подрывников<br/>\r\n");
}

elseif ($_GET[artefact] == 'pult'){
	printrus("Пульт с дистанционным управлением: +100% маневренность и +100% мощность подрывников<br/>\r\n");
}


elseif ($_GET[artefact] == 'pogon'){
	printrus("Генеральский погон: +1..3 морали за крупную битву (больше 10000 опыта) <br/>\r\n");
}

elseif ($_GET[artefact] == 'kniga_taktiki'){
	printrus("Учебник по тактике: +200 к навыку<br/>\r\n");
}

elseif ($_GET[artefact] == 'medal'){
	printrus("Медаль за храбрость: +30 морали<br/>\r\n");
}

elseif ($_GET[artefact] == 'teh_volshebstvo'){
	printrus("Техническое волшебство:  +50% знание и +50% силе магии<br/>\r\n");
}
elseif ($_GET[artefact] == 'dragon_scale_shield'){
	printrus("Щит из чешуи дракона:  +50 марали генералу<br/>\r\n");
}

elseif ($_GET[artefact] == 'crest_of_valor'){
	printrus("Герб Доблести:  +5000 опыта генералу<br/>\r\n");
}

//==============================================================================
//Конец скрипту=================================================================
print "---<br/>\r\n";
printrus
("
<a href='game.php?$ses'>Назад</a>
<br/>
");
//printrus ("<a href='unlogin.php?$ses'>&lt;&lt;&lt;Выход</a><br/>\r\n");
//футер страницы:
include_once("other_inc/footer.php");
?>
