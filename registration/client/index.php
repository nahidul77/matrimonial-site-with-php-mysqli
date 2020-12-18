<?php
session_start();
require_once './classes/Server.php';
$result = '';
$error = '';
$server = new Server();

if (isset($_POST['save'])) {

    if (empty($_POST["first_name"])) {
        $error = "First name is required";
    } elseif (empty($_POST["birthday"])) {
        $error = "Birthday is required";
    } elseif (empty($_POST["gender"])) {
        $error = "gender is required";
    } elseif (empty($_POST["phone"])) {
        $error = "phone is required";
    } elseif (empty($_POST["username"])) {
        $error = "username is required";
    } elseif (empty($_POST["password"])) {
        $error = "password is required";
    } else {
        $result = $server->registration($_POST);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <title>Matrimony</title>
        <style>
            html {
                overflow: scroll;
                overflow-x: hidden;
            }
            ::-webkit-scrollbar {
                width: 0px;  /* Remove scrollbar space */
                background: transparent;  /* Optional: just make scrollbar invisible */
            }
            /* Optional: show position indicator in red */
            ::-webkit-scrollbar-thumb {
                background: #FF0000;
            }
            body{
                font-family: 'Titillium Web', sans-serif !important;
                font-size: 20px;
                background-image: url("assets/img/background.jpg");
                background-position: center;
                background-repeat: no-repeat;
                background-size: cover;
                overflow: auto;
            }
            a{
                color:blueviolet
            }
            label, h3{
                font-family: 'Rajdhani', sans-serif !important;
                font-weight: bolder !important;
                text-transform: uppercase;

            }
            form input{
                border: 1px solid !important;
            }
            i{
                color:red;
            }
        </style>
        <?php include './parts/css-links.php'; ?>

    </head>
    <body>
        <div class="main-wrapper">
            <div class="row">
                <div class="col-sm-2">

                </div>
                <div class="content col-sm-8">
                    <div class="row">
                        <div class="col-sm-12">
                            <center>
                                <h2 style="text-align: center;font-family: 'Baumans', cursive;color:blue"><i class="fa fa-heart"></i><u>Gatchara</u><i class="fa fa-heart"></i></h2>
                                <br>
                                <h4 ><a href="http://gatchara.com" style="color:black"><i class="fa fa-home"></i> HOME</a> || <a href="../../login/client/" style="color:black"><i class="fa fa-sign-in"></i> LOGIN</a></h4>
                                <br>
                                <h4 class="page-title" style="margin-left: 20px;color: wheat"><u>REGISTRATION FORM</u></h4>
                                <h3 style="text-align: center;">
                                    <?php echo $result; ?>
                                    <span style="color:red">&nbsp;<?php echo $error; ?></span>
                                </h3>
                            </center>
                        </div>
                    </div>
                    <form method="POST" action = "" enctype="multipart/form-data">
                        <div class="card-box">
                            <h3 class="card-title">Basic Informations</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="profile-img-wrap">
                                        <img class="inline-block" src="assets/img/user.jpg" alt="user" id="output">
                                        <div class="fileupload btn">
                                            <span class="btn-text">upload</span>
                                            <input class="upload" type="file" onchange="loadFile(event)" name="propic" required>
                                        </div>
                                    </div>
                                    <script>
                                        var loadFile = function (event) {
                                            var output = document.getElementById('output');
                                            output.src = URL.createObjectURL(event.target.files[0]);
                                        };
                                    </script>
                                    <div class="profile-basic">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <label class="focus-label">First Name<span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control floating" name="first_name"  required>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <label class="focus-label">Last Name</label>
                                                    <input type="text" class="form-control floating" name="last_name"  >
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus">
                                                    <label class="focus-label">Birth Date<span class="text-danger">*</span></label>
                                                    <div class="cal-icon">
                                                        <input class="form-control floating datetimepicker" type="text" name="birthday" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-focus select-focus">
                                                    <label class="focus-label">Gender<span class="text-danger">*</span></label>
                                                    <select class="select form-control floating" name="gender" required>
                                                        <option value="Male"  selected>Male</option>
                                                        <option value="Female">Female</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-box">
                            <h3 class="card-title">Basic Contact Informations</h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Phone Number<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" name="phone" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Email</label>
                                        <input type="text" name="email" class="form-control floating">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-box">
                            <h3 class="card-title">Authentication Information </h3>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Username<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" name = "username"  required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group form-focus">
                                        <label class="focus-label">Password<span class="text-danger">*</span></label>
                                        <input type="text" class="form-control floating" name = "password"  required>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="m-t-20 text-center">
                            <button class="btn btn-primary submit-btn" type="submit" name="save">Submit</button>
                        </div>
                    </form>
                </div>
                <div class="col-sm-2">
                </div>
            </div>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <script src="assets/js/jquery-3.2.1.min.js"></script>
        <script src="assets/js/popper.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery.slimscroll.js"></script>
        <script src="assets/js/select2.min.js"></script>
        <script src="assets/js/moment.min.js"></script>
        <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>