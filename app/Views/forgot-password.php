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
                <h4>  <?=   lang('ADMINPANEL.forgotpass.title');  ?></h4>
              </div>
              <div class="card-body">
                <p class="text-muted"><?=   lang('ADMINPANEL.forgotpass.sendmailnotice');  ?></p>
                <form method="POST" id="forgot_form" action="#">
                  <div class="form-group">
                    <label for="email"><?=   lang('ADMINPANEL.forgotpass.email');  ?></label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block btn_forgot_pass" form="forgot_form" tabindex="4">
                      <?=   lang('ADMINPANEL.forgotpass.send_link');  ?>
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
