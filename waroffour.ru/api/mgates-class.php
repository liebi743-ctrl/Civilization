<?php

	require_once 'mgates-config.php';

	class MGates
	{		var $ref;
		var $param;
		var $chat_rights;
		var $forum_rights;
		var $last_code;
		var $last_trans;
		
		function MGates($param)
		{
			$this->chat_rights = array("view", "read", "post", "del", "topic", "ban");
			$this->forum_rights = array("view", "read", "post", "own_edit", "own_del", "all_edit", "all_del", "topic_create", "topic_close", "topic_del", "ban");
			
			$protocol = 'http';
			if (!empty($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) != 'off')
				$protocol = 'https';
 			$this->ref = rawurlencode($protocol."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);

			$this->param = $param;
			$this->param['VER'] = '20110531-PHPCONTEXT';
 			$this->param['HOST'] = rawurlencode($_SERVER['HTTP_HOST']);
 			if (!empty($_SERVER['HTTP_X_MGATES_HOST']))
 				$this->param['HOST'] = rawurlencode($_SERVER['HTTP_X_MGATES_HOST']);
 			
			$this->param['CONTEXT'] = array(
					'http' => array(
					'method'          => 'GET',
					'request_fulluri' => true,
					'timeout'         => 10,
					'max_redirects'   => 1
				)
			);
			if (isset($this->param['PROXY']) && $this->param['PROXY'])
				$this->param['CONTEXT']['http']['proxy'] = $this->param['PROXY'];

			$this->param['SID'] = array();
			$this->param['SID']['ua'] = '';
			$this->param['SID']['ip'] = '';
			preg_match("/[0-9\.]*/", $_SERVER['REMOTE_ADDR'], $out);
			if (!empty($out[0]))
				$this->param['SID']['ip'] = substr($out[0], 0, 15);
			if (isset($_SERVER['HTTP_USER_AGENT']))
				$this->param['SID']['ua'] = rawurlencode(substr($_SERVER['HTTP_USER_AGENT'], 0, 100));
			if (strpos($this->param['SID']['ua'], 'Opera%20Mini'))
			{
				if (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
				{
					preg_match("/[0-9\.]*/", $_SERVER['HTTP_X_FORWARDED_FOR'], $out);
					if (!empty($out[0]))
						$this->param['SID']['ip'] = substr($out[0], 0, 15);
				}
				if (isset($_SERVER['HTTP_X_OPERAMINI_PHONE_UA']))
					$this->param['SID']['ua'] = rawurlencode(substr($_SERVER['HTTP_X_OPERAMINI_PHONE_UA'], 0, 100));
			}
		}

		function setRef($url)
		{			$this->ref = rawurlencode($url);
		}

		function setHost($host)
		{
			$this->param['HOST'] = rawurlencode($host);
		}

		function getUserInfo($sid)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'getUserInfo', '');
			if ($res)
			{
				$result = array();
				$result['id'] = sprintf("%d", $res->response->id);
				$result['substitutor'] = sprintf("%d", $res->response->substitutor);
				$result['login'] = sprintf("%s", $res->response->login);
				$result['permanent'] = sprintf("%d", $res->response->permanent);
				$result['phone'] = sprintf("%d", $res->response->phone);
				$result['phonezone'] = sprintf("%d", $res->response->phonezone);
				$result['sex'] = sprintf("%d", $res->response->sex);
				$result['birthdate'] = sprintf("%s", $res->response->birthdate);
				$result['avatar'] = sprintf("%s", $res->response->avatar);
				$result['sid'] = sprintf("%s", $res->response->sid);
				$result['own'] = sprintf("%d", $res->response->own);
				$result['placecode'] = sprintf("%s", $res->response->placecode);
				$result['balance'] = sprintf("%d", $res->response->balance);
				$result['bonus'] = sprintf("%d", $res->response->bonus);
				$result['paid'] = sprintf("%d", $res->response->paid);
				$result['status'] = sprintf("%d", $res->response->status);
				$result['mobile'] = sprintf("%d", $res->response->mobile);
				$result['mobile_x'] = sprintf("%d", $res->response->mobile_x);
				$result['mobile_y'] = sprintf("%d", $res->response->mobile_y);
				$result['widget'] = sprintf("%d", $res->response->widget);
			}
			return $result;
		}

		function getUserBalance($sid)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'getUserBalance', '');
			if ($res)
			{
				$result = array();
				$result['balance'] = sprintf("%d", $res->response->balance);
				$result['bonus'] = sprintf("%d", $res->response->bonus);
				$result['paid'] = sprintf("%d", $res->response->paid);
			}
			return $result;
		}

		function addBonus($sid, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'addBonus', $value);
			if ($res)
			{
				$result = array();
				$result['money'] = $value;
			}
			return $result;
		}

		function addCommonBonus($sid, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'addCommonBonus', $value);
			if ($res)
			{
				$result = array();
				$result['money'] = $value;
			}
			return $result;
		}

		function addBalance($sid, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'addBalance', $value);
			if ($res)
			{
				$result = array();
				$result['money'] = $value;
			}
			return $result;
		}

		function getMiscInfo($sid = '')
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'getMiscInfo', '');
			if ($res)
			{
				$result = array();
				$result['mirror'] = sprintf("%s", $res->response->mirror);
				$result['host'] = sprintf("%s", $res->response->host);
				$result['url_main'] = sprintf("%s", $res->response->url->main);
				$result['url_login'] = sprintf("%s", $res->response->url->login);
				$result['url_registration'] = sprintf("%s", $res->response->url->registration);
				$result['url_balance'] = sprintf("%s", $res->response->url->balance);
				$result['url_chat'] = sprintf("%s", $res->response->url->chat);
				$result['url_forum'] = sprintf("%s", $res->response->url->forum);
			}
			return $result;
		}

		function spendMoney($sid, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'spendMoney', $value);
			if ($res)
			{
				$result = array();
				$result['gamebonus'] = sprintf("%d", $res->response->gamebonus);
				$result['bonus'] = sprintf("%d", $res->response->bonus);
				$result['paid'] = sprintf("%d", $res->response->paid);
			}
			return $result;
		}

		function spendBonus($sid, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'spendBonus', $value);
			if ($res && ($res->response->gamebonus > 0))
			{
				$result = array();
				$result['gamebonus'] = sprintf("%d", $res->response->gamebonus);
				$result['bonus'] = 0;
				$result['paid'] = 0;
			}
			return $result;
		}

		function spendBalance($sid, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'spendBalance', $value);
			if ($res)
			{
				$result = array();
				$result['gamebonus'] = 0;
				$result['bonus'] = sprintf("%d", $res->response->bonus);
				$result['paid'] = sprintf("%d", $res->response->paid);
			}
			return $result;
		}

		function spendPaid($sid, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'spendPaid', $value);
			if ($res)
			{
				$result = array();
				$result['gamebonus'] = 0;
				$result['bonus'] = 0;
				$result['paid'] = sprintf("%d", $res->response->paid);
			}
			return $result;
		}

		function multiSpend($sid, $value, $id_fund, $value_fund, $id_user, $value_user)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'multiSpend', $value.",".$id_fund.",".$value_fund.",".$id_user.",".$value_user);
			if ($res)
			{
				$result = array();
				$result['gamebonus'] = sprintf("%d", $res->response->gamebonus);
				$result['bonus'] = sprintf("%d", $res->response->bonus);
				$result['paid'] = sprintf("%d", $res->response->paid);
				$result['user'] = sprintf("%d", $res->response->user);
				$result['fund'] = sprintf("%d", $res->response->fund);
			}
			return $result;
		}

		function spendPrizeFund($sid, $id_fund, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'spendPrizeFund', $id_fund.",".$value);
			if ($res)
			{
				$result = array();
				$result['money'] = $value;
			}
			return $result;
		}

		function openPrizeFund($type=0)
		{
			$result = false;
			$res = $this->ExecCommand('', 'openPrizeFund', $type);
			if ($res)
			{
				$result = array();
				$result['id'] = sprintf("%d", $res->response->id);
			}
			return $result;
		}

		function closePrizeFund($id)
		{
			$result = false;
			$res = $this->ExecCommand('', 'closePrizeFund', $id);
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
			}
			return $result;
		}

		function userToPrizeFund($sid, $id_fund, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'userToPrizeFund', $id_fund.",".$value);
			if ($res)
			{
				$result = array();
				$result['gamebonus'] = 0;
				$result['bonus'] = 0;
				$result['paid'] = sprintf("%d", $res->response->paid);
			}
			return $result;
		}

		function userFromPrizeFund($sid, $id_fund, $value)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'userFromPrizeFund', $id_fund.",".$value);
			if ($res)
			{
				$result = array();
				$result['money'] = $value;
			}
			return $result;
		}

		function registerUser($login, $pwd)
		{
			$result = false;
			$res = $this->ExecCommand('', 'registerUser', $login.",".$pwd);
			if ($res)
			{
				$result = array();
				$result['id'] = sprintf("%d", $res->response->id);
				$result['ssid'] = sprintf("%s", $res->response->ssid);
			}
			return $result;
		}

		function loginUser($login, $pwd)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'loginUser', $login.",".$pwd);
			if ($res)
			{
				$result = array();
				$result['id'] = sprintf("%d", $res->response->id);
				$result['ssid'] = sprintf("%s", $res->response->ssid);
			}
			return $result;
		}
		
		function checkUser($sid)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'checkUser', '');
			if ($res)
			{
				$result = array();
				$result['id'] = sprintf("%d", $res->response->id);
			}
			return $result;
		}

		function setUserInfo($sid, $phone, $email="", $sex=0, $birthdate="", $id_country=0, $id_city=0, $name="")
		{
			$result = false;
			if ($phone)
				$res = $this->ExecCommand($sid, 'setUserInfo', "1,".$phone);
			else if ($email)
				$res = $this->ExecCommand($sid, 'setUserInfo', "2,".$email);
			else
				$res = $this->ExecCommand($sid, 'setUserInfo', "3,".$sex.",".$birthdate.",".$id_country.",".$id_city.",".$name);
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
			}
			return $result;
		}
		
		function requestPayment($sid, $country="", $operator="")
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'requestPayment', $country.",".$operator);
			if ($res)
			{
				$result = array();
				$result['result'] = sprintf("%d", $res->response->result);
				if ($result['result'] == 902)
				{
					$result['num'] = sprintf("%s", $res->response->num);
					$result['text'] = sprintf("%s", $res->response->text);
					$result['price'] = sprintf("%s", $res->response->price);
					$result['currency'] = sprintf("%s", $res->response->currency);
					$result['vat'] = sprintf("%s", $res->response->vat);
					$result['spec'] = sprintf("%s", $res->response->spec);
					$result['country'] = sprintf("%s", $res->response->country);
				}
				else if ($result['result'] == 903)
				{
					$result['list'] = array();
					foreach ($res->response->list->country as $elem)
					{
						$tmp = array();
						$tmp['name'] = sprintf("%s", $elem->name);
						$tmp['code'] = sprintf("%s", $elem->code);
						array_push($result['list'], $tmp);
					}
				}
				else if ($result['result'] == 904)
				{
					$result['country'] = sprintf("%s", $res->response->country);
					$result['list'] = array();
					foreach ($res->response->list->operator as $elem)
					{
						$tmp = array();
						$tmp['name'] = sprintf("%s", $elem->name);
						$tmp['code'] = sprintf("%s", $elem->code);
						array_push($result['list'], $tmp);
					}
				}
			}
			return $result;
		}

		function getForumInfo()
		{
			$result = false;
			$res = $this->ExecCommand('', 'getForumInfo', '');
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
				$result['list'] = array();
				foreach ($res->response->branch as $elem)
				{
					$tmp = array();
					$tmp['id'] = sprintf("%d", $elem->id);
					$tmp['name'] = sprintf("%s", $elem->name);
					$tmp['order'] = sprintf("%d", $elem->order);
					$tmp['status'] = sprintf("%d", $elem->status);
					$tmp['mstatus'] = sprintf("%d", $elem->mstatus);
					$tmp['rights'] = array();
					foreach ($elem->right as $right)
					{
						$tmp2 = sprintf("%s", $right->name);
						$tmp['rights'][$tmp2] = sprintf("%d", $right->value);
					}
					array_push($result['list'], $tmp);
				}
			}
			return $result;
		}
		
		function addForumBranch($order, $status, $mstatus, $rights, $name)
		{
			$result = false;
			$mask = "";
			$list = $this->forum_rights;
			for ($i = 0; $i < count($list); $i++)
			{
				if (isset($rights[$list[$i]]))
					$mask .= $rights[$list[$i]];
				else
					$mask .= '2';
			}
			$res = $this->ExecCommand('', 'addForumBranch', $order.','.$status.','.$mstatus.','.$mask.','.$name);
			if ($res)
			{
				$result = array();
				$result['id'] = sprintf("%d", $res->response->id);
			}
			return $result;
		}
		
		function setForumBranch($id_branch, $order, $status, $mstatus, $rights, $name)
		{
			$result = false;
			$mask = "";
			$list = $this->forum_rights;
			for ($i = 0; $i < count($list); $i++)
			{
				if (isset($rights[$list[$i]]))
					$mask .= $rights[$list[$i]];
				else
					$mask .= '2';
			}
			$res = $this->ExecCommand('', 'setForumBranch', $id_branch.','.$order.','.$status.','.$mstatus.','.$mask.','.$name);
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
			}
			return $result;
		}
		
		function getForumRights($id_branch, $ids)
		{
			$result = false;
			$res = $this->ExecCommand('', 'getForumRights', $id_branch.','.$ids);
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
				$result['list'] = array();
				foreach ($res->response->user as $elem)
				{
					$tmp = array();
					$tmp['id'] = sprintf("%d", $elem->id);
					$tmp['rights'] = array();
					foreach ($elem->right as $right)
					{
						$tmp2 = sprintf("%s", $right->name);
						$tmp['rights'][$tmp2] = sprintf("%d", $right->value);
					}
					array_push($result['list'], $tmp);
				}
			}
			return $result;
		}
		
		function setForumRights($id_branch, $ids, $rights)
		{
			$result = false;
			$mask = "";
			$list = $this->forum_rights;
			for ($i = 0; $i < count($list); $i++)
			{
				if (isset($rights[$list[$i]]))
					$mask .= $rights[$list[$i]];
				else
					$mask .= '2';
			}
			$res = $this->ExecCommand('', 'setForumRights', $id_branch.','.$mask.','.$ids);
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
			}
			return $result;
		}
		
		function getChatInfo()
		{
			$result = false;
			$res = $this->ExecCommand('', 'getChatInfo', '');
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
				$result['list'] = array();
				foreach ($res->response->room as $elem)
				{
					$tmp = array();
					$tmp['id'] = sprintf("%d", $elem->id);
					$tmp['name'] = sprintf("%s", $elem->name);
					$tmp['order'] = sprintf("%d", $elem->order);
					$tmp['status'] = sprintf("%d", $elem->status);
					$tmp['rights'] = array();
					foreach ($elem->right as $right)
					{
						$tmp2 = sprintf("%s", $right->name);
						$tmp['rights'][$tmp2] = sprintf("%d", $right->value);
					}
					array_push($result['list'], $tmp);
				}
			}
			return $result;
		}
		
		function addChatRoom($order, $status, $rights, $name)
		{
			$result = false;
			$mask = "";
			$list = $this->chat_rights;
			for ($i = 0; $i < count($list); $i++)
			{
				if (isset($rights[$list[$i]]))
					$mask .= $rights[$list[$i]];
				else
					$mask .= '2';
			}
			$res = $this->ExecCommand('', 'addChatRoom', $order.','.$status.','.$mask.','.$name);
			if ($res)
			{
				$result = array();
				$result['id'] = sprintf("%d", $res->response->id);
			}
			return $result;
		}
		
		function setChatRoom($id_room, $order, $status, $rights, $name)
		{
			$result = false;
			$mask = "";
			$list = $this->chat_rights;
			for ($i = 0; $i < count($list); $i++)
			{
				if (isset($rights[$list[$i]]))
					$mask .= $rights[$list[$i]];
				else
					$mask .= '2';
			}
			$res = $this->ExecCommand('', 'setChatRoom', $id_room.','.$order.','.$status.','.$mask.','.$name);
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
			}
			return $result;
		}
		
		function getChatRights($id_room, $ids)
		{
			$result = false;
			$res = $this->ExecCommand('', 'getChatRights', $id_room.','.$ids);
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
				$result['list'] = array();
				foreach ($res->response->user as $elem)
				{
					$tmp = array();
					$tmp['id'] = sprintf("%d", $elem->id);
					$tmp['rights'] = array();
					foreach ($elem->right as $right)
					{
						$tmp2 = sprintf("%s", $right->name);
						$tmp['rights'][$tmp2] = sprintf("%d", $right->value);
					}
					array_push($result['list'], $tmp);
				}
			}
			return $result;
		}
		
		function setChatRights($id_room, $ids, $rights)
		{
			$result = false;
			$mask = "";
			$list = $this->chat_rights;
			for ($i = 0; $i < count($list); $i++)
			{
				if (isset($rights[$list[$i]]))
					$mask .= $rights[$list[$i]];
				else
					$mask .= '2';
			}
			$res = $this->ExecCommand('', 'setChatRights', $id_room.','.$mask.','.$ids);
			if ($res)
			{
				$result = array();
				$result['success'] = 1;
			}
			return $result;
		}
		
		function rollbackTrans($id_trans)
		{
			$result = false;
			$res = $this->ExecCommand('', 'rollbackTrans', $id_trans);
			if ($res)
			{
				$result = array();
				$result['status'] = sprintf("%d", $res->response->status);
			}
			return $result;
		}
		
		function sendSMS($id_user, $phone_zone, $msg)
		{
			$result = false;
			$res = $this->ExecCommand('', 'sendSMS', $id_user.','.$phone_zone.','.$msg);
			if ($res)
			{
				$result = array();
				$result['id'] = sprintf("%d", $res->response->id);
				$result['cost'] = sprintf("%d", $res->response->cost);
			}
			return $result;
		}
		
		function getWidgets($sid)
		{
			$result = false;
			$res = $this->ExecCommand($sid, 'getWidgets', '');
			if ($res)
			{
				$result = array();
				$result['header'] = base64_decode(sprintf("%s", $res->response->header));
				$result['footer'] = base64_decode(sprintf("%s", $res->response->footer));
			}
			return $result;
		}
		
		function ExecCommand($sid, $cmd, $param)
		{
			$this->last_code = 0;
			$this->last_trans = 0;
						$url = $this->param['URL'];
			$url .= "?sid=".$sid;
			$url .= "&sid_ua=".$this->param['SID']['ua'];
			$url .= "&sid_ip=".$this->param['SID']['ip'];
			$url .= "&id=".$this->param['ID'];
			$url .= "&cmd=".$cmd;
			$url .= "&param=".rawurlencode($param);
			$url .= "&secret=".$this->param['SECRET'];
			$url .= "&host=".$this->param['HOST'];
			$url .= "&ver=".$this->param['VER'];

			$confirm = '';
			$connection = stream_context_create($this->param['CONTEXT']);
			$data = file_get_contents($url, false, $connection);
			if ($data)
			{				$xml = @simplexml_load_string($data);
				if ($xml)
				{
					if ($xml->result->code == 201)
					{
						$confirm = $xml->response->confirm;
						if (!empty($xml->response->trans))
							$this->last_trans = sprintf("%d", $xml->response->trans);
					}
					else
					{
						$this->LogError($xml->result->text);
						$this->last_code = sprintf("%d", $xml->result->code);
					}
				}
				else
					$this->LogError("Unexpected response for command request"."\r\n".$data);
			}
			else
				$this->LogError("Unable to send command request"."\r\n"."SID=".$sid." CMD=".$cmd." PARAM=".$param);
			if ($confirm)
			{				$url .= "&confirm=".$confirm;
				$data = file_get_contents($url, false, $connection);
				if ($data)
				{
					$xml = @simplexml_load_string($data);
					if ($xml)
					{
						$code = $xml->result->code;
						$this->last_code = sprintf("%d", $xml->result->code);
						if ($code == 200)
							return $xml;
						else if (($code == 103) || ($code == 303))
						{							$url = $xml->response->url;							$url .= "?ref=".$this->ref;
							$url .= "&sid=".$sid;
							header("location: ".$url);
							die();
						}
						else
							$this->LogError("ID = ".$xml->result->id.". ".$xml->result->text);
					}
					else
						$this->LogError("Unexpected response for confirm request"."\r\n".$data);
				}
				else
					$this->LogError("Unable to send confirm request"."\r\n"."TRANS=".$this->last_trans." SID=".$sid." CMD=".$cmd." PARAM=".$param);
			}

			return false;
		}
		
		function getLastCode()
		{
			return $this->last_code;
		}

		function getLastTrans()
		{
			return $this->last_trans;
		}

		function LogError($txt)
		{			if (isset($this->param['LOG']) && $this->param['LOG'] && ($handle = fopen($this->param['LOG'], 'a')))
			{
				$tmp = "[".date('Y-m-d H:i:s')."]\r\n";
				$tmp .= "Error. ".$txt."\r\n";
				fwrite($handle, $tmp);
				fclose($handle);
			}
		}

	}



?>