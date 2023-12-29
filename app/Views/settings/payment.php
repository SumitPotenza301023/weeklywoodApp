<?php
    if($paypal_setting['SETTING_KEY'] == PAYPAL_SETTING ){
        $value = json_decode($paypal_setting['SETTING_VALUE'], true);
        $client_key =  $value[PAYPAL_CLIENT_KEY];
        $secret = $value[PAYPAL_SECRET_KEY];
?>
<section class="section">
    <div class="section-body">
        <div class="row">
           <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        
                        <h4><i class="fab fa-paypal"></i> <?=   lang('points.payment_setting');  ?></h4>
                        
                    </div>
                   
                    <div class="card-body">
                        <form class="update_payment_setting" id="update_payment_setting" method="POST" >  
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label><?=   lang('points.field.client_key');  ?></label>
                                    <div class="input-group">
                                    <input type="text" name='client_key' value="<?=   $client_key  ?>" class="form-control" >
                                    </div>
                                </div>
                            </div>
                             <div class="form-row">
                                <div class="form-group col-md-12">
                                    <label><?=   lang('points.field.secret_key');  ?></label>
                                    <div class="input-group">
                                    <input type="password" name='secret_key' value="<?=   $secret  ?>"  class="form-control">
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="submit" role="button" form="update_payment_setting" id="btnupdatepoint" class="btn btn-primary btn-lg btn-block">
                                        <?=   lang('points.update_payment');  ?>
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