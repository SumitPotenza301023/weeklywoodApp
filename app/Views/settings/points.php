<?php
    if($price_setting['SETTING_KEY'] == POINT_PRICE ){
        $value = json_decode($price_setting['SETTING_VALUE'], true);
        $point =  $value[POINT];
        $point_price_value = $value[POINT_PRICE_VALUE];
?>
<section class="section">
    <div class="section-body">
        <div class="row">
           <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                    <h4><?=   lang('points.point_setting');  ?></h4>
                    </div>
                    <div class="card-body">
                        <form class="update_point_setting" id="update_point_setting" method="POST" >  
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label><?=   lang('points.fields.point');  ?></label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <i class="fas fa-coins"></i>
                                        </div>
                                    </div>
                                    <input type="number" name='point' value=<?=   $point   ?> class="form-control currency" min=1 disabled>
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <label><?=   lang('points.fields.point_price');  ?></label>
                                    <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">
                                        <?=   CURRENCY      ?>
                                        </div>
                                    </div>
                                    <input type="number" name='point_price' value=<?=   $point_price_value   ?>  class="form-control currency" min=1>
                                    </div>
                                </div>
                            </div>
                            <div class='form-row'>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                </div>
                                <div class="form-group col-md-4">
                                    <button type="submit" role="button" form="update_point_setting" id="btnupdatepoint" class="btn btn-primary btn-lg btn-block">
                                        <?=   lang('points.update');  ?>
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