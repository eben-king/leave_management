<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['staffid'])==0) {   
    header('location:index.php');
}else{
    if(isset($_POST['apply'])){
        $staffid=$_SESSION['staffid'];
        $dopl=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['dopl'])));
        $ol=$_POST['ol'];  
        $cl=$_POST['cl'];
        $tle=$_POST['tle'];  
        $ldr=$_POST['ldr'];  
        $lafcy=$_POST['lafcy'];  
        $dlc=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['dlc'])));
        $dle=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['dle'])));
        $dorod=date("Y-m-d", strtotime(str_replace('/', '-', $_POST['dorod'])));
        if($dlc >= $dle){
            $error=" ToDate should be greater than FromDate ";
        }
        $sql="INSERT INTO tblleaves(staffid, dopl, ol, cl, tle, ldr, lafcy, dlc, dle, dorod, doff, `STATUS`) VALUES
        (:staffid, :dopl, :ol, :cl, :tle, :ldr, :lafcy, :dlc, :dle, :dorod, now(), 1)";
        $query = $dbh->prepare($sql);
        $query->bindParam(':staffid',$staffid,PDO::PARAM_STR);
        $query->bindParam(':dopl',$dopl,PDO::PARAM_STR);
        $query->bindParam(':ol',$ol,PDO::PARAM_INT);
        $query->bindParam(':cl',$cl,PDO::PARAM_INT);
        $query->bindParam(':tle',$tle,PDO::PARAM_INT);
        $query->bindParam(':ldr',$ldr,PDO::PARAM_INT);
        $query->bindParam(':lafcy',$lafcy,PDO::PARAM_INT);
        $query->bindParam(':dlc',$dlc,PDO::PARAM_STR);
        $query->bindParam(':dle',$dle,PDO::PARAM_STR);
        $query->bindParam(':dorod',$dorod,PDO::PARAM_STR);
        $query->execute();
        $lastInsertId = $dbh->lastInsertId();
        if($lastInsertId){
            $msg="Leave applied successfully";
        }else{
            $error="Something went wrong. Please try again";
        }

    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Header Menu -->
    <?php include_once('includes/header.php');?>
    <title>Request Leave</title>
</head>
<body onload="totalLeave()" class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

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
                        <div class="col-md-4">
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
                                            $staffid = $_SESSION['staffid'];
                                            $sql = "SELECT * from tblemployees 
                                            join tblpolicy 
                                            on tblemployees.policy = tblpolicy.id
                                            WHERE tblemployees.staffid=:staffid";
                                            $query = $dbh -> prepare($sql);
                                            $query->bindParam(':staffid',$staffid,PDO::PARAM_STR);
                                            $query->execute();
                                            $results=$query->fetchAll(PDO::FETCH_OBJ);
                                            $cnt=1;
                                            if($query->rowCount() > 0)  {
                                            foreach($results as $result) { ?>
                                            <div class="form-body">
                                                <h4 class="form-section"><i class="ft-user"></i> Personal Info</h4>
                                                <div class="row">

                                                    <div class="col-md-12">
                                                        <?php if ($result->dopl_set ==1) { ?>

                                                            <div class="form-group">
                                                            <label for="dopl">Date Of Previous Leave</label>
                                                            <input type="date" name="dopl" id="dopl" class="form-control" readonly value="<?php echo htmlentities($result->dopl);?>">
                                                            </div>
                                                            <?php } else { ?>
                                                            <div class="form-group">
                                                            <label for="dopl">Date Of Previous Leave</label>
                                                            <input type="date" name="dopl" id="dopl" class="form-control">
                                                            </div>

                                                        <?php } 
                                                        if ($result->ol_set ==1) {?>
                                                        <div class="form-group">
                                                            <label for="ol">Outstanding Leave</label>
                                                            <input type="number" name="ol" id="ol" class="form-control" readonly value="<?php echo htmlentities($result->ol);?>">
                                                        </div>
                                                        <?php } else { ?>
                                                        <div class="form-group">
                                                            <label for="ol">Outstanding Leave</label>
                                                            <input type="number" name="ol" id="ol" class="form-control" oninput="totalLeave()">
                                                        </div>
                                                        <?php }  ?>
                                                        <div class="form-group">
                                                            <label for="cl">Current Leave</label>
                                                            <input type="number" name="cl" id="cl" class="form-control" value="<?php echo htmlentities($result->nold);?>" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="tle">Total Leave Earned</label>
                                                            <input type="number" name="tle" id="tle" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="ldr">Leave Days Requested</label>
                                                            <input type="number" max="40" name="ldr" id="ldr" class="form-control" oninput="myFunc()">
                                                        </div>
                                                        <div>
                                                            <label for="lafcy">Leave Approved For Current Year</label>
                                                            <input type="number" name="lafcy" id="lafcy" class="form-control" value="<?php echo htmlentities($result->ldafcy);?>" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dlc">Date Leave Commences</label>
                                                            <input type="date" name="dlc" id="dlc" class="form-control" onchange="myFunc()">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dle">Date Leave Ends</label>
                                                            <input type="date" name="dle" id="dle" class="form-control" readonly>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="dorod">Date Of Resumption of Duty</label>
                                                            <input type="date" name="dorod" id="dorod" class="form-control" readonly>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                            <?php } } ?>

                                            <div class="form-actions">
                                                <button name="apply" onclick="return confirm('Are you sure you want to request leave?');"  type="submit" class="btn btn-primary">
                                                    <i class="fa fa-check-square-o"></i> Submit</button>
                                            </div>
                                        </form>
                                        <script>
                                            function myFunc() {
                                                var ldr =document.getElementById('ldr').value;
                                                var a = 1;
                                                var dlc = document.getElementById('dlc').value;
                                                var dle =document.getElementById('dle');
                                                var dorod =document.getElementById('dorod');
                                                
                                                var date = new Date(dlc);
                                                while (a < ldr) {
                                                    if ((date.getDay() != 0) && (date.getDay() !=6)) {
                                                        date.setDate(date.getDate() + 1);
                                                        a++;
                                                    }else{            
                                                        date.setDate(date.getDate() + 1);
                                                    }
                                                    
                                                }
                                                
                                                dle.value= fullDate(checkWeekend(date));
                                                date.setDate(date.getDate() + 1);
                                                dorod.value= fullDate(checkWeekend(date));
                                                
                                            }

                                            function fullDate($date) {
                                                var days = [1, 2, 3, 4, 5, 6, 7, 8, 9]
                                                if (($date.getMonth()+1) in days) {
                                                    var month = '-0'+($date.getMonth()+1);
                                                } else {
                                                    var month = '-'+($date.getMonth()+1);                
                                                }
                                                if ($date.getDate() in days) {
                                                    var day = '-0'+$date.getDate();
                                                } else {
                                                    var day = '-'+$date.getDate();                
                                                }
                                                var year = $date.getFullYear();
                                                return year+month+day;
                                            }

                                            function checkWeekend($date) {
                                                if ($date.getDay() ==6) {
                                                    $date.setDate($date.getDate() + 1);
                                                }          
                                                if ($date.getDay() ==0) {
                                                    $date.setDate($date.getDate() + 1);
                                                } 
                                                return $date;
                                            }

                                            function totalLeave() {
                                                var ol =parseInt(document.getElementById('ol').value);
                                                var cl =parseInt(document.getElementById('cl').value);
                                                $total = ol+cl
                                                document.getElementById('tle').value=$total;
                                            }
                                        </script>
                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8">
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
                                                <th>Employee Name</th>
                                                <th>Leave Start Date</th>
                                                <th>Leave End Date</th>
                                                <th>Leave Status</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $staffid = $_SESSION['staffid'];
                                            $sql1 = "SELECT concat(fname, ' ', lname) as fullname, dlc, dle, `status` from tblemployees as e
                                            join tblleaves as l on l.staffid = e.staffid where l.status=1 or l.status = 2 and 
                                            department=(SELECT department FROM tblemployees WHERE staffid=:staffid)";
                                            $query1 = $dbh -> prepare($sql1);
                                            $query1->bindParam(':staffid',$staffid,PDO::PARAM_STR);
                                            $query1->execute();
                                            $results1=$query1->fetchAll(PDO::FETCH_OBJ);
                                            $cnt1=1;
                                            if($query1->rowCount() > 0){
                                                foreach($results1 as $result){  ?>
                                                    <tr>
                                                        <td> <?php echo htmlentities($cnt1);?></td>
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