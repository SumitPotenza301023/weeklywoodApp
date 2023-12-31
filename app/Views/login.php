<?php
$view = array('title' => "Login");
?>
<?= view('_partials/head',$view); ?>
<body>
  <div class="loader"></div>
  <div id="app">
    <section class="section login">
      <div class="container mt-5">
        <div class="row">
          <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-6 offset-xl-6" style="margin-left:25%"> 
            <div class="card card-primary">
              <div class="card-header">
                <img  src='<?= base_url().IMGPATH.'/logo.png'; ?>' />
              </div>
              
              <div class="card-body">
                  <h4><?=   lang('ADMINPANEL.login.name');  ?></h4>
                <form method="POST"  id="login_form" class="needs-validation" novalidate="">
                  <div class="form-group">
                    <label for="email"><?=   lang('ADMINPANEL.login.fields.username');  ?></label>
                    <input id="email" type="text" class="form-control" name="email" tabindex="1" required autofocus>
                    <div class="invalid-feedback">
                      Please fill in your email / password
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="d-block">
                      <label for="password" class="control-label"><?=   lang('ADMINPANEL.login.fields.password');  ?></label>
                      <div class="float-right">
                        <a href="<?= base_url("/login/forgot-password")?>" class="text-small">
                          <?=   lang('ADMINPANEL.login.forgotpass');  ?>
                        </a>
                      </div>
                    </div>
                    <input id="password" type="password" class="form-control" name="password" tabindex="2" required>
                    <div class="invalid-feedback">
                      please fill in your password
                    </div>
                  </div>
                  <div class="form-group">
                    <button type="submit" class="btn btn-primary btn-lg btn-block" tabindex="4">
                      <?=   lang('ADMINPANEL.login.loginbtn');  ?>
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


<!-- auth-login.html  21 Nov 2019 03:49:32 GMT -->
</html>