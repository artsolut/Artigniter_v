<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }?>

<?php $this->load->view('componentes/header', $nestedview) ?>

<div class="container">
	<div class="row wrap_login">
		<div class="col-md-6 text-right">
			<h1>Restablecer contraseña</h1>
		</div>
		<div class="col-md-6">
			<?php echo form_open('login/reset_password', array('id' => 'reset_password')); ?>
				<?php echo form_input(array(
					'id' => 'email',
					'name' => 'email',
					'class' => 'inputform',
					'placeholder' => 'Email'
				)); ?>
				<!-- <?php echo form_password(array(
					'id' => 'password',
					'name' => 'password',
					'class' => 'inputform',
					'placeholder' => 'Nuevo Password'
				)); ?>
				<?php echo form_password(array(
					'id' => 're-password',
					'name' => 're-password',
					'class' => 'inputform',
					'placeholder' => 'Repite Password'
				)); ?> -->

				<?php echo form_submit('submit', 'Enviar', 'class="buttonform"') ?>
			<?php echo form_close(); ?>

			<?php $errors = validation_errors(); ?>
			<?php if ( $errors != '' ): ?>
				<div class="error_login">
					<img src="<?php echo base_url()?>public/images/icon_alert.png" width="45" height="45" />
					<?php echo $errors ?>
				</div>
			<?php endif; ?>

		</div>
	</div>
</div>
<?php $this->load->view('componentes/footer'); ?>