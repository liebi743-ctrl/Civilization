<?php

if ( $_SERVER[HTTP_HOST] == 'waroffour.mgates.ru')
	{



	session_start();

	if (!isset($_SESSION['id_user']))
		$_SESSION['id_user'] = 0;
	if (!isset($_SESSION['user_info']))
		$_SESSION['user_info'] = array();
	if (!isset($_SESSION['sid_value']))
		$_SESSION['sid_value'] = '';
	if (!isset($_SESSION['sid_expire']))
		$_SESSION['sid_expire'] = time()+24*60*60;

	if (!empty($_GET['logout']))
	{
		$_SESSION['id_user'] = 0;
		$_SESSION['user_info'] = array();
		$_SESSION['sid_value'] = '';
	}

	if (!empty($_GET['sid']))
	{
		$_SESSION['id_user'] = 0;
		$_SESSION['sid_value'] = $_GET['sid'];
		$_SESSION['sid_expire'] = time()+24*60*60;
		$_SESSION['user_info'] = array();
	}
	if ($_SESSION['id_user'] && $_SESSION['sid_value'] && ($_SESSION['sid_expire'] < time()))
	{
		$_SESSION['id_user'] = 0;
		$_SESSION['user_info'] = array();
	}
	include_once '/var/www/waroffour/data/www/waroffour.ru/api/mgates-class.php';
	global $mgates;
	$mgates = new MGates($mgates_params);

	if (!$_SESSION['id_user'] && $_SESSION['sid_value'])
	{
		$res = $mgates->getUserInfo($_SESSION['sid_value']);
		$_SESSION['sid_value'] = "";
		if ($res)
		{
			$_SESSION['id_user'] = $res['id'];
			$_SESSION['sid_value'] = $res['sid'];
			$_SESSION['sid_expire'] = time()+24*60*60;
			$_SESSION['user_info'] = $res;
			$_SESSION['mgates_info'] = $mgates->getMiscInfo($_SESSION['sid_value']);
		}
	}

	if (empty($_SESSION['mgates_info']))
		$_SESSION['mgates_info'] = $mgates->getMiscInfo();

?>


<?php
	if ($_SESSION['id_user'])
	{
?>


	<?php
	$mtt=time();
	if ($_SESSION['mgates_data']=='' OR $_SESSION['mgates_last']+180 < $mtt)
	{
	$mgates_data= $mgates->getWidgets($_SESSION['sid_value']);
	$_SESSION['mgates_data']=$mgates_data;
	$_SESSION['mgates_last']=$mtt;
	}
	else{
	$mgates_data=$_SESSION['mgates_data'];
	}

//	printrus($mgates_data[header]);
	//$mgates_info= $mgates->getUserInfo($_SESSION['sid_value']);

		//print_r($_SESSION);
		$mid=$_SESSION[user_info][id];

		$mc=mysql_fetch_array(mysql_query("SELECT COUNT(id) AS cc FROM mgates WHERE mgates_sid='$mid'"));
		//print "SELECT COUNT(id) AS cc FROM mgates WHERE mgates_sid='". $_SESSION['sid_value'] ."'";
		//print "mc -";
		//print_r($mc);
		if ($mc['cc'] == 0)
		{
			if ($_SESSION['userID'] <> '' AND $_SESSION['countryID'] <> '' AND $_SESSION['in_db'] <> 1){
			//print 'stavim';
				mysql_query("INSERT INTO mgates(mgates_sid, user_id, country_id) VALUES('$mid', '". $_SESSION['userID'] ."', '". $_SESSION['countryID'] ."' )");
				$_SESSION['in_db']='1';
			}
		}
		else
		{
		$ms=mysql_fetch_array(mysql_query("SELECT * FROM mgates WHERE mgates_sid='$mid'"));
		//print "SELECT * FROM mgates WHERE mgates_sid='". $_SESSION['sid_value'] ."'";
		//print "ms  - ";
		//print_r($ms);
		$_SESSION['countryID']=$ms['country_id'];
		$_SESSION['auth']='1';
		$_SESSION['userID']=$ms['user_id'];
		}





	?>


<?php
	}
	else{

	//header('Location: http://spaces.ru/app/');
	header('Location: http://spaces.ru/app/?sid=&enter=48');

	}
?>












	<?php
	print $mgates_data['header'];
	}

	?>