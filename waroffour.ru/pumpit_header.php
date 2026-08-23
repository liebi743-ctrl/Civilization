<?

// Функция формирования QUERY_STRING c подписью 
function GoToPumpit($query, $billing=false) {
     // Формируем подпись запроса
     $sig = getSig($query, $billing);
      //echo "SIG: $sig"."\n";

     $url = PUMPIT_API_URL;
     // Собираем URL с сортировкой по ключам
     ksort($query);
     foreach ($query as $key=>$value){
         // Исключаем параметр sig
         if (strtolower($key)!='sig'){
             $url .= urlencode($key)."=".urlencode($value)."&";
         }
     }
     $url .= "sig=".$sig;
      //echo "URL: $url"."\n";
	  return $url;
}

// Функция формирования подписи
function getSig($query, $billing=false) {
     $str = "";
     // Собираем строку для подписи с сортировкой по ключам
     ksort($query);
     foreach ($query as $key=>$value){
         // Исключаем параметр sig
         if (strtolower($key)!='sig'){
             $str .= $key."=".$value;
         }
     }
     // echo "String for sign: $str"."\n";
     $appkey = ($billing) ? PUMPIT_KEY_BILLING : PUMPIT_KEY_API;
     return md5($str.$appkey);
}


define("PUMPIT_API_URL",     "http://pumpit.ru/riba_api?");
define("PUMPIT_KEY_BILLING", "09mVsXAYRFO4rWJlw");
define("PUMPIT_KEY_API",     "SmWpBuMUaceGrK8Gi");
define("PUMPIT_APP_ID",      "12");

?>