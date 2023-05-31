<?php
$con = mysqli_connect('localhost','root','','proiect');// or die('Connection failed'. mysqli_error());
if(!$con)
{
    die(mysqli_errno($con));
}