<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-2 col-lg-2">
                <div class="card">
                    <a type="button" class="btn btn-primary" href='<?= base_url().ADMIN ?>/cms/new-page' > 
                        <?=   lang('cms.new_page');  ?>
                    </a>
                </div>
            </div>

        </div>
    </div>
     <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4> <?=   lang('cms.data_table.page_list');  ?></h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="pagedatatable">
                        <thead>
                          <tr>
                            <th class="text-center">
                              <?=   lang('contest.contest_text.data_table.sr_no');  ?>
                            </th>
                            <th> <?=   lang('cms.data_table.title');  ?> </th>
                            <th> <?=   lang('cms.data_table.slug');  ?> </th>
                            <th><?=   lang('cms.data_table.last_update');  ?></th>
                            <th><?=   lang('contest.contest_text.data_table.action');  ?></th>
                          </tr>
                        </thead>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
        </div>
</section>