<?= $this->include('partials/header') ?>

<body class="hold-transition register-page">
  <div class="register-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        <a href="register" class="h1"><b><?= $short_name ?></b> </a>
      </div>
      <div class="card-body">


        <?php if (!empty($message) && isset($message)) : ?>
          <?php echo $message; ?>
        <?php else : ?>
          <?php echo '<p class="login-box-msg"> New users registration </p>'; ?>
        <?php endif; ?>

        <form action="register" method="post">
          <?= csrf_field() ?>
          <div class="input-group mb-3">
            <input type="text" name="firstname" value="<?= set_value('firstname') ?>" size="12" class="form-control" placeholder="First name" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-user"></span>
              </div>
            </div>
            <div class="input-group">
              <span class="text-danger"><?= isset($validation) ? $validation->getError('firstname') : '' ?></span>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="lastname" value="<?= set_value('lastname') ?>" size="12" class="form-control" placeholder="Last name" autocomplete="off">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fa fa-user"></span>
              </div>
            </div>
            <div class="input-group">
              <span class="text-danger"><?= isset($validation) ? $validation->getError('lastname') : '' ?></span>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="email" value="<?= set_value('email') ?>" size="50" class="form-control" placeholder="Email" autocomplete="off">
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
            <input type="password" name="retypepassword" value="<?= set_value('retypepassword') ?>" size="12" class="form-control" placeholder="Retype password" autocomplete="off">
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
            <div class="col-8">
              <div class="icheck-primary">
                <input type="checkbox" id="agreeTerms" name="terms" value="agree">
                <label for="agreeTerms">
                  I agree to the <a href="#">terms</a>
                </label>
              </div>
            </div>
            <!-- /.col -->
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
            </div>
            <!-- /.col -->
          </div>
        </form>

        <div class="social-auth-links text-center">
          <a href="#" class="btn btn-block btn-primary">
            <i class="fa fa-facebook mr-2"></i>
            Sign up using Facebook
          </a>
          <a href="#" class="btn btn-block btn-danger">
            <i class="fa fa-google-plus mr-2"></i>
            Sign up using Google+
          </a>
        </div>

        <a href="login" class="text-center">I already have a membership</a>
      </div>
      <!-- /.form-box -->
    </div><!-- /.card -->
  </div>
  <!-- /.register-box -->


  <?= $this->include('partials/loginfooter') ?>