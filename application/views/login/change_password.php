<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }?>

<?php $this->load->view('componentes/header', $nestedview); ?>
<div class="container">
	<div class="row wrap_login">
		<div class="col-md-6 text-right">
			<h1>Cambiar contraseña</h1>
		</div>
		<div class="col-md-6">
			<?php echo form_open('login/change_password', array('id' => 'change_password')); ?>
				<?php echo form_password(array(
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
				)); ?>
                <?php echo form_input(array(
					'id' => 'id_socio',
					'name' => 'id_socio',
					'class' => 'inputform',
					'type' => 'hidden',
                    'value' => $id_socio
				)); ?> 
				<?php echo form_input(array(
					'id' => 'key_url',
					'name' => 'key_url',
					'class' => 'inputform',
					'type' => 'hidden',
                    'value' => $key_url
				)); ?>            

				<?php echo form_submit('submit', 'Cambiar contraseña', 'class="buttonform"') ?>
			<?php echo form_close(); ?>

			<?php $errors = validation_errors(); ?>
			<?php if ( $errors != '' || $errormsg != ''): ?>
				<div class="error_login">
					<img src="<?php echo base_url()?>public/images/icon_alert.png" width="45" height="45" />
					<?php echo $errors . '<br />'. $errormsg;?>
				</div>
			<?php endif; ?>
            <?php 
            if ( $this->session->flashdata("success")) {
            
            ?>
				<div class="success_login">
					<img src="<?php echo base_url()?>public/images/icon_success.png" width="45"  />
					<?php echo $this->session->flashdata("success");?>
				</div>
			<?php }; ?>

		</div>
	</div>
</div>
<?php $this->load->view('componentes/footer'); ?>