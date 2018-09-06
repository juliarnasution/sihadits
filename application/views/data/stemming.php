<?= $this->session->flashdata('notif'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="btn-toolbar" style="margin-bottom: 10px">
                <h4 class="m-t-0 header-title"><b>Data Stemming</b></h4>
                <a type="button" data-toggle="modal" data-target="#myModal" class="btn btn-primary pull-right"> Tambah</a>
            </div>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kata Dasar</th>
                        <th>Tipe Kata Dasar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=1;
                        foreach ($data as $datanya) { 
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?=$datanya->katadasar?></td>
                        <td><?=$datanya->tipe_katadasar?></td>
                        <td>
                            <a data-href="<?= base_url('data/hapus_stemming/'.$datanya->id_stemming)?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#confirm-delete"> Hapus</a>
                        </td>
                        <!-- <td><a href="<?php //base_url('data/hapusstemming/'.$datanya->id_stemming); ?>" class="btn btn-danger btn-xs">Hapus</a></td> -->
                    </tr>
                <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- modal tambah data -->
 <div id="myModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Tambah Stemming</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url('data/tambah_stemming') ?>" method="post" data-toggle="validator">
            <div class="form-group">
                <label>Kata Dasar</label>
                <input name="kata" type="text" class="form-control" placeholder="Kata Dasar" required="">
            </div>
            <div class="form-group">
                <label>Tipe Kata Dasar</label>
                <input name="tipe" type="text" class="form-control" placeholder="Tipe Kata Dasar" required="">
            </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
            <button type="submit" name="simpan" class="btn btn-primary" value="simpan">Simpan</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- modal hapus data -->
<div class="modal fade" id="confirm-delete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Konfirmasi Hapus</h4>
            </div>
            <div class="modal-body">
                <h2>Anda akan menghapus data.</h2>
                <h3>Yakin ingin melanjutkan ?</h3>
                <p class="debug-url"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Batal</button>
                <a class="btn btn-danger btn-ok">Hapus</a>
            </div>
        </div>
    </div>
</div>