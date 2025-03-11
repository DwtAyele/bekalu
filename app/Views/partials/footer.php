<footer class="main-footer">
  <div class="float-right d-none d-sm-block">
    <b>Version</b> <?= esc($etkalversion) ?>
  </div>
  <strong>Copyright &copy; <?= $copyright ?> <a href=<?= base_url('kalat') ?>> <?= $short_name ?> </a>.</strong> All rights reserved.
</footer>


</div>
<!-- ./wrapper -->


<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
<!-- overlayScrollbars -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/overlayscrollbars/1.13.3/js/jquery.overlayScrollbars.min.js"></script>
<!-- AdminLTE App -->
<script src="<?= base_url('public/asset/adminlte/js/adminlte.min.js') ?>"></script>
<?= $this->renderSection('javascript') ?>
</body>

</html>