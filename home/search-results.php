<?php
require_once './server/Home.php';
$result = "";

$server = new Home();

if (isset($_GET['search'])) {
    $output = $server->search($_GET);
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include './parts/head.php'; ?>

    </head>
    <body>
        <!--heading part start-->
        <?php include './parts/menu.php'; ?>

        <!-- Serach-part start-->
        <section>
            <div class="search-part">
                <div class="search">
                    <div class="container" style="min-height: 500px">
                        <div class="row">
                            <?php
                            if ($output->num_rows > 0) {
                                while ($row = $output->fetch_assoc()) {
                                    ?>
                                    <div class="card col-sm-12" style="min-height: 190px;padding-top: 2%"> 

                                        <div class="row">
                                            <div class="col-sm-2">
                                                <img style="height: 150px;width:150px" src="../dashboard/<?php echo substr($row['propic'],3) ?>" onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt="">
                                            </div>
                                            <div class="col-sm-3">
                                                <h4><b>Basic Info</b></h4>
                                                <table>
                                                    <tr>
                                                        <td>Name:</td>
                                                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Country:</td>
                                                        <td><?php echo $row['current_country'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>City:</td>
                                                        <td><?php echo $row['current_city'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Marital Status:</td>
                                                        <td><?php echo $row['marital_status'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Religion:</td>
                                                        <td><?php echo $row['religion'] ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-2">
                                                <h4></h4><br>
                                                <table>
                                                    <tr>
                                                        <td>Gender:</td>
                                                        <td><?php echo $row['gender'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Age:</td>
                                                        <td><?php echo $row['age'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Height:</td>
                                                        <td><?php echo $row['height'] ?></td>
                                                    </tr>
                                                    <tr>
                                                        <td>Weight</td>
                                                        <td><?php echo $row['weight'] ?></td>
                                                    </tr>
                                                </table>
                                            </div>
                                            <div class="col-sm-4">
                                                <h4><b>Biography</b></h4>
                                                <?php
                                                $string = $row['biography'];
                                                if (strlen($string) > 100) {
                                                    $trimstring = substr($string, 0, 100) . ' <a href="#modal1' . $a++ . '">read more...</a>';
                                                } else {
                                                    $trimstring = $string;
                                                }
                                                echo $trimstring;
                                                ?>
                                            </div>
                                            <div class="col-sm-1">
                                                <table>

                                                    <tr>
                                                        <td><a href="#modal1" ><button class="btn btn-primary" title="Profile"><i class="fa fa-user"></i></button></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#modal1"><button class="btn btn-success" title="Send Requst"><i class="fa fa-user-plus"></i></button></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#modal1"><button class="btn btn-dark" title="Send Message"><i class="fa fa-envelope"></i></button></a></td>
                                                    </tr>
                                                    <tr>
                                                        <td><a href="#modal1"><button class="btn btn-secondary" title="Like"><i class="fa fa-heart" style="color:red"></i></button></a></td>
                                                    </tr>

                                                </table>

                                                <div class="awesome-modal" id="modal1" style="font-family: 'Titillium Web', sans-serif !important;">
                                                    <a class="close-icon" href="#close"></a>
                                                    <center>
                                                        <h4 class="modal-title text-danger">Sorry! you are not logged in.Please login your account first.</h4>
                                                        <br>
                                                        <a href="../login/client/" class="btn btn-success" style="width:100px">Login</a>
                                                        &emsp;||&emsp;
                                                        <a href="../registration/client/" class="btn btn-primary">Register</a>
                                                    </center>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
        <?php
    }
} else {
    ?>
                                <div class="card col-md-12 col-sm-12  col-lg-12">
                                    <center>
                                        <img alt="" src="" alt="" style="height: 100%;width: 100%">
                                    </center>
                                </div>
<?php }
?>

                        </div>
                    </div>
                </div>

            </div>
        </section>
        <!-- search-part end-->
        <!-- footer-part start-->
<?php include './parts/footer.php'; ?>
        <!-- footert-part end-->
        <?php include './parts/js-links.php'; ?>
    </body>
</html>