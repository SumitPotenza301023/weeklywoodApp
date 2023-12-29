<?php
if(isset($contests)){
?>
<section class="section">
    <div class="section-body">
        <div class="card profile-widget">
            <div class="profile-widget-header">
            <img alt="image" src="<?php  echo $contests['CONTEST_BANNER'];   ?>" class="profile-widget-picture" style="width:300px">
            <div class="profile-widget-items">
                <div class="profile-widget-item">
                <div class="profile-widget-item-label">TOTAL PRIZE POOL</div>
                <div class="profile-widget-item-value"><?php  echo $contests['TOTAL_PRICE_POOL']." Points";   ?></div>
                </div>
                <div class="profile-widget-item">
                <div class="profile-widget-item-label">TIER 1</div>
                <div class="profile-widget-item-value"><?php  echo $contests['TOTAL_TIER_1']." Points";   ?></div>
                </div>
                <div class="profile-widget-item">
                <div class="profile-widget-item-label">TIER 2</div>
                <div class="profile-widget-item-value"><?php  echo $contests['TOTAL_TIER_2']." Points";   ?></div>
                </div>
                <div class="profile-widget-item">
                <div class="profile-widget-item-label">TIER 3</div>
                <div class="profile-widget-item-value"><?php  echo $contests['TOTAL_TIER_3']." Points";   ?></div>
                </div>
            </div>
            <div class="profile-widget-items">
                <div class="profile-widget-item">
                <div class="profile-widget-item-label">TIER 1 EACH</div>
                <div class="profile-widget-item-value"><?php  echo $contests['TIER_1_EACH']." Points";   ?></div>
                </div>
                <div class="profile-widget-item">
                <div class="profile-widget-item-label">TIER 2 EACH</div>
                <div class="profile-widget-item-value"><?php  echo $contests['TIER_2_EACH']." Points";   ?></div>
                </div>
                <div class="profile-widget-item">
                <div class="profile-widget-item-label">TIER 3 EACH</div>
                <div class="profile-widget-item-value"><?php  echo $contests['TIER_3_EACH']." Points";   ?></div>
                </div>
            </div>
            </div>
            <div class="profile-widget-description pb-0">
            <div class="profile-widget-name"><?php  echo $contests['CONTEST_NAME'];   ?>
            </div>
            <div class="profile-widget-name">
                <div class="text-muted d-inline font-weight-normal">
                    <?php  echo $contests['START_DATE'];   ?> to <?php  echo $contests['END_DATE'];   ?>
                </div>
            </div>
            <div class="profile-widget-name"> Score Type :
                <div class="text-muted d-inline font-weight-normal">
                    <?php  echo $contests['SCORE_TYPE'];   ?>
                </div>
            </div>
            <p><?php  echo $contests['CONTEST_DESCRIPTION'];   ?></p>
            </div>
            <div class="card-footer text-center pt-0">
                <div class="font-weight-bold mb-2 text-small">Made Official On</div>
            <span class="badge badge-primary"><?php  echo $contests['OFFICIAL_ON'];   ?></span>
            </div>
        </div>
    </div>
</section>
<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4> <?=   lang('contest.contest_text.contest_result.title');  ?></h4>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="contestresultdatatable">
                        <thead>
                          <tr>
                            <th class="text-center">
                              <?=   lang('contest.contest_text.data_table.sr_no');  ?>
                            </th>
                            <th> <?=  lang('contest.contest_text.contest_result.name');  ?></th>
                            <th><?=   lang('contest.contest_text.contest_result.rank');  ?></th>
                            <th><?=   lang('contest.contest_text.contest_result.score');  ?></th>
                            <th><?=   lang('contest.contest_text.contest_result.Tier');  ?><i></th>
                            <th><?=   lang('contest.contest_text.contest_result.price_points');  ?><i></th>
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
<?php
}
?>