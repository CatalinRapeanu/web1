<?php 
require_once('connection.php');
session_start();
    if(isset($_POST['Login']))
    {
       if(empty($_POST['username']) || empty($_POST['password']))
       {
            header("location:rememberme.php?Empty= Please Fill in the Blanks");
       }
       else
       {
            $query="select * from conturi where username='".$_POST['username']."' and password='".$_POST['password']."'";
            $result=mysqli_query($con,$query);

            if(mysqli_fetch_assoc($result))
            {
                $_SESSION['User']=$_POST['username'];
                header("location:index.php?Invalid= Please Enter Correct User Name and Password");
            }
            else
            {
                header("location:rememberme.php");
            }
       }
       if(isset($_POST['rememberme'])){
            setcookie('username', $_POST['username'], time()+60*60*24*365);
            setcookie('password', md5($_POST['password']), time()+60*60*24*365);
        }else{
                setcookie('username', $_POST['username'], false);
                setcookie('password', md5($_POST['password']), false);
        }
    }
    else
    {
        echo 'Not Working Now Guys';
    }

?>