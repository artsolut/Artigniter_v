<?php if ($this->session->flashdata('flash_messages')) : ?>
	<div class="container">
	<?php $flashMessages = $this->session->flashdata('flash_messages'); ?>
	<?php foreach( $flashMessages as $errorType => $messages ): ?>
		<?php foreach( $messages as $message): ?>
			<div class="alert alert-<?php echo $errorType?> alert-dismissible fade show" role="alert">
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<?php echo $message ?>
			</div>
		<?php endforeach; ?>
	<?php endforeach; ?>	
	</div>
<?php endif; ?>
