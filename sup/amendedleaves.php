<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['hodid'])==0 && strlen($_SESSION['hrid']==0))
    {   
header('location:index.php');
}
else{

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Header Menu -->
  <?php include('includes/header.php');?>
    
    <title>Leave History</title>
</head>
<body>
          
  
  <!-- Side Menu -->
  <?php include('includes/sidebar.php');?>

    <!-- The Content -->
    <section>
      <h1>LEAVE HISTORY</h1>
      <?php if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
      <table>
            <thead>
                <th>No.</th>
                <th>Employee Name</th>
                <th>Leave Start Date</th>
                <th>Leave End Date</th>
                <th>Leave Status</th>
                <th>Action</th>
            </thead>
            <tbody>
            <?php 
            if(isset($_SESSION['hrid'])){
                $sql1 = "SELECT l.id as id, concat(fname, ' ', lname) as fullname, dlc, dle, `status` from tblemployees as e
                join tblleaves as l on l.staffid = e.staffid where status=4";
                $query1 = $dbh -> prepare($sql1);
            }else {
                $hodid = $_SESSION['hodid'];
                $sql1 = "SELECT l.id as id, concat(fname, ' ', lname) as fullname, dlc, dle, `status` from tblemployees as e
                join tblleaves as l on l.staffid = e.staffid where status=4 and
                department=(SELECT department FROM tblemployees WHERE staffid=:hodid)";
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
                          <a href="leaves.php?recid=<?php echo htmlentities($result->id);?>"><i class="material-icons">Recommend</i></a>
                          <a href="updateleave.php?lid=<?php echo htmlentities($result->id);?>"><i class="material-icons">Amend Leave</i></a>
                         <a href="leaves.php?notid=<?php echo htmlentities($result->id);?>" onclick="return confirm('Do you want to reject leave?');"> <i class="material-icons">Not Recommend</i></a></td>

                    </tr>
                <?php $cnt1++;} }?>
        </tbody>
        </table>
    </section>
</body>
</html>
<?php } ?>