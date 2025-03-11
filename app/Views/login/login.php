<?= $this->include('partials/header') ?>

<body class="hold-transition login-page">
  <div class="login-box">
    <!-- /.login-logo -->
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="login" class="h1"><?= $short_name ?></a>
      </div>
      <div class="card-body">


        <?php if (!empty($message) && isset($message)) : ?>
          <?php echo '<p class="alert alert-danger alert-dismissible"><i class="icon fa fa-ban"></i>' . $message . '</p>'; ?>

        <?php else : ?>
          <?php echo '<p class="login-box-msg">' . $login_box_msg . '</p>'; ?>
        <?php endif; ?>


        <form action="login" method="post">
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
          <div class="input-group mb-3">
            <input type="password" name="password" value="<?= set_value('password') ?>" size="12" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-lock"></span>
              </div>
            </div>
            <div class="input-group">
              <span class="text-danger"> <?= isset($validation) ? $validation->getError('password') : '' ?></span>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="remember">
                <label for="remember">
                  Remember Me
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center mt-2 mb-3">
          <a href="#" class="btn btn-block btn-primary">
            <i class="fa fa-facebook mr-2"></i> Sign in using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fa fa-google-plus mr-2"></i> Sign in using Google+
          </a>
        </div>
        <!-- /.social-auth-links -->

        <p class="mb-1">
          <a href="forgotpassword">I forgot my password</a>
        </p>
        <p class="mb-0">
          <a href="register" class="text-center">Register a new membership</a>
        </p>
      </div>
      <!-- /.card-body -->
    </div>
    <!-- /.card -->
  </div>
  <!-- /.login-box -->
  <?= $this->include('partials/loginfooter') ?>