<?= $this->include('partials/header') ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="recoverpassword" class="h1"><?= $short_name ?></a>
      </div>
      <div class="card-body">


        <?php if (!empty($message) && isset($message)) : ?>
          <?php echo '<p class="alert alert-success alert-dismissible"><i class="icon fa fa-check"></i>'; ?>
          <?php echo $message.'</p>'; ?>
        <?php else : ?>
          <?php echo '<p class="login-box-msg"> New password </p>'; ?>
        <?php endif; ?>



        <form action="recoverpassword" method="post">
        <?php // csrf_field() ?>
          <div class="input-group mb-3">
            <input type="password" name="password" value="<?= set_value('password') ?>" size="12" class="form-control" placeholder="Password" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-lock"></span>
              </div>
            </div>
            <div class="input-group">
              <span class="text-danger"><?= isset($validation) ? $validation->getError('password') : '' ?></span>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" name="retypepassword" value="<?= set_value('retypepassword') ?>" size="12" class="form-control" placeholder="Retype password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-lock"></span>
              </div>
            </div>
            <div class="input-group">
              <span class="text-danger"><?= isset($validation) ? $validation->getError('retypepassword') : '' ?></span>
            </div>
          </div>
          <div class="row">
            <div class="col-12">
              <button type="submit" class="btn btn-primary btn-block">Change password</button>
            </div>
            <!-- /.col  retypepassword -->
          </div>
        </form>
        <div class="row">
          <div class="col-sm-6">
            <p class="mt-3 mb-1">
              <a href="forgotpassword">Back</a>
            </p>
          </div>
          <div class="col-sm-6">
            <p class="mt-3 mb-1 float-sm-right">
              <a href="login">login</a>
            </p>
          </div>
        </div>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->


  <?= $this->include('partials/loginfooter') ?>