<?php
    if($firebase_setting['SETTING_KEY'] == FIREBASE_SERVER_KEY ){
        $setting_value = $firebase_setting['SETTING_VALUE'];
?>
<section class="section">
    <div class="section-body">
        <div class="row">
           <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                    <h4><?=   lang('settings.firebasetitle');  ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="update_firebase_setting" id="update_firebase_setting" method="POST" >  
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label><?=   lang('settings.field');  ?></label>
                                    <div class="input-group">
                                    <input type="text" name='firebasekey' value="<?=   $setting_value   ?>"  class="form-control" />
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="submit" role="button" form="update_firebase_setting" id="btnupdatefirebase" class="btn btn-primary btn-lg btn-block">
                                        <?=   lang('settings.update');  ?>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
    }
?>