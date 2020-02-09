<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); } ?>

<?php $this->load->view('componentes/header', $nestedview ); ?>
<?php $this->load->view('partials/breadcrumb', $nestedview); ?>
<?php $this->load->view('configuracion/menu'); ?>

<?php $this->load->view('partials/alert'); ?>

<div class="container" style="margin-top: 10px;">
	<div class="col-md-3 area-nuevo">
		<a href="<?php echo base_url().'area/view' ?>" class="btn btn-success"><span class="oi oi-plus"></span> Nuevo</a>
	</div>
	<div class="listado_areas">
		<table id="tabla-areas" class="table table-bordered table-stripped">
			<thead>
				<tr>
					<th scope="col">Area</th>
					<th scope="col" style="width: 100px;">&nbsp;</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach( $areas_data->result() as $area ): ?>
					<tr id="<?php echo $area->id ?>">
						<td ><?php echo $area->area ?></td>
						<td>
							<a href="<?php echo base_url('area/view/'.$area->id) ?>"><button class="button btn-sm"><span class="oi oi-pencil"></span></button></a>
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
		$('#tabla-areas').DataTable();
		
		$('.remove').click(function(){
			var id = $(this).parents("tr").attr("id");
			var url= "<?php echo base_url().'area/delete/';?>";

			Swal.fire({
  				title: 'Está seguro ?',
				text: "Está apunto de eliminar un area",
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



