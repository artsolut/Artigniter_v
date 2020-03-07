<?php if ($this->session->flashdata('message')) : ?>

	<div class="container">
        
                <div class="alert alert-<?php echo $this->session->flashdata('type');?> alert-dismissible fade show" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <?php echo $this->session->flashdata('message') ?>
                </div>
        
	</div>

<?php  endif; ?>
