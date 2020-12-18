<?php
require_once './server/Home.php';
$result = "";

$server = new Home();

if (isset($_POST['send'])) {
    $result = $server->send_message($_POST);
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
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="header text-center">
                                    <h2>Search Your Partner</h2>
                                    <ul>
                                        <li><a href="#"><i class="fas fa-heart"></i></a></li>
                                    </ul>
                                </div>
                                <div class="row">
                                    <div class="col-md-7">
                                       <form method="GET" action="search-results.php">
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label col-form-label-sm">Country :</label>
                                                <div class="col-sm-9">
                                                    <input type="text" class="custom-select" list="country" name="country" placeholder="Enter Country"/>
                                                    <datalist name="country" id="country" required>
                                                        <?php include '../dashboard/countries.php'; ?>
                                                    </datalist>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label col-form-label-sm">Loking For :</label>
                                                <div class="col-sm-9">
                                                    <select class="custom-select" name="gender" required>
                                                        <option value="">Select Gender</option>
                                                        <option value="Male">Man</option>
                                                        <option value="Female">Woman</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label col-form-label-sm">Religion:</label>
                                                <div class="col-sm-9">
                                                    <select class="custom-select" name="religion" required>
                                                        <option value="">Select Religion</option>
                                                        <option>Islam</option>
                                                        <option>Christianity</option>
                                                        <option>Judaism</option>
                                                        <option>Hinduism</option>
                                                        <option>Buddhism</option>
                                                        <option>Atheist</option>
                                                        <option>Any</option>
                                                        <option>Other</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label col-form-label-sm">Marital Status:</label>
                                                <div class="col-sm-9">
                                                    <select class="custom-select" name="marital_status" required>
                                                        <option value="">Select Status</option>
                                                        <option>Unmarried</option>
                                                        <option>Married</option>
                                                        <option>Divorced</option>
                                                        <option>Any</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-group row">
                                                <label class="col-sm-3 col-form-label col-form-label-sm">Age From:</label>
                                                <div class="col-sm-4">
                                                    <select class="custom-select" name="age_from" required>
                                                        <option disabled>Select</option>
                                                        <?php for ($i = 18; $i <= 100; $i++) { ?>
                                                            <option><?php echo $i; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                                <label class="col-sm-1 col-form-label col-form-label-sm">To:</label>
                                                <div class="col-sm-4">
                                                    <select class="custom-select" name="age_to" required>
                                                        <option disabled>Select</option>
                                                        <?php for ($i = 18; $i <= 100; $i++) { ?>
                                                            <option><?php echo $i; ?></option>
                                                        <?php }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="offset-md-5 col-2 ">
                                                <button class=" search-submit  btn btn-primary mb-2" type="submit" name="search">Search</button>
                                            </div>
                                        </form>
                                    </div>
                                   
                                    <div class="col-sm-5">
                                        <div class="bd-example">
                                            <div id="carouselExampleCaptions18" class="carousel slide" data-ride="carousel">
                                                <div class="carousel-inner carousel-search">
                                                    <div class="carousel-item active">
                                                        <img src="images/search1.jpg" class="d-block w-100" alt="...">
                                                        <div class="carousel-caption d-none d-md-block">
                                                            <h5>We provide Best Service</h5>
                                                            <p>Nulla vitae elit libero, a pharetra augue mollis interdum.</p>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item carousel-search ">
                                                        <img src="images/search2.jpg" class="d-block w-100" alt="...">
                                                        <div class="carousel-caption d-none d-md-block">
                                                            <h5>We provide Best Sequrity</h5>
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                                                        </div>
                                                    </div>
                                                    <div class="carousel-item carousel-search">
                                                        <img src="images/search3.jpg" class="d-block w-100" alt="...">
                                                        <div class="carousel-caption d-none d-md-block">
                                                            <h5>Your Privacy Is Our Resposibility</h5>
                                                            <p>Praesent commodo cursus magna, vel scelerisque nisl consectetur.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Previous</span>
                                                </a>
                                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                    <span class="sr-only">Next</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
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