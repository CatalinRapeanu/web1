<!--php
include 'connection.php';
$sql="SELECT * FROM bauturi WHERE ID='{$_GET['id']}'";
$query=mysqli_query($con, $sql)or die(mysqli_error($con));
$row=mysqli_fetch_array($query);
echo "Nume: ".$row["nume"]."<br/>";
echo "Imagine: <img src=".$row['imagine']."><br/>";
?-->
<?php
include 'connection.php';

session_start();
if(isset($_COOKIE['username']) && !isset($_SESSION['username']))
{
	$_SESSION['username'] = $_COOKIE['username'];
}
if(isset($_SESSION['username'])){
    $sql="SELECT * FROM conturi WHERE username='{$_SESSION['username']}'";
    $query=mysqli_query($con,$sql) or die(mysqli_query($con));
    $record=mysqli_fetch_array($query);
    $pos=$record['user_type'];
}

if(!isset($_POST['submit'])){
    $sql="SELECT * FROM bauturi WHERE ID='{$_GET['id']}'";
    $result=mysqli_query($con, $sql);
    $record=mysqli_fetch_array($result);
}
else{
    $sql2="SELECT * FROM bauturi WHERE ID='{$_POST['id']}'";
    $result2=mysqli_query($con, $sql2);
    $rec=mysqli_fetch_array($result2);
    $title=$_POST['nume'];
    $ingr=$_POST['ingrediente'];
    $pret=$_POST['pret'];
    $tipb=$_POST['tipbautura'];
    if(isset($_POST['imagine'])){
        $target="./multimedia/".basename($_FILES['imagine']['name']);
    }else{
        $target=$rec['imagine'];
    }
    $sql1="UPDATE bauturi SET nume='{$title}', imagine='{$target}', ingrediente='{$ingr}', tip_bautura='{$tipb}', pret='{$pret}' WHERE id='{$_POST['id']}'";
    mysqli_query($con,$sql1)or die(mysqli_error($con));
    move_uploaded_file($_FILES['imagine']['tmp_name'],$target);
    header('Location:administrarebaza.php');
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Acasa</title>
        <!-- Favicon-->
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="css/styles.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" />
        <script src="js/.js"></script>
        <script src="js/faraclick.js"></script>
        <script src="js/faraplagiat.js"></script>
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top bg-dark">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" style="color: white;" href="index.php">Shooters</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0 ms-lg-4">
                        <li class="nav-item"><a class="nav-link" style="color: #808080;" aria-current="page" href="index.php">Acasa</a></li>
                        <li class="nav-item"><a class="nav-link" style="color: white;" href="about.php">Despre noi</a></li>
                        <li class="nav-item dropdown" >
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">Bauturi</a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a class="dropdown-item" href="produse.php">Toate bauturile</a></li>
                                <li><hr class="dropdown-divider" /></li>
                                <li><a class="dropdown-item" href="populare.php">Shot-uri</a></li>
                                <li><a class="dropdown-item" href="noi.php">Cocktail-uri</a></li>
                            </ul>
                        </li>
                        <?php 
                        if(isset($_SESSION['username'])){
                        echo '<li class="nav-item dropdown">';
                            echo '<a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white;">'.$_SESSION["username"].'</a>';
                            echo '<ul class="dropdown-menu" aria-labelledby="navbarDropdown">';
                                
                                if(isset($_SESSION['username'])){
                                    if($pos == 'admin' ){
                                       echo '<li><a class="dropdown-item" href="administrareconturi.php">Administrare conturi</a></li>';
                                       echo '<li><a class="dropdown-item" href="administrarebaza.php" style="color: black;">Administrare baza de date</a></li>';
                                       echo '<li><hr class="dropdown-divider" /></li>';
                                         }
                                }
                                
                                //echo '<li><hr class="dropdown-divider" /></li>';
                                echo '<li><a class="dropdown-item" href="logout.php">Logout</a></li>';
                            echo '</ul>';
                        echo '</li>';
                        }
                        else{
                            echo '<a class="nav-link" href="rememberme.php" style="color: white;">Login</a>';
                        }
                        ?>
                    </ul>
                </div>
                </div>
        </nav>
        <header class="bg-dark py-5">
            <div class="container px-4 px-lg-5 my-5">
                
                <div class="text-center text-white">
                    <h1 class="display-4 fw-bolder">Vizualizare inregistrare</h1>                             
                    <form method="post" enctype="multipart/form-data">
                    Nume bautura:<input class="form-control" style="width: 30%; margin-left: auto; margin-right: auto;" type="text" name="nume" value="<?php echo $record['nume'];?>" readonly><br/>
                    Imagine:<br/>
                    <img style="width:200px; height:200px;" src="<?php echo $record['imagine'];?>"><br/>
                    Ingrediente:<input class="form-control" style="width: 30%; margin-left: auto; margin-right: auto;" type="text" name="ingrediente" value="<?php echo $record['ingrediente'];?>" readonly><br/>
                    Tipul bauturii:<input class="form-control" style="width: 30%; margin-left: auto; margin-right: auto;" type="text" name="tipbautura" value="<?php echo $record['tip_bautura'];?>" readonly><br/>
                    Pret:<input class="form-control" style="width: 30%; margin-left: auto; margin-right: auto;" type="text" name="pret" value="<?php echo $record['pret'];?>" readonly><br/>
                    <input type="hidden" name="id" value="<?php echo $record['id']; ?>">
                    <a href="administrarebaza.php" class="navbar-brand">Inapoi la tabel</a>
                    </form>
                </div>
            </div>
        </header>
        
        <div class="bg-dark"><br/><br/><br/></div>
        
        <footer class="py-5 bg-dark">
            <div class="container"><p class="m-0 text-center text-white">Copyright &copy; Your Website 2023</p></div>
        </footer>
        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        
    </body>
</html>