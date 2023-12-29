<div class="card">

    <div class="card-header">
        <h4> <?=   lang('ADMINPANEL.resetpass.name');  ?></h4>
    </div>
  
    <form class="edit_admin_form" id="edit_password_form" method="POST" enctype="multipart/form-data">
        <div class="card-body">
          
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="pass"><?=   lang('ADMINPANEL.resetpass.fields.password');  ?></label>
                    <input type="password" class="form-control" id="pass" name="password">
                </div>
                <div class="form-group col-md-6">
                    <label for="confirm_pass"><?=   lang('ADMINPANEL.resetpass.fields.confirmpass');  ?></label>
                    <input type="password" class="form-control" id="confirm_pass" name="confirmpass" >
                </div>
                
            </div>
            <hr>
        </div>
        <div class="card-footer">
            <button type="submit" role="button" form="edit_password_form" class="btn btn-primary" id="btnupdatepass">
                <?=   lang('ADMINPANEL.resetpass.updatepassbtn');  ?>
            </button>
        </div>
    </form>
   
</div>
