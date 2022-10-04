<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {   
  header('location:index.php');
} else {
    if(isset($_POST['add'])) {
      $school=$_POST['school'];
      $deptname=$_POST['deptname'];
      $deptshortname=$_POST['deptshortname'];
      $hod = $_POST['hod'];
      if (($_POST['school']!=0) && ($_POST['deptname']!='') && ($_POST['deptshortname']!='')) {
          $sql2 = "update tblemployees set role=2 where id=:hod";
          $query2 = $dbh->prepare($sql2);
          $query2->bindParam(':hod',$hod,PDO::PARAM_INT);
          $query2->execute();
        
        $sql="INSERT INTO tbldepartments(school, deptname, deptshortname) VALUES(:school, :deptname, :deptshortname)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':school',$school,PDO::PARAM_INT);
        $query->bindParam(':deptname',$deptname,PDO::PARAM_STR);
        $query->bindParam(':deptshortname',$deptshortname,PDO::PARAM_STR);
        $query->execute();    
        
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId) {
          
          $msg="Department Created Successfully";
        } else {
          $error="Something went wrong. Please try again";
        }
      } else {
        $error="Please enter school and department name!";
      }
    }
    $sql = "SELECT id, schoolname FROM tblschools";
    $query = $dbh->prepare($sql);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Header Menu -->
        <?php include_once('includes/header.php');?>
        <title>Add School</title>
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
                                                    <h4 class="form-section"><i class="ft-user"></i>Add New Department</h4>
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="school">School</label>
                                                                <select name="school" id="" required class="form-control">
                                                                    <option value="0">No School Selected</option>
                                                                    <?php foreach ($results as $obj) { ?>
                                                                        <option value="<?php echo $obj->id ?>"><?php echo $obj->schoolname ?></option>";
                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="deptname">Department Name</label>
                                                                <input type="text" name="deptname" id="" required class="form-control">
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="deptshortname">Department Short Name (FMS/FAS)</label>
                                                                <input type="text" name="deptshortname" id="" class="form-control">
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