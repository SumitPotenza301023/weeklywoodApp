        <section class="section">
          <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        
                          <div class="card-content">
                            <h5 class="font-15"><a href="<?= base_url().ADMIN ?>/users">USERS</a></h5>
                            <h2 class="mb-3 font-18"><?php
                              if(isset($usercount)){
                              echo $usercount;
                              }
                            ?></h2>
                          </div>
                          
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                          <div class="banner-img">
                            <img src="<?= base_url().IMGPATH ?>/banner/users.png" alt="">
                          </div>
                        </div>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"><a href="<?= base_url().ADMIN ?>/contests">CONTESTS</a></h5>
                          <h2 class="mb-3 font-18"><?php
                            if(isset($contestcount)){
                             echo $contestcount;
                            }
                          ?></h2>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?= base_url().IMGPATH ?>/banner/contest.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"><a href="<?= base_url().ADMIN ?>/participant">PARTICIPANT</a></h5>
                          <h2 class="mb-3 font-18"><?php
                            if(isset($participantcount)){
                              echo  $participantcount;
                            }
                          ?></h2>
                         
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="<?= base_url().IMGPATH ?>/banner/participant.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
