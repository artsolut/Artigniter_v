<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }?>

<?php $this->load->view('componentes/header', $nestedview); ?>
<?php $this->load->view('partials/breadcrumb', $nestedview); ?>
<?php $this->load->view('socios/menu'); ?>

<?php echo form_open('socio/save/'.(isset($socio_data->id)? $socio_data->id : '' ), array('id' => 'socio_form')); ?>

<div class="container clearfix formulario">
	<div class="row">
		<div class="col-md-3">
			<?php echo form_label('Nombre *', 'nombre', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'nombre',
				'id' => 'nombre',
				'class' => 'form-control',
				'value' => set_value('nombre', isset($socio_data->nombre) ? $socio_data->nombre : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('nombre'); ?>
			</div>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Primer apellido *', 'apellido1', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'apellido1',
				'id' => 'apellido1',
				'class' => 'form-control',
				'value' => set_value('apellido1', isset($socio_data->apellido1) ? $socio_data->apellido1 : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('apellido1'); ?>
			</div>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Segundo apellido *', 'apellido2', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'apellido2',
				'id' => 'apellido2',
				'class' => 'form-control',
				'value' => set_value('apellido2', isset($socio_data->apellido2) ? $socio_data->apellido2 : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('apellido2'); ?>
			</div>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Fecha de alta *', 'fecha_alta', array(
				'class' => 'disabled control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'fecha_alta',
				'id' => 'fecha_alta',
				'class' => 'form-control',
                'value' => set_value('fecha_alta', isset($socio_data->fecha_alta) ? $socio_data->fecha_alta : '0000-00-00')

			)); ?>
		</div>
	</div>
	<div class="row">

		<div class="col-md-3">
			<?php echo form_label('DNI *', 'dni', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'dni',
				'id' => 'dni',
				'class' => 'form-control',
				'value' => set_value('dni', isset($socio_data->dni) ? $socio_data->dni : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('dni'); ?>
			</div>
		</div>

		<div class="col-md-3">
			<?php echo form_label('Dirección *', 'direccion', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'direccion',
				'id' => 'direccion',
				'class' => 'form-control',
				'value' => set_value('direccion', isset($socio_data->direccion) ? $socio_data->direccion : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('direccion'); ?>
			</div>
		</div>

		<div class="col-md-2">
			<?php echo form_label('Código postal *', 'cp', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'cp',
				'id' => 'cp',
				'class' => 'form-control',
				'value' => set_value('cp', isset($socio_data->cp) ? $socio_data->cp : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('cp'); ?>
			</div>
		</div>

		<div class="col-md-2">
			<?php echo form_label('Provincia *', 'provincia', array(
				'class' => 'required control-label'
			)); ?>
			<?php $provincia_data = $this->Provincia_model->get_provincia_array()?>
            <?php
				$provincia_select_data = '';
				if (isset($_POST['provincia'])){
					$provincia_select_data = $_POST['provincia'];
				} elseif (isset($socio_data->provincia)){
					$provincia_select_data = $socio_data->provincia;
				}
			 ?>
			<?php echo form_dropdown('provincia', $provincia_data, $provincia_select_data, 'class="form-control"') ?>
			<div class="help-block with-errors">
				<?php echo form_error('provincia'); ?>
			</div>
		</div>

		<div class="col-md-2">
			<?php echo form_label('Localidad *', 'localidad', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'localidad',
				'id' => 'localidad',
				'class' => 'form-control',
				'value' => set_value('localidad', isset($socio_data->localidad) ? $socio_data->localidad : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('localidad'); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<?php echo form_label('Email *', 'email', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'email',
				'id' => 'email',
				'class' => 'form-control',
				'value' => set_value('email', isset($socio_data->email) ? $socio_data->email : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('email'); ?>
			</div>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Teléfono *', 'telefono', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'telefono',
				'id' => 'telefono',
				'class' => 'form-control',
				'value' => set_value('telefono', isset($socio_data->telefono) ? $socio_data->telefono : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('telefono'); ?>
			</div>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Estatus *', 'estatus', array(
				'class' => 'required control-label'
			)); ?>

			<?php $estatus_data = $this->Estatus_model->get_estatus_array(); ?>
            <?php
				$estatus_select_data = '';
				if (isset($_POST['estatus'])){
					$estatus_select_data = $_POST['estatus'];
				} elseif (isset($socio_data->estatus)){
					$estatus_select_data = $socio_data->estatus;
				}
			 ?>
			<?php echo form_dropdown('estatus', $estatus_data, $estatus_select_data, 'class="form-control"') ?>
			<div class="help-block with-errors">
				<?php echo form_error('estatus'); ?>
			</div>
		</div>

		<div class="col-md-3">
			<?php echo form_label('Área profesional *', 'area', array(
				'class' => 'required control-label'
			)); ?>
			<?php $area_data = $this->Area_model->get_area_array(); ?>
			<?php
				$area_profesional_data = '';
				if( isset($_POST['area_profesional'])){
					$area_profesional_data = $_POST['area_profesional'];
				} elseif ( isset($socio_data->area_profesional)) {
					$area_profesional_data = $socio_data->area_profesional;
				}
			 ?>
			<?php echo form_dropdown('area_profesional', $area_data, $area_profesional_data, 'class="form-control"') ?>
			<div class="help-block with-errors">
				<?php echo form_error('area_profesional'); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-md-3">
			<?php echo form_label('Marca', 'telefono', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'marca',
				'id' => 'marca',
				'class' => 'form-control',
				'value' => set_value('marca', isset($socio_data->marca) ? $socio_data->marca : '')
			)); ?>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Web', 'web', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'web',
				'id' => 'web',
				'class' => 'form-control',
				'value' => set_value('web', isset($socio_data->web) ? $socio_data->web : '')
			)); ?>
		</div>
		<div class="col-md-6">
			<?php echo form_label('IBAN *', 'iban', array(
				'class' => 'reqeuired control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'iban',
				'id' => 'iban',
				'class' => 'form-control',
				'value' => set_value('iban', isset($socio_data->iban) ? $socio_data->iban : '')
			)); ?>
			<div class="help-block with-errors">
				<?php echo form_error('iban'); ?>
			</div>
		</div>
	</div>

	<div class="row">
		<div class="col-md-3">
			<?php echo form_label('Twitter', 'web', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'twitter',
				'id' => 'twitter',
				'class' => 'form-control',
				'value' => set_value('twitter', isset($socio_data->twitter) ? $socio_data->twitter : '')
			)); ?>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Facebook', 'web', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'facebook',
				'id' => 'facebook',
				'class' => 'form-control',
				'value' => set_value('facebook', isset($socio_data->facebook) ? $socio_data->facebook : '')
			)); ?>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Instagram', 'web', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'instagram',
				'id' => 'instagram',
				'class' => 'form-control',
				'value' => set_value('instagram', isset($socio_data->instagram) ? $socio_data->instagram : '')
			)); ?>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Linkedin', 'web', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'linkedin',
				'id' => 'linkedin',
				'class' => 'form-control',
				'value' => set_value('linkedin', isset($socio_data->linkedin) ? $socio_data->linkedin : '')
			)); ?>
		</div>
	</div>
	<div class="row">
		<div class="col-md-6">
			<?php echo form_label('Otras redes', 'web', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'otros',
				'id' => 'otros',
				'class' => 'form-control',
				'value' => set_value('otros', isset($socio_data->otros) ? $socio_data->otros : '')
			)); ?>
		</div>
        <div class="col-md-6">
			<?php echo form_label('Notas', 'web', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_textarea(array(
				'name' => 'notas',
				'id' => 'notas',
				'class' => 'form-control',
                'rows' => '5',
				'value' => set_value('notas', isset($socio_data->notas) ? $socio_data->notas : '')
     
			)); ?>
		</div>
    </div>  
	<div class="row">
		<div class="col-md-3">
			<?php echo form_submit('submit', 'Guardar', 'class="buttonform"') ?>
		</div>
	</div>

</div>
<?php echo form_close(); ?>
<?php $this->load->view('componentes/footer') ?>