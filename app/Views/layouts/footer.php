  </main>
  <?php
  if(stripos($title, 'register') || stripos($title, 'login'))
    echo "</div>";
  ?>
  <footer class="py-4 bg-light mt-auto">
    <div class="container-fluid px-4">
      <div class="d-flex align-items-center justify-content-between small">
        <div class="text-muted">Copyright &copy; Shama Education <?= date("Y") ?></div>
        <div>
          <a href="#">Privacy Policy</a>
          &middot;
          <a href="#">Terms &amp; Conditions</a>
        </div>
      </div>
    </div>
  </footer>
  </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
  <script src="<?= base_url() ?>/public/assets/js/scripts.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script>
  <!-- <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script> -->
  <script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" crossorigin="anonymous"></script>
  <!-- <script src="<?= base_url() ?>/public/assets/js/datatables-simple-demo.js"></script> -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
  <script>
    <?php if (session()->getTempdata('success')) : ?>
      toastr.success(<?= "'" . session()->getTempdata('success') . "'"; ?>);
      <?php session()->removeTempdata('success'); ?>
    <?php endif; ?>

    <?php if (session()->getTempdata('error')) : ?>
      toastr.error(<?= "'" . session()->getTempdata('error') . "'"; ?>);
      <?php session()->removeTempdata('error'); ?>
    <?php endif; ?>

    toastr.options.timeOut = 2000;
    toastr.options.extendedTimeOut = 1000;
  </script>
</body>

</html>