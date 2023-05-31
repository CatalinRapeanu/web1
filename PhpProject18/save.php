<?php
require_once "connection.php";
if(isset($_POST['upload'])){
    $target="./multimedia/".md5(uniqid(time())).basename($_FILES['image']['name']);
    $text=$_POST['nume'];
    $ingrediente=$_POST['ingrediente'];
    $tipb=$_POST['tipbautura'];
    $pret=$_POST['pret'];
    $sql="INSERT INTO bauturi(nume, imagine, ingrediente, tip_bautura, pret) VALUES('$text', '$target','$ingrediente','$tipb','$pret')";
    mysqli_query($con, $sql);
    if(move_uploaded_file($_FILES['image']['tmp_name'], $target)){
        header('location:administrarebaza.php');
    }
}