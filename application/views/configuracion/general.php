<?php $this->load->view('componentes/header'); ?>

<script type="text/javascript">
	//dialog_support.init("a.modal-dlg");
</script>

<div class="container">
	<div class="row pt-3">
		<ul class="nav nav-tabs" id="myTab" role="tablist">
			<li class="nav-item">
				<a class="nav-link active" id="home-tab" data-toggle="tab" href="#general" role="tab" aria-controls="home" aria-selected="true">Home</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">Profile</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact</a>
			</li>
		</ul>
		<div class="tab-content" id="myTabContent">
			<div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">...</div>
			<div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
			<div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
		</div>
	</div>
</div>

<?php $this->load->view('componentes/footer'); ?>