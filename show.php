<html lang="sr">
<head>
  <title>Spyder Net</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  </head>
<content id="content">
  <?php
    $s = file_get_contents($_GET["url"]);
    $newoutput = preg_replace("/ubistvo/i", "<span style=\"color:red;\">$1</span>", $s);
    echo $newoutput;
  ?>
</content>
<?php
  
 ?>

</html>
<script type="text/javascript">
  $(document).ready(function() {
    parent.document.getElementById("text_received").style.height = $("body").height() + 100 + "px";

  })
</script>
