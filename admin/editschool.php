<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
if(isset($_POST['update'])) {
    $schoolid=intval($_GET['schoolid']);    
    $schoolname=$_POST['schoolname'];
    $dean=$_POST['dean'];
    $sql="update tblschools set schoolname=:schoolname, dean=:dean where id=:schoolid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':schoolname',$schoolname,PDO::PARAM_STR);
    $query->bindParam(':dean',$dean,PDO::PARAM_INT);
    $query->bindParam(':schoolid',$schoolid,PDO::PARAM_INT);
    $query->execute();
    $msg="School updated Successfully";
}

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
                                                    <h4 class="form-section"><i class="ft-user"></i>Edit School Info</h4>
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <?php
                                                            $sql1 = "SELECT id, fname, lname FROM tblemployees";
                                                            $query1 = $dbh->prepare($sql1);
                                                            $query1->execute();
                                                            $results1=$query1->fetchAll(PDO::FETCH_OBJ);

                                                            $schoolid=intval($_GET['schoolid']);
                                                            $sql = "SELECT * from tblschools WHERE id=:schoolid";
                                                            $query = $dbh -> prepare($sql);
                                                            $query->bindParam(':schoolid',$schoolid,PDO::PARAM_INT);
                                                            $query->execute();
                                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                            $cnt=1;
                                                            if($query->rowCount() > 0)  {
                                                            foreach($results as $result) { ?>
                                                                <div class="form-group">
                                                                    <label for="schoolname">School Name</label>
                                                                    <input type="text" name="schoolname" id="schoolname" value="<?php echo htmlentities($result->schoolname);?>" class="form-control" >
                                                                </div>
                                                                <div class="form-group">
                                                                    <label for="dean">Dean Of School</label>
                                                                    <select name="dean" id="dean" class="form-control">
                                                                        <option value="0">No Dean Yet</option>
                                                                        <?php foreach ($results1 as $obj) { ?>
                                                                            <option value="<?php echo $obj->id ?>"><?php echo $obj->fname ." ". $obj->lname ?></option>";
                                                                        <?php } ?>
                                                                    </select>
                                                                </div>
                                                            <?php } } ?>

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



    <?php include_once('includes/footer.php') ?>
    </body>
    </html>
<?php } ?>