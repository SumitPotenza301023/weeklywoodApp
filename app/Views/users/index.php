<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-2 col-lg-2">
                <div class="card">
                    <button type="button" class="btn btn-primary" id="btnadduser" data-toggle="modal" data-target=".bd-create-user-modal-lg"> 
                        <?=   lang('users.users.add_user');  ?>
                    </button>
                </div>
            </div>

        </div>
         <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4>  <?=   lang('users.users.data_table.userlisting');  ?> </h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="usersdatatable">
                        <thead>
                          <tr>
                            <th class="text-center">
                             <?=   lang('promocodes.promocode.data_table.srno');  ?>
                            </th>
                            <th> <?=  lang('users.users.data_table.name');  ?></th>
                            <th><?=   lang('users.users.data_table.username');  ?></th>
                            <th><?=   lang('users.users.data_table.email');  ?></th>
                            <th><?=   lang('users.users.data_table.role');  ?></th>
                            <th><?=   lang('users.users.data_table.access');  ?></th>
                            <th><?=   lang('contest.contest_text.data_table.action');  ?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>
    </div>
</section>
<!-- CREATE USER -->
<div class="modal fade bd-create-user-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?=   lang('users.users.add_user');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form class="add_user" id="add_user" method="POST" >  
                
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="first_name"><?=   lang('users.users.fields.first_name');  ?></label>
                            <input type="text" class="form-control" name="first_name" id="first_name" required>
                        </div>
                         <div class="form-group col-md-6">
                            <label for="contest-description"><?=   lang('users.users.fields.last_name');  ?></label>
                            <input type="text" class="form-control" name="last_name" id="last_name" required>
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="username"><?=   lang('users.users.fields.username');  ?></label>
                            <input type="text" class="form-control" name="username" id="username"required />
                        </div>
                         <div class="form-group col-md-4">
                            <label for="email"><?=   lang('users.users.fields.email');  ?></label>
                            <input type="email" class="form-control" name="email" id="email"required />
                        </div>
                         <div class="form-group col-md-4">
                            <label for="role"><?=   lang('users.users.fields.role');  ?></label>
                             <select class="form-control" name="user_role" id = "role" required>
                                 <option>--SELECT ROLE--</option>
                                <?php
                                    foreach($role as $user_role){
                                        ?>
                                             <option value=<?=  $user_role['R_ID']    ?>><?=  $user_role['NAME']  ?></option>
                                        <?php
                                    }
                                ?>
                               
                            </select>
                        </div>
                    </div>
                   
                   
                    <button type="submit" role="button" form="add_user" id="btnadduser" class="btn btn-primary btn-lg btn-block">
                       <?=   lang('users.users.add_user');  ?>
                    </button>
                   
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END CREATE USER -->
<!-- EDIT USER -->
<div class="modal fade bd-edit-user-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?=   lang('users.users.edit_user');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form class="edit_user" id="edit_user" method="POST" >
                     <input type='hidden' name='user_id'/>
                    <div class="form-row">
                        <div class="form-group col-md-12" align="center">
                            <img src="<?= base_url(); ?>/public/assets/img/user.png" class="rounded-circle author-box-picture"
                            id="userimage" height="100" weight="200" />
                        </div>
                           
                    </div>  
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="first_name"><?=   lang('users.users.fields.first_name');  ?></label>
                            <input type="text" class="form-control" name="first_name" id="first_name" required>
                        </div>
                         <div class="form-group col-md-4">
                            <label for="contest-description"><?=   lang('users.users.fields.last_name');  ?></label>
                            <input type="text" class="form-control" name="last_name" id="last_name" required>
                        </div>
                         <div class="form-group col-md-4">
                            <label for="dob"><?=   lang('ADMINPANEL.profile.dob.name');  ?></label>
                            <input type="date" class="form-control" id="dob" name="dob" disabled/>
                        </div>
                    </div>
                     <div class="form-row">
                          <div class="form-group col-md-4">
                            <label for="gender"><?=   lang('ADMINPANEL.profile.gender.name');  ?></label>
                            <div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="gendermale" value="M" name = "gender" disabled>
                                    <label class="form-check-label" for="gendermale"><?=   lang('ADMINPANEL.profile.gender.male');  ?></label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" id="genderfemale" value="F" name = "gender" disabled>
                                    <label class="form-check-label" for="genderfemale"><?=   lang('ADMINPANEL.profile.gender.female');  ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="username"><?=   lang('users.users.fields.username');  ?></label>
                            <input type="text" class="form-control" name="username" id="username" required />
                        </div>
                         <div class="form-group col-md-4">
                            <label for="email"><?=   lang('users.users.fields.email');  ?></label>
                            <input type="email" class="form-control" name="email" id="email" required />
                        </div>
                        
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="role"><?=   lang('users.users.fields.role');  ?></label>
                             <select class="form-control" name="user_role" id = "role" required>
                                 <option>--SELECT ROLE--</option>
                                <?php
                                    foreach($role as $user_role){
                                        ?>
                                             <option value=<?=  $user_role['R_ID']    ?>><?=  $user_role['NAME']  ?></option>
                                        <?php
                                    }
                                ?>
                               
                            </select>
                        </div>
                        <div class="form-group col-md-4">
                            <label for="street"><?=   lang('users.users.fields.street');  ?></label>
                            <input type="text" class="form-control" name="street" id="street" disabled />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="city"><?=   lang('users.users.fields.city');  ?></label>
                            <input type="text" class="form-control" name="city" id="city" disabled />
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="zipcode"><?=   lang('users.users.fields.zipcode');  ?></label>
                            <input type="text" class="form-control" name="zipcode" id="zipcode" disabled />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="state"><?=   lang('users.users.fields.state');  ?></label>
                            <input type="text" class="form-control" name="state" id="state" disabled />
                        </div>
                         <div class="form-group col-md-4">
                            <label for="paypalid"><?=   lang('users.users.fields.paypalid');  ?></label>
                            <input type="email" class="form-control" name="paypalid" id="paypalid" disabled />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="tax_id"><?=   lang('users.users.fields.taxid');  ?></label>
                            <input type="text" class="form-control" name="tax_id" id="tax_id" disabled />
                        </div>
                    </div>
                   
                   
                    <button type="submit" role="button" form="edit_user" id="btnedituser" class="btn btn-primary btn-lg btn-block">
                       <?=   lang('users.users.edit_user');  ?>
                    </button>
                   
                </form>
            </div>
        </div>
    </div>
</div>
<!-- END EDIT USER -->