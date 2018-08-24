<?= $this->session->flashdata('notif'); ?>
<div class="col-sm-12">
	<div class="card-box">
		<form  action="<?= base_url('muslim/updateprofil'); ?>" method="post">
			<textarea id="elm1" name="profil">
				<?php
				if (empty($data->biografi)) {
	                echo "";
	            }else{
	                echo $data->biografi;
	             }
				?>
			</textarea>
			<div style="margin-top: 15px;">
				<button type="submit" class="btn btn-default waves-effect waves-light btn-md"> Simpan </button>
			</div>
		</form>
	</div>
</div>