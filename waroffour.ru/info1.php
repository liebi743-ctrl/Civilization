<?
 
 $re = mysqli_query("SELECT * FROM `countries`");
?>

<ul>
     <?php
      while ( ($cat = mysqli_fetch_assoc($re)) ) {
        echo $cat['ip'];
      }
        ?>
</ul>

<?
//ботинки:
include_once("other_inc/footer.php");

?>
