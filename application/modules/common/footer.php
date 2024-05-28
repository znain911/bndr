            </div>
            <!-- /.container-fluid -->
            <footer class="footer text-center"> <?php echo date('Y');?> &copy; Nationwide Electronic Registry. <span style="float: right;">Version 2</span></footer>
        </div>
        <!-- /#page-wrapper -->
    </div>
    <!-- /#wrapper -->
    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>bootstrap/dist/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
	<script src="<?php echo base_url('assets/'); ?>plugins/bower_components/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
	<!-- Menu Plugin JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js"></script>
    <!--Counter js -->
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/waypoints/lib/jquery.waypoints.js"></script>
    <script src="<?php echo base_url('assets/'); ?>plugins/bower_components/counterup/jquery.counterup.min.js"></script>
    <!--slimscroll JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>js/jquery.slimscroll.js"></script>
    <!-- Custom Theme JavaScript -->
    <script src="<?php echo base_url('assets/'); ?>js/custom.min.js"></script>
    <script src="<?php echo base_url('assets/'); ?>js/dashboard3.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
			$('#dataTable').DataTable();
		});
	</script>
	<script type="text/javascript">
		$('.datepicker').datepicker({
			autoclose: true,
			todayHighlight: true,
			format: 'dd/mm/yyyy',
		});
	</script>
</body>
</html>