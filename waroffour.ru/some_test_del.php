<?/*
//мертвая или живая страна?

$mysql_connect = mysql_connect('localhost', 'cv', 'DhmhF9EW') or die('Not Connected.');
mysql_select_db('cv');
mysql_query("SET NAMES 'utf8'");
$q = mysql_query("SELECT `countryID`,`reggedTime` FROM `countries_test` WHERE `countryName` NOT LIKE '%Пустынные территории%' ORDER BY reggedTime ASC");
while($data = mysql_fetch_assoc($q)){
	$res = coun_is_die ($data[countryID]);
	print $res;
	print "<br/>";
}
function coun_is_die($countryID){
	$query="SELECT countries_test.countryID,countries_test.countryName FROM `countries_test` LEFT JOIN `messages`
	   ON countries_test.countryID=messages.countryID and messages.`from` = 'loose'
	   WHERE (messages.countryID IS NULL)and(countries_test.countryID = '".$countryID."')";
	   $result12  = mysql_fetch_assoc(@MYSQL_QUERY($query));
	$result=mysql_num_rows(@MYSQL_QUERY($query));
	if($result){
		return "ID: ".$result12[countryID]." , Name: '".$result12[countryName]."' is <p style='color:green;display: inline;'>alive</p>"; 
	}else{
		$query="SELECT countries_test.countryID,countries_test.countryName FROM `countries_test` LEFT JOIN `messages`
			ON countries_test.countryID=messages.countryID and messages.`from` = 'loose'
			WHERE (messages.countryID IS NOT NULL)and(countries_test.countryID = '".$countryID."')";
	   $result12  = mysql_fetch_assoc(@MYSQL_QUERY($query));
		return "ID: ".$result12[countryID]." , Name: '".$result12[countryName]."' is <p style='color:red;display: inline;'>die</p>";
	}
}


die();*/
/*
//добавление каждой стране по 1 соседу

$mysql_connect = mysql_connect('localhost', 'cv', 'DhmhF9EW') or die('Not Connected.');
mysql_select_db('cv');
mysql_query("SET NAMES 'utf8'");

function setNeighbour($countryID,$neighbourID){

 $countryID=addslashes($countryID);
 $neighbourID=addslashes($neighbourID);

 $query="INSERT INTO `neighbours_test` VALUES('$countryID','$neighbourID')";
 $result=MYSQL_QUERY($query);


 $query="INSERT INTO `neighbours_test` VALUES('$neighbourID','$countryID')";
 $result=MYSQL_QUERY($query);


}

$q = mysql_query("SELECT `countryID`,`reggedTime` FROM `countries_test` WHERE `countryName` NOT LIKE '%Пустынные территории%' ORDER BY reggedTime ASC");
while($data = mysql_fetch_assoc($q)){
	$countryID = $data[countryID];
	$query="SELECT countries_test.countryID,countries_test.countryName FROM `countries_test` LEFT JOIN `messages`
	   ON countries_test.countryID=messages.countryID and messages.`from` = 'loose'
	   WHERE (messages.countryID IS NULL)and(countries_test.countryID!='".$countryID."')and
	   (countries_test.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
	   and (reggedTime<".$data['reggedTime'].") ORDER BY reggedTime DESC
	   LIMIT 2";
	$result=@MYSQL_QUERY($query);

	   while (($a=mysql_fetch_array($result))!==FALSE){
		$neigh_=$a["countryName"];
		$neighbourID=$a["countryID"];
	   setNeighbour($countryID,$neighbourID);
	   }
	   
	   $query="SELECT countries_test.countryID,countries_test.countryName FROM `countries_test` LEFT JOIN `messages`
	   ON countries_test.countryID=messages.countryID and messages.`from` = 'loose'
	   WHERE (messages.countryID IS NULL)and(countries_test.countryID!='".$countryID."')and
	   (countries_test.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
	   and (reggedTime>".$data['reggedTime'].") ORDER BY reggedTime ASC
	   LIMIT 2";
	   $result=@MYSQL_QUERY($query);
	   while (($a=mysql_fetch_array($result))!==FALSE){
		$neigh_=$a["countryName"];
		$neighbourID=$a["countryID"];
	   setNeighbour($countryID,$neighbourID);
	}
}
die();*/
/*
//визуализатор стран и их соседей
function coun_is_die($countryID){
	$query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
	   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
	   WHERE (messages.countryID IS NULL)and(countries.countryID = '".$countryID."')";
	  // $result12  = mysql_fetch_assoc(@MYSQL_QUERY($query));
	$result=mysql_num_rows(MYSQL_QUERY($query));
	if($result){
		return true; 
	}else{
		return false;
	}
}
//set_time_limit(500);
$mysql_connect = mysql_connect('localhost', 'cv', 'DhmhF9EW') or die('Not Connected.');
mysql_select_db('cv');
mysql_query("SET NAMES 'utf8'");
$map= array();
$q = mysql_query("SELECT `countryID`,`reggedTime`,`countryName` FROM `countries` WHERE `countryName` NOT LIKE '%Пустынные территории%' ORDER BY reggedTime ASC");
$eee=0;
while($data = mysql_fetch_assoc($q)){
	//$eee++;
	//if($eee>900){
		$map[abs($data[reggedTime])]=array($data[countryID],$data[countryName],abs($data[reggedTime]));
	//}
}
$i=0;
$mn=count($map);
$mn=300;

header ("Content-type: image/png");
$im = imagecreatetruecolor(140*$mn, 1500);
$white = imagecolorallocate($im, 255, 255, 255); 
$mag = imagecolorallocate($im, 255, 127, 255);
$red = imagecolorallocate($im, 255, 0, 0);
$bl = imagecolorallocate($im, 1, 1, 1);
imagefill($im, 0, 0, $white); 
$ink = imagecolorallocate($im,1, 1, 1);
//$tmp = 0;

foreach($map as $key=>$val){
	$neib = mysql_query("SELECT * FROM `neighbours` WHERE `countryID` = '$val[0]'");
	//$j=0;
	$j=0;
//	$tmp = 0; 
	$draw_array = array();
	while($data = mysql_fetch_assoc($neib)){
		
		//print $j."<br/>";
		$qq = $data[neighbourID];	
		$qqq = mysql_fetch_assoc(mysql_query("SELECT `countryName`,`reggedTime` FROM `countries` WHERE `countryID` = '$qq'"));		
		$res = mysql_num_rows(mysql_query("SELECT * FROM `countries` WHERE (`reggedTime` BETWEEN '$val[2]'+1 AND '$qqq[reggedTime]'-1) OR (`reggedTime` BETWEEN '$qqq[reggedTime]'+1 AND '$val[2]'-1)"));
		//if($res < 20){
		//continue;
		//}
		//mysql_query( "DELETE FROM `neighbours` WHERE `countryID` = '$val[0]' AND `neighbourID` = '$data[neighbourID]'");
		//$res = mysql_num_rows(mysql_query());
		$tmp++;
		//imagefilledellipse($im,70+(140*$i),95+(60 * $j),30,30,$ink); 
		$prr = coun_is_die($qq);
		if($prr){
			array_push($draw_array,array($im,70+(140*$i),95+(60 * $j),30,30,$ink));
		}else{
			array_push($draw_array,array($im,70+(140*$i),95+(60 * $j),30,30,$red));
		}
		//imagefttext($im, 10, 0, 65+(140*$i), 100+(60 * $j), $mag ,'./5102337.ttf',  $res );
		array_push($draw_array,array($im, 10, 0, 65+(140*$i), 100+(60 * $j), $mag ,"./5102337.ttf",  $res ));
		$result2=$i%2;
		if ($result2===0) {
			$result2=60;
		}
		else{
			$result2=60;
		}
		$mass2 = split (" ", $qqq[countryName], 3);
		if($mass2[0] == "Пустынные" && $mass2[1] == "территории"){
			//imagefttext($im, 7, 0, 50+(140*$i), 120+($result2 * $j), $bl,'./5102337.ttf',  'PT_'.$mass2[2]);
			array_push($draw_array,array($im, 7, 0, 50+(140*$i), 120+($result2 * $j), $bl,"./5102337.ttf",  'PT_'.$mass2[2]));
		}else{
			//imagefttext($im, 7, 0, 50+(140*$i), 120+($result2 * $j), $bl,'./5102337.ttf',$qqq[countryName]);
			array_push($draw_array,array($im, 7, 0, 50+(140*$i), 120+($result2 * $j), $bl,"./5102337.ttf",$qqq[countryName]));
		}
		$j++;
	}
//	if($tmp <= 2){
	//	continue;
	//}
	foreach($draw_array as $key7=>$val7){
	//print count($val7);
		if(count($val7) == 6){
			//print "qqq";
			imagefilledellipse($val7[0],$val7[1],$val7[2],$val7[3],$val7[4],$val7[5]);
		}else{
			//print $val7[6];
			imagefttext($val7[0],$val7[1],$val7[2],$val7[3],$val7[4],$val7[5],$val7[6],$val7[7]);
		}
	}
	$prr = coun_is_die($val[0]);
	if($prr){
		imagefilledellipse($im,70+(140*$i),30,50,50,$ink); 
	}else{
		imagefilledellipse($im,70+(140*$i),30,50,50,$red); 
	}
	$result=$i%2;
	if ($result===0) {
		$result=65;
	}
	else{
		$result=75;
	}
	//str_replace("Пустынные", "P", $val[1]);
	//str_replace("территории", "T.", $val[1]);
	$mass1 = split (" ", $val[1], 3);
	if($mass1[0] == "Пустынные" && $mass1[1] == "территории"){
		imagefttext($im, 8, 0, 50+(140*$i), $result, $bl,'./5102337.ttf',  "PT_".$mass1[2]);//." time:".$val[2]);
	}else{
		imagefttext($im, 8, 0, 50+(140*$i), $result, $bl,'./5102337.ttf',  "".$val[1]);//." time:".$val[2]);
	}	
	$i++;
	if($i>300)
		break;
}
//print $im;
imagepng($im);
imagedestroy($im);
die();*/
/*
///самый дальний сосед
set_time_limit(500);
$mysql_connect = mysql_connect('localhost', 'cv', 'DhmhF9EW') or die('Not Connected.');
mysql_select_db('cv');
mysql_query("SET NAMES 'utf8'");
$map= array();
$q = mysql_query("SELECT `countryID`,`reggedTime`,`countryName` FROM `countries` WHERE `countryName` NOT LIKE '%Пустынные территории%' ORDER BY reggedTime ASC");
$eee=0;
while($data = mysql_fetch_assoc($q)){
		$map[abs($data[reggedTime])]=array($data[countryID],$data[countryName],abs($data[reggedTime]));
}
$i=0;
$tmp = array(0,0,0);
foreach($map as $key=>$val){
	$neib = mysql_query("SELECT * FROM `neighbours` WHERE `countryID` = '$val[0]'");
	while($data = mysql_fetch_assoc($neib)){
		$j=0; 
		$qq = $data[neighbourID];	
		//$qqq = mysql_fetch_assoc(mysql_query("SELECT `countryName`,`reggedTime` FROM `countries_test` WHERE `countryID` = '$qq'"));		
		$qqq = mysql_fetch_assoc(mysql_query("SELECT `countryID`,`countryName`,`reggedTime` FROM `countries` WHERE `countryID` = '$qq'"));		
		
		$query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
			ON countries.countryID=messages.countryID and messages.`from` = 'loose'
			WHERE (messages.countryID IS NOT NULL)and(countries.countryID = '".$countryID."')";
		
		$res = mysql_num_rows(mysql_query("SELECT * FROM `countries` WHERE (`reggedTime` BETWEEN '$val[2]'+1 AND '$qqq[reggedTime]'-1) OR (`reggedTime` BETWEEN '$qqq[reggedTime]'+1 AND '$val[2]'-1)"));
		if($res > $tmp[0]){
			$tmp[0] = $res;
			$tmp[1] = $val;
			$tmp[2] = $qqq;
		}		
		$j++;
	}
	$i++;
}
$fp = fopen('teset/counter1.txt', 'w+');
$test = fwrite($fp, iconv("UTF-8", "WINDOWS-1251", json_encode($tmp)));
die();
*/

// удаление дохлых соседей
function coun_is_die($countryID){
	$query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
	   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
	   WHERE (messages.countryID IS NULL)and(countries.countryID = '".$countryID."')";
	  // $result12  = mysql_fetch_assoc(@MYSQL_QUERY($query));
	$result=mysql_num_rows(@MYSQL_QUERY($query));
	if($result){
		return true; 
	}else{
		
		return false;
	}
}
set_time_limit(500);
$mysql_connect = mysql_connect('localhost', 'cv', 'DhmhF9EW') or die('Not Connected.');
mysql_select_db('cv');
mysql_query("SET NAMES 'utf8'");
$map= array();
$q = mysql_query("SELECT `countryID`,`reggedTime`,`countryName` FROM `countries` WHERE `countryName` NOT LIKE '%Пустынные территории%' ORDER BY reggedTime ASC");
$eee=0;
while($data = mysql_fetch_assoc($q)){
		$map[abs($data[reggedTime])]=array($data[countryID],$data[countryName],abs($data[reggedTime]));
}
$i=0;
foreach($map as $key=>$val){
	$neib = mysql_query("SELECT * FROM `neighbours` WHERE `countryID` = '$val[0]'");
	if(!coun_is_die($val[0])){
		$j=0; 
		while($data = mysql_fetch_assoc($neib)){
			$qq = $data[neighbourID];			
			mysql_query( "DELETE FROM `neighbours` WHERE `countryID` = '$val[0]' AND `neighbourID` = '$data[neighbourID]'");
			print "   delfr1   ";
			$j++;
		}
	}else{	
		$j=0; 
		while($data = mysql_fetch_assoc($neib)){
			$qq = $data[neighbourID];			
			if(!coun_is_die($qq)){
				mysql_query( "DELETE FROM `neighbours` WHERE `countryID` = '$val[0]' AND `neighbourID` = '$data[neighbourID]'");			
				print "   delfr2   ";
			}
			$j++;
		}
	}
	$i++;
}
print "qq";
die();
