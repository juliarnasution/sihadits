<div class="row">
    <div class="col-sm-12">
        <div class="card-box table-responsive">
            <h4 class="m-t-0 header-title"><b>Daftar Stopword</h4>
            <table id="datatable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Word</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $i=1;
                        foreach ($data as $datanya) { 
                    ?>
                    <tr>
                        <td><?= $i ?></td>
                        <td><?=$datanya->word?></td>
                    </tr>
                <?php $i++; } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>