<style>
.tooltip {
  position: relative;
  display: inline-block;
  border-bottom: 1px dotted black;
}

.tooltip .tooltiptext {
  visibility: hidden;
  width: 120px;
  background-color: #555;
  color: #fff;
  text-align: center;
  border-radius: 6px;
  padding: 5px 0;
  position: absolute;
  z-index: 1;
  bottom: 125%;
  left: 50%;
  margin-left: -60px;
  opacity: 0;
  transition: opacity 0.3s;
}

.tooltip .tooltiptext::after {
  content: "";
  position: absolute;
  top: 100%;
  left: 50%;
  margin-left: -5px;
  border-width: 5px;
  border-style: solid;
  border-color: #555 transparent transparent transparent;
}

.tooltip:hover .tooltiptext {
  visibility: visible;
  opacity: 1;
}
</style>
<section class="section">
    <div class="row ">
        <?php  foreach($contests as $contest){ ?>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12"   >
                <div class="card">
                    <div class="card-statistic-4">
                        <div class="align-items-center justify-content-between">
                        <div class="row ">
                            <div class="col-lg-12 col-md-6 col-sm-6">
                                <div class="banner-img">
                                    <img src="<?=  $contest['CONTEST_BANNER']; ?>" alt="">
                                </div>
                            </div>
                            <hr/>
                            <div class="col-lg-12 col-md-6 col-sm-6 col-xs-6 pl-3 pt-4">
                        
                            <div class="card-content">
                                <h5 class="font-15 center"><?=  $contest['CONTEST_NAME'];   ?></h5>
                                 <p class="font-15 center"><b>From : </b> <?=    $contest['START_DATE']     ?></p>
                                
                                 <p class="font-15 center"><b>To : </b> <?=    $contest['END_DATE']     ?></p>

                                  <p class="font-15 center"><b>Entry Charge : </b> <?=    $contest['CONTEST_POINTS']." Points"     ?></p>
 
                                <?php
                                    if(isset($active_contest) && $contest['C_ID'] == $active_contest['C_ID']){
                                ?>
                               
                                <div class="badge badge-pill badge-success mb-1 float-left">ACTIVE</div>
                                <?php
                                    }
                                ?>
                                
                                <a href="<?= base_url().ADMIN.'/participant/contestparticipant?contest-id='.$contest['C_ID'] ?>" class='view-participant float-right'>View Participant</a>
                               
                            </div>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php   } ?>
    </div>
</section>