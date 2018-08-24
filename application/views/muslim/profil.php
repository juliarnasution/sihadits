<?= $this->session->flashdata('notif'); ?>
<div class="row">
    <div class="col-xs-12">
        <div class="card-box product-detail-box">
            <div class="row">
                <div class="text-center">
                    <div class="pull-right">
                      <?php if ($this->uri->segment(1)!='beranda'): ?>
                          <a href="<?= base_url('muslim/editprofil') ?>" class="btn btn-default">Edit</a>
                      <?php endif ?>
                    </div>
                    <!-- <div class="product-right-info"> -->
                       <h3><b>Biografi Imam Muslim</b></h3>
                       <hr/>
                       <div style="text-align: justify;">
                          <p class="text-muted"><?php if (empty($data->biografi)) {
                            echo "kosong";
                          }else{
                            echo $data->biografi;
                          }
                          ?>.</p>
                       </div>
                    <!-- </div> -->
                </div>
            </div>
        </div>
    </div>
</div>
