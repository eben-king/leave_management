<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['hodid'])==0 && strlen($_SESSION['hrid']==0))
    {   
header('location:index.php');
}
else{
if(isset($_POST['update'])) {
    $lid=intval($_GET['lid']);    
    $ldr=$_POST['ldr'];
    $dlc=$_POST['dlc'];
    $dle=$_POST['dle'];
    $dorod=$_POST['dorod'];
    $sql="update tblleaves set ldr=:ldr, dlc=:dlc, dle=:dle, dorod=:dorod, status=4 where id=:lid";
    $query = $dbh->prepare($sql);
    $query->bindParam(':ldr',$ldr,PDO::PARAM_INT);
    $query->bindParam(':dlc',$dlc,PDO::PARAM_STR);
    $query->bindParam(':dle',$dle,PDO::PARAM_STR);
    $query->bindParam(':dorod',$dorod,PDO::PARAM_STR);
    $query->bindParam(':lid',$lid,PDO::PARAM_INT);
    $query->execute();
    $msg="Leave updated Successfully";
}

?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php include_once('includes/header.php') ?>
        <title>Dashboard</title>
    </head>
    <?php include_once('includes/style.php') ?>
    <body class="vertical-layout vertical-menu 2-columns   menu-expanded fixed-navbar" data-open="click" data-menu="vertical-menu" data-col="2-columns">

    <!-- fixed-top-->
    <?php include_once('includes/navbar.php') ?>
    <!-- ////////////////////////////////////////////////////////////////////////////-->

    <?php include_once('includes/sidebar.php') ?>

    <div class="app-content content">
        <div class="content-wrapper">
            <div class="content-body">
                <div id="user-profile">
                    <div class="row">
                        <div class="col-12">

                            <section id="basic-form-layouts" style="margin-top: 5px;">
                                <div class="row match-height">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">
                                                <h4 class="card-title" id="basic-layout-form">Update Your Leave</h4>
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
                                                    <form class="form"  method="post">
                                                        <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php }
                                                        else if($msg){?><div class="succWrap"><strong>SUCCESS</strong> : <?php echo htmlentities($msg); ?> </div><?php }?>
                                                        <?php
                                                        $lid=intval($_GET['lid']);

                                                        $sql = "SELECT * from tblleaves WHERE id=:lid";
                                                        $query = $dbh -> prepare($sql);
                                                        $query->bindParam(':lid',$lid,PDO::PARAM_INT);
                                                        $query->execute();
                                                        $results=$query->fetchAll(PDO::FETCH_OBJ);
                                                        $cnt=1;
                                                        if($query->rowCount() > 0)  {
                                                        foreach($results as $result) { ?>
                                                        <div class="form-body">

                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="form-group">
                                                                        <label for="ol">Outstanding Leave:</label>
                                                                        <input class="form-control" id="ol" type="text"  autocomplete="off" name="ol" value="<?php echo htmlentities($result->ol);?>"  >
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="cl">Current Leave:</label>
                                                                        <input class="form-control" id="cl" type="text"  autocomplete="off" name="cl" value="<?php echo htmlentities($result->cl);?>"  required>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="tle">Total Leave Earned:</label>
                                                                        <input class="form-control" id="tle" type="text"  autocomplete="off" name="tle" value="<?php echo htmlentities($result->tle);?>"  >
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="ldr">Leave Days Requested</label>
                                                                        <input class="form-control" type="number" name="ldr" id="ldr" value="<?php echo htmlentities($result->ldr);?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="lafcy">Leave Approved For Current Year</label>
                                                                        <input class="form-control" type="number" name="lafcy" id="lafcy" value="<?php echo htmlentities($result->lafcy);?>" >
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="dlc">Date Leave Commences</label>
                                                                        <input class="form-control" type="date" name="dlc" id="dlc" value="<?php echo htmlentities($result->dlc);?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="dle">Date Leave Ends</label>
                                                                        <input class="form-control" type="date" name="dle" id="dle" value="<?php echo htmlentities($result->dle);?>">
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <label for="dorod">Date Of Resumption of Duty</label>
                                                                        <input class="form-control" type="date" name="dorod" id="dorod" value="<?php echo htmlentities($result->dorod);?>">
                                                                    </div>

                                                                    <?php } } ?>

                                                                    <div class="form-group">
                                                                        <button class="form-control" type="submit" name="update">UPDATE</button>

                                                                    </div>
                                                                </div>
                                                            </div>

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
        </div>
    </div>
    <section>

    </section>

    <?php include_once('includes/footer.php') ?>
    </body>
    </html>
<?php } ?>