<?php
session_start();
require_once '../auth/Login.php';
$result = '';

if (isset($_SESSION['client_id'])) {
    header('location:../../dashboard/clients/index.php');
}

$login = new Login();

if (isset($_POST['login'])) {

    $result = $login->clientLogin($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>BrideBox || Marriage</title>
        <?php include '../parts/links.php'; ?>
        <style>
            i{ color:red; }
        </style>

    </head>
    <body>
        <div class="main-wrapper account-wrapper">
            <div class="row">
                <div class="col-sm-4">
                    <a href="https://bridebox.nahidul.me"><h2 style="text-align: center;font-family: 'Baumans', cursive;"><i class="fa fa-heart"></i><u>BrideBox</u><i class="fa fa-heart"></i></h2></a>
                </div>
                <div class="col-sm-4"></div>
                <div class="col-sm-4">
                    <h3 style="text-align: center"><i class="fa fa-arrow-left"></i></i><a href="https://bridebox.nahidul.me"  class="active">Back To Home</a></h3>
                </div>
            </div>
            <div class="account-page">
                <div class="account-center">
                    <div class="account-box">
                        <form method="POST" action="" class="form-signin" autocomplete="off">
                            <div class="account-logo">
                                <h1>Login</h1>
                            </div>
                            <div class="form-group">
                                <label>Username</label>
                                <input type="text" name="username" class="form-control" placeholder="Enter username" required>
                            </div>
                            <div class="form-group">
                                <label>Password</label>
                                <input type="password" name="password" class="form-control" placeholder="Enter password" required>
                            </div>
                            <div class="form-group text-right">
                                <a href="forgot-password.php">Forgot your password?</a><br>
                                <a href="../../registration/client/">No account? Create one.</a>
                            </div>
                            <div class="form-group text-center">
                                <button type="submit" name="login" class="btn btn-primary account-btn">Login</button>
                            </div>
                            <?php echo $result ?>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../parts/scripts.php'; ?>
        
    </body>

</html>