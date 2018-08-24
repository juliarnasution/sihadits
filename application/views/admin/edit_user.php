<?= $this->session->flashdata('notif'); ?>
<div class="col-md-12">
	<div class="col-md-6">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b>Edit User</b></h4>
			<br>
			<form action="<?= base_url('user/prosesedit_user/'.$data->id) ?>" data-parsley-validate novalidate method="post">
				<div class="form-group">
					<label for="nama">Nama</label>
					<input type="text" name="nama" parsley-trigger="change" value="<?= $data->nama ?>" required placeholder="Nama" class="form-control">
				</div>
				<div class="form-group">
					<label for="username">Username</label>
					<input type="email" name="username" parsley-trigger="change" value="<?= $data->username ?>" required placeholder="Enter email" class="form-control">
				</div>
				<div class="form-group">
					<label for="password">Password*</label>
					<input id="pass1" type="password" name="password" placeholder="Password" required class="form-control">
				</div>
				<div class="form-group">
					<label for="konfirmasi-passWord">Konfirmasi Password</label>
					<input data-parsley-equalto="#pass1" type="password" required placeholder="Konfirmasi Password" class="form-control">
				</div>
				<div class="form-group text-right m-b-0">
					<button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
					<a type="button" href="<?= base_url('user/user')?>" class="btn btn-default waves-effect waves-light m-l-5">Kembali</a>
				</div>
				
			</form>
		</div>
	</div>
</div>