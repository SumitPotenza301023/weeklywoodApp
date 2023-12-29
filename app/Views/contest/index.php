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
                    <button type="button" class="btn btn-primary" id="btnaddclub" data-toggle="modal" data-target=".bd-create-contest-modal-lg">
                        <?= lang('contest.contest_text.add_contest');  ?>
                    </button>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4> <?= lang('contest.contest_text.data_table.contest_list');  ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="contestdatatable">
                                <thead>
                                    <tr>
                                        <th class="text-center">
                                            <?= lang('contest.contest_text.data_table.sr_no');  ?>
                                        </th>
                                        <th> <?= lang('contest.contest_text.contest_name');  ?></th>
                                        <th><?= lang('contest.contest_text.start_date_week');  ?></th>
                                        <th><?= lang('contest.contest_text.end_date');  ?></th>
                                        <th><?= lang('contest.contest_text.contest_points');  ?><i></th>
                                        <th><?= lang('contest.contest_text.scoretype');  ?><i></th>
                                        <th><?= lang('contest.contest_text.data_table.official');  ?><i></th>
                                        <th><?= lang('contest.contest_text.data_table.action');  ?></th>
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
<div class="modal fade bd-create-contest-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?= lang('contest.contest_text.add_contest');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <div class="alert-title">Note</div>
                    Please select a date in which contest is not scheduled.
                </div>
                <form class="add_contest" id="add_contest" method="POST">
                    <div class="form-row">
                        <div class="file-upload form-group col-12">
                            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><?= lang('contest.contest_text.banner');  ?> </button>

                            <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' name='filebanner' onchange="readURL(this);" accept="image/*" />
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
                            <label for="inputcity"><?= lang('contest.contest_text.contest_name');  ?></label>
                            <input type="text" class="form-control" name="contest_name" id="contest_name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="contest-description"><?= lang('contest.contest_text.contest_description');  ?></label>
                            <textarea class="form-control" id="contest-description" name="contest_description"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputpoints"><?= lang('contest.contest_text.contest_pdf_title');  ?></label>
                            <input type="text" class="form-control" name="contest_pdf_title" id="inputpdftitle" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputpdf"><?= lang('contest.contest_text.contest_pdf');  ?></label>
                            <input type="file" class="form-control" name="contestpdf" accept="application/pdf" id="inputpdf" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputpoints"><?= lang('contest.contest_text.contest_points');  ?></label>
                            <input type="number" class="form-control" name="contest_points" id="inputpoints" min="1" required />
                        </div>
                        <div class="form-group col-md-6">
                            <label for="score_type"><?= lang('contest.contest_text.score_type');  ?></label>
                            <select class="form-control" name="score_type" id="score_type" required>
                                <?php if (isset($score_type)) {
                                    foreach ($score_type as $score) {
                                ?>
                                        <option value='<?= $score['ST_ID'] ?>'><?= $score['NAME'] ?></option>
                                <?php
                                    }
                                } ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="form-group col-md-6">
                            <label for="start_date"><?= lang('contest.contest_text.start_time');  ?></label>

                            <input type="text" class="form-control datetimepicker" name="start_date" required>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date"><?= lang('contest.contest_text.end_time');  ?></label>

                            <input type="text" class="form-control datetimepicker" name="end_date" required>

                        </div>

                    </div>


                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="videourl"><?= lang('contest.contest_text.videourl');  ?></label>
                            <input class="form-control" name="videourl" type='url' id="videourl" required />
                        </div>
                    </div>



                    <button type="submit" role="button" form="add_contest" id="btnaddcontest" class="btn btn-primary btn-lg btn-block">
                        <?= lang('contest.contest_text.add_contest_btn');  ?>
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- End model create contest -->
<!-- Model edit Contest -->
<div class="modal fade bd-edit-contest-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myLargeModalLabel"> <?= lang('contest.contest_text.banner');  ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <div class="alert-title">Note</div>
                    Please select a date in which contest is not scheduled.
                </div>
                <form class="edit_contest" id="edit_contest" method="POST">
                    <div class="form-row">
                        <input type="hidden" name="contest_id" />
                        <div class="file-upload form-group col-12">
                            <button class="file-upload-btn" type="button" onclick="$('.file-upload-input').trigger( 'click' )"><?= lang('contest.contest_text.banner');  ?> </button>

                            <div class="image-upload-wrap">
                                <input class="file-upload-input" type='file' name='filebanner' onchange="readURL(this);" accept="image/*" />
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
                            <label for="inputcity"><?= lang('contest.contest_text.contest_name');  ?></label>
                            <input type="text" class="form-control" name="contest_name" id="contest_name" required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label for="contest-description"><?= lang('contest.contest_text.contest_description');  ?></label>
                            <textarea class="form-control" id="contest-description" name="contest_description" required></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputpoints"><?= lang('contest.contest_text.contest_pdf_title');  ?></label>
                            <input type="text" class="form-control" name="contest_pdf_title" id="inputpdftitle" />
                        </div>

                        <div class="form-group col-md-6">
                            <label for="inputpdf"><?= lang('contest.contest_text.contest_pdf');  ?></label> :
                            <a class="contestpdflink" href="#">Click Here To View</a>
                            <input type="file" class="form-control" name="contestpdf" accept="application/pdf" id="inputpdf" />
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="inputpoints"><?= lang('contest.contest_text.contest_points');  ?></label>
                            <input type="number" class="form-control" name="contest_points" id="inputpoints" min="1" required />
                        </div>
                        <!-- <div class="form-group col-md-4">
                            <label for="inputpdf"><?= lang('contest.contest_text.contest_pdf');  ?></label> :
                            <a class="contestpdflink" href="#">Click Here To View</a>
                            <input type="file" class="form-control" name="contestpdf" accept="application/pdf" id="inputpdf" />
                        </div> -->
                        <div class="form-group col-md-6">
                            <label for="score_type"><?= lang('contest.contest_text.score_type');  ?></label>
                            <select class="form-control" name="score_type" id="score_type" required>
                                <?php if (isset($score_type)) {
                                    foreach ($score_type as $score) {
                                ?>
                                        <option value='<?= $score['ST_ID'] ?>'><?= $score['NAME'] ?></option>
                                <?php
                                    }
                                } ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-6">
                            <label for="start_date"><?= lang('contest.contest_text.start_time');  ?></label>

                            <input type="text" class="form-control datetimepicker" name="start_date" required>

                        </div>
                        <div class="form-group col-md-6">
                            <label for="end_date"><?= lang('contest.contest_text.end_time');  ?></label>

                            <input type="text" class="form-control datetimepicker" name="end_date" required>

                        </div>


                    </div>
                    <div class="form-row">

                        <div class="form-group col-md-12">
                            <label for="videourl"><?= lang('contest.contest_text.videourl');  ?></label>
                            <input class="form-control" name="videourl" type='url' id="videourl" required />
                        </div>

                    </div>

                    <button type="submit" role="button" form="edit_contest" id="btneditcontest" class="btn btn-primary btn-lg btn-block">
                        <?= lang('contest.contest_text.edit_contest_btn');  ?>
                    </button>

                </form>
            </div>
        </div>
    </div>
</div>
<!-- End model edit contest -->