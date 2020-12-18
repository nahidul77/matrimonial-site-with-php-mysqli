<?php
session_start();
if (!isset($_SESSION["client_id"])) {
    header("location:logout.php");
}

require_once './server/Client.php';
$result = "";
$updateError = "";

$server = new Client();
$result = $server->viewData();

if (isset($_POST['update'])) {
    $updateError = $server->updateProfile($_POST);
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
        <?php include './parts/css-links.php'; ?>
        <style>
            label, h3, .page-title {
                font-family: 'Rajdhani', sans-serif !important;
                font-weight: bolder !important;
                text-transform: uppercase
            }

            form input {
                border: 1px solid !important;
            }

        </style>
    </head>

    <body>
        <div class="main-wrapper">
            <?php
            while ($row = $result->fetch_assoc()) {
                $account_status = $row['account_status'];
                ?>

                <?php
                if ($row['status'] == 0) {
                    echo "<script type='text/javascript'>alert('SORRY! YOU ARE BLOCKED!');document.location='logout.php';</script>";
                }
                ?>

                <div class="header">
                    <?php include './parts/top-nav.php'; ?>
                </div>
                <div class="sidebar" id="sidebar">
                    <?php include './parts/side-nav.php'; ?>
                </div>
                <div class="page-wrapper">
                    <div class="content">
                        <div class="row">
                            <div class="col-sm-6">
                                <h4 class="page-title"><u>Update Profile</u>
                                    <?php echo '<span style="color:red">' . $updateError . '<span style="color:red">'; ?>
                                </h4>
                            </div>
                            <div class="col-sm-6">
                                <a class="btn btn-primary btn-rounded float-right" href="profile.php"><i class="fa fa-user"></i>&nbsp;My
                                    Profile</a>
                            </div>
                        </div>
                        <?php if ($account_status == 0) { ?>

                            <form method="POST" action="" enctype="multipart/form-data">
                                <div class="card-box">
                                    <h3 class="card-title">Basic Informations</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="profile-img-wrap">
                                                <img class="inline-block" src="<?php echo $row['propic'] ?>"
                                                     onerror="this.onerror=null; this.src='assets/img/user.jpg'" alt="user"
                                                     id="output">
                                                <div class="fileupload btn">
                                                    <span class="btn-text">change</span>
                                                    <input class="upload" type="file" onchange="loadFile(event)" name="propic">
                                                </div>
                                            </div>
                                            <?php
                                            $oldpic = $row['propic'];
                                            $_SESSION['oldpic'] = $oldpic;
                                            ?>
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
                                                            <input type="text" class="form-control floating" name="first_name"
                                                                   value="<?php echo $row['first_name'] ?>" required>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus">
                                                            <label class="focus-label">Last Name</label>
                                                            <input type="text" class="form-control floating" name="last_name"
                                                                   value="<?php echo $row['last_name'] ?>">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus">
                                                            <label class="focus-label">Birth Date<span class="text-danger">*</span></label>
                                                            <div class="cal-icon">
                                                                <input class="form-control floating datetimepicker" type="text"
                                                                       name="birthday" value="<?php echo $row['birthday'] ?>"
                                                                       required>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group form-focus select-focus" style="border:1px solid">
                                                            <label class="focus-label">Gender<span
                                                                    class="text-danger">*</span></label>
                                                            <select class="select form-control floating" name="gender" required>
                                                                <option value="Male" <?php
                                                                if ($row['gender'] == 'Male') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Male
                                                                </option>
                                                                <option value="Female" <?php
                                                                if ($row['gender'] == 'Female') {
                                                                    echo 'selected';
                                                                }
                                                                ?>>Female
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-box">
                                    <h3 class="card-title">Personal Information</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Religion<span class="text-danger">*</span></label>
                                                <input class="form-control floating" name="religion"
                                                       value="<?php echo $row['religion'] ?>" list="religion" required>
                                                <datalist id="religion">
                                                    <option>Islam</option>
                                                    <option>Christianity</option>
                                                    <option>Judaism</option>
                                                    <option>Hinduism</option>
                                                    <option>Buddhism</option>
                                                    <option>Atheist</option>
                                                    <option>Other</option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Marital Status<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="marital_status" required>
                                                    <option <?php
                                                    if ($row['marital_status'] == 'Married') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Married</option>
                                                    <option <?php
                                                    if ($row['marital_status'] == 'Unmarried') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Unmarried</option>
                                                    <option <?php
                                                    if ($row['marital_status'] == 'Divorced') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Divorced</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Age<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="age" required>
                                                    <option><?php echo $row['age'] ?></option>
                                                    <option disabled>Select</option>
                                                    <?php
                                                    for ($i = 18; $i <= 100; $i++) {
                                                        ?>
                                                        <option><?php echo $i; ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Nationality<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="nationality"
                                                       value="<?php echo $row['nationality'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Personal Interest</label>
                                                <input type="text" class="form-control floating" name="interest"
                                                       value="<?php echo $row['interest'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Hobby</label>
                                                <input type="text" class="form-control floating" name="hobby"
                                                       value="<?php echo $row['hobby'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Blood Group<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="blood_group"required>
                                                    <option <?php
                                                    if ($row['blood_group'] == 'A+') {
                                                        echo 'selected';
                                                    }
                                                    ?>>A+</option>
                                                    <option <?php
                                                    if ($row['blood_group'] == 'A-') {
                                                        echo 'selected';
                                                    }
                                                    ?>>A-</option>
                                                    <option <?php
                                                    if ($row['blood_group'] == 'B+') {
                                                        echo 'selected';
                                                    }
                                                    ?>>B+</option>
                                                    <option <?php
                                                    if ($row['blood_group'] == 'B-') {
                                                        echo 'selected';
                                                    }
                                                    ?>>B-</option>
                                                    <option <?php
                                                    if ($row['blood_group'] == 'AB+') {
                                                        echo 'selected';
                                                    }
                                                    ?>>AB+</option>
                                                    <option <?php
                                                    if ($row['blood_group'] == 'AB-') {
                                                        echo 'selected';
                                                    }
                                                    ?>>AB-</option>
                                                    <option <?php
                                                    if ($row['blood_group'] == 'O+') {
                                                        echo 'selected';
                                                    }
                                                    ?>>O+</option>
                                                    <option <?php
                                                    if ($row['blood_group'] == 'O-') {
                                                        echo 'selected';
                                                    }
                                                    ?>>O-</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Smoking Habit<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="smoking" required>
                                                    <option <?php
                                                    if ($row['smoking'] == 'Non-smoker') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Non-smoker</option>
                                                    <option <?php
                                                    if ($row['smoking'] == 'Chain-smoker') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Chain-smoker</option>
                                                    <option <?php
                                                    if ($row['smoking'] == 'Light/Social smoker') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Light/Social smoker</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-box">
                                    <h3 class="card-title">Family Information</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Father's Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="father_name"
                                                       value="<?php echo $row['father_name'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Mother's Name<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="mother_name"
                                                       value="<?php echo $row['mother_name'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Father Status<span class="text-danger">*</span></label>
                                                <input class="form-control floating" name="father_status"
                                                       value="<?php echo $row['father_status'] ?>" list="f_status" required>
                                                <datalist id="f_status">
                                                    <option value="" label="--- Please Select ---" selected="selected">Select
                                                    </option>
                                                    <option value="Employed" label="Employed">Employed</option>
                                                    <option value="Business" label="Business">Business</option>
                                                    <option value="Retired" label="Retired">Retired</option>
                                                    <option value="Not Employed" label="Not Employed">Not Employed</option>
                                                    <option value="Passed Away" label="Passed Away">Passed Away</option>
                                                    <option value="Professional" label="Professional">Professional</option>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Mother Status<span class="text-danger">*</span></label>
                                                <input class="form-control floating" name="mother_status"
                                                       value="<?php echo $row['father_status'] ?>" list="m_status" required>
                                                <datalist id="m_status">
                                                    <option value="" label="--- Please Select ---" selected="selected">Select
                                                    </option>
                                                    <option value="Homemaker" label="Homemaker">Homemaker</option>
                                                    <option value="Employed" label="Employed">Employed</option>
                                                    <option value="Business" label="Business">Business</option>
                                                    <option value="Retired" label="Retired">Retired</option>
                                                    <option value="Passed Away" label="Passed Away">Passed Away</option>
                                                    <option value="Professional" label="Professional">Professional</option>
                                                    </select>
                                                </datalist>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Number of member<span
                                                        class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="total_member"
                                                        value="<?php echo $row['total_member'] ?>" required>
                                                            <?php
                                                            for ($i = 0; $i <= 100; $i++) {
                                                                ?>
                                                        <option><?php echo $i; ?></option>
                                                    <?php }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Family Type<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="family_type" required>
                                                    <option <?php
                                                    if ($row['family_type'] == 'Joint') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Joint</option>
                                                    <option <?php
                                                    if ($row['family_type'] == 'Single') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Single</option>
                                                    <option <?php
                                                    if ($row['family_type'] == 'Separated') {
                                                        echo 'selected';
                                                    }
                                                    ?>>Separated</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">About Family</label>
                                                <textarea class="form-control floating" style="min-height: 80px;border:1px solid;resize: none" name="about_family"><?php
                                                    echo $row['about_family']
                                                    ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-box">
                                    <h3 class="card-title">Contact Information</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Permanent Address<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="permanent_address"
                                                       value="<?php echo $row['permanent_address'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Present Address<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="present_address"
                                                       value="<?php echo $row['present_address'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Country<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="country" required>
                                                    <option selected><?php echo $row['country'] ?></option>
                                                    <?php include '../countries.php';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Division</label>
                                                <input type="text" class="form-control floating" name="division"
                                                       value="<?php echo $row['division'] ?>" >
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Post Code<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="postal_code"
                                                       value="<?php echo $row['postal_code'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">State</label>
                                                <input type="text" class="form-control floating" name="state"
                                                       value="<?php echo $row['state'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Currently Living In<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="current_country" required>
                                                    <option selected><?php echo $row['current_country'] ?></option>
                                                    <?php include '../countries.php';
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">City Living In<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="current_city"
                                                       value="<?php echo $row['current_city'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Phone Number<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating"
                                                       value="<?php echo $row['phone'] ?>" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Email</label>
                                                <input type="text" name="email" class="form-control floating"
                                                       value="<?php echo $row['email'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-box">
                                    <h3 class="card-title">Education & Career</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Education Details</label>
                                                <textarea class="form-control floating" style="border:1px solid;resize: none"
                                                          name="education_details"><?php
                                                              echo $row['education_details']
                                                              ?></textarea>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Highest Education<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="education" required>
                                                    <option selected><?php echo $row['education'] ?></option>
                                                    <option value="">--- Select Education ---</option>
                                                    <option value="Doctorate / Phd / MPhil">Doctorate / Phd / MPhil</option>
                                                    <option value="Masters">Masters</option>
                                                    <option value="Bachelors">Bachelors</option>
                                                    <option value="FCPS / MD">FCPS / MD</option>
                                                    <option value="MBBS / BDS">MBBS / BDS</option>
                                                    <option value="Undergraduate">Undergraduate</option>
                                                    <option value="Diploma">Diploma</option>
                                                    <option value="Professional Degree">Professional Degree</option>
                                                    <option value="HSC / A-Label">HSC / A-Label</option>
                                                    <option value="Others">Others</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Professional Sector<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="professional_sector" required>
                                                    <option selected><?php echo $row['professional_sector'] ?></option>
                                                    <option value="">---Please Select---</option>
                                                    <option value="Private Company">Private Company</option>
                                                    <option value="Government / Public Sector">Government / Public Sector</option>
                                                    <option value="Defense / Civil Services">Defense / Civil Services</option>
                                                    <option value="Business / Self Employed">Business / Self Employed</option>
                                                    <option value="Freelancing">Freelancing</option>
                                                    <option value="Not Working">Not Working</option>
                                                </select>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus" style="border:1px solid">
                                                <label class="focus-label">Profession<span class="text-danger">*</span></label>
                                                <select class="form-control floating select" name="profession" required>
                                                    <option selected><?php echo $row['profession'] ?></option>
                                                    <option value="">--- Select Occupation ---</option>
                                                    <optgroup label="Accounting, Banking &amp; Finance"></optgroup>
                                                    <option value="Accounting Professional">Accounting Professional</option>
                                                    <option value="Banking Professional">Banking Professional</option>
                                                    <option value="Chartered Accountant">Chartered Accountant</option>
                                                    <option value="Finance Professional">Finance Professional</option>
                                                    <option value="Investment Professional">Investment Professional</option>
                                                    <option value="Accounting &amp; Finance (Others)">Accounting &amp; Finance (Others)</option>

                                                    <optgroup label="Administration &amp; HR"></optgroup>
                                                    <option value="Admin Professional">Admin Professional</option>
                                                    <option value="Human Resources Professional">Human Resources Professional</option>

                                                    <optgroup label="Advertising, Media &amp; Entertainment"></optgroup>
                                                    <option value="Actor">Actor</option>
                                                    <option value="Advertising Professional">Advertising Professional</option>
                                                    <option value="Entertainment Professional">Entertainment Professional</option>
                                                    <option value="Event Manager">Event Manager</option>
                                                    <option value="Journalist">Journalist</option>
                                                    <option value="Media Professional">Media Professional</option>
                                                    <option value="Public Relations Professional">Public Relations Professional</option>

                                                    <optgroup label="Agriculture"></optgroup>
                                                    <option value="Agricultural Professional">Agricultural Professional</option>

                                                    <optgroup label="Airline &amp; Aviation"></optgroup>
                                                    <option value="Air Hostess / Flight Attendant">Air Hostess / Flight Attendant</option>
                                                    <option value="Pilot">Pilot</option>
                                                    <option value="Airline Professional">Airline Professional</option>

                                                    <optgroup label="Architecture &amp; Design"></optgroup>
                                                    <option value="Architect">Architect</option>
                                                    <option value="Interior Designer">Interior Designer</option>

                                                    <optgroup label="Artists &amp; Animators"></optgroup>
                                                    <option value="Animator">Animator</option>
                                                    <option value="Artist">Artist</option>

                                                    <optgroup label="Beauty &amp; Fashion"></optgroup>
                                                    <option value="Beautician">Beautician</option>
                                                    <option value="Fashion Designer">Fashion Designer</option>

                                                    <optgroup label="Defense"></optgroup>
                                                    <option value="Air Force">Air Force</option>
                                                    <option value="Army">Army</option>
                                                    <option value="Navy">Navy</option>
                                                    <option value="Defense Services (Others)">Defense Services (Others)</option>

                                                    <optgroup label="Education &amp; Training"></optgroup>
                                                    <option value="Lecturer">Lecturer</option>
                                                    <option value="Professor">Professor</option>
                                                    <option value="Teacher">Teacher</option>

                                                    <optgroup label="Engineering"></optgroup>
                                                    <option value="Civil Engineer">Civil Engineer</option>
                                                    <option value="Electronics / Telecom Engineer">Electronics / Telecom Engineer</option>
                                                    <option value="Mechanical / Production Engineer">Mechanical / Production Engineer</option>
                                                    <option value="Engineer (Non IT)">Engineer (Non IT)</option>

                                                    <optgroup label="IT &amp; Software Engineering"></optgroup>
                                                    <option value="Software Engineer / Programmer">Software Engineer / Programmer</option>
                                                    <option value="Software Consultant">Software Consultant</option>
                                                    <option value="Hardware &amp; Networking professional">Hardware &amp; Networking professional</option>
                                                    <option value="Database Administrator">Database Administrator</option>
                                                    <option value="Web / UX Designers / Graphics Designers">Web / UX Designers / Graphics Designers</option>
                                                    <option value="Computer Operator">Computer Operator</option>
                                                    <option value="Computers / IT">Computers / IT</option>
                                                    <option value="Software Professional (Others)">Software Professional (Others)</option>

                                                    <optgroup label="Legal"></optgroup>
                                                    <option value="Lawyer">Lawyer</option>
                                                    <option value="Legal Assistant">Legal Assistant</option>
                                                    <option value="Legal Professional (Others)">Legal Professional (Others)</option>

                                                    <optgroup label="Medical &amp; Healthcare"></optgroup>
                                                    <option value="Doctor">Doctor</option>
                                                    <option value="Dentist">Dentist</option>
                                                    <option value="Nurse">Nurse</option>
                                                    <option value="Pharmacist">Pharmacist</option>
                                                    <option value="Psychologist">Psychologist</option>
                                                    <option value="Therapist">Therapist</option>
                                                    <option value="Medical / Healthcare Professional">Medical / Healthcare Professional</option>

                                                    <optgroup label="Sales &amp; Marketing"></optgroup>
                                                    <option value="Marketing Professional">Marketing Professional</option>
                                                    <option value="Sales Professional">Sales Professional</option>

                                                    <optgroup label="Business &amp; Others"></optgroup>
                                                    <option value="Business Owner / Entrepreneur">Business Owner / Entrepreneur</option>
                                                    <option value="Consultant / Supervisor">Consultant / Supervisor</option>
                                                    <option value="Politician">Politician</option>
                                                    <option value="Sportsman">Sportsman</option>
                                                    <option value="Travel &amp; Transport Professional">Travel &amp; Transport Professional</option>
                                                    <option value="Writer">Writer</option>
                                                    <option value="Not Defined">Not Defined</option>

                                                    <optgroup label="Not Working"></optgroup>
                                                    <option value="Student">Student</option>
                                                    <option value="Not Working">Not Working</option>
                                                </select>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Monthly Income</label>
                                                <input type="text" class="form-control floating" name="income"
                                                       value="<?php echo $row['income'] ?>" >
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-box">
                                    <h3 class="card-title">Physical Attribute</h3>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Height<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="height"
                                                       value="<?php echo $row['height'] ?>" placeholder="Example: 5 Feet 2 Inches " required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Weight</label>
                                                <input type="text" class="form-control floating" name="weight"
                                                       value="<?php echo $row['weight'] ?>" placeholder="Example: 50 KG " required>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Any Physical Condition?</label>
                                                <textarea class="form-control floating" style="min-height: 80px;border:1px solid;resize: none"
                                                          name="physical_condition"><?php
                                                              echo $row['physical_condition']
                                                              ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-box" style="min-height:300px">
                                    <h3 class="card-title">Biography / Personal Record</h3>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Short Biography<span class="text-danger">*</span></label>
                                                <textarea class="form-control floating" style="min-height: 200px;resize: none"
                                                          cols="30" name="biography"
                                                          required><?php echo $row['biography'] ?></textarea>
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
                                                <input type="text" class="form-control floating" name="username"
                                                       value="<?php echo $row['username'] ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group form-focus">
                                                <label class="focus-label">Password<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control floating" name="password"
                                                       value="<?php echo $row['password'] ?>" required>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="m-t-20 text-center">
                                    <button class="btn btn-primary submit-btn" type="submit" name="update">Submit</button>
                                </div>
                            </form>
                        <?php } else { ?>
                            <h4 class="text-danger"><span class="text-success">Your account is verified. </span>You can't make any change in your profile anymore.</h4>
                            <h4>To change login details please visit <a href=""><i class="fa fa-cog"></i>&nbsp;sittings.</a></h4>
                        <?php } ?>
                    </div>
                    <?php include './parts/messages.php'; ?>
                </div>
            <?php } ?>
        </div>
        <div class="sidebar-overlay" data-reff=""></div>
        <!--js links-->
        <?php include './parts/js-links-2.php'; ?>
    </body>
</html>