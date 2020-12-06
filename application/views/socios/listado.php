<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }?>
<!-- Filtro de acceso -->
<?php $has_access = $this->usuario_model->check_access(2);//pasamos como parámetro el nivel de acceso necesario para esta sección?>
<!-- Carga de cabecera -->
<?php $this->load->view('componentes/header', $nestedview ) ?>
<?php $this->load->view('partials/breadcrumb', $nestedview); ?>
<?php $this->load->view('socios/menu'); ?>
<?php $this->load->view('partials/alert'); ?>

<!-- 
Tabla que muestra el listado de socios y permite su edición individual, su eliminación individual y su ordenación.
El botón Nuevo Socio Utiliza el método create de la clase socio.
-->
<?php if ($has_access){?>
<div class="container" style="margin-top: 10px;">
	
    <!-- Área de botón nuevo -->
    <div class="col-md-3 area-nuevo">
		<a href="<?php echo base_url().'socio/create' ?>" class="btn btn-success"><span class="oi oi-plus"></span> Nuevo</a>
	</div>

	<div class="listado-socios">
        
        <!-- Inicio de tabla -->
		<table id="tabla-socios" class="table table-bordered table-stripped">
            <!-- Cabecera de tabla -->
			<thead>
			   <tr>
				 <th scope="col">Nombre</th>
				 <th scope="col">Email</th>
				 <th scope="col">Teléfonos</th>
				 <th scope="col">Estatus</th>
				 <th scope="col">Localidad</th>
				 <th scope="col">Area prof.</th>
				 <th>&nbsp;</th>
                 <th>&nbsp;</th>
			   </tr>
			</thead>
            <!-- Cuerpo de tabla -->
			<tbody>
                <!-- Bucle de construcción de filas -->
				<?php foreach ( $socios_data->result() as $socio ): ?>
					
                    <?php
						$nombre = $socio->apellido1.' '.$socio->apellido2.', '.$socio->nombre;
					?>
                
					<tr id="<?php echo $socio->id ?>">
						<td id="nombre"><?php echo $nombre ?> </td>
						<td><?php echo $socio->email ?></td>
						<td><?php echo $socio->telefono ?></td>
						<td><?php echo $this->Estatus_model->get_estatus($socio->estatus) ?></td>
						<td><?php echo $socio->localidad ?></td>
						<td><?php echo $this->Area_model->get_area($socio->area_profesional) ?></td>
						<td>
							<a href="<?php echo base_url('socio/view/'.$socio->id) ?>"><button class="button btn-sm"><span class="oi oi-pencil"></span></button></a>
						</td>
                        <td>
                            <button class="button btn-sm btn-danger remove"><span class="oi oi-trash"></span></button>
                        </td>
					</tr>

				<?php endforeach; ?>
			</tbody>
		</table>
        <!-- Fin de tabla -->

	</div>
</div>

<!-- Función de inicialización de datatable, en la que he incluido el parámetro columns que me permite manipular el ancho de las columnas -->
<script type="text/javascript">

	$(document).ready(function(){
	
        
		$('.remove').click(function(){
			var id = $(this).parents("tr").attr("id");
			var url= "<?php echo base_url().'socio/delete_socio/';?>";

			Swal.fire({
  				title: '¿ Está seguro ?',
				text: "Está apunto de eliminar el socio con Id " + id + ". Éste se marcará como eliminado, pero no será borrado.",
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
        
        $("#tabla-socios").dataTable({
          "columns": [
            { "width": "40%" },
            null,
            null,
            null,
            null,
            null,
            null,
            null
          ]
        } );
 
        table.rows('.important').select();
	});
</script>
<?php } ?>
<!-- Cargamos el footer -->
<?php $this->load->view('componentes/footersh'); ?>