<?php
$view = array('title' => "Delete Account");
?>
<?= view('_partials/head', $view); ?>

<body>
    <div class="loader"></div>
    <div id="app">
        <section class="section login">
            <div class="container mt-5">
                <div class="row">
                    <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-6 offset-xl-6" style="margin-left:25%">
                        <div class="card card-primary">
                            <div class="card-header">
                                <img src='<?= base_url() . IMGPATH . '/logo.png'; ?>' />
                            </div>

                            <div class="card-body">
                                <h4><?= lang('ADMINPANEL.deleteAccount.name');  ?></h4>

                                <?php
                                    $session = \Config\Services::session();

                                    if ($session->has('success')) { ?>
                                        <div class="alert alert-success">
                                            <?php echo $session->getFlashdata('success'); ?>
                                        </div>
                                <?php } ?>
                                <form method="POST" id="deleteAccount_form" class="needs-validation" novalidate="">
                                    <div class="form-group">
                                        <label for="email"><?= lang('ADMINPANEL.deleteAccount.fields.username');  ?></label>
                                        <input id="email" type="text" class="form-control" name="email" tabindex="1" required placeholder="Enter Your Email">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="d-block">
                                            <label for="password" class="control-label"><?= lang('ADMINPANEL.deleteAccount.fields.password');  ?></label>
                                        </div>
                                        <input id="password" type="password" class="form-control" name="password" tabindex="2" required placeholder="Enter Your Password">
                                        <div class="invalid-feedback">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <span style="color: #ff6262; font-weight:700;">
                                            Note: Proceeding with account deletion will permanently remove all personal data and deactivate your account, ensuring a complete termination of your profile and associated information. Please note that this action cannot be reverted back.
                                        </span>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary btn-lg btn-block btnDeleteAccount" tabindex="4">
                                            <?= lang('ADMINPANEL.deleteAccount.deletebtn');  ?>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </section>
    </div>
    <?= view('_partials/footer_js'); ?>
</body>

</html>