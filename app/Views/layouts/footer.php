  </main>
  <?php
  if (stripos($title, 'register') || stripos($title, 'login') || stripos($title, 'forgot') || stripos($title, 'reset')) {
    echo "</div>";
?>
    <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>
  <?php } ?>
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
  <!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script> -->
  <script src="<?= base_url() ?>/assets/js/bootstrap.bundle.min.js"></script>
  <script src="<?= base_url() ?>/assets/js/scripts.js"></script>
  <script src="<?= base_url() ?>/assets/js/toastr.min.js"></script>
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js" crossorigin="anonymous"></script> -->
  <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->
  <!-- <script src="assets/demo/chart-area-demo.js"></script>
  <script src="assets/demo/chart-bar-demo.js"></script> -->
  <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script> -->
  <script>
    $(document).ready(function() {

      toastr.options.positionClass = "toast-top-center";
      toastr.options.timeOut = 2000;
      toastr.options.extendedTimeOut = 1000;

      <?php if (session()->getTempdata('success')) : ?>
        toastr.success(<?= "'" . session()->getTempdata('success') . "'"; ?>);
        <?php session()->removeTempdata('success'); ?>
      <?php endif; ?>

      <?php if (session()->getTempdata('error')) : ?>
        toastr.error(<?= "'" . session()->getTempdata('error') . "'"; ?>);
        <?php session()->removeTempdata('error'); ?>
      <?php endif; ?>

      let url = '<?= current_url() ?>';
      if (url.match(/\/dashboard$/)) {
        $(".nav .nav-link:eq(0)").addClass('active');
        $(".nav .nav-link:eq(0) path").attr("fill","rgba(255,255,255,1)");
      } else if (url.match(/\/attendance$/)) {
        $(".nav .nav-link:eq(1)").addClass('active');
        $(".nav .nav-link:eq(1) path").attr("fill","rgba(255,255,255,1)");
      } else if (url.match(/\/timings$/)) {
        $(".nav .nav-link:eq(2)").addClass('active');
        $(".nav .nav-link:eq(2) path").attr("fill","rgba(255,255,255,1)");
      }
    });
  </script>
  </body>

  </html>