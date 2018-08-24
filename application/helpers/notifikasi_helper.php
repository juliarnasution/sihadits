<?php 
if (!defined('BASEPATH')) exit('No direct script access allowed');
	if (! function_exists('notifikasi_helper')) {
		function notifikasi($nilai)
		{
			if ($nilai==TRUE) {
				$notif = 	'<div class="alert alert-success alert-dismissible">
							    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							    <p><i class="icon fa fa-check"></i> Operasi Berhasil!</p>
							</div>';
			}else{
				$notif = 	'<div class="alert alert-danger alert-dismissible">
							    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
							    <p><i class="icon fa fa-ban"></i> Operasi Gagal!</p>
							</div>';
			}
			
			return $notif;
		}
	}

