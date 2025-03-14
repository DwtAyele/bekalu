<?= $this->include('partials/header') ?>

<body class="hold-transition lockscreen">
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href="../../index2.html"><b>KAL</b> ET</a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name">አበበ ኡርጌሳ</div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="<?php base_url()?>asset/img/user/user1-128x128.jpg" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form class="lockscreen-credentials">
      <div class="input-group">
        <input type="password" class="form-control" placeholder="password">

        <div class="input-group-append">
          <button type="button" class="btn">
            <i class="fa fa-arrow-right text-muted"></i>
          </button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Enter your password to retrieve your session
  </div>
  <div class="text-center">
    <a href="login">Or sign in as a different user</a>
  </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; ፪ሺ፲፭ <b><a href="#" class="text-black">ET - KAL</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->


<?= $this->include('partials/loginfooter') ?>
