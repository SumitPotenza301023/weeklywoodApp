<section class="section">
    <div class="section-body">
       <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4> <?=   lang('cms.edit_page');  ?> </h4>
                    </div>
                    <div class="card-body">
                        <form method="post" id='edit_page' >
                            <input type='hidden' name='page_id' value=<?= $page['ID'] ?> >
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?=   lang('cms.page_title');  ?></label>
                                <div class="col-sm-12 col-md-7">
                                    <input type="text" name='pagetitle' class="form-control" value="<?= $page['TITLE'] ?>" >
                                </div>
                            </div>
                             <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"><?=   lang('cms.page_content');  ?></label>
                                <div class="col-sm-12 col-md-7">
                                      <textarea id="new-page-content" name='pagecontent' >
                                          <?= $page['CONTENT'] ?>
                                      </textarea>
                                </div>
                            </div>
                            <div class="form-group row mb-4">
                                <label class="col-form-label text-md-right col-12 col-md-3 col-lg-3"></label>
                                <div class="col-sm-12 col-md-7">
                                    <button class="btn btn-primary" type="submit" role="button" form="edit_page" id="btnedit_page" ><?=   lang('cms.update_page');  ?></button>
                                </div>
                            </div>
                          
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
