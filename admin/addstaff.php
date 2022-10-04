<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0) {
    header('location:index.php');
} else {
    if(isset($_POST['add'])) {
        $staffid=$_POST['staffid'];
        $fname=$_POST['fname'];
        $lname=$_POST['lname'];
        $position=$_POST['position'];
        $department=$_POST['department'];
        $address=$_POST['address'];
        $phone=$_POST['phone'];
        $email=$_POST['email'];
        $password=md5($_POST['password']);
        if ($position == "Junior Staff") {
            $policy = 1;
        }else {
            $policy =2;
        }
        if ($_POST['department']!=0) {

            try {
                $sql="INSERT INTO tblemployees(staffid, fname, lname, `position`, department, address, phone, email, password, policy)
                VALUES(:staffid, :fname, :lname, :position, :department, :address, :phone, :email, :password, :policy)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':staffid',$staffid,PDO::PARAM_STR);
                $query->bindParam(':fname',$fname,PDO::PARAM_STR);
                $query->bindParam(':lname',$lname,PDO::PARAM_STR);
                $query->bindParam(':position',$position,PDO::PARAM_STR);
                $query->bindParam(':department',$department,PDO::PARAM_INT);
                $query->bindParam(':address',$address,PDO::PARAM_STR);
                $query->bindParam(':phone',$phone,PDO::PARAM_STR);
                $query->bindParam(':email',$email,PDO::PARAM_STR);
                $query->bindParam(':password',$password,PDO::PARAM_STR);
                $query->bindParam(':policy',$policy,PDO::PARAM_INT);
                
                $query->execute();
                $lastInsertId = $dbh->lastInsertId();
            } catch (mysqli_sql_exception $th) {
                $error = $th;
            }
            if($lastInsertId) {
                $msg="Staff Created Successfully";
            } else {
                $error="Something went wrong. Please try again";
            }
        } else {
            $error="Please enter the Staff Details and tru again!";
        }
    }
    $sql1 = "SELECT * from tbldepartments";
    $query1 = $dbh->prepare($sql1);
    $query1->execute();
    $results1=$query1->fetchAll(PDO::FETCH_OBJ);

    ?>

    <!DOCTYPE html>
    <html lang="en">
    <head>
        <!-- Header Menu -->
        <?php include_once('includes/header.php');?>
        <title>Add Staff</title>
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
                                                    <h4 class="form-section">Add A New Staff</h4>
                                                    <div class="row">

                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label for="fname">First Name</label>
                                                                <input type="text" name="fname" id="fname" class="form-control"  required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="lname">Last Name</label>
                                                                <input type="text" name="lname" id="lname" class="form-control"  required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="staffid">Staff ID</label>
                                                                <input type="text" name="staffid" id="staffid" class="form-control"  required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="address">Home Address</label>
                                                                <input type="text" name="address" id="address" class="form-control" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="phone">Phone Number</label>
                                                                <input type="text" name="phone" id="phone" class="form-control"  required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="email">Email</label>
                                                                <input type="email" name="email" id="email" class="form-control" >
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="password">Password</label>
                                                                <input type="password" name="password" id="password" class="form-control"  required>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="position">Position</label>
                                                                <select name="position" id="position" class="form-control" required>
                                                                    <option value="Junior Staff">Junior Staff</option>
                                                                    <option value="Senior Staff">Senior Staff</option>
                                                                    <option value="Senior Member">Senior Member</option>
                                                                </select>
                                                            </div>
                                                            <div class="form-group">
                                                                <label for="department">Department</label>
                                                                <select name="department" id="department" class="form-control" required>
                                                                    <option value="0">Select A Department</option>
                                                                    <?php foreach ($results1 as $obj) { ?>
                                                                        <option value="<?php echo $obj->id ?>"><?php echo $obj->deptname ?></option>";
                                                                    <?php } ?>
                                                                </select>
                                                        </div>

                                                    </div>
                                                </div>

                                                <div class="form-actions">
                                                    <button name="add" onclick="return confirm('confirm creation');"  type="submit" class="btn btn-primary">
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

