
<?php
session_start();
//tes

session_destroy();

echo "<script>window.open('http://www.twitter.com/logout', 'testing', 'height=700,width=300')</script>";

$url = 'http://localhost/nestle/nestle/';
echo "<meta http-equiv=\"Refresh\" content=\"0; url={$url}\">";
// echo "<script>window.location.href='./'</script>";
?>
