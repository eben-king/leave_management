<?php
session_start();
include('includes/config.php');
if(isset($_POST['signin']))
{
$staffid=$_POST['staffid'];
$password=md5($_POST['password']);
$sql ="SELECT staffid,`password`, `role`, concat(fname, ' ', lname) as `name` FROM tblemployees WHERE staffid=:staffid and Password=:password";
$query= $dbh -> prepare($sql);
$query-> bindParam(':staffid', $staffid, PDO::PARAM_STR);
$query-> bindParam(':password', $password, PDO::PARAM_STR);
$query-> execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0){
  foreach ($results as $result) {
    $_SESSION['uname']=$result->name;
    if ($result->role == 1) {
        $_SESSION['staffid']=$_POST['staffid'];
        header("location:dashboard.php");
    }elseif ($result->role == 2) {
          $_SESSION['hodid']=$_POST['staffid'];
          header("location:sup/dashboard.php"); 
    }else{
          $_SESSION['hrid']=$_POST['staffid'];
          header("location:sup/dashboard.php"); 
  }
  }
}else{
  
  echo "<script>alert('Invalid Details');</script>";

}

}

?>
<!DOCTYPE html> 
<html lang="en">
<head>
    <!-- Header Menu -->
    <?php include_once('includes/header.php');?>
    <title>Staff Sing In</title>
    <style>
      .navbar-wrapper{
        display: flex;
        justify-content: space-between;
      }
    </style>
</head>
<body class="vertical-layout vertical-menu 1-column   menu-expanded blank-page blank-page" data-open="click" data-menu="vertical-menu" data-col="1-column">
    <!-- ////////////////////////////////////////////////////////////////////////////-->
    <!-- Navigation -->
    <header>
    
    <nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
      <div class="navbar-wrapper">
        <div class="navbar-header">
          <ul class="nav navbar-nav flex-row">
            <li class="nav-item mobile-menu d-md-none mr-auto disabled"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ft-menu font-large-1"></i></a></li>
            <li class="nav-item"><a class="navbar-brand" href="profile.php"><img class="brand-logo" alt="robust admin logo" src="app-assets/images/logo/logo-light-sm.png">
                <h3 class="brand-text">CKT-UTAS MIS</h3></a></li>
            <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse" data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
          </ul>
        </div>
        <div class="navbar-container content" >
          <div class="collapse navbar-collapse" id="navbar-mobile">
            <ul class="nav navbar-nav">    
              <li class=" nav-item"><a class="nav-link" href="admin/index.php" data-toggle="dropdown"><span class="avatar avatar-online"></span><span class="user-name">Admin</span></a>
              </li>
            </ul>
              </div>
          </div>
        </div>
    </nav>

  </header>

    <div class="app-content content" style="margin-top: 30px;">
      <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body"><section class="flexbox-container">
    <div class="col-12 d-flex align-items-center justify-content-center">
        <div class="col-md-4 col-10 box-shadow-2 p-0">
            <div class="card border-grey border-lighten-3 m-0">
                <div class="card-header border-0">
                    <div class="card-title text-center">
                        <div class="p-1"><img style="width: 100px;height: 100px;" src="img_/logo.png" alt="branding logo"></div>
                        <h4>STAFF LEAVE LOGIN PAGE</h4>
                        <h5 class='text-danger'>Default password: john</h5>
                        
                    </div>
                    
                      <h5 class="text-center m-0">Need help?, contact our ICT-Team on <a href='mailto:mis@cktutas.edu.gh'>mis@cktutas.edu.gh</a></h5>
                </div>
                <div class="card-content">
                    <div class="card-body">
                        <form class="form-horizontal form-simple" action="" method="POST" novalidate>
                            <fieldset class="form-group position-relative has-icon-left mb-0">
                                <input type="text" class="form-control form-control-lg input-lg" id="user-name" placeholder="Student ID" required name="staffid">
                                <div class="form-control-position">
                                    <i class="ft-user"></i>
                                </div>
                            </fieldset>
                            <fieldset class="form-group position-relative has-icon-left">
                                <input name="password" type="password" class="form-control form-control-lg input-lg" id="user-password" placeholder="Enter Password" required>
                                <div class="form-control-position">
                                    <i class="fa fa-key"></i>
                                </div>
                            </fieldset>
                            <button type="submit" class="btn btn-info btn-lg btn-block" name="signin"><i class="ft-unlock"></i> Login</button>
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
</body>
</html>