<?php
require_once './server/Home.php';
$result ="";

$server = new Home();

if(isset($_POST['send'])){
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

        <!--profile part start-->
        <section>
            <div class="contact-us  cont-heading">
                <h2 class="text-center">Contact us</h2>
                <ul class="text-center">
                    <li><a href="#"><i class="fas fa-heart"></i></a></li>
                </ul>
                <div class="container">
                    <div class="row">
                        <div class=" col-md-12">
                            <div class="contact-heading-content">
                                <div class="row">
                                    <div class="offset-md-4 col-md-8">
                                        <ul>
                                            <li><i class="fas fa-user"></i></li>
                                        </ul>
                                        <h4>Need 24/7 Support</h4>
                                        <span> Contact Support</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="container">
                        <div class="row">
                            <div class=" col-md-6">
                                <div class="contact-head">
                                    <form method="POST" action="">
                                        <div class="form-group contact-heading row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Name</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" placeholder="Your Name...." name="message_from" required>
                                            </div>
                                        </div>
                                        <div class="form-group contact-heading row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Email/Phone</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" placeholder="Your Email or Phone..." name="contact" required>
                                            </div>
                                        </div>
                                        <div class="form-group contact-heading row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Subject</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control form-control-sm" placeholder="Subject..." name="subject" required>
                                            </div>
                                        </div>
                                        <div class="form-group contact-heading row">
                                            <label class="col-sm-3 col-form-label col-form-label-sm">Message</label>
                                            <div class="col-sm-9">
                                                <textarea class="form-control" rows="3" placeholder="Message..." name="message" required></textarea>
                                            </div>
                                        </div>

                                        <div class="offset-md-4 contact-heading col-2 ">
                                            <button type="submit" class="meating-sub btn btn-primary mb-2" name="send">Submit</button>
                                        </div>
                                        <h4 style="text-align: center;color: red"><?php echo $result; ?></h4>
                                    </form>
                                </div>
                            </div>
                            <div class=" col-md-6">
                                <div class="contact-details">
                                    <ul>
                                        <li><i class="fas fa-envelope-open"></i></li>
                                    </ul>
                                    <h4>Mail Address</h4>
                                    <a href="#">Info@gatchara.com</a><br><br>
                                    <ul>
                                        <li><i class="fas fa-phone-volume"></i></li>
                                    </ul>
                                    <h4>Phone Number</h4>
                                    <p>+393205335380</p>
                                    <p>+41779916097</p>
                                    <p>+8801400250091<p><br><br>
                                    <ul>
                                        <li><i class="fas fa-address-book"></i></li>
                                    </ul>
                                    <h4>Dhaka Office</h4>
                                    <span> 15/A West,  </span>
                                    <p>Dhanmondi Dhaka,1207,Bangladesh </p><br>
                                    <br>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- footer-part start-->
        <?php include './parts/footer.php'; ?>
        <!-- footert-part end-->
        <?php include './parts/js-links.php'; ?>
    </body>
</html>