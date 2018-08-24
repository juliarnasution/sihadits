
                     
                </div> <!-- content -->

                <footer class="footer">
                    © 2016. All rights reserved.
                </footer>

            </div>
            <!-- ============================================================== -->
            <!-- End Right content here -->
            <!-- ============================================================== -->

        </div>
        <!-- END wrapper -->

        <script>
            var resizefunc = [];
        </script>

        <!-- jQuery  -->
        <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/detect.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/fastclick.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.slimscroll.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.blockUI.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/waves.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/wow.min.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.nicescroll.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.scrollTo.min.js'); ?>"></script>


        <script src="<?php echo base_url('assets/js/jquery.core.js'); ?>"></script>
        <script src="<?php echo base_url('assets/js/jquery.app.js'); ?>"></script>
        <script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
        <script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.js')?>"></script>

        <script src="<?= base_url('assets/plugins/datatables/dataTables.buttons.min.js')?>"></script>
        <script src="<?= base_url('assets/plugins/datatables/buttons.bootstrap.min.js')?>"></script>
        <script src="<?= base_url('assets/plugins/datatables/buttons.html5.min.js')?>"></script>        
        <script src="<?= base_url('assets/pages/datatables.init.js')?>"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                $('#datatable').dataTable();
            });
        </script>
       <!--  <script type="text/javascript">
          $("#cari").on('click',function () {
            var hadits  = 
            var query   = $("#query").val();
            console.log("datanya ="+query);
              $.ajax({
                type:"POST",
                url:base_url('beranda/prosesdata'),
                data : "query="+query
              }).done(function (data) {
                $('#lihatdata').html(data);
              });
          });
          </script> -->
    
    </body>
</html>