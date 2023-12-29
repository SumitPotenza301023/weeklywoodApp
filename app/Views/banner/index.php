<section class="section">
<div class="section-body">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4> <?=   lang('banners.banner_test.upload_banner');  ?></h4>
                </div>
                <div class="card-body">
                    <form class="uploadbanner" id="upload_banner" method="POST" enctype="multipart/form-data" >
                        <div class="form-row">
                            <div class="dropzone form-group col-12" id="banner_files" >
                                <div class="fallback">
                                    <input name="file" type="file" id="upload_banner_images" multiple accept="image/*"/>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
    <div class="card">
        <div class="card-header">
        <h4><?=   lang('banners.banner_test.list');  ?></h4>
        </div>
        <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered table-md" id="tbl_banners">
              <thead>
                <tr>
                <th class="text-center">
                    <?=   lang('banners.banner_test.srno');  ?>
                </th>
                <th> <?=  lang('banners.banner_test.image_col');  ?></th>
                <th><?=   lang('banners.banner_test.active_status');  ?></th>
                <th><?=   lang('banners.banner_test.sort_order');  ?></th>
                <th><?=   lang('banners.banner_test.action');  ?></th>
                </tr>
            </thead>    
            </table>
        </div>
        </div>
    </div>
    </div>
</div>
</section>