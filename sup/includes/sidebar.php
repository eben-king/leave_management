<div class="main-menu menu-fixed menu-dark menu-accordion    menu-shadow " data-scroll-to-active="true">
      <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <li class=" nav-item"><a href="dashboard.php"><i class="icon-home"></i><span class="menu-title" data-i18n="nav.navbars.main">Dashboard</span></a>
     
    </li>       <li class=" nav-item"><a href="myprofile.php"><i class="icon-question"></i><span class="menu-title" data-i18n="nav.navbars.main">Profile</span></a>
     
    </li>
    
     <li class=" nav-item"><a href="changepassword.php"><i class="icon-question"></i><span class="menu-title" data-i18n="nav.navbars.main">Change Password</span></a>
     
    </li>
    <li class=" nav-item"><a href="#"><i class="icon-list"></i><span class="menu-title" data-i18n="nav.navbars.main">Leave Actions</span></a>
     <ul class="menu-content">
        <li><a class="menu-item" href="leaves.php" data-i18n="nav.dash.ecommerce">All Leaves</a>
        </li>
        <li><a class="menu-item" href="pendingleaves.php" data-i18n="nav.dash.ecommerce">Pending Leaves</a>
        </li><?php if (isset($_SESSION['hodid'])) { ?>
          <li><a class="menu-item" href="amendedleaves.php" data-i18n="nav.dash.ecommerce">Amended Leaves</a>
          </li>
        <?php } ?>
         <li><a class="menu-item" href="recommendedleaves.php" data-i18n="nav.dash.ecommerce">Recommended Leaves</a>
         </li>
         <li><a class="menu-item" href="rejectedleaves.php" data-i18n="nav.dash.ecommerce">Not Recommended Leaves</a>
         </li>

      </ul>
    </li>
     




       
        </ul>
      </div>
    </div>