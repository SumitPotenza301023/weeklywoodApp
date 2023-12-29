<style>
.file-upload {
  background-color: #ffffff;
  width: 600px;
  margin: 0 auto;
  padding: 20px;
}

.file-upload-btn {
  width: 100%;
  margin: 0;
  color: #fff;
  background: #1FB264;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #15824B;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.file-upload-btn:hover {
  background: #1AA059;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.file-upload-btn:active {
  border: 0;
  transition: all .2s ease;
}

.file-upload-content {
  display: none;
  text-align: center;
}

.file-upload-input {
  position: absolute;
  margin: 0;
  padding: 0;
  width: 100%;
  height: 100%;
  outline: none;
  opacity: 0;
  cursor: pointer;
}

.image-upload-wrap {
  margin-top: 20px;
  border: 4px dashed #1FB264;
  position: relative;
}

.image-dropping,
.image-upload-wrap:hover {
  background-color: #1FB264;
  border: 4px dashed #ffffff;
}

.image-title-wrap {
  padding: 0 15px 15px 15px;
  color: #222;
}

.drag-text {
  text-align: center;
}

.drag-text h3 {
  font-weight: 100;
  text-transform: uppercase;
  color: #15824B;
  padding: 60px 0;
}

.file-upload-image {
  max-height: 200px;
  max-width: 200px;
  margin: auto;
  padding: 20px;
}

.remove-image {
  width: 200px;
  margin: 0;
  color: #fff;
  background: #cd4535;
  border: none;
  padding: 10px;
  border-radius: 4px;
  border-bottom: 4px solid #b02818;
  transition: all .2s ease;
  outline: none;
  text-transform: uppercase;
  font-weight: 700;
}

.remove-image:hover {
  background: #c13b2a;
  color: #ffffff;
  transition: all .2s ease;
  cursor: pointer;
}

.remove-image:active {
  border: 0;
  transition: all .2s ease;
}
</style>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-2 col-lg-2">
                <div class="card">
                    <button type="button" class="btn btn-primary" id="btnaddclub" data-toggle="modal" data-target=".bd-create-promocode-modal-lg"> 
                        <?=   lang('promocodes.promocode.add_promocode');  ?>
                    </button>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4> <?=  lang('promocodes.promocode.promocode_list');  ?></h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="promocodedatatable">
                        <thead>
                          <tr>
                            <th class="text-center">
                             <?=   lang('promocodes.promocode.data_table.srno');  ?>
                            </th>
                            <th> <?=  lang('promocodes.promocode.data_table.title');  ?> </th>
                            <th><?=   lang('promocodes.promocode.data_table.banner');  ?></th>
                            <th><?=   lang('promocodes.promocode.data_table.purchase_point');  ?></th>
                             <th><?=   lang('promocodes.promocode.data_table.expiry_date');  ?><i></th>
                            <th><?=   lang('promocodes.promocode.data_table.used');  ?><i></th>
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
<!-- Model Create Contest -->
<div class="modal fade bd-create-promocode-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?=   lang('promocodes.promocode.add_promocode');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form class="add_promocode" id="add_promocode" method="POST" >  
                    <div class="form-row">
                        <div class="file-upload form-group col-12">
                            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><?=   lang('promocodes.promocode.fields.promocode_banner');  ?> </button>

                            <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' name='filebannerpromocode' onchange="readURL(this);" accept="image/*" required/>
                                <div class="drag-text">
                                    <h3>Drag and drop a file or select add Image</h3>
                                </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="image-title-wrap">
                                    <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputcity"><?=   lang('promocodes.promocode.fields.promocode_title');  ?></label>
                            <input type="text" class="form-control" name="promocode_title" id="promocode-title" required>
                        </div>
                    </div>
                    <div class="form-row">
                         <div class="form-group col-md-12">
                            <label for="contest-description"><?=   lang('promocodes.promocode.fields.promocode_description');  ?></label>
                            <textarea class="form-control" id="promocode-description" name = "promocode_description" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputpoints"><?=   lang('promocodes.promocode.fields.promocode_points');  ?></label>
                             <div class="promoinfo">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <div class="pointsinfo">
                                  <p> Purchase Point - Point given as discount</p>
                            </div>
                            </div>
                            <input type="number" class="form-control" name="promocode_points" id="promocode-points" min="1" required />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputpoints"><?=   lang('promocodes.promocode.fields.minimum_purchase');  ?></label>
                            <div class="promoinfo">
                              <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                              <div class="pointsinfo">
                                    <p> Minimum Point - Minimum point to purchase to apply for promocode</p>
                              </div>
                            </div>
                            <input type="number" class="form-control" name="minimum_promocode_points" id="minimum_promocode_points" min="1" required />
                        </div>
                         <div class="form-group col-md-4">
                            <label for="start_date"><?=   lang('promocodes.promocode.fields.promocode_expiry');  ?></label>
                            <div class="promoinfo">
                              <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                              <div class="pointsinfo">
                                    <p> Expiry Date - Promocode will be valid till </p>
                              </div>
                            </div>
                            <input  class="form-control datepicker nobefore" name="expiry_date" id="expiry-date" required />
                        </div>
                    </div>
                  
                   
                    <button type="submit" role="button" form="add_promocode" id="btnaddpromocode" class="btn btn-primary btn-lg btn-block">
                       <?=   lang('promocodes.promocode.add_promocode');  ?>
                    </button>
                   
                </form>
                <!-- <div class="alert alert-info">
                      <div class="alert-title">Note:</div>
                      <p> Purchase Point - Point given as discount</p>
                      <p> Minimum Point - Minimum point to purchase to apply for promocode</p>
                </div> -->
            </div>
        </div>
    </div>
</div>
<!-- End model create contest -->
<!-- Model edit Contest -->
<div class="modal fade bd-create-edit-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?=   lang('promocodes.promocode.add_promocode');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form class="edit_promocode" id="edit_promocode" method="POST" >  
                     <input type="hidden" name="promo_id" />
                    <div class="form-row">
                        <div class="file-upload form-group col-12">
                            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><?=   lang('promocodes.promocode.fields.promocode_banner');  ?> </button>

                            <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' name='filebannerpromocode' onchange="readURL(this);" accept="image/*"/>
                                <div class="drag-text">
                                    <h3>Drag and drop a file or select add Image</h3>
                                </div>
                            </div>
                            <div class="file-upload-content">
                                <img class="file-upload-image" src="#" alt="your image" />
                                <div class="image-title-wrap">
                                    <button type="button" onclick="removeUpload()" class="remove-image">Remove <span class="image-title">Uploaded Image</span></button>
                                </div>
                            </div>
                        </div>
                    </div>
                
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="inputcity"><?=   lang('promocodes.promocode.fields.promocode_title');  ?></label>
                            <input type="text" class="form-control" name="promocode_title" id="promocode-title" required>
                        </div>
                    </div>
                    <div class="form-row">
                         <div class="form-group col-md-12">
                            <label for="contest-description"><?=   lang('promocodes.promocode.fields.promocode_description');  ?></label>
                            <textarea class="form-control" id="promocode-description" name = "promocode_description" required></textarea>
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-4">
                            <label for="inputpoints"><?=   lang('promocodes.promocode.fields.promocode_points');  ?></label>
                             <div class="promoinfo">
                            <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                            <div class="pointsinfo">
                                  <p> Purchase Point - Point given as discount</p>
                            </div>
                            </div>
                            <input type="number" class="form-control" name="promocode_points" id="promocode-points" min="1" required />
                        </div>
                        <div class="form-group col-md-4">
                            <label for="inputpoints"><?=   lang('promocodes.promocode.fields.minimum_purchase');  ?></label>
                            <div class="promoinfo">
                              <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                              <div class="pointsinfo">
                                    <p> Minimum Point - Minimum point to purchase to apply for promocode</p>
                              </div>
                            </div>
                            <input type="number" class="form-control" name="minimum_promocode_points" id="minimum_promocode_points" min="1" required />
                        </div>
                         <div class="form-group col-md-4">
                            <label for="start_date"><?=   lang('promocodes.promocode.fields.promocode_expiry');  ?></label>
                            <div class="promoinfo">
                              <i class="fa fa-exclamation-circle" aria-hidden="true"></i>
                              <div class="pointsinfo">
                                    <p> Expiry Date - Promocode will be valid till </p>
                              </div>
                            </div>
                            <input  class="form-control datepicker nobefore" name="expiry_date" id="expiry-date" required />
                        </div>
                    </div>
                  
                   
                    <button type="submit" role="button" form="edit_promocode" id="btneditpromocode" class="btn btn-primary btn-lg btn-block">
                       <?=   lang('promocodes.promocode.edit_promocode');  ?>
                    </button>
                   
                </form>
            
            </div>
        </div>
    </div>
</div>
<!-- End model edit contest -->

 