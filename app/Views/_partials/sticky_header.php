      <nav class="navbar navbar-expand-lg main-navbar sticky">
        <div class="form-inline mr-auto">
          <ul class="navbar-nav mr-3">
            <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                <i data-feather="maximize"></i>
              </a></li>
          
          </ul>
        </div>
        <ul class="navbar-nav navbar-right">
          <li class="dropdown"><a href="#" data-toggle="dropdown"
              class="nav-link dropdown-toggle nav-link-lg nav-link-user"> 
              <?php 
                if(!empty($_SESSION['PROFILE_IMAGE'])){
                    ?>
                   <img alt="image" src="<?= base_url().ADMINPROFILEIMAGEPATH; ?>/<?=$_SESSION['ID']."/".$_SESSION['PROFILE_IMAGE'] ?>" class="user-img-radious-style">
                    <?php
                }else {
                  ?>
                   <img alt="image" src="<?=  base_url().IMGPATH ?>/user.png" class="user-img-radious-style">
                  <?php
                }
              ?>
              <span class="d-sm-none d-lg-inline-block"></span></a>
            <div class="dropdown-menu dropdown-menu-right pullDown">
              <div class="dropdown-title">Hello,  <?php echo $_SESSION['FIRST_NAME']; ?></div>
              <a href="<?= base_url().'/admin/profile'?>" class="dropdown-item has-icon"> <i class="far
										fa-user"></i> <?=   lang('ADMINPANEL.stickyheader.profile');  ?>
              </a> <a href="<?= base_url("admin/reset-password")?>" class="dropdown-item has-icon"> <i class="fas fa-bolt"></i>
                <?=   lang('ADMINPANEL.stickyheader.update_password');  ?>
              </a>
              <div class="dropdown-divider"></div>
              <a href="<?= base_url("/admin/logout")?>" class="dropdown-item has-icon text-danger"> <i class="fas fa-sign-out-alt"></i>
                <?=   lang('ADMINPANEL.stickyheader.logout');  ?>
              </a>
            </div>
          </li>
        </ul>
      </nav>