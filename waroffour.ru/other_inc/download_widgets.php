<?php
function load_w(){
global $mgates_data;

if ( $_SERVER[HTTP_HOST] == 'waroffour.mgates.ru' OR $_GET['qtest'] == 1)
{
                            if ($_GET['qtest'] == 1)
                            print_r($_SERVER);

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


                            if ($_SESSION['id_user'])
                            $mgates_data= $mgates->getWidgets($_SESSION['sid_value']);

}


}

load_w();

?>