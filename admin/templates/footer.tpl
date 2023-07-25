</body>
<!--   Core JS Files   -->
  <script src="{$domain}/admin/js/jquery.min.js"></script>
  <script src="{$domain}/admin/js/bootstrap-dialog.js"></script>
  <script src="{$domain}/admin/js/global.js"></script>
  <script src="{$domain}/admin/js/main.js"></script>
  <script src="{$domain}/admin/public/js/core/popper.min.js"></script>
  <script src="{$domain}/admin/public/js/core/bootstrap.min.js"></script>
  <script src="{$domain}/admin/public/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="{$domain}/admin/public/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="{$domain}/admin/public/js/plugins/chartjs.min.js"></script>
  <script src="{$domain}/admin/public/js/charts_data.js"></script>
  <script src="{$domain}/admin/js/js_act/{$m}_{$act}.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>


  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="{$domain}/admin/public/js/material-dashboard.min.js?v=3.1.0"></script>
</html>