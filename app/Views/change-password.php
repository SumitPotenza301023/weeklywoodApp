<?php
$view = array('title' => "Forgot Password");
?>
<?= view('_partials/head',$view); ?>

<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
            <div class="card card-primary">
              <div class="card-header">
                <h4>  <?=   lang('ADMINPANEL.changepassword.title');  ?></h4>
              </div>
              <div class="card-body">
                <form method="POST" id="reset_form" action="#">
                  <div class="form-group">
                    <label for="password"><?=   lang('ADMINPANEL.changepassword.password');  ?></label>
                    <input id="password" type="password" class="form-control" name="password" tabindex="1" required autofocus>
                  </div>
                  <div class="form-group">
                    <label for="confirmpass"><?=   lang('ADMINPANEL.changepassword.confirmPassword');  ?></label>
                    <input id="confirmpass" type="password" class="form-control" name="confirmpassword" tabindex="1" required autofocus>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block btn_reset_pass" form="reset_form" tabindex="4">
                      <?=   lang('ADMINPANEL.changepassword.title');  ?>
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
