<?= $this->session->flashdata('notif'); ?>
<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <div class="btn-toolbar" style="margin-bottom: 10px">
                <h4 class="m-t-0 header-title col-sm-4" style="margin-bottom: 0px; padding-top: 7.5px;"><b>Hadits Riwayat Muslim</b></h4>
                <a type="button" href="<?= base_url('muslim/tambah')?>" class="btn btn-primary pull-right"> Tambah</a>
            </div>
            <div class="box-body">
                <table id="datatable" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kitab</th>
                            <th>Terjemahan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            // $i=1;
                            foreach ($data as $datanya) { 
                        ?>
                        <tr>
                            <td><?= $datanya[0] ?></td>
                            <td><?=$datanya[1]?></td>
                            <td><?= $datanya[3]?></td>
                            <?php if ($this->uri->segment(1)!='beranda'): ?>
                                <td>
                                    <a href="<?= base_url('muslim/view/'.$datanya[0]); ?>" class="btn btn-default btn-xs">Lihat</a>
                                    <a href="<?= base_url('muslim/edit/'.$datanya[0]); ?>" class="btn btn-warning btn-xs">Edit</a>
                                    <a data-href="<?= base_url('muslim/hapus_hadits/'.$datanya[0])?>" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#confirm-delete"> Hapus</a>
                                </td>
                            <?php else: ?>
                                <td><a href="<?= base_url('beranda/muslimview/'.$datanya[0]); ?>" class="btn btn-default btn-xs">Lihat</a></td>
                            <?php endif ?>
                        </tr>
                    <?php  } ?>
                    </tbody>
                </table>
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