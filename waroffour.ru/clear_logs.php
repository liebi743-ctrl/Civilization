<?php

$ds  = opendir("logs");
chdir("logs");
while (false !== ($files = readdir($ds))) {
   if($files=='.'||$files=='..'||$files=='.htaccess')continue;
   if (file_exists($files)){
     if (time()-filemtime($files)>3600*24*7) unlink($files);
   }
}

echo "done!";

?>