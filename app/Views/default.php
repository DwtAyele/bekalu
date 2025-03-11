<?= $this->include('partials/header') ?>

<body class="hold-transition sidebar-mini layout-fixed">
  <!-- Site wrapper -->
  <div class="wrapper">
    <?= $this->include('partials/navbar') ?>
    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href=<?= base_url('home') ?> class="brand-link">
        <img src="<?php base_url('public/asset/img/AdminLTELogo3.4.png') ?>" alt="" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light"><?= $breand_text ?></span>
      </a>

      <!-- Sidebar -->

      <?= $this->include('partials/sidebar') ?>



      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->



      <?= $this->renderSection('content') ?>





    </div>
    <!-- /.content-wrapper -->


    <?= $this->include('partials/footer') ?>