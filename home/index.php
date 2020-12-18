<?php
require_once './server/Home.php';

$server = new Home();

$profiles = $server->featured_profile();
$profiles2 = $server->featured_profile2();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include './parts/head.php'; ?>

    </head>
    <body>
        <!--heading part start-->
        <?php include './parts/menu.php'; ?>
        <!--slider-partstart -->
        <?php include './parts/slider.php'; ?>
        <!--slider part end-->
        <!--profile part start-->
        <section>
            <div class="profile-part">
                <div class="container">
                    <div class="pro-head cont-heading text-center">
                        <h2>Featured Profiles </h2>
                        <ul>
                            <li><a href="#"><i class="fas fa-heart"></i></a></li>
                        </ul>
                    </div>

                    <div class="for-slick-slider multiple-items">
                        <?php while ($row = $profiles->fetch_assoc()) { ?>
                            <div class="item text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="../dashboard/<?php echo substr($row['propic'], 3) ?>" alt="" >
                                        <a class="pro-btn" href="#modal1">Profile</a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="portfolio-content-field">
                                            <span><?php echo $row['first_name'] . ' ' . $row['first_name'] ?></span>
                                            <P><?php echo $row['age'] ?>&nbsp; years old</P>
                                            <P><?php echo $row['height'] ?><br> <?php echo $row['religion'] ?></P>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        <?php } ?>
                    </div>
                    <div class="for-slick-slider multiple-items">
                        <?php while ($data = $profiles2->fetch_assoc()) { ?>
                            <div class="item text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <img src="../dashboard/<?php echo substr($data['propic'], 3) ?>" alt="">
                                         <a class="pro-btn" href="#modal1">Profile</a>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="portfolio-content-field">
                                            <span><?php echo $data['first_name'] . ' ' . $row['first_name'] ?></span>
                                            <P><?php echo $data['age'] ?>&nbsp; years old</P>
                                            <P><?php echo $data['height'] ?><br> <?php echo $data['religion'] ?></P>
                                            
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        <?php } ?>
                    </div>

                </div>
            </div>
        </section>
        <!--profile part end-->
        <!-- contact-part start-->
        <?php include './parts/contact.php'; ?>
        <!-- contract-part end-->
        <!-- footer-part start-->
        <?php include './parts/footer.php'; ?>
        <!-- footert-part end-->
        <?php include './parts/js-links.php'; ?>
    </body>
</html>