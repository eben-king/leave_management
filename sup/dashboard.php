<?php
session_start();
error_reporting(0);
include('includes/config.php');
if((strlen($_SESSION['hodid'])==0) && (strlen($_SESSION['hrid'])==0))
    {   
header('location:../index.php');
}
else{

?>
    <!DOCTYPE html>
    <html class="loading" lang="en" data-textdirection="ltr">

    <head>
        <?php include_once('includes/header.php') ?>
        <title>Dashboard</title>
    </head>
    <?php include_once('includes/style.php') ?>
    <body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

    <!-- fixed-top-->
    <?php include_once('includes/navbar.php') ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <?php include_once('includes/sidebar.php') ?>


    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div id="user-profile">
                    <div class="row">
                        <div class="col-12">
                            <div class="card profile-with-cover">
                                <div class="card-img-top img-fluid bg-cover height-200" style="background: url('../img_/logo.png') 50%;"></div>
                                <div class="media profile-cover-details w-100">
                                    <div class="media-left pl-2 pt-2" style="background: white;">
                                        <a href="#" class="profile-image">
                                            <img src="../files/default.png" class="rounded-circle img-border height-100" alt="Card image">
                                        </a>
                                    </div>
                                    <div class="media-body pt-3 px-2" style="background: white;">
                                        <div class="row">
                                            <div class="col">
                                                <h3 class="card-title" style="color: black;"><?php echo $_SESSION['uname'] ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <section id="basic-form-layouts" style="margin-top: 5px;">
                                <div class="row match-height">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title" id="basic-layout-form">Message</h4>
                                                <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
                                                <div class="heading-elements">
                                                    <ul class="list-inline mb-0">
                                                        <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                                                        <li><a data-action="reload"><i class="ft-rotate-cw"></i></a></li>
                                                        <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                                                        <li><a data-action="close"><i class="ft-x"></i></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-content collapse show">
                                                <div class="card-body">
                                                    <h1>Welcome <?php echo $_SESSION['uname'] ?></h1>

                                                    <p>Here is where to manage your details as an employee. With the tabs on the left-sidebar, you can view, edit and delete your account without any difficulty.</p>
                                                    <p>Also included are the ability to view your leave requests such as recommended leaves, accepted leaves, rejected leaves, in addition to being able to request for new leaves - all at the comfort of your home or on the go.</p>
                                                    <p>You can view your job description, generate reports of the leave activities of a particular time/all time, view leave statistics, pending leaves, and update your job description.</p>
                                                    <h3>Welcome to your dashboard</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <?php include_once('includes/footer.php') ?>
    </body>

    </html>
<?php } ?>