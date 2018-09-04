<?= $this->session->flashdata('notif'); ?>
<div class="col-md-12">
	<div class="col-md-6">
		<div class="card-box">
			<h4 class="m-t-0 header-title"><b>Generate Term Frekuensi</b></h4>
			<br>
			<form action="<?= base_url('data/proses_generate_tf') ?>" data-parsley-validate novalidate method="post">
				<div class="form-group">
					<label for="nama">Jenis Hadits</label>
					<select name="jenis_hadits" class="form-control">
						<option value="muslim">Hadits Muslim</option>
						<option value="bukhari">Hadits Bukhari</option>
					</select>
				</div>
				<div class="form-group text-right m-b-0">
					<button class="btn btn-primary waves-effect waves-light" type="submit">Simpan</button>
				</div>
				
			</form>
		</div>
	</div>
</div>