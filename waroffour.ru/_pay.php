<?php
//!!! При необходимости поменять название переменных, которые передаются скрипту.
//!!! остальные настройки находятся в config.php

	define('IN_CLV',true);
	require ('func/functions_clv.php');

	mem_connect();

	$secretKey = '575d7be4db927bab58963b602f685de3';
	$params = $_GET['params'];
	$method = $_GET['method'];
	$account = $params['account'];


	function md5sign($params) {
        ksort($params);
        unset($params['sign']);

        return md5(join(null, $params) . $secretKey);
    }

    function checkSign() {
		global $params;

        if ($params['sign'] != md5sign($params)) {
            responseError("Некорректная цифровая подпись");
        }
    }

	function executeQuery($query) {
        return mysql_query($query);
    }

	function action_check() {
		global $params;

        $login = str(strtolower($params['account']));
        $sum = $params['orderSum'];

        $data = mysql_num_rows(executeQuery("SELECT * FROM `uzers` WHERE `userID`='$login' LIMIT 1"));

        if ($data != 1) {
            responseError("Неверный ID игрока");
        } else {
            responseSuccess("ID проверен. Платформа готова к совершению операции");
        }
    }

    function action_pay() {
		global $params;

        $login = str(strtolower($params['account']));
        $sum = $params['orderSum'];

		executeQuery("UPDATE `uzers` SET `credits`=`credits`+".$sum." WHERE `userID` = '".addslashes($login)."' LIMIT 1");

        responseSuccess("Оплата успешно завершена. Кредиты зачислены");
    }

    function action_error() {
        responseError("Неизвестная ошибка! Обратитесь к администрации!");

		exit();
    }

	function responseError($message) {
        echo json_encode(array(
            "error" => array(
                "message" => $message
            )
        ));

        exit();
    }

    function responseSuccess($message) {
        echo json_encode(array(
            "result" => array(
                "message" => $message
            )
        ));

        exit();
    }

	function action_default() {
        responseError("Некорректный метод, поддерживаются методы: check и pay");
    }

	function str($string) {
        return mysql_real_escape_string($string);
    }

	//checkSign();

	if (function_exists($f = 'action_' . $method)) {
		$f();
	} else {
		action_default();
	}



?>