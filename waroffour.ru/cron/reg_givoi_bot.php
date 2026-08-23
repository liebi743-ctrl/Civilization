<?php
foreach($_REQUEST as $key => $var){
$_REQUEST[$key]=trim(htmlspecialchars(addslashes($_REQUEST[$key])));
}


set_time_limit(0);
error_reporting(0);

define('IN_CLV',true);
include_once("../func/functions_clv.php");
mem_connect();

include_once("../other_inc/header.php");


 //все параметры страны ботов, кроме науки - она всегда 100 у обоих ботов...

 //25 часов
 $land[1]=12000; $mountains[1]=2000; $forest[1]=1000; $money[1]=25000; $arbor[1]=10000; $stone[1]=3000; $iron[1]=2500; $grain[1]=15000; $oil[1]=200; $workers[1]=1500; $scientists[1]=1000;
 $spy[1]=50; $sabotage[1]=10; $grabber[1]=35; $verb[1]=10;
 $weapon_force[1]=4; $weapon_force_2[1]=5; $weapon_force_3[1]=5; $weapon_force_4[1]=1; $weapon_force_5[1]=1; $weapon_force_6[1]=1; $weapon_force_7[1]=1;
 $weapon_speed[1]=4; $weapon_speed_2[1]=5; $weapon_speed_3[1]=5; $weapon_speed_4[1]=0; $weapon_speed_5[1]=0; $weapon_speed_6[1]=0; $weapon_speed_7[1]=0;
 $age[1]=60; $moral[1]=10; $exp[1]=1; $study[1]=51;
 $wariorsto[1]=300; $wariorsto_2[1]=300; $wariorsto_3[1]=200; $wariorsto_4[1]=0; $wariorsto_5[1]=0; $wariorsto_6[1]=0; $wariorsto_7[1]=0; $wariorsto_8[1]=0;
 $ip[1]='botsysreg1'; $soft[1]='botsysreg1'; $countryName[1]='Варвары '.rand(0,9999999); $reggedTime[1]=25*60*60;

//37 часов
 $land[2]=16000; $mountains[2]=3500; $forest[2]=1500; $money[2]=35000; $arbor[2]=20000; $stone[2]=5000; $iron[2]=3500; $grain[2]=25000; $oil[2]=500; $workers[2]=2500; $scientists[2]=1000;
 $spy[2]=55; $sabotage[2]=10; $grabber[2]=55; $verb[2]=10;
 $weapon_force[2]=1; $weapon_force_2[2]=8; $weapon_force_3[2]=7; $weapon_force_4[2]=4; $weapon_force_5[2]=4; $weapon_force_6[2]=1; $weapon_force_7[2]=1;
 $weapon_speed[2]=1; $weapon_speed_2[2]=8; $weapon_speed_3[2]=7; $weapon_speed_4[2]=4; $weapon_speed_5[2]=4; $weapon_speed_6[2]=0; $weapon_speed_7[2]=0;
 $age[2]=55; $moral[2]=45; $exp[2]=4000; $study[2]=51;
 $wariorsto[2]=400; $wariorsto_2[2]=600; $wariorsto_3[2]=550; $wariorsto_4[2]=150; $wariorsto_5[2]=100; $wariorsto_6[2]=0; $wariorsto_7[2]=0; $wariorsto_8[2]=0;
 $ip[2]='botsysreg2'; $soft[2]='botsysreg2'; $countryName[2]='Армия Киликийской Армении '.rand(0,9999999); $reggedTime[2]=37*60*60;

//50 часов
 $land[3]=16000; $mountains[3]=3500; $forest[3]=1500; $money[3]=35000; $arbor[3]=20000; $stone[3]=5000; $iron[3]=3500; $grain[3]=25000; $oil[3]=500; $workers[3]=2500; $scientists[3]=1000;
 $spy[3]=55; $sabotage[3]=10; $grabber[3]=55; $verb[3]=10;
 $weapon_force[3]=1; $weapon_force_2[3]=8; $weapon_force_3[3]=7; $weapon_force_4[3]=4; $weapon_force_5[3]=4; $weapon_force_6[3]=1; $weapon_force_7[3]=1;
 $weapon_speed[3]=1; $weapon_speed_2[3]=8; $weapon_speed_3[3]=7; $weapon_speed_4[3]=4; $weapon_speed_5[3]=4; $weapon_speed_6[3]=0; $weapon_speed_7[3]=0;
 $age[3]=55; $moral[3]=45; $exp[3]=4000; $study[3]=51;
 $wariorsto[3]=0; $wariorsto_2[3]=600; $wariorsto_3[3]=550; $wariorsto_4[3]=150; $wariorsto_5[3]=100; $wariorsto_6[3]=0; $wariorsto_7[3]=0; $wariorsto_8[3]=0;
 $ip[3]='botsysreg2'; $soft[3]='botsysreg2'; $countryName[3]='Армия Киликийской Армении '.rand(0,9999999); $reggedTime[3]=50*60*60;

//75 часов
 $land[4]=20000; $mountains[4]=5000; $forest[4]=2000; $money[4]=40000; $arbor[4]=25000; $stone[4]=7000; $iron[4]=4000; $grain[4]=40000; $oil[4]=1000; $workers[4]=4000; $scientists[4]=1000;
 $spy[4]=65; $sabotage[4]=10; $grabber[4]=55; $verb[4]=10;
 $weapon_force[4]=1; $weapon_force_2[4]=13; $weapon_force_3[4]=10; $weapon_force_4[4]=7; $weapon_force_5[4]=7; $weapon_force_6[4]=5; $weapon_force_7[4]=1;
 $weapon_speed[4]=1; $weapon_speed_2[4]=13; $weapon_speed_3[4]=10; $weapon_speed_4[4]=7; $weapon_speed_5[4]=7; $weapon_speed_6[4]=5; $weapon_speed_7[4]=0;
 $age[4]=60; $moral[4]=60; $exp[4]=12000; $study[4]=51;
 $wariorsto[4]=0; $wariorsto_2[4]=2000; $wariorsto_3[4]=1000; $wariorsto_4[4]=500; $wariorsto_5[4]=500; $wariorsto_6[4]=400; $wariorsto_7[4]=0; $wariorsto_8[4]=0;
 $ip[4]='botsysreg3'; $soft[4]='botsysreg3'; $countryName[4]='Гайдуки '.rand(0,9999999); $reggedTime[4]=75*60*60;

//100 часов
 $land[5]=25000; $mountains[5]=7000; $forest[5]=4000; $money[5]=50000; $arbor[5]=25000; $stone[5]=8500; $iron[5]=5500; $grain[5]=60000; $oil[5]=2000; $workers[5]=4500; $scientists[5]=1000;
 $spy[5]=80; $sabotage[5]=10; $grabber[5]=75; $verb[5]=10;
 $weapon_force[5]=1; $weapon_force_2[5]=15; $weapon_force_3[5]=10; $weapon_force_4[5]=10; $weapon_force_5[5]=7; $weapon_force_6[5]=5; $weapon_force_7[5]=5;
 $weapon_speed[5]=1; $weapon_speed_2[5]=15; $weapon_speed_3[5]=10; $weapon_speed_4[5]=10; $weapon_speed_5[5]=7; $weapon_speed_6[5]=5; $weapon_speed_7[5]=5;
 $age[5]=60; $moral[5]=90; $exp[5]=20000; $study[5]=51;
 $wariorsto[5]=0; $wariorsto_2[5]=2500; $wariorsto_3[5]=1500; $wariorsto_4[5]=1000; $wariorsto_5[5]=1000; $wariorsto_6[5]=700; $wariorsto_7[5]=500; $wariorsto_8[5]=0;
 $ip[5]='botsysreg4'; $soft[5]='botsysreg4'; $countryName[5]='Дети Львицы '.rand(0,9999999); $reggedTime[5]=100*60*60;

//125 часов
 $land[6]=30000; $mountains[6]=9000; $forest[6]=4000; $money[6]=60000; $arbor[6]=30000; $stone[6]=10000; $iron[6]=8000; $grain[6]=80000; $oil[6]=2500; $workers[6]=4500; $scientists[6]=1000;
 $spy[6]=85; $sabotage[6]=10; $grabber[6]=75; $verb[6]=10;
 $weapon_force[6]=1; $weapon_force_2[6]=20; $weapon_force_3[6]=10; $weapon_force_4[6]=12; $weapon_force_5[6]=10; $weapon_force_6[6]=10; $weapon_force_7[6]=7;
 $weapon_speed[6]=1; $weapon_speed_2[6]=15; $weapon_speed_3[6]=10; $weapon_speed_4[6]=12; $weapon_speed_5[6]=10; $weapon_speed_6[6]=10; $weapon_speed_7[6]=7;
 $age[6]=70; $moral[6]=110; $exp[6]=25000; $study[6]=51;
 $wariorsto[6]=0; $wariorsto_2[6]=3500; $wariorsto_3[6]=1800; $wariorsto_4[6]=1000; $wariorsto_5[6]=1000; $wariorsto_6[6]=1000; $wariorsto_7[6]=500; $wariorsto_8[6]=0;
 $ip[6]='botsysreg5'; $soft[6]='botsysreg5'; $countryName[6]='Венецианские галерные рабы '.rand(0,9999999); $reggedTime[6]=125*60*60;

//150 часов
 $land[7]=35000; $mountains[7]=10000; $forest[7]=4500; $money[7]=60000; $arbor[7]=40000; $stone[7]=10000; $iron[7]=8000; $grain[7]=90000; $oil[7]=2500; $workers[7]=4500; $scientists[7]=1500;
 $spy[7]=85; $sabotage[7]=10; $grabber[7]=75; $verb[7]=10;
 $weapon_force[7]=1; $weapon_force_2[7]=20; $weapon_force_3[7]=15; $weapon_force_4[7]=12; $weapon_force_5[7]=12; $weapon_force_6[7]=12; $weapon_force_7[7]=10;
 $weapon_speed[7]=1; $weapon_speed_2[7]=20; $weapon_speed_3[7]=15; $weapon_speed_4[7]=12; $weapon_speed_5[7]=12; $weapon_speed_6[7]=12; $weapon_speed_7[7]=10;
 $age[7]=60; $moral[7]=135; $exp[7]=50000; $study[7]=100;
 $wariorsto[7]=0; $wariorsto_2[7]=4000; $wariorsto_3[7]=2000; $wariorsto_4[7]=1500; $wariorsto_5[7]=1000; $wariorsto_6[7]=1000; $wariorsto_7[7]=500; $wariorsto_8[7]=0;
 $ip[7]='botsysreg6'; $soft[7]='botsysreg6'; $countryName[7]='Львовская городская стража '.rand(0,9999999); $reggedTime[7]=150*60*60;

//175 часов
 $land[8]=45000; $mountains[8]=12000; $forest[8]=4500; $money[8]=60000; $arbor[8]=45000; $stone[8]=10000; $iron[8]=8000; $grain[8]=90000; $oil[8]=2500; $workers[8]=4500; $scientists[8]=1500;
 $spy[8]=90; $sabotage[8]=10; $grabber[8]=75; $verb[8]=10;
 $weapon_force[8]=1; $weapon_force_2[8]=25; $weapon_force_3[8]=15; $weapon_force_4[8]=15; $weapon_force_5[8]=12; $weapon_force_6[8]=12; $weapon_force_7[8]=10;
 $weapon_speed[8]=1; $weapon_speed_2[8]=25; $weapon_speed_3[8]=15; $weapon_speed_4[8]=15; $weapon_speed_5[8]=12; $weapon_speed_6[8]=12; $weapon_speed_7[8]=10;
 $age[8]=60; $moral[8]=155; $exp[8]=60000; $study[8]=100;
 $wariorsto[8]=0; $wariorsto_2[8]=5500; $wariorsto_3[8]=2500; $wariorsto_4[8]=1500; $wariorsto_5[8]=1500; $wariorsto_6[8]=1000; $wariorsto_7[8]=800; $wariorsto_8[8]=0;
 $ip[8]='botsysreg7'; $soft[8]='botsysreg7'; $countryName[8]='Мамлюки '.rand(0,9999999); $reggedTime[8]=175*60*60;

//200 часов
 $land[9]=55000; $mountains[9]=14000; $forest[9]=5000; $money[9]=70000; $arbor[9]=50000; $stone[9]=13000; $iron[9]=10000; $grain[9]=100000; $oil[9]=3000; $workers[9]=5000; $scientists[9]=2000;
 $spy[9]=100; $sabotage[9]=10; $grabber[9]=90; $verb[9]=10;
 $weapon_force[9]=1; $weapon_force_2[9]=35; $weapon_force_3[9]=15; $weapon_force_4[9]=15; $weapon_force_5[9]=15; $weapon_force_6[9]=15; $weapon_force_7[9]=10;
 $weapon_speed[9]=1; $weapon_speed_2[9]=35; $weapon_speed_3[9]=15; $weapon_speed_4[9]=15; $weapon_speed_5[9]=15; $weapon_speed_6[9]=15; $weapon_speed_7[9]=10;
 $age[9]=60; $moral[9]=170; $exp[9]=75000; $study[9]=100;
 $wariorsto[9]=0; $wariorsto_2[9]=6000; $wariorsto_3[9]=3000; $wariorsto_4[9]=1500; $wariorsto_5[9]=1500; $wariorsto_6[9]=1500; $wariorsto_7[9]=1000; $wariorsto_8[9]=0;
 $ip[9]='botsysreg8'; $soft[9]='botsysreg8'; $countryName[9]='Тамплиеры '.rand(0,9999999); $reggedTime[9]=200*60*60;

//225 часов
 $land[10]=65000; $mountains[10]=16000; $forest[10]=5500; $money[10]=70000; $arbor[10]=55000; $stone[10]=13000; $iron[10]=10000; $grain[10]=100000; $oil[10]=3000; $workers[10]=5000; $scientists[10]=2000;
 $spy[10]=100; $sabotage[10]=10; $grabber[10]=90; $verb[10]=10;
 $weapon_force[10]=1; $weapon_force_2[10]=35; $weapon_force_3[10]=20; $weapon_force_4[10]=17; $weapon_force_5[10]=15; $weapon_force_6[10]=15; $weapon_force_7[10]=10;
 $weapon_speed[10]=1; $weapon_speed_2[10]=35; $weapon_speed_3[10]=20; $weapon_speed_4[10]=17; $weapon_speed_5[10]=15; $weapon_speed_6[10]=15; $weapon_speed_7[10]=10;
 $age[10]=60; $moral[10]=180; $exp[10]=80000; $study[10]=110;
 $wariorsto[10]=0; $wariorsto_2[10]=6500; $wariorsto_3[10]=3000; $wariorsto_4[10]=1500; $wariorsto_5[10]=1500; $wariorsto_6[10]=1000; $wariorsto_7[10]=1000; $wariorsto_8[10]=0;
 $ip[10]='botsysreg9'; $soft[10]='botsysreg9'; $countryName[10]='Шаолиньские монахи '.rand(0,9999999); $reggedTime[10]=225*60*60;

 //250 часов
 $land[11]=65000; $mountains[11]=18000; $forest[11]=5500; $money[11]=70000; $arbor[11]=65000; $stone[11]=13000; $iron[11]=10000; $grain[11]=200000; $oil[11]=3000; $workers[11]=5000; $scientists[11]=2000;
 $spy[11]=100; $sabotage[11]=10; $grabber[11]=90; $verb[11]=10;
 $weapon_force[11]=1; $weapon_force_2[11]=35; $weapon_force_3[11]=20; $weapon_force_4[11]=17; $weapon_force_5[11]=15; $weapon_force_6[11]=15; $weapon_force_7[11]=10;
 $weapon_speed[11]=1; $weapon_speed_2[11]=35; $weapon_speed_3[11]=20; $weapon_speed_4[11]=17; $weapon_speed_5[11]=15; $weapon_speed_6[11]=15; $weapon_speed_7[11]=10;
 $age[11]=60; $moral[11]=190; $exp[11]=90000; $study[11]=110;
 $wariorsto[11]=0; $wariorsto_2[11]=7000; $wariorsto_3[11]=3000; $wariorsto_4[11]=1500; $wariorsto_5[11]=1500; $wariorsto_6[11]=1000; $wariorsto_7[11]=1000; $wariorsto_8[11]=0;
 $ip[11]='botsysreg10'; $soft[11]='botsysreg10'; $countryName[11]='Далматское ополчение '.rand(0,9999999); $reggedTime[11]=250*60*60;

//300 часов
 $land[12]=75000; $mountains[12]=19000; $forest[12]=6500; $money[12]=80000; $arbor[12]=75000; $stone[12]=16000; $iron[12]=11500; $grain[12]=200000; $oil[12]=3500; $workers[12]=6000; $scientists[12]=2000;
 $spy[12]=100; $sabotage[12]=10; $grabber[12]=90; $verb[12]=10;
 $weapon_force[12]=1; $weapon_force_2[12]=40; $weapon_force_3[12]=25; $weapon_force_4[12]=17; $weapon_force_5[12]=15; $weapon_force_6[12]=15; $weapon_force_7[12]=10;
 $weapon_speed[12]=1; $weapon_speed_2[12]=40; $weapon_speed_3[12]=25; $weapon_speed_4[12]=17; $weapon_speed_5[12]=15; $weapon_speed_6[12]=15; $weapon_speed_7[12]=10;
 $age[12]=100; $moral[12]=200; $exp[12]=95000; $study[12]=110;
 $wariorsto[12]=0; $wariorsto_2[12]=8000; $wariorsto_3[12]=3500; $wariorsto_4[12]=2000; $wariorsto_5[12]=2000; $wariorsto_6[12]=1500; $wariorsto_7[12]=1000; $wariorsto_8[12]=0;
 $ip[12]='botsysreg11'; $soft[12]='botsysreg11'; $countryName[12]='Монголы '.rand(0,9999999); $reggedTime[12]=300*60*60;

 //350 часов
 $land[13]=75000; $mountains[13]=20000; $forest[13]=6500; $money[13]=80000; $arbor[13]=80000; $stone[13]=16000; $iron[13]=11500; $grain[13]=300000; $oil[13]=3500; $workers[13]=6500; $scientists[13]=2000;
 $spy[13]=100; $sabotage[13]=10; $grabber[13]=90; $verb[13]=10;
 $weapon_force[13]=1; $weapon_force_2[13]=40; $weapon_force_3[13]=25; $weapon_force_4[13]=17; $weapon_force_5[13]=15; $weapon_force_6[13]=15; $weapon_force_7[13]=15;
 $weapon_speed[13]=1; $weapon_speed_2[13]=40; $weapon_speed_3[13]=25; $weapon_speed_4[13]=17; $weapon_speed_5[13]=15; $weapon_speed_6[13]=15; $weapon_speed_7[13]=15;
 $age[13]=110; $moral[13]=200; $exp[13]=100000; $study[13]=130;
 $wariorsto[13]=0; $wariorsto_2[13]=8500; $wariorsto_3[13]=3500; $wariorsto_4[13]=2000; $wariorsto_5[13]=2000; $wariorsto_6[13]=2000; $wariorsto_7[13]=1500; $wariorsto_8[13]=0;
 $ip[13]='botsysreg12'; $soft[13]='botsysreg12'; $countryName[13]='Енисейские Кыргызы '.rand(0,9999999); $reggedTime[13]=350*60*60;

//400 часов
 $land[14]=80000; $mountains[14]=20000; $forest[14]=6500; $money[14]=80000; $arbor[14]=85000; $stone[14]=16000; $iron[14]=11500; $grain[14]=300000; $oil[14]=3500; $workers[14]=6500; $scientists[14]=2000;
 $spy[14]=101; $sabotage[14]=10; $grabber[14]=90; $verb[14]=10;
 $weapon_force[14]=1; $weapon_force_2[14]=40; $weapon_force_3[14]=25; $weapon_force_4[14]=17; $weapon_force_5[14]=17; $weapon_force_6[14]=17; $weapon_force_7[14]=15;
 $weapon_speed[14]=1; $weapon_speed_2[14]=40; $weapon_speed_3[14]=25; $weapon_speed_4[14]=17; $weapon_speed_5[14]=17; $weapon_speed_6[14]=17; $weapon_speed_7[14]=15;
 $age[14]=130; $moral[14]=200; $exp[14]=110000; $study[14]=140;
 $wariorsto[14]=0; $wariorsto_2[14]=8700; $wariorsto_3[14]=3700; $wariorsto_4[14]=2200; $wariorsto_5[14]=2200; $wariorsto_6[14]=1500; $wariorsto_7[14]=1100; $wariorsto_8[14]=0;
 $ip[14]='botsysreg13'; $soft[14]='botsysreg13'; $countryName[14]='Монахи воины Шаолинь '.rand(0,9999999); $reggedTime[14]=400*60*60;

//450 часов
 $land[15]=80000; $mountains[15]=21500; $forest[15]=6500; $money[15]=90000; $arbor[15]=90000; $stone[15]=17000; $iron[15]=12000; $grain[15]=300000; $oil[15]=4000; $workers[15]=6500; $scientists[15]=2500;
 $spy[15]=101; $sabotage[15]=10; $grabber[15]=90; $verb[15]=10;
 $weapon_force[15]=1; $weapon_force_2[15]=45; $weapon_force_3[15]=25; $weapon_force_4[15]=17; $weapon_force_5[15]=20; $weapon_force_6[15]=17; $weapon_force_7[15]=15;
 $weapon_speed[15]=1; $weapon_speed_2[15]=45; $weapon_speed_3[15]=25; $weapon_speed_4[15]=17; $weapon_speed_5[15]=20; $weapon_speed_6[15]=17; $weapon_speed_7[15]=15;
 $age[15]=130; $moral[15]=210; $exp[15]=120000; $study[15]=145;
 $wariorsto[15]=0; $wariorsto_2[15]=9000; $wariorsto_3[15]=3700; $wariorsto_4[15]=2200; $wariorsto_5[15]=2200; $wariorsto_6[15]=1800; $wariorsto_7[15]=1500; $wariorsto_8[15]=0;
 $ip[15]='botsysreg14'; $soft[15]='botsysreg14'; $countryName[15]='Гунны '.rand(0,9999999); $reggedTime[15]=450*60*60;

//500 часов
 $land[16]=80000; $mountains[16]=21500; $forest[16]=6500; $money[16]=90000; $arbor[16]=95000; $stone[16]=17000; $iron[16]=12000; $grain[16]=350000; $oil[16]=4000; $workers[16]=6800; $scientists[16]=2500;
 $spy[16]=101; $sabotage[16]=10; $grabber[16]=90; $verb[16]=10;
 $weapon_force[16]=1; $weapon_force_2[16]=45; $weapon_force_3[16]=25; $weapon_force_4[16]=17; $weapon_force_5[16]=20; $weapon_force_6[16]=17; $weapon_force_7[16]=15;
 $weapon_speed[16]=1; $weapon_speed_2[16]=45; $weapon_speed_3[16]=25; $weapon_speed_4[16]=17; $weapon_speed_5[16]=20; $weapon_speed_6[16]=17; $weapon_speed_7[16]=15;
 $age[16]=130; $moral[16]=220; $exp[16]=120000; $study[16]=150;
 $wariorsto[16]=0; $wariorsto_2[16]=9000; $wariorsto_3[16]=4000; $wariorsto_4[16]=2200; $wariorsto_5[16]=2200; $wariorsto_6[16]=2000; $wariorsto_7[16]=1700; $wariorsto_8[16]=0;
 $ip[16]='botsysreg15'; $soft[16]='botsysreg15'; $countryName[16]='Русские дружинники '.rand(0,9999999); $reggedTime[16]=500*60*60;

//550 часов
 $land[17]=85000; $mountains[17]=23000; $forest[17]=7000; $money[17]=190000; $arbor[17]=100000; $stone[17]=17000; $iron[17]=12000; $grain[17]=400000; $oil[17]=4000; $workers[17]=7500; $scientists[17]=2500;
 $spy[17]=101; $sabotage[17]=10; $grabber[17]=95; $verb[17]=10;
 $weapon_force[17]=1; $weapon_force_2[17]=50; $weapon_force_3[17]=30; $weapon_force_4[17]=20; $weapon_force_5[17]=20; $weapon_force_6[17]=20; $weapon_force_7[17]=15;
 $weapon_speed[17]=1; $weapon_speed_2[17]=50; $weapon_speed_3[17]=30; $weapon_speed_4[17]=20; $weapon_speed_5[17]=20; $weapon_speed_6[17]=20; $weapon_speed_7[17]=15;
 $age[17]=130; $moral[17]=230; $exp[17]=120000; $study[17]=170;
 $wariorsto[17]=0; $wariorsto_2[17]=9500; $wariorsto_3[17]=4000; $wariorsto_4[17]=2200; $wariorsto_5[17]=2200; $wariorsto_6[17]=2200; $wariorsto_7[17]=2000; $wariorsto_8[17]=0;
 $ip[17]='botsysreg16'; $soft[17]='botsysreg16'; $countryName[17]='Рыцари Мальты '.rand(0,9999999); $reggedTime[17]=550*60*60;



 for($i=1;$i<18;$i++)
 {
 $query = "SELECT max(userID)as maxx FROM uzers";
 $result = mysql_query($query);
 $a = mysql_fetch_array($result);
 $userID = $a['maxx']+1;

 $username = 'botsysreg'.rand(0,99999999);
 $password1 = rand(1000000,9999999);

 //генерируем уникальный идентификатор страны чувака:
 $countryID=generateCountryID($userID,$password1,$username,$countryName[$i]);
 $password=md5($password1);

 $query="INSERT INTO `uzers` SET userID = '$userID', countryID = '$countryID', username = '$username',
 Email = 'sys@sys.sys', firstemail = 'sys@sys.sys', password = '$password', onlineflag=0, noob=2,
 ip = '".$ip[$i]."', soft = '".$soft[$i]."', telnum = 'sysnumber', inv = 0, lastsessid = '', clanID = 0,
 maratory=25, voting=0, cnts='', lastMail = 0, lastMaratory=0, datereg = '".date("d M Y")."',
 about = 'sys', imya = 'sys', counts = 0, credits = 0, spent=0, race=0, class=0";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

 $query="INSERT INTO countries SET countryID = '$countryID', countryName = '".$countryName[$i]."',
 reggedTime='".(time()-$reggedTime[$i])."', nalog=1, napr=0, lastNal = '".(time()-$reggedTime[$i])."', lastWar = '".(time()-$reggedTime[$i])."', land='".$land[$i]."', mountains='".$mountains[$i]."',
 forest='".$forest[$i]."', money='".$money[$i]."', arbor='".$arbor[$i]."', stone='".$stone[$i]."', iron='".$iron[$i]."', grain='".$grain[$i]."', oil='".$oil[$i]."',
 workers='".$workers[$i]."', scientists='".$scientists[$i]."', science=100, plotn_people=100, plotn_wariors=100,
 people_adding=100, forest_adding=100, grain_making=100, arbor_making=100, iron_making=100,
 stone_making=100, oil_making=100, forest_max=100, mountains_max=100, spy='".$spy[$i]."', sabotage='".$sabotage[$i]."', grabber='".$grabber[$i]."',
 verb='".$verb[$i]."', spyTime=0, sabTime=0, grbTime=0, vrbTime=0, wariors_free = '".$wariorsto[$i]."', wariors_free_2 = '".$wariorsto_2[$i]."', wariors_free_3 = '".$wariorsto_3[$i]."', wariors_free_4 = '".$wariorsto_4[$i]."',
 wariors_free_5 = '".$wariorsto_5[$i]."', wariors_free_6 = '".$wariorsto_6[$i]."', wariors_free_7 = '".$wariorsto_7[$i]."', wariors_free_8 = '".$wariorsto_8[$i]."',
 weapon_force='".$weapon_force[$i]."', weapon_force_2='".$weapon_force_2[$i]."', weapon_force_3='".$weapon_force_3[$i]."', weapon_force_4='".$weapon_force_4[$i]."', weapon_force_5='".$weapon_force_5[$i]."',
 weapon_force_6='".$weapon_force_6[$i]."', weapon_force_7='".$weapon_force_7[$i]."', weapon_force_8=1,
 weapon_speed='".$weapon_speed[$i]."', weapon_speed_2='".$weapon_speed_2[$i]."', weapon_speed_3='".$weapon_speed_3[$i]."', weapon_speed_4='".$weapon_speed_4[$i]."', weapon_speed_5='".$weapon_speed_5[$i]."',
 weapon_speed_6='".$weapon_speed_6[$i]."', weapon_speed_7='".$weapon_speed_7[$i]."', weapon_speed_8=0,
 ip = '".$ip[$i]."', soft = '".$soft[$i]."', count=100000, protection=5, unites=2";
 $result=MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));

//здания
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'citadel', space = 60, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'zavod', space = 500, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'market', space = 35000, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'scientificcenter', space = 30, var2 = 10, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'village', space = 5000, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'warhouse', space = 40, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'gorodmagov', space = 600, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'neftevxwka', space = 1000, hits = 100");
 mysql_query("INSERT INTO `buildings` SET countryID = '$countryID', building = 'wall', space = 300, hits = 100");

//генерал
 $query="INSERT INTO `general` VALUES ('$countryID','".$ip[$i]."','".$age[$i]."','".$moral[$i]."','".$exp[$i]."','".$study[$i]."')";
 $result=@MYSQL_QUERY($query) or (mySQLqueryERROR($query) and die(""));


//Получаем соседей:
//С востока
 $query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$countryID."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
   and (reggedTime<".(time()-$reggedTime[$i]).") ORDER BY reggedTime DESC
   LIMIT 5";

   $result=@MYSQL_QUERY($query);
   while (($a4=mysql_fetch_array($result))!==FALSE){

    $neigh_=$a4["countryName"];
    $neighbourID=$a4["countryID"];

    setNeighbour($countryID,$neighbourID);
    sendMessage($neighbourID,"newNeighbour",$countryName[$i]);
    sendMessage($countryID,"newNeighbour",$neigh_);
   }

//С запада
 $query="SELECT countries.countryID,countries.countryName FROM `countries` LEFT JOIN `messages`
   ON countries.countryID=messages.countryID and messages.`from` = 'loose'
   WHERE (messages.countryID IS NULL)and(countries.countryID!='".$countryID."')and
   (countries.countryID NOT IN (SELECT neighbourID FROM neighbours WHERE countryID='".$countryID."'))
   and (reggedTime>".(time()-$reggedTime[$i]).") ORDER BY reggedTime ASC
   LIMIT 5";

   $result=@MYSQL_QUERY($query);
   while (($a4=mysql_fetch_array($result))!==FALSE){

    $neigh_=$a4["countryName"];
    $neighbourID=$a4["countryID"];

    setNeighbour($countryID,$neighbourID);
    sendMessage($neighbourID,"newNeighbour",$countryName[$i]);
    sendMessage($countryID,"newNeighbour",$neigh_);
   }

 echo ''.$ip[$i].' - login - '.$username.', pass - '.$password1.'<br />';
 }
include_once("../other_inc/footer.php");
?>