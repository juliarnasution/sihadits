<?= $this->session->flashdata('notif'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="btn-toolbar" style="margin-bottom: 10px">
                <h4 class="m-t-0 header-title col-sm-4" style="margin-bottom: 0px; padding-top: 7.5px;"><b>Data User</b></h4>
                <a type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal"> Tambah</a>
            </div>
            <!-- <div class="pull-right"> -->
                
            <!-- </div> -->
            <div class="box-body">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
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
                            <td><?= ucfirst($datanya->nama) ?></td>
                            <td><?= $datanya->username ?></td>
                            <td>                            
                                <a href="<?php echo base_url('user/edit_user/'.$datanya->id) ?>" type="button" class="btn btn-primary btn-xs">Edit</a>
                                <!-- <a href="#" class="confirm-delete btn btn-danger btn-xs" data-id="<?=$datanya->id?>">Hapus</a> -->
                                <a data-href="<?= base_url('user/hapus_user/'.$datanya->id)?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#confirm-delete"> Hapus</a>
                            </td>
                        </tr>
                    <?php $i++; } ?>
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>


<!-- modal tambah data -->
 <div id="myModal" class="modal fade">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          <h4 class="modal-title">Tambah User</h4>
        </div>
        <div class="modal-body">
          <form action="<?php echo base_url('user/tambahuser') ?>" method="post" data-toggle="validator">
            <div class="form-group">
                <label>Nama</label>
                <input name="nama" type="text" class="form-control" placeholder="Nama" required="">
            </div>
            <div class="form-group">
                <label>Username</label>
                <input name="username" type="email" required parsley-type="email" class="form-control" placeholder="Username" required="">
            </div>            
            <div class="form-group">
                <label>Password</label>
                <input name="password" type="password" id="pass1" class="form-control" placeholder="Password" required="">
            </div>
            <div class="form-group">
                <label>Konfirmasi Password</label>
                <input name="kpassword" type="password" data-parsley-equalto="#pass1" class="form-control" placeholder="Konfirmasi Password" required="">
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