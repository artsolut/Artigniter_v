<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="container">
    <div class="row wrap_login">
     	<div class="col-md-6 text-right">
        <h1>Control de acceso</h1>
        <a href="<?php echo base_url().'login/reset_password' ?>">He olvidado mi contraseña</a>
        </div>
        <div class="col-md-6">

            <?php echo form_open('login'); ?>
                <input type="text" class="inputform" name="email" placeholder="Usuario" />
                <input type="password" class="inputform" id="password" name="password" placeholder="Contraseña" />
                <input type="submit" class="buttonform" value="Acceder" name="submit" />
            <?php echo form_close();?>

            <?php $errors = validation_errors(); ?>
            <?php if($errors!=''): ?>

                <div class="error_login">
                <img src="<?php echo base_url()?>public/images/icon_alert.png" width="45" height="45" />
                <p>Usuario o contraseña incorectos.<br />Vuelva a intentarlo.</p>
                </div>

			<?php endif; ?>
        </div>
    </div>
</div>
