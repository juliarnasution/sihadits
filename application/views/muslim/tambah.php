
<?= $this->session->flashdata('notif'); ?>
<div class="col-md-12">
	<div class="col-md-10">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b>Tambah Hadits Muslim</b></h4>
			<br>
			<form action="<?= base_url('muslim/tambah_hadits') ?>" data-parsley-validate novalidate method="post">
				<div class="form-group">
					<label for="nama">Nomor Hadits*</label>
					<input name="nomor" type="number" class="form-control" placeholder="Nomor Hadits" required="">
				</div>
				<div class="form-group">
					<label for="username">Kitab Hadits</label>
					<input name="kitab" type="text"  class="form-control" placeholder="Kitab Hadits">
				</div>
				<div class="form-group">
					<label for="Arab">Arab</label>
					<textarea name="arab" class="form-control" placeholder="Hadits dalam bahasa Arab"></textarea>
				</div>
				<div class="form-group">
					<label for="konfirmasi-passWord">Terjemahan*</label>
					<textarea name="terjemahan" class="form-control" placeholder="Terjemahan Hadits" required=""></textarea>
				</div>
				<div class="form-group text-right m-b-0">
					<button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
					<a type="button" href="<?= base_url('muslim/index')?>" class="btn btn-default waves-effect waves-light m-l-5">Kembali</a>
				</div>
				
			</form>
		</div>
	</div>
</div>