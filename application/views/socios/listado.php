<?php $this->load->view('componentes/header', $nestedview ) ?>
<?php $this->load->view('partials/breadcrumb', $nestedview); ?>
<?php $this->load->view('socios/menu'); ?>
<?php $this->load->view('partials/alert'); ?>

<div class="container" style="margin-top: 10px;">
	<div class="col-md-3 area-nuevo">
		<a href="<?php echo base_url().'socio/create' ?>" class="btn btn-success"><span class="oi oi-plus"></span> Nuevo</a>
	</div>
	<div class="listado-socios">
		<table id="tabla-socios" class="table table-bordered table-stripped">
			<thead>
			   <tr>
				 <th scope="col">Apellidos y nombre</th>
				 <th scope="col">Email</th>
				 <th scope="col">Teléfonos</th>
				 <th scope="col">Estatus</th>
				 <th scope="col">Localidad</th>
				 <th scope="col">Area prof.</th>
				 <th>&nbsp;</th>
			   </tr>
			</thead>
			<tbody>
				<?php foreach ( $socios_data->result() as $socio ): ?>
					<?php
						$nombre = $socio->apellido1.' '.$socio->apellido2.': '.$socio->nombre;
					?>
					<tr id="<?php echo $socio->id ?>">
						<td id="nombre"><?php echo $nombre ?> </td>
						<td><?php echo $socio->email ?></td>
						<td><?php echo $socio->telefono ?></td>
						<td><?php echo $socio->estatus ?></td>
						<td><?php echo $socio->localidad ?></td>
						<td><?php echo $this->Area_model->get_area($socio->area_profesional) ?></td>
						<td>
							<a href="<?php echo base_url('socio/view/'.$socio->id) ?>"><button class="button btn-sm"><span class="oi oi-pencil"></span></button></a>
							<button class="button btn-sm btn-danger remove"><span class="oi oi-trash"></span></button>
						</td>
					</tr>

				<?php endforeach; ?>
			</tbody>
		</table>


	</div>
</div>
<!-- <script language="text/javascript">
	$('.alert').alert();
</script>
 -->
<script type="text/javascript">
	$(document).ready(function(){
		$("#tabla-socios").dataTable();

		$('.remove').click(function(){
			var id = $(this).parents("tr").attr("id");
			var url= "<?php echo base_url().'socio/delete/';?>";

			Swal.fire({
  				title: 'Está seguro ?',
				text: "Está apunto de eliminar un socio",
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
	});
</script>

<?php $this->load->view('componentes/footer'); ?>