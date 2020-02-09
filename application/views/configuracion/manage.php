<?php $this->load->view('componentes/header'); ?>

<script type="text/javascript">
	//dialog_support.init("a.modal-dlg");
</script>

<div class="container">
	<div class="row pt-3">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="general-tab" data-toggle="tab" href="#general" role="tab" aria-controls="general" aria-selected="true">General</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="profile-tab" data-toggle="tab" href="#estatus" role="tab" aria-controls="estatus" aria-selected="false">Estatus</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="contact-tab" data-toggle="tab" href="#areas" role="tab" aria-controls="areas" aria-selected="false">Contact</a>
			</li>
		</ul>

		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="home-tab">...</div>
			<!-- <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
			<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div> -->
		</div>
	</div>
</div>

<?php $this->load->view('componentes/footer'); ?>