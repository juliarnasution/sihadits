
<div class="container">
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="<?= base_url('beranda/index') ?>" method="post">
                <div class="input-group">
                    <select class="form-control select2" name="jenis_hadits">
                        <option value="muslim">Muslim</option>
                        <option value="bukhari">Bukhari</option>
                    </select>
                </div>
                <div class="input-group m-t-10">
                    <input type="text"  name="hadits" class="form-control input-lg" placeholder="Cari Hadits...">
                    <span class="input-group-btn">
                    <button type="submit" class="btn waves-effect waves-light btn-default btn-lg"><i class="fa fa-search m-r-5"></i> Cari</button>
                    </span>    
                </div>
            </form>
        </div>
    </div>
    
    <div class="row">
        <div class="col-md-8 col-md-offset-2 text-center m-t-30">
            <h3 class="h4"><b><?php if (!empty($query)) { ?>
                Query pencarian " <?= $query.'"'; } ?> </b></h3>
        </div>
    </div>
    
    
    <div class="row">
        <div class="col-lg-12"> 
            <div class="search-result-box m-t-40">
                <ul class="nav nav-tabs"> </ul> <!--berfungsi untuk memanggil desain css konten hasil pencarian. jangan di hapus-->
                <div class="tab-content" > 
                    <div class="tab-pane active"> 
                        <div class="row">
                            <div class="col-md-12">
                                <?php 
                                // var_dump($data);
                                if (!empty($data) || !is_null($data)) {
                                    $i =1;
                                   foreach ($data as $value) { 
                                        if ($value[0]==0 || $i==10) {
                                            break;
                                        }
                                    ?>
                                        <div class="search-item">
                                            <h3 class="h5 font-600 m-b-5"><a href="#">Hadits Nomor <?=$value[1]?> </a></h3>
                                            <div class="font-13 text-success m-b-10">
                                                Kitab <?=$value[3]?>
                                            </div>
                                            <p>
                                                <?=$value[4]?>
                                            </p>
                                            <p>
                                                <?=$value[2]?>
                                            </p>
                                            <p>
                                                <small> Nilai Dice : <?=$value[0]?></small>
                                            </p>
                                        </div>
                                <?php
                                    $i++;
                                   }
                                }else{
                                ?>
                                    <div class="search-item">
                                        <h2>
                                            Selamat datang, silahkan melakukan pencarian hadits
                                        </h2>
                                    </div>
                                <?php
                                }
                                ?>
                                

                                
                                <!-- <ul class="pagination pagination-split pull-right">
                                    <li class="disabled">
                                        <a href="#"><i class="fa fa-angle-left"></i></a>
                                    </li>
                                    <li>
                                        <a href="#">1</a>
                                    </li>
                                    <li class="active">
                                        <a href="#">2</a>
                                    </li>
                                    <li>
                                        <a href="#">3</a>
                                    </li>
                                    <li>
                                        <a href="#">4</a>
                                    </li>
                                    <li>
                                        <a href="#">5</a>
                                    </li>
                                    <li>
                                        <a href="#"><i class="fa fa-angle-right"></i></a>
                                    </li>
                                </ul> -->
                                
                                <div class="clearfix"></div>
                            </div>
                        </div> 
                    </div> 
                    
                    <!-- end All results tab -->
                </div> 
            </div>
        </div>
    </div>
</div> <!-- container -->
               