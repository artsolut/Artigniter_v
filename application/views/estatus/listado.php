<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); } ?>

<?php $this->load->view('componentes/header', $nestedview ); ?>
<?php $this->load->view('partials/breadcrumb', $nestedview); ?>
<?php $this->load->view('configuracion/menu'); ?>

<?php $this->load->view('partials/alert'); ?>

<div class="container" style="margin-top: 10px;">
	<div class="area-nuevo">
		<a href="<?php echo base_url().'estatus/view' ?>" class="btn btn-success"><span class="oi oi-plus"></span> Nuevo</a>
	</div>
	<div class="listado_estatus">
		<table id="tabla-estatus" class="table table-bordered table-stripped">
			<thead>
				<tr>
					<th scope="col">Estatus</th>
					<th scope="col">Cuota</th>
					<th scope="col">Periodicidad</th>
					<th scope="col" style="width: 100px;">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $estatus_data->result() as $estatus ): ?>
					<tr id="<?php echo $estatus->id ?>">
						<td ><?php echo  $estatus->estatus ?></td>
						<td><?php echo $estatus->cuota ?></td>
						<td><?php echo $this->Periodicidad_model->get_periodicidad($estatus->periodicidad) ?></td>
						<td>
							<a href="<?php echo base_url('estatus/view/'.$estatus->id) ?>"><button class="button btn-sm"><span class="oi oi-pencil"></span></button></a>
							<button class="button btn-sm btn-danger remove"><span class="oi oi-trash"></span></button>
						</td>
					</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
	</div>
</div>
<br>

<script type="text/javascript">
	$(document).ready(function() {
		$('#tabla-estatus').DataTable();
		
		$('.remove').click(function(){
			var id = $(this).parents("tr").attr("id");
			var url= "<?php echo base_url().'estatus/delete/';?>";

			Swal.fire({
  				title: 'Está seguro ?',
				text: "Está apunto de eliminar un estatus",
				type: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: 'Si'
				}).then((result) => {
				if (result.value) {
					window.location.replace( url + id );
				}
			});
		})
	} );
</script>

<?php $this->load->view('componentes/footer'); ?>



