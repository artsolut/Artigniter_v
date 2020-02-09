<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }	 ?>

<?php echo form_open('socio/save', array('id' => 'socio_form')); ?>

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
				'value' => set_value('nombre')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['nombre']) && $errors['nombre'] != '' ): ?>
				  	<?php echo $errors['nombre'] ?>
				<?php endif; ?>
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
				'value' => set_value('apellido1')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['apellido1']) && $errors['apellido1'] != '' ): ?>
				  	<?php echo $errors['apellido1'] ?>
				<?php endif; ?>
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
				'value' => set_value('apellido2')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['apellido2']) && $errors['apellido2'] != '' ): ?>
				  	<?php echo $errors['apellido2'] ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Fecha de alta *', 'fecha_alta', array(
				'class' => 'required control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'fecha_alta',
				'id' => 'fecha_alta',
				'class' => 'form-control',
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
				'value' => set_value('dni')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['dni']) && $errors['dni'] != '' ): ?>
				  	<?php echo $errors['dni'] ?>
				<?php endif; ?>
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
				'value' => set_value('direccion')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['direccion']) && $errors['direccion'] != '' ): ?>
				  	<?php echo $errors['direccion'] ?>
				<?php endif; ?>
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
				'value' => set_value('cp')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['cp']) && $errors['cp'] != '' ): ?>
				  	<?php echo $errors['cp'] ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="col-md-2">
			<?php echo form_label('Provincia *', 'provincia', array(
				'class' => 'required control-label'
			)); ?>
			<?php $provincias = array('' => 'Provincia', '1' => 'Murcia') ?>
			<?php echo form_dropdown('provincia', $provincias, (isset($_POST['provincia']) ? $_POST['provincia'] : ''), 'class="form-control"') ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['provincia']) && $errors['provincia'] != '' ): ?>
				  	<?php echo $errors['provincia'] ?>
				<?php endif; ?>
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
				'value' => set_value('localidad')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['localidad']) && $errors['localidad'] != '' ): ?>
					<?php echo $errors['localidad'] ?>
				<?php endif; ?>
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
				'value' => set_value('email')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['email']) && $errors['email'] != '' ): ?>
				  	<?php echo $errors['email'] ?>
				<?php endif; ?>
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
				'value' => set_value('telefono')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['telefono']) && $errors['telefono'] != '' ): ?>
				  	<?php echo $errors['telefono'] ?>
				<?php endif; ?>
			</div>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Estatus *', 'estatus', array(
				'class' => 'required control-label'
			)); ?>
			<?php $estatus_data = array('' => 'Seleccione un estatus', '1' => 'Profesional') ?>
			<?php echo form_dropdown('estatus', $estatus_data, (isset($_POST['estatus']) ? $_POST['estatus'] : ''), 'class="form-control"') ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['estatus']) && $errors['estatus'] != '' ): ?>
				  	<?php echo $errors['estatus'] ?>
				<?php endif; ?>
			</div>
		</div>

		<div class="col-md-3">
			<?php echo form_label('Área profesional *', 'area', array(
				'class' => 'required control-label'
			)); ?>
			<?php $area_data = array('' => 'Seleccione un area', '1' => 'Diseño gráfico') ?>
			<?php echo form_dropdown('area', $area_data, (isset($_POST['area']) ? $_POST['area'] : ''), 'class="form-control"') ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['area']) && $errors['area'] != '' ): ?>
				  	<?php echo $errors['area'] ?>
				<?php endif; ?>
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
				'value' => set_value('marca')
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
				'value' => set_value('web')
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
				'value' => set_value('iban')
			)); ?>
			<div class="help-block with-errors">
				<?php if ( isset($errors['iban']) && $errors['iban'] != '' ): ?>
				  	<?php echo $errors['iban'] ?>
				<?php endif; ?>
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
				'value' => set_value('twitter')
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
				'value' => set_value('facebook')
			)); ?>
		</div>
		<div class="col-md-3">
			<?php echo form_label('Pinterest', 'web', array(
				'class' => 'control-label'
			)); ?>
			<?php echo form_input(array(
				'name' => 'pinterest',
				'id' => 'pinteres',
				'class' => 'form-control',
				'value' => set_value('pinterest')
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
				'value' => set_value('linkedin')
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