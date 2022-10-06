<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['staffid'])==0)
    {   
header('location:index.php');
}
else{
    if(isset($_GET['del'])){
        $lid=$_GET['del'];
        $sql = "update tblleaves set status=0  WHERE id=:lid";
        $query = $dbh->prepare($sql);
        $query -> bindParam(':lid',$lid, PDO::PARAM_STR);
        $query -> execute();
        $msg="Leave record deleted";
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
                                                <th>#</th>
                                                <th>From</th>
                                                <th>To</th>
                                                <th>Posting Date</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $staffid=$_SESSION['staffid'];
                                            $sql = "SELECT id,dlc, dle, doff, `status` from tblleaves where staffid=:staffid
                                            ORDER BY dlc DESC";
                                            $query = $dbh -> prepare($sql);
                                            $query->bindParam(':staffid',$staffid,PDO::PARAM_STR);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0){
                                                foreach($results as $result){  ?>
                                                    <tr>
                                                        <td> <?php echo htmlentities($cnt);?></td>
                                                        <td><?php echo htmlentities($result->dlc);?></td>
                                                        <td><?php echo htmlentities($result->dle);?></td>
                                                        <td><?php echo htmlentities($result->doff);?></td>
                                                        <td><?php $stats=$result->status;
                                                            if($stats==0){?>
                                                                <span style="color: red">Not Approved</span> <?php
                                                            }if($stats==1){?>
                                                                <span style="color: blue">Waiting for HOD Approval</span> <?php
                                                            } if($stats==2){ ?>
                                                                <span style="color: violet">HOD has approved. Waiting for Registrar's Approval</span> <?php
                                                            } if($stats==3){ ?>
                                                                <span style="color: green">Aprroved</span> <?php
                                                            } if($stats==4){ ?>
                                                                <span style="color: pink">Ammended</span> <?php
                                                            } ?> </td>
                                                        <td>
                                                            <?php
                                                                if ($result->status ==1 || $result->status==4) { ?>
                                                            <a style="color: green;" href="updateleave.php?lid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Confirm update of leave?');"><i>Update Leave</i></a><br>
                                                            <a style="color: red;" href="leavehistory.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to cancel leave?');"> <i class="fa fa-check-square-o">Delete Leave</i></a>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <?php $cnt++;} }?>
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