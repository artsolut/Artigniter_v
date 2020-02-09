<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }


/**
* Clase Configuracion
* @category    Controlador
* @author      Fernando Marín
* Clase que hereda de CI_Controller. Es el Controlador responsable del área de Configuración y tablas de datos auxiliares
*/
class Configuracion extends CI_Controller {

    public function __construct() {
		parent::__construct();
		$this->load->model('Usuario_model');
		$this->load->model('Configuracion_model');
    }

	/**
	 * Método Index
	 * Redirige al controlador Login (pantalla de acceso) si no existe la sesión.
	 * Si existe la sesión, se carga la sección Configuración con los datos registrados editables.
	 * @param
	 * @return
	*/
    public function index() {

			if ( !$this->Usuario_model->is_logged_in() )
				redirect('login');

			$config = $this->Configuracion_model->get_configuracion();

			$data['config_data'] = $config;
			$data['nestedview']['main_title'] = 'Configuración General';

			$this->mybreadcrumb->add('Configuracion', 'configuracion');

			$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

			$this->load->view('configuracion/configuracion_vista', $data);
	}

	/**
	 * Método save_config
	 * Recibe el id y el formulario del registro y los datos a reemplazar
	 * Carga el registro (único) de la tabla Configuracion y lo actualiza
	 * @param id, (config_form)
	 * @return
	*/
	public function save_config ($id = -1) {


		$data['main_title'] = '';

		//Establecemos condiciones de validación

		$this->form_validation->set_rules('ultima_factura', 'Última factura', 'trim|required|is_numeric');
		$this->form_validation->set_rules('ultimo_abono', 'Último abono', 'trim|required|is_numeric');
		$this->form_validation->set_rules('anno', 'Año', 'required|is_numeric');
		$this->form_validation->set_rules('email_emisor', 'E-mail emisor', 'trim|required|valid_email');
		$this->form_validation->set_rules('smtp', 'SMTP', 'trim|required');
		$this->form_validation->set_rules('password', 'Contraseña', 'trim|required');

		//Comprobamos validez de los datos

		if ( $this->form_validation->run() == false ){
			$this->errors = $this->form_validation->error_array();
			$data['errors'] = $this->errors;
            $this->index();
            return false;
		}


		// Recogemos valores del formulario

		$ultima_factura = $this->input->post('ultima_factura');
		$ultimo_abono = $this->input->post('ultimo_abono');
		$anno = $this->input->post('anno');
		$email_emisor = $this->input->post('email_emisor');
		$smtp = $this->input->post('smtp');
		$password = $this->input->post('password');
		//$puerto = $this->input->post('puerto');


		//Almacenamos los valores en un array

		$config_data = array(

			'id' => $id,
			'ultima_factura' => $ultima_factura,
			'ultimo_abono' => $ultimo_abono,
			'anno' => $anno,
			'email_emisor' => $this->encryption->encrypt($email_emisor),
			'smtp' => $this->encryption->encrypt($smtp),
			'password' => $this->encryption->encrypt($password),
		);

		if ( $this->Configuracion_model->update_config($config_data, $id) ) {
			$this->flash->setMessage('Configuración general actualizada con éxito', $this->flash->getSuccessType());
		} else {
			$this->flash->setMessage('Error al actualizar la configuración general', $this->flash->getErrorType());
		}
		$this->flash->setFlashMessages();

		redirect('configuracion/index');
	}

}