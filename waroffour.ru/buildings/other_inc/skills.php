<?
  if($noob>=1)
   printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=spy\">?</a>]
");
  $spy=$b["spy"];
  if ($b['spravo4nik'] == 1)
  $spy=($spy-1) . "% +1";
  printrus ("<u>Шпионаж</u> [".$spy."%]\r\n");
  if($b["spy"]<10000)
   printrus
("<a href=\"citadel.php?$ses&amp;m=spyup\">^</a>

");
  print "<br/>\r\n";

  if($noob>=1)
   printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=sabotage\">?</a>]
");
  printrus ("<u>Саботаж</u> [".$b["sabotage"]."%]\r\n");
  if($b["sabotage"]<10000)
   printrus
("<a href=\"citadel.php?$ses&amp;m=sabotageup\">^</a>

");
  print "<br/>\r\n";

  if($noob>=1)
   printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=grab\">?</a>]
");

  $grab=$b["grabber"];
  if ($b['lapi'] == 1)
  $grab=($grab-1) . "% +1";

  printrus ("<u>Воровство</u> [".$grab."%]\r\n");
  if($b["grabber"]<10000)
   printrus
("<a href=\"citadel.php?$ses&amp;m=grabberup\">^</a>

");
  print "<br/>\r\n";

  if($noob>=1)
   printrus
("[<a href=\"citadel.php?$ses&amp;m=help&amp;n=verb\">?</a>]
");
  printrus ("<u>Вербовка</u> [".$b["verb"]."%]\r\n");
  if($b["verb"]<10000)
   printrus
("<a href=\"citadel.php?$ses&amp;m=verbup\">^</a>

");
  print "<br/>\r\n";
  
  
?>