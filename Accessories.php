

<?php
session_start();
$_SESSION['accessories']=$_POST['des'];
echo "<script>window.close();</script>";
?>