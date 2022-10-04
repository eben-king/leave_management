<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
    {   
header('location:index.php');
}
else{
    
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <!-- Header Menu -->
        <?php include_once('includes/header.php');?>
        <title>Leave History</title>
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
                                        <h4 class="card-title"></h4>
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
                                                    <th>No.</th>
                                                    <th>Department</th>
                                                    <th>Employee Name</th>
                                                    <th>Leave Start Date</th>
                                                    <th>Leave End Date</th>
                                                    <th>Leave Status</th>
                                                    <th>Action</th>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $alogin = $_SESSION['alogin'];
                                                    $sql1 = "SELECT l.id as id, d.deptname, concat(fname, ' ', lname) as fullname, dlc, dle, `status` from tblemployees as e
                                                    join tblleaves as l 
                                                    on l.staffid = e.staffid
                                                    JOIN tbldepartments as d
                                                    on d.id = e.department";
                                                    $query1 = $dbh -> prepare($sql1);
                                                    $query1->execute();
                                                    $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                    $cnt1=1;
                                                    if($query1->rowCount() > 0){
                                                        foreach($results1 as $result){  ?>
                                                            <tr>
                                                                <td> <?php echo htmlentities($cnt1);?></td>
                                                                <td><?php echo htmlentities($result->deptname);?></td>
                                                                <td><?php echo htmlentities($result->fullname);?></td>
                                                                <td><?php echo htmlentities($result->dlc);?></td>
                                                                <td><?php echo htmlentities($result->dle);?></td>
                                                                <td><?php $stats=$result->status;
                                                                    if($stats==0){?>
                                                                        <span style="color: red">Not Approved</span> <?php
                                                                    }if($stats==1){?>
                                                                        <span style="color: blue">Waiting for HOD Approval</span> <?php
                                                                    } if($stats==2){ ?>
                                                                        <span style="color: violet">Waiting for Registrar's Approval</span> <?php
                                                                    } if($stats==3){ ?>
                                                                        <span style="color: green">Aprroved</span> <?php
                                                                    } if($stats==4){ ?>
                                                                        <span style="color: pink">Ammended</span> <?php
                                                                    } ?> </td>
                                                                <td>
                                                                    <a href="leavedetails.php?lid=<?php echo htmlentities($result->id);?>"><i class="material-icons">View Details</i></a>
                                                            </tr>
                                                            <?php $cnt1++;} }?>
                                                </tbody>

                                            </table>
                                        </div>
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
