<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="apple-mobile-web-app-capable" content="yes" />

    <title><?php echo @$main_title;?></title>
    <meta name="description" content="Dip. Asociación de Profesionales del Diseño y la Comunicación Publicitaria de la Región de Murcia" />
    <meta name="author" content="Fernando Marín">

    <link href="https://fonts.googleapis.com/css?family=Libre+Franklin:400,600&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href=<?php echo base_url()?>favicon.png />

	<script src="<?php echo base_url() ?>public/js/jquery-3.4.1.min.js"></script>
	<script src="<?php echo base_url() ?>public/js/bootstrap.min.js"></script>
	<script src="<?php echo base_url() ?>public/js/datatables.min.js"></script>
	<script src="<?php echo base_url() ?>public/js/sweetalert2.all.min.js"></script>

	<link rel="stylesheet" href="<?php echo base_url()?>public/css/bootstrap.min.css" media="all"/>
	<link rel="stylesheet" href="<?php echo base_url()?>public/css/datatables.min.css" media="all"/>
	<link rel="stylesheet" href="<?php echo base_url()?>public/css/open-iconic-bootstrap.min.css" media="all"/>
    <link rel="stylesheet" href="<?php echo base_url()?>public/css/style.css" media="all"/>
    <link rel="stylesheet" href="<?php echo base_url()?>public/css/custom.css" media="all"/>
</head>
<body>

<header>
    <div class="container">
        <div class="row">
            <div class="col-md-3"><img src="<?php echo base_url()?>public/images/logotipo-dip.png" ></div>
            <div class="col-md-9">
				
                <?php if ( $this->session->userdata('id_socio') ): ?>

					<div class="menu-usuario">Usuario: <?php echo $this->session->userdata('email'); ?></div>
					<div class="contenedor-menu">
						<ul class="menu-principal">
							<li><a href="<?php echo base_url().'socios'; ?>">SOCIOS</a></li>
							<li>REMESAS</li>
							<li>ESTADISTICAS</li>
							<li>COMUNICACIÓN</li>
							<li><a href="<?php echo base_url().'configuracion';?>">CONFIGURACIÓN</a></li>
							<li class="link-exit"><a href="<?php echo base_url().'intranet/logout' ?>">CERRAR SESIÓN</a></li>
						</ul>
					</div>

				<?php endif; ?>


            </div>
        </div>
    </div>
</header>