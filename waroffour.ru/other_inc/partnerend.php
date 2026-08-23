<?
#--------------------- WAP Lineage -------------------#
#  VPortale.Ru                             L2full.ru  #
#             (c) by FrosT, 2008 - 2011               #
#-----------------------------------------------------#
echo '
<div class="clear"></div>
</div>
<div id="sb">
<span class="sbtop"></span>
<div class="sbcn">
  <h2><a href="http://waroffour.ru">Онлайн игра Война Четырех!</a></h2>
  <ul id="latestposts">
    <li><a href="http://waroffour.ru">Посмотреть игру</a></li>
   </ul>
</div>
<span class="sbbtm"></span></div>
<div class="clear"></div>
</div>
<div id="ft">&copy; waroffour.ru, 2011 &nbsp;&nbsp;&nbsp; <a href="partner.php?per">ПЕРЕХОДЫ</a> | <a href="partner.php?reg">РЕГИСТРАЦИИ</a> | <a href="partner.php?sms">СМС</a> | <a href="partner.php?all">ОБЩАЯ СТАТИСТИКА</a>';
list($msec,$sec)=explode(chr(32),microtime());
echo '<div align="right">'.round((($sec+$msec)-$gtime),4).'</div>';
echo '</div>';

ob_end_flush();
exit;
?>