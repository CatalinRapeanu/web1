<?php
 include "connection.php";
 $sql="DELETE FROM conturi WHERE id='{$_GET['id']}'";
 $query= mysqli_query($con, $sql) or die (mysqli_error($con));
 header('Location:administrareconturi.php');
 ?>