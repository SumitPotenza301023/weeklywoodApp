<div class="card">

    <div class="card-header">
        <h4> <?=   lang('ADMINPANEL.profile.profiledetails');  ?></h4>
    </div>
    <?php
					if(isset($data['admin_data']) && !empty($data['admin_data'])){
						$admin_data = $data['admin_data']; 
    ?>
    <form class="edit_admin_form" id="edit_admin_form" method="POST" enctype="multipart/form-data">
        <div class="card-body">
            <div class="form-group">
                <div class="form-group col-md-12" align="center">
                    <?php
                    if(empty($admin_data['PROFILE_IMAGE'])){
                      ?>
                    <img src="<?= base_url(); ?>/public/assets/img/user.png" class="rounded-circle author-box-picture"
                        height="100" weight="200" />
                    <?php
                    } else {
                    ?>
                    <img src="<?= base_url().ADMINPROFILEIMAGEPATH; ?>/<?= $admin_data['ID']."/".$admin_data['PROFILE_IMAGE'] ?>"
                        class="rounded-circle author-box-picture" height="100" />
                    <?php
                    }
                    ?>
                    </br>
                    </br>
                    <input type="file" class="form-control" id="image" name="image">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="first_name"><?=   lang('ADMINPANEL.profile.first_name.name');  ?></label>
                    <input type="text" class="form-control" id="first_name1" name="first_name"
                        value="<?= $admin_data['FIRST_NAME'] ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="last_name"><?=   lang('ADMINPANEL.profile.last_name.name');  ?></label>
                    <input type="text" class="form-control" id="last_name1" name="last_name"
                        value="<?= $admin_data['LAST_NAME'] ?>">
                </div>
                 <div class="form-group col-md-4">
                    <label for="dob"><?=   lang('ADMINPANEL.profile.dob.name');  ?></label>
                    <input type="date" class="form-control" id="dob" name="dob"
                        value="<?= $admin_data['DOB'] ?>">
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="email"><?=   lang('ADMINPANEL.profile.email.name');  ?></label>
                    <input type="text" class="form-control" id="email1" name="email" value="<?= $admin_data['EMAIL_ID'] ?>"
                        disabled>
                </div>
                <div class="form-group col-md-4">
                    <label for="username"><?=   lang('ADMINPANEL.profile.username.name');  ?></label>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?= $admin_data['USERNAME'] ?>">
                </div>
                <div class="form-group col-md-4">
                    <label for="gender"><?=   lang('ADMINPANEL.profile.gender.name');  ?></label>
                    <div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="gendermale" value="M" name = "gender" <?php  if($admin_data['GENDER'] === "M"){ echo "checked"; } ?>>
                            <label class="form-check-label" for="gendermale"><?=   lang('ADMINPANEL.profile.gender.male');  ?></label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" id="genderfemale" value="F" name = "gender" <?php  if($admin_data['GENDER'] ==="F"){ echo "checked"; } ?>>
                            <label class="form-check-label" for="genderfemale"><?=   lang('ADMINPANEL.profile.gender.female');  ?></label>
                        </div>
                    </div>
                </div>
            </div>
            <hr>
        </div>
        <div class="card-footer">
            <button type="submit" role="button" form="edit_admin_form" class="btn btn-primary" id="btneditadmin">
                <?=   lang('ADMINPANEL.profile.updateprofile.name');  ?>
            </button>
        </div>
    </form>
    <?php
          }
    ?>
</div>
