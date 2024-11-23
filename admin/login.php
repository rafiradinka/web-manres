<?php
session_start(); // pembatasan
if(isset($_SESSION['admin_username'])!=''){
    header("location:index.php");
    exit();
}
include("../inc/koneksi.php");

$username   = "";
$password   = "";
$err        = "";

if(isset($_POST['login'])){
    $username = $_POST['username'];
    $password = $_POST['password'];

    if($username =='' or $password==''){
        $err    = "Silahkan masukkan semua isian";
    } else {
        $sql1   = "select * from admin where username = '$username'";
        $q1     = mysqli_query($koneksi,$sql1);
        $r1     = mysqli_fetch_array($q1);
        $n1     = mysqli_num_rows($q1);

        if($n1<1){
            $err = "username tidak ditemmukan";
        } elseif($r1['password'] != MD5($password)){
            $err = "password yang kamu masukkan tidak sesuai";
        } else {
            $_SESSION['admin_username'] = $username;
            header("location:index.php");
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Login Admin</title>
</head>
<body style="width:100%; max-width:330px;margin:auto;padding:15px">
    <form action="" method="POST">
        <h1>Login Admin</h1>
        <?php 
        if($err){
        ?>
        <div class="alert alert-danger">
            <?php echo $err ?>
        </div>
        <?php
        }
        ?>
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Masukkan Username Anda" value="<?php echo $username?>"/>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password"/>
        </div>
        <button type="submit" class="btn btn-primary" name="login">Login</button>
    </form>
</body>
</html>