<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }
?>
<?php $this->load->view('componentes/header', $nestedview) ?>
<?php $this->load->view('partials/breadcrumb', $nestedview) ?>
<?php $this->load->view('configuracion/menu') ?>

<?php $this->load->view('partials/alert'); ?>

<div class="container clearfix formulario" style="margin-top: 20px;">

    <?php echo form_open('configuracion/save_config/'. (isset($config_data->id)? $config_data->id : '' ), array('id' => 'configuracion_form')); ?>

	<div class="row">
		<div class="col-md-2">
			<?php
			echo form_label('Última factura e *', 'ultima_factura', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'ultima_factura',
				'id' => 'ultima_factura',
				'class' => 'form-control',
				'value' => set_value('ultima_factura', isset($config_data->ultima_factura) ? $config_data->ultima_factura : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('ultima_factura') ?>
			</div>
		</div>

		<div class="col-md-2">
			<?php echo form_label('Último abono *', 'ultimo_abono', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'ultimo_abono',
				'id' => 'ultimo_abono',
				'class' => 'form-control',
				'value' => set_value('ultimo_abono', isset($config_data->ultimo_abono) ? $config_data->ultimo_abono : '')
			)); ?>

            <div class="help-block with-errors">
				<?php echo form_error('ultimo_abono') ?>
			</div>

		</div>

		<div class="col-md-2">
			<?php echo form_label('Año *', 'anno', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'anno',
				'id' => 'anno',
				'class' => 'form-control',
				'value' => set_value('anno', isset($config_data->anno) ? $config_data->anno : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('anno') ?>
			</div>
		</div>

		<div class="col-md-3">
			<?php echo form_label('E-mail *', 'email_emisor', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'email_emisor',
				'id' => 'email_emisor',
				'class' => 'form-control',
				'value' => set_value('email_emisor', isset($config_data->email_emisor) ? $this->encryption->decrypt($config_data->email_emisor) : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('email_emisor') ?>
			</div>
		</div>
		<div class="col-md-3">
			<?php echo form_label('SMTP *', 'smtp', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'smtp',
				'id' => 'smtp',
				'class' => 'form-control',
				'value' => set_value('smtp', isset($config_data->smtp)  ? $this->encryption->decrypt($config_data->smtp) : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('smtp') ?>
			</div>
		</div>
	</div>
	<div class="row">

		<div class="col-md-6">
			<?php echo form_label('Contraseña *', 'password', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'password',
				'id' => 'password',
				'class' => 'form-control',
				'value' => set_value('password', isset($config_data->password) ? $this->encryption->decrypt($config_data->password) : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('password') ?>
			</div>
		</div>

			<?php echo form_submit('submit', 'Guardar', 'class="buttonform"') ?>
		</div>
	</div>

</div>

<?php echo form_close(); ?>
<?php $this->load->view('componentes/footer') ?>