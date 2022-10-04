<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['staffid'])==0)
    {   
header('location:index.php');
}
else{
// Code for change password 
if(isset($_POST['change']))    {
$password=md5($_POST['password']);
$newpassword=md5($_POST['newpassword']);
$staffid=$_SESSION['staffid'];
$sql ="SELECT `password` FROM tblemployees WHERE staffid=:staffid and `password`=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':staffid', $staffid, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results = $query -> fetchAll(PDO::FETCH_OBJ);
if($query -> rowCount() > 0)
{
$con="update tblemployees set Password=:newpassword where staffid=:staffid";
$chngpwd1 = $dbh->prepare($con);
$chngpwd1-> bindParam(':staffid', $staffid, PDO::PARAM_STR);
$chngpwd1-> bindParam(':newpassword', $newpassword, PDO::PARAM_STR);
$chngpwd1->execute();
$msg="Your Password succesfully changed";
}
else {
$error="Your current password is wrong";    
}
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Header Menu -->
    <?php include_once('includes/header.php');?>
    <title>Change Password</title>
</head>
<body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

<!-- Navigation bar -->
<?php include('includes/navbar.php');?>

<!-- Side Menu -->
<?php include('includes/sidebar.php');?>


<!-- The Content -->
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row"></div>
        <div class="content-body"><div id="user-profile">
                <section id="basic-form-layouts" style="margin-top: 5px;">
                    <div class="row match-height">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4 class="card-title" id="basic-layout-form">User Password</h4>
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
                                        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                        <form class="form" method="POST" action="">
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-user"></i> Change Password</h4>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label for="password">Current Password</label>
                                                            <input type="password" name="password" id="password" class="form-control" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="newpassword">New Password</label>
                                                            <input type="password" name="newpassword" id="newpassword" class="form-control" >
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="confrimpassword">Confirm Password</label>
                                                            <input type="password" name="confrimpassword" id="confrimpassword" class="form-control" >
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>

                                            <div class="form-actions">
                                                <button name="change" onclick="return confirm('confirm update');"  type="submit" class="btn btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Save</button>
                                            </div>
                                        </form>
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



    <?php include_once('includes/footer.php') ?>
</body>
</html>
<?php } ?>