<?php
// byvlad
require_once 'class.phpmailer.php';

$file = file('mails.txt');
$text = 'Привет!<br/>
Друзья, сокланы постоянно спрашивают о тебе, потому мы решили написать тебе email.<br/>
Возвращайся скорее, мы приготовили для тебя подарок!<br/>
<a href="l2wap.ru">Вернуться и Забрать Подарок</a><br/><br/>
- Появились заместители главы клана;<br/>
- Фестиваль семи печатей;<br/>
- Новые осады замков;<br/>
- Новая рыбалка;<br/>
- Свадьбы;<br/>
- Достижения;<br/>
- Амнистия (до 07.06.2013);<br/><br/>
- Ежедневные бонусы в окрестностях;<br/>
- Клан "Элита" набирает людей;<br/>
- Множество улучшений в клане, городе, при общении;<br/>
- Исправлены ошибки рынка, люкс магазина и пр.;<br/>
- Открыт перевод игровой валюты, открыт банк;<br/>
- Полное восстановление жизней и маны при получении уровня;<br/>
- Регенерация жизней и маны у кланов 3-го ур. и более восстанавливается быстрее.<br/><br/>
И это еще не все!<br/>
Возвращайся поскорей.<br/><br/>
Адрес: <a href="l2wap.ru">l2wap.ru</a><br/>
Восстановить пароль: <a href="l2wap.ru/password.php">l2wap.ru/password.php</a>
';

$from = array('Wap LineAge Online Game', 'support@l2wap.ru', 'Возвращайся скорее, тебя ждет подарок');

foreach($file AS $obj) {
	$user = explode('|', $obj);
	
	$mail = new PHPMailer; 
	$mail->From = $from[1];      // от кого 
	$mail->FromName = $from[0];   // от кого 
//	$mail->AddAddress($user[1], iconv('utf-8', 'windows-1251', $user[0])); // кому - адрес, Имя 
	$mail->AddAddress($user[0], iconv('utf-8', 'windows-1251', $user[0])); // кому - адрес, Имя 
	$mail->IsHTML(true);        // выставляем формат письма HTML 
	$mail->Subject = iconv('utf-8', 'windows-1251', $from[2]);  // тема письма 

	$mail->Body = iconv('utf-8', 'windows-1251', strtr($text, array('%user%' => $user[0],'%nick%' => $user[1])));
// лог
$fp=fopen('sends_mails.dat',"a+");
flock($fp,LOCK_EX);
fputs($fp,"$user[0]|$user[1]");
flock($fp,LOCK_UN);
fclose($fp);
// лог
	// отправляем наше письмо 
	if (!$mail->Send())
		echo 'Mailer Error: '.$mail->ErrorInfo;

sleep(1);
}
?>