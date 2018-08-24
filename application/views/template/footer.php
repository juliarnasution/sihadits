




                    </div> <!-- container -->

                </div> <!-- content -->

                <footer class="footer text-right">
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

        <!-- jQuery inti -->
        <script src=" <?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/detect.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/fastclick.js'); ?>"></script>

        <script src=" <?php echo base_url('assets/js/jquery.slimscroll.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/jquery.blockUI.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/waves.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/wow.min.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/jquery.nicescroll.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/jquery.scrollTo.min.js'); ?>"></script>
        <!-- batas js inti -->

        <!-- batas atas datatables -->
        <script src="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.js')?>"></script>
        <script src="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.js')?>"></script>

        <script src="<?= base_url('assets/plugins/datatables/dataTables.buttons.min.js')?>"></script>
        <script src="<?= base_url('assets/plugins/datatables/buttons.bootstrap.min.js')?>"></script>
        <script src="<?= base_url('assets/plugins/datatables/buttons.html5.min.js')?>"></script>        
        <script src="<?= base_url('assets/pages/datatables.init.js')?>"></script>
        <!-- batas bawah datatables -->

        <!-- jquery, pokoknya paling bawah di panggil -->

        <script src=" <?php echo base_url('assets/js/jquery.core.js'); ?>"></script>
        <script src=" <?php echo base_url('assets/js/jquery.app.js'); ?>"></script>

        <!-- js form validation -->
        <script type="text/javascript" src=" <?php echo base_url('assets/plugins/parsleyjs/parsley.min.js'); ?>"></script>

        <!-- js form validation -->
        <script type="text/javascript">
            $(document).ready(function() {
                $('form').parsley();
            });
        </script>

        <!-- js datatable -->
        <script type="text/javascript">
            $(document).ready(function () {
                $('#datatable').dataTable();
            });
        </script>

        <!-- untuk modal hapus -->
        <script type="text/javascript">
            $('#confirm-delete').on('show.bs.modal', function(e) {
                $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
            });
        </script>

        <script src="<?=base_url('assets/plugins/tinymce/tinymce.min.js')?>"></script>
        
        <script type="text/javascript">
            $(document).ready(function () {
                if($("#elm1").length > 0){
                    tinymce.init({
                        selector: "textarea#elm1",
                        theme: "modern",
                        height:300,
                        plugins: [
                            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                            "save table contextmenu directionality emoticons template paste textcolor"
                        ],
                        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons", 
                        style_formats: [
                            {title: 'Bold text', inline: 'b'},
                            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
                            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
                            {title: 'Example 1', inline: 'span', classes: 'example1'},
                            {title: 'Example 2', inline: 'span', classes: 'example2'},
                            {title: 'Table styles'},
                            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
                        ]
                    });    
                }  
            });
        </script>

    </body>
</html>