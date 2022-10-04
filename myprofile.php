<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['staffid'])==0)
    {   
header('location:index.php');
}else{
    if(isset($_POST['update'])){
        $staffid = $_SESSION['staffid'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];   
        $address=$_POST['address']; 
        $phone=$_POST['phone']; 
        $email=$_POST['email']; 
        $sql="update tblemployees set fname=:fname,lname=:lname,address=:address,phone=:phone, email=:email where staffid=:staffid";
        $query = $dbh->prepare($sql);
        $query->bindParam(':fname',$fname,PDO::PARAM_STR);
        $query->bindParam(':lname',$lname,PDO::PARAM_STR);
        $query->bindParam(':address',$address,PDO::PARAM_STR);
        $query->bindParam(':email',$email,PDO::PARAM_STR);
        $query->bindParam(':phone',$phone,PDO::PARAM_STR);
        $query->bindParam(':staffid',$staffid,PDO::PARAM_STR);
        $query->execute();
        $msg="Staff record updated Successfully";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Header Menu -->
    <?php include_once('includes/header.php');?>
    <title>Profile Update</title>
</head>
<?php include_once('includes/style.php') ?>

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
                                <h4 class="card-title" id="basic-layout-form">User detail</h4>
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
                                    <?php 
                                    $staffid=$_SESSION['staffid'];
                                    $sql = "SELECT * from  tblemployees where staffid=:staffid";
                                    $query = $dbh -> prepare($sql);
                                    $query -> bindParam(':staffid',$staffid, PDO::PARAM_STR);
                                    $query->execute();
                                    $results=$query->fetchAll(PDO::FETCH_OBJ);
                                    $cnt=1;
                                    if($query->rowCount() > 0)
                                    {
                                    foreach($results as $result)
                                    { ?>
                                        <div class="form-body">
                                            <h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
                                            <div class="row">
                                            
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="fname">First Name</label>
                                                        <input type="text" name="fname" id="fname" class="form-control" value="<?php echo htmlentities($result->fname);?>" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="lname">Last Name</label>
                                                        <input type="text" name="lname" id="lname" class="form-control" value="<?php echo htmlentities($result->lname);?>" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email Address</label>
                                                        <input type="email" name="email" id="email" class="form-control" value="<?php echo htmlentities($result->email);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="phone">Phone Number</label>
                                                        <input type="tel" name="phone" id="phone" class="form-control" value="<?php echo htmlentities($result->phone);?>">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="address">Home Address</label>
                                                        <input type="text" name="address" id="address" class="form-control" value="<?php echo htmlentities($result->address);?>">
                                                    </div>
                                                    <?php }}?>
                                                </div>  
                  
                                            </div>                         
                                        </div>

                                        <div class="form-actions">
                                            <button name="update" onclick="return confirm('confirm update');"  type="submit" class="btn btn-primary">
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

   
    <?php include_once("includes/footer.php") ?>
</body>
</html>
<?php } ?>