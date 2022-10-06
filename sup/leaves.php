<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['hodid'])==0 && strlen($_SESSION['hrid'])==0)
    {   
header('location:index.php');
}
else{
    if(isset($_GET['recid'])){
        $recid=$_GET['recid'];
        if(isset($_SESSION['hrid'])){
            $sql = "BEGIN;
            UPDATE tblemployees
            set ubal =ubal+(select ldr from tblleaves WHERE id=:recid),
            cl_used=1,
            dopl=(select dle from tblleaves WHERE id=:recid),
            dopl_set=1;
            UPDATE tblemployees set
            ol=(select tbal from tblemployees where staffid=(select staffid from tblleaves WHERE id=:recid))-
            (select ubal from tblemployees where staffid=(select staffid from tblleaves WHERE id=:recid))
            where staffid=(select staffid from tblleaves WHERE id=:recid);
            UPDATE tblleaves
            set status=3
            where id=:recid;
            COMMIT;";
        }else {
            $sql = "update tblleaves set status=2  WHERE id=:recid";
        }
        $query = $dbh->prepare($sql);
        $query -> bindParam(':recid',$recid, PDO::PARAM_INT);
        $query -> execute();
        $msg="Leave record Approved!";
    }
    if(isset($_GET['notid'])){
        $notid=$_GET['notid'];
        $sql = "update tblleaves set status=0  WHERE id=:notid";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':notid',$notid, PDO::PARAM_INT);
        $query -> execute();
        $msg="Leave record Rejected!";
    }

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
                                                    <tr>
                                                        <th>No.</th>
                                                        <?php if(isset($_SESSION['hrid'])){ ?>
                                                        <th>Department</th>
                                                        <?php } ?>
                                                        <th>Employee Name</th>
                                                        <th>Leave Start Date</th>
                                                        <th>Leave End Date</th>
                                                        <th>Leave Status</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if(isset($_SESSION['hrid'])){
                                                    $sql1 = "SELECT d.deptname, l.id as id, concat(fname, ' ', lname) as fullname, dlc, dle, `status` from tblemployees as e
                                                    join tblleaves as l 
                                                    on l.staffid = e.staffid
                                                    JOIN tbldepartments as d
                                                    on d.id=e.department
                                                    where status=2 or status=3 or status=0
                                                    ORDER BY department, dlc desc";
                                                    $query1 = $dbh -> prepare($sql1);
                                                }else {
                                                    $hodid = $_SESSION['hodid'];
                                                    $sql1 = "SELECT l.id as id, concat(fname, ' ', lname) as fullname, dlc, dle, `status` from tblemployees as e
                                                    join tblleaves as l on l.staffid = e.staffid where 
                                                    department=(SELECT department FROM tblemployees WHERE staffid=:hodid)
                                                    ORDER BY dlc desc";
                                                    $query1 = $dbh -> prepare($sql1);
                                                    $query1->bindParam(':hodid',$hodid,PDO::PARAM_STR);
                                                }
                                                $query1->execute();
                                                $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                                $cnt1=1;
                                                if($query1->rowCount() > 0){
                                                    foreach($results1 as $result){  ?>
                                                        <tr>
                                                            <td> <?php echo htmlentities($cnt1);?></td>
                                                            <?php if(isset($_SESSION['hrid'])){ ?>
                                                                <td><?php echo htmlentities($result->deptname);?></td>
                                                            <?php } ?>
                                                            <td><?php echo htmlentities($result->fullname);?></td>
                                                            <td><?php echo htmlentities($result->dlc);?></td>
                                                            <td><?php echo htmlentities($result->dle);?></td>
                                                            <td><?php $stats=$result->status;
                                                                if($stats==0){?>
                                                                    <span style="color: red">Not Approved</span> <?php
                                                                }if($stats==1){?>
                                                                    <span style="color: blue">Waiting for your Recommendation</span> <?php
                                                                } if($stats==2 && isset($_SESSION['hrid'])){ ?>
                                                                    <span style="color: violet">Waiting for your recommendation</span> <?php
                                                                }else if($stats==2){ ?>
                                                                    <span style="color: violet">You have recommended. Waiting for Registrar's Recommendation</span> <?php
                                                                } if($stats==3){ ?>
                                                                    <span style="color: green">Aprroved</span> <?php
                                                                } if($stats==4){ ?>
                                                                    <span style="color: pink">Ammended</span> <?php
                                                                } ?> </td>
                                                            <td><?php 
                                                                if(($stats==2) && isset($_SESSION['hrid']) ){?>
                                                                <a style="color: green;" href="leaves.php?recid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to recommend leave?');"><i class="material-icons">Recommend</i></a><br>
                                                                <a style="color: purple;" href="updateleave.php?lid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to amend leave?');"><i class="material-icons">Amend Leave</i></a><br>
                                                                <a style="color: red;" href="leaves.php?notid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to reject leave?');"> <i class="material-icons">Not Recommend</i></a>
                                                                <?php }elseif ($stats==1 or $stats==4) { ?>
                                                                    <a style="color: green;" href="leaves.php?recid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to recommend leave?');"><i class="material-icons">Recommend</i></a><br>
                                                                    <a style="color: purple;" href="updateleave.php?lid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to amend leave?');"><i class="material-icons">Amend Leave</i></a><br>
                                                                    <a style="color: red;" href="leaves.php?notid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to reject leave?');"> <i class="material-icons">Not Recommend</i></a>
                                                                <?php } ?>
                                                            </td>
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