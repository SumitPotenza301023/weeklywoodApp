<section class="section">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                  <div class="card-header">
                    <h4> <?=   lang('participant.list.participant_list');  ?></h4>
                    <div class="card-header-action">
                    <div class="dropdown">
                      <a href="#" data-toggle="dropdown" class="btn btn-warning dropdown-toggle" style='margin-right: 100px;'>ACTION</a>
                      <div class="dropdown-menu">
                        <!-- <a href="#" class="dropdown-item has-icon btnbtnassign" data-toggle="modal" data-target=".bd-assignreviewer-bulk-modal-lg"><i class="far fa-edit"></i> Assign Reviewer</a> -->
                        <a href="#" class="dropdown-item has-icon btnbtnassign" ><i class="far fa-edit"></i> Assign Reviewer</a>

                      </div>
                    </div>
                   
                  </div>
                  </div>
                  <div class="card-body">
                    <div class="table-responsive">
                      <table class="table table-striped" id="participantdatatable">
                        <thead>
                          <tr>
                            <th class="text-center">
                           
                              <div class="custom-checkbox custom-checkbox-table custom-control">
                                <input type="checkbox" data-checkboxes="mygroup" data-checkbox-role="dad"
                                  class="custom-control-input" id="checkbox-all">
                                <label for="checkbox-all" class="custom-control-label">&nbsp;</label>
                              </div>
                     
                            </th>
                            <th> <?=  lang('participant.list.datatable.name');  ?></th>
                            <th><?=   lang('participant.list.datatable.score');  ?></th>
                            <th><?=   lang('participant.list.datatable.video_url');  ?><i></th>
                            <th><?=   lang('participant.list.datatable.reviwer');  ?><i></th>
                            <th><?=   lang('participant.list.datatable.accept_reject');  ?><i></th>
                            <th><?=   lang('participant.list.datatable.action');  ?></th>
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
<!-- Assign Participant -->
<div class="modal fade bd-assignreviewer-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?=   lang('participant.list.assign');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form class="assign-reviewer" id="assign-reviewer" method="POST" >  
                   <input type="hidden" name = 'p_id'/>
                    <div class="form-row">
                         <div class="form-group col-md-12">
                            <label><?=   lang('participant.list.assignpaticipant');  ?></label> : <b><span class="participant_name"></span></b>
            
                        </div>
                    </div>
                     <div class="form-row">
                        
                        <div class="form-group col-md-12">
                            <label for="inputpoints"><?=   lang('participant.list.selectreviewer');  ?></label>
                              <select class="form-control select2" name="reviewer">
                               <option>--Select Reviewer--</option>
                                <?php
                                 if(isset($reviwers)){
                                  foreach($reviwers as $reviwer){
                                    echo "<option value=".$reviwer['ID'].">".$reviwer['FIRST_NAME']."</option>";
                                  }
                                 }
                                ?>
                              </select>
                        </div>
                       
                    </div>
                  
                   
                    <button type="submit" role="button" form="assign-reviewer" id="btnassign" class="btn btn-primary btn-lg btn-block">
                       <?=   lang('participant.list.assign');  ?>
                    </button>
                   
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Assign Participant -->
<!-- Assign Participant bulk -->
<div class="modal fade bd-assignreviewer-bulk-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?=   lang('participant.list.assign');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                 <form class="assign-reviewer-bulk" id="assign-reviewer-bulk" method="POST" >  
                    <div class='participant_id_list '>
                    </div>
                    <div class="form-row">
                         <div class="form-group col-md-12">
                            <label><?=   lang('participant.list.assignpaticipant');  ?></label>
                            <div class='participant_name'>
                            </div> 
                        </div>
                    </div>
                     <div class="form-row">
                        <div class="form-group col-md-4">
                        </div>
                        <div class="form-group col-md-12">
                            <label for="inputpoints"><?=   lang('participant.list.selectreviewer');  ?></label>
                              <select class="form-control select2" name="reviewer">
                               <option>--Select Reviewer--</option>
                                <?php
                                 if(isset($reviwers)){
                                  foreach($reviwers as $reviwer){
                                    echo "<option value=".$reviwer['ID'].">".$reviwer['FIRST_NAME']."</option>";
                                  }
                                 }
                                ?>
                              </select>
                        </div>
                         <div class="form-group col-md-4">
                            
                        </div>
                    </div>
                  
                   
                    <button type="submit" role="button" form="assign-reviewer-bulk" id="btnassignbluk" class="btn btn-primary btn-lg btn-block">
                       <?=   lang('participant.list.assign');  ?>
                    </button>
                   
                </form>
            </div>
        </div>
    </div>
</div>
<!-- Assign Participant -->
<!-- PARTICIPANT DETAILS -->
<div class="modal fade bd-participantdetails-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?=   lang('participant.list.participant_details');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <form class="paricipant_details" id="paricipant_details" method="POST" >  
                  <input type="hidden" name = 'participant_id'/>
                  <div class="form-row">
                        <div class="form-group col-md-12">
                          <label><?=   lang('participant.list.assignpaticipant');  ?></label> 
                          <input type="text"  class="form-control" name="inputname" disabled/>
                        </div>
                  </div>
                    <div class="form-row">
                      <div class="form-group col-md-12">
                        <label><?=   lang('participant.list.participant_video');  ?></label> 
                        <div class="embed-responsive embed-responsive-16by9">
                          <iframe width="100%" height="300px" class='participant_video'
                            src="">
                          </iframe>
                          </div>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-12">
                        <label><?=   lang('participant.list.datatable.score');  ?></label> 
                        <input type="number" class="form-control" name="score"/>
                      </div>
                  </div>
                  <div class="form-row">
                      <div class="form-group col-md-12">
                        <label><?=   lang('participant.list.scoretype');  ?></label> 
                        <input type="text" class="form-control" name="scoretype" disabled/>
                      </div>
                  </div>
                
                  
                  <button type="submit" role="button" form="paricipant_details" id="btnparticipant_details" class="btn btn-primary btn-lg btn-block">
                      <?=   lang('participant.list.edit_participant');  ?>
                  </button>
                  
              </form>
            </div>
        </div>
    </div>
</div>
<!-- PARTICIPANT DETAILS -->
