<?= $this->include('partials/header') ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="forgotpassword" class="h1"><?= $short_name ?></a>
      </div>
      <div class="card-body">
        <p class="login-box-msg">Enter your Email</p>

        <form action="forgotpassword" method="post">
          <?= csrf_field() ?>
          <div class="input-group mb-3">
            <input type="email" name="email" value="<?= set_value('email') ?>" size="50" class="form-control" placeholder="Email" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-envelope"></span>
              </div>
            </div>
            <div class="input-group">
              <span class="text-danger"><?= isset($validation) ? $validation->getError('email') : '' ?></span>
            </div>
          </div>

          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Request new password</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <p class="mt-3 mb-1">
          <a href="login">Login</a>
        </p>
      </div>
      <!-- /.login-card-body  ? Here you can easily retrieve a new password.-->
    </div>
  </div>
  <!-- /.login-box -->


  <?= $this->include('partials/loginfooter') ?>