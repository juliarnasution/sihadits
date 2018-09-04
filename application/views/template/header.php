<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="A fully featured admin theme which can be used to build CRM, CMS, etc.">
        <meta name="author" content="Coderthemes">

        <link rel="shortcut icon" href=" <?php echo base_url('assets/images/favicon_1.ico'); ?>">

        <title>Admin - SIHadits</title>

        <!-- DataTables -->
        <link href="<?= base_url('assets/plugins/datatables/jquery.dataTables.min.css')?>" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url('assets/plugins/datatables/buttons.bootstrap.min.css')?>" rel="stylesheet" type="text/css"/>
        <link href="<?= base_url('assets/plugins/datatables/dataTables.bootstrap.min.css')?>" rel="stylesheet" type="text/css"/>

        <!-- css inti -->
        <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/core.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/components.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/icons.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/pages.css'); ?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo base_url('assets/css/responsive.css'); ?>" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shiv and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->

        <script src=" <?php echo base_url('assets/js/modernizr.min.js'); ?>"></script>


    </head>


    <body class="fixed-left">

        <!-- Begin page -->
        <div id="wrapper">

            <!-- Top Bar Start -->
            <div class="topbar">

                <!-- LOGO -->
                <div class="topbar-left">
                    <div class="text-center">
                        <a href="<?= base_url('home/index')?>" class="logo"><i class="icon-magnet icon-c-logo"></i><span>SIHADITS</span></a>
                        <!-- Image Logo here -->
                        <!--<a href="index.html" class="logo">-->
                            <!--<i class="icon-c-logo"> <img src="assets/images/logo_sm.png" height="42"/> </i>-->
                            <!--<span><img src="assets/images/logo_light.png" height="20"/></span>-->
                        <!--</a>-->
                    </div>
                </div>

                <!-- Button mobile view to collapse sidebar menu -->
                <div class="navbar navbar-default" role="navigation">
                    <div class="container">
                        <div class="">
                          <!-- button navigasi yang tiga bar -->
                            <div class="pull-left">
                                <button class="button-menu-mobile open-left waves-effect waves-light">
                                    <i class="md md-menu"></i>
                                </button>
                                <span class="clearfix"></span>
                            </div>

                            <ul class="nav navbar-nav navbar-right pull-right">
                                <li class="dropdown top-menu-item-xs">
                                    <a href="" class="dropdown-toggle profile waves-effect waves-light" data-toggle="dropdown" aria-expanded="true"><i class="ti-user m-r-10 text-custom"></i><?= ucfirst($this->session->userdata('nama')); ?></a>
                                    <ul class="dropdown-menu">
                                        <li><a href="<?= base_url('user/profil') ?>"><i class="ti-user m-r-10 text-custom"></i> Ganti Username</a></li>
                                        <li><a href="<?= base_url('user/password') ?>"><i class="ti-settings m-r-10 text-custom"></i> Ganti Passowrd</a></li>
                                        <li class="divider"></li>
                                        <li><a href="<?= base_url('admin/logout'); ?>"><i class="ti-power-off m-r-10 text-danger"></i> Logout</a></li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                        <!--/.nav-collapse -->
                    </div>
                </div>
            </div>
            <!-- Top Bar End -->


            <!-- ========== Left Sidebar Start ========== -->

            <div class="left side-menu">
                <div class="sidebar-inner slimscrollleft">
                    <!--- Divider -->
                    <div id="sidebar-menu">
                        <ul>

                            <!-- <li class="text-muted menu-title">Navigasi</li> -->

                            <li class="has_sub">
                                <a href="<?php echo base_url('home/index') ?>" class="waves-effect"><i class="ti-home"></i> <span> Dashboard </span></a>
                                
                            </li>

                            <li class="has_sub">
                                <a href="<?php echo base_url('bukhari/index') ?>" class="waves-effect"><i class="ti-book"></i> <span> Shahih Bukhari </span></span> </a>
                                <!-- <ul class="list-unstyled">
                                    <li><a href="#">Hadits</a></li>
                                    <li><a href="ui-loading-buttons.html">Loading Buttons</a></li>
                                </ul> -->
                            </li>

                            <li class="has_sub">
                                <a href="<?php echo base_url('muslim/index') ?>" class="waves-effect"><i class="ti-book"></i><span> Shahih Muslim </span> </a>
                                <!-- <ul class="list-unstyled">
                                    <li><a href="components-grid.html">Grid</a></li>
                                    <li><a href="components-widgets.html">Widgets</a></li>
                                    <li><a href="components-nestable-list.html">Nesteble</a></li>
                                    <li><a href="components-range-sliders.html">Range sliders</a></li>
                                </ul> -->
                            </li>

                            <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-user"></i> <span> Biografi Singkat </span> <span class="menu-arrow"></span> </a>
                                <ul class="list-unstyled">
                                    <li><a href="<?=base_url('bukhari/profil')?>">Imam Bukhari</a></li>
                                    <li><a href="<?=base_url('muslim/profil')?>">Imam Muslim</a></li>
                                </ul>
                            </li>

                             <li class="has_sub">
                                <a href="javascript:void(0);" class="waves-effect"><i class="ti-menu-alt"></i><span>Data </span> <span class="menu-arrow"></span></a>
                                <ul class="list-unstyled">
                                    <li><a href="<?=base_url('user/index')?>">User</a></li>
                                    <li><a href="<?=base_url('data/stemming_view')?>">Data Stemming</a></li>
                                    <li><a href="<?=base_url('data/stopword')?>">Data Stopword</a></li>
                                    <li><a href="<?=base_url('data/generate_term')?>">Generate Term</a></li>
                                    <li><a href="<?=base_url('data/generate_tf')?>">Generate Term Frekuensi (TF)</a></li>

                                    <!-- <li><a href="tables-editable.html">Editable Table</a></li> -->
                                </ul>
                            </li>

                        </ul>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
            <!-- Left Sidebar End -->



            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="content-page">
                <!-- Start content -->
                <div class="content">
                    <div class="container">