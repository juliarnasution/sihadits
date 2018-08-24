<?= $this->session->flashdata('notif'); ?>
<div class="col-md-12">
	<div class="col-md-6">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b>Edit Profil</b></h4>
			<br>
			<form action="<?= base_url('user/update_profil') ?>" data-parsley-validate novalidate method="post">
				<div class="form-group">
					<label for="nama">Nama</label>
					<input type="text" name="nama" parsley-trigger="change" value="<?= $data->nama ?>" required placeholder="Nama" class="form-control">
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="email" name="username" parsley-trigger="change" value="<?= $data->username ?>" required placeholder="Enter email" class="form-control">
				</div>
				<div class="form-group text-right m-b-0">
					<button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
					<a type="button" href="<?= base_url('home/index')?>" class="btn btn-default waves-effect waves-light m-l-5">Kembali</a>
				</div>
				
			</form>
		</div>
	</div>
</div>