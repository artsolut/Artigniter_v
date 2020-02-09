<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); } ?>

<?php $this->load->view('componentes/header', $nestedview); ?>
<?php $this->load->view('partials/breadcrumb', $nestedview); ?>
<?php $this->load->view('configuracion/menu'); ?>

<?php echo form_open('area/save/'.(isset($area_info->id)? $area_info->id : '' ), array('id' => 'area_form')); ?>

<div class="container clearfix formulario">
	<div class="row">
		<div class="col-md-12">
			<div class="campo-400">
				<?php echo form_label('Área *', 'area', array(
					'class' => 'required control-label'
				)); ?>
				<?php echo form_input(array(
					'name' => 'area',
					'id' => 'area',
					'class' => 'form-control',
					'value' => set_value('area', isset($area_info->area)? $area_info->area : '' )
				)); ?>
				<div class="help-block with-errors">
					<?php echo form_error('area'); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="campo-400">
			<?php echo form_submit('submit', 'Guardar', 'class="buttonform"'); ?>
		</div>
	</div>
</div>


<?php echo form_close(); ?>

<?php $this->load->view('componentes/footer'); ?>