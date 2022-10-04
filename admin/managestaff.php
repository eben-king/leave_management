<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0){
    header('location:index.php');
}else{
    if(isset($_GET['del'])){
        $id=$_GET['del'];
        $sql = "delete from  tblemployees  WHERE staffid=:id";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':id',$id, PDO::PARAM_STR);
        $query -> execute();
        $msg="Staff record deleted";
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
                                        <div class="card-body card-dashboard table-responsive">
                                            <table class="table table-striped table-bordered">
                                                <thead>
                                                <th>Sr No.</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Staff ID</th>
                                                </thead>
                                                <tbody>
                                                <?php $sql = "select * from tblemployees";
                                                $query = $dbh -> prepare($sql);
                                                $query->execute();
                                                $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                $cnt=1;
                                                if($query->rowCount() > 0) {
                                                    foreach($results as $result){ ?>
                                                        <tr>
                                                            <td> <?php echo htmlentities($cnt);?></td>
                                                            <td><?php echo htmlentities($result->fname);?></td>
                                                            <td><?php echo htmlentities($result->lname);?></td>
                                                            <td><?php echo htmlentities($result->staffid);?></td>
                                                            <td><a href="editstaff.php?id=<?php echo htmlentities($result->id);?>"><i class="material-icons">mode_edit</i></a><a href="managestaff.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to delete');"> <i class="material-icons">delete_forever</i></a></td>
                                                        </tr>
                                                        <?php $cnt++;} }?>
                                                </tbody>

                                            </table>
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