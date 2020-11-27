<footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>2020 All Rights Reserved FCI. Developed BY Mego</strong>
  </footer>

  <!-- Control Sidebar -->

  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->


<script type="text/javascript">

  var baseURI = window.location.origin;

  if (baseURI == 'http://167.172.208.67') {
    baseURI += '/lara-walema/public/';
    chatURL = 'http://167.172.208.67:3000';
  }else {
    baseURI += '/';
    chatURL = 'http://127.0.0.1:3000';
  }

</script>


<!-- jQuery 3 -->
<script src="{{ url('/') }}/admin_design/bower_components/jquery/dist/jquery.min.js"></script>
<script src="{{ url('/') }}/admin_design/bower_components/jquery-ui/jquery-ui.min.js"></script>

<script src="{{ url('/') }}/admin_design/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="{{ url('/') }}/admin_design/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="{{ url('/') }}/admin_design/bower_components/datatables.net-bs/js/dataTables.buttons.min.js"></script>
<script src="{{ url('/') }}/vendor/datatables/buttons.server-side.js"></script>

<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ url('/') }}/admin_design/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="{{ url('/') }}/admin_design/bower_components/raphael/raphael.min.js"></script>
<script src="{{ url('/') }}/admin_design/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="{{ url('/') }}/admin_design/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{{ url('/') }}/admin_design/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{ url('/') }}/admin_design/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{ url('/') }}/admin_design/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{ url('/') }}/admin_design/bower_components/moment/min/moment.min.js"></script>
<script src="{{ url('/') }}/admin_design/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="{{ url('/') }}/admin_design/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{ url('/') }}/admin_design/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="{{ url('/') }}/admin_design/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{ url('/') }}/admin_design/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{ url('/') }}/admin_design/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{ url('/') }}/admin_design/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ url('/') }}/admin_design/dist/js/demo.js"></script>

<script src="{{ url('/') }}/admin_design/dist/js/functions.js"></script>

<script src="{{ url('/') }}/admin_design/plugins/loading/jquery-loader.js"></script>

<script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyBwxuW2cdXbL38w9dcPOXfGLmi1J7AVVB8'></script>

@stack('js')


<script>

</script>

</body>
</html>
