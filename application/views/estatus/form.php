<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); } ?>

<?php $this->load->view('componentes/header', $nestedview); ?>
<?php $this->load->view('partials/breadcrumb', $nestedview); ?>
<?php $this->load->view('configuracion/menu'); ?>

<?php echo form_open('estatus/save/'.(isset($estatus_info->id)? $estatus_info->id : '' ), array('id' => 'estatus_form')); ?>

<div class="container clearfix formulario">
	<div class="row">
		<div class="col-md-3">
			<?php echo form_label('Estatus *', 'status', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'estatus',
				'id' => 'estatus',
				'class' => 'form-control',
				'value' => set_value('estatus', isset($estatus_info->estatus)? $estatus_info->estatus : '' )
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('estatus'); ?>
			</div>
		</div>

		<div class="col-md-2">
			<?php echo form_label('Cuota *', 'cuota', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'cuota',
				'id' => 'cuota',
				'class' => 'form-control',
				'value' => set_value('cuota', isset($estatus_info->cuota)? $estatus_info->cuota : '' )
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('cuota'); ?>
			</div>
		</div>

		<div class="col-md-3">
			<?php echo form_label('Periodicidad *', 'cuota', array(
				'class' => 'required control-label'
			)); ?>
			<?php $periodos = $this->Periodicidad_model->get_periodicidad_array(); ?>
			<?php
				$periodo_data = '';
				if (isset($_POST['periodicidad'])){
					$periodo_data = $_POST['periodicidad'];
				} elseif (isset($estatus_info->periodicidad)) {
					$periodo_data = $estatus_info->periodicidad;
				}
			 ?>
			<?php echo form_dropdown('periodicidad', $periodos, $periodo_data, 'class="form-control"'); ?>
			<div class="hel-block with-errors">
				<?php echo form_error('periodicidad') ?>
			</div>
		</div>

		<div class="col-md-1 check-input">
				<?php echo form_label('Activo', 	'activo', array(
					'class' => 'control-label'
				)); ?>
				<?php 
					if ( isset($_POST['activo']) ){
						$check = $_POST['activo']? true : false;
					} elseif (isset($estatus_info->activo)){
						$check = $estatus_info->activo? true: false;
					} 
				 ?>
				<?php echo form_checkbox(array(
					'id' => 'activo',
					'name' => 'activo',
					'value' => '1',
					'checked' => $check,
					'style' => 'text-align: center;'
				)); ?>
		</div>		
		<div class="col-md-3">
			<?php echo form_submit('submit', 'Guardar', 'class="buttonform"'); ?>
		</div>
	</div>
</div>

<?php echo form_close(); ?>

<?php $this->load->view('componentes/footer'); ?>