<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4> <?=  lang('payments.payment_list');  ?></h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="transactiondatatable">
                        <thead>
                          <tr>
                            <th class="text-center">
                             <?=   lang('promocodes.promocode.data_table.srno');  ?>
                            </th>
                            <th> <?=  lang('payments.name');  ?> </th>
                            <th><?=   lang('payments.amount');  ?></th>
                            <th><?=   lang('payments.transaction_id');  ?></th>
                             <th class="text-center"><?=   lang('payments.promocode');  ?><i></th>
                           
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