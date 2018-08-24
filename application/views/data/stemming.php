<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Hadits Riwayat Bukhari</h4>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kata Dasar</th>
                        <th>Tipe Kata Dasar</th>
                        <!-- <th>Aksi</th> -->
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
                        <!-- <td><a href="<?php //base_url('data/hapusstemming/'.$datanya->id_stemming); ?>" class="btn btn-danger btn-xs">Hapus</a></td> -->
                    </tr>
                <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>