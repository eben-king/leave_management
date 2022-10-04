<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {   
  header('location:index.php');
} else {
    if(isset($_POST['add'])) {
      $position=$_POST['position'];
      $nold=$_POST['nold'];
      $ldafcy=$_POST['ldafcy'];
      if ($_POST['position']!='') {
        
        $sql="INSERT INTO tblpolicy(position, nold, ldafcy) VALUES(:position, :nold, :ldafcy)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':position',$position,PDO::PARAM_STR);
        $query->bindParam(':nold',$nold,PDO::PARAM_INT);
        $query->bindParam(':ldafcy',$ldafcy,PDO::PARAM_INT);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
          $msg="Policy Created Successfully";
        } else {
          $error="Something went wrong. Please try again";
        }
      } else {
        $error="Please enter a Policy Type!";
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Header Menu -->
        <?php include_once('includes/header.php');?>
        <title>Add Policy</title>
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
                                        <h4 class="card-title" id="basic-layout-form"></h4>
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
                                                    <h4 class="form-section"><i class="ft-user"></i>Set New Leave Policy</h4>
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="position">Staff Position (Junior/Senior Staff)</label>
                                                                <input type="text" name="position" id="position" class="form-control" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="nold">Number Of Leave Days</label>
                                                                <input type="number" name="nold" id="nold" class="form-control" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="ldafcy">Leave Days Approved For Current Year</label>
                                                                <input type="number" name="ldafcy" id="ldafcy" class="form-control" >
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="form-actions">
                                                    <button name="add" onclick="return confirm('confirm update');"  type="submit" class="btn btn-primary">
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
