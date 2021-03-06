<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }


class Estatus extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Estatus_model');
		$this->load->model('Periodicidad_model');
		$this->load->library('flash', 'mybreadcrumb');
		$this->load->helper('form', 'form_validation', 'url');
	}

	/**
	 * Vista principal
	 */
	public function index() {

		$estatus_obj = $this->Estatus_model->get_all();
		$data['nestedview']['main_title'] = "Listado de estatus";
		$data['estatus_data'] = $estatus_obj;

		$this->mybreadcrumb->add( 'Configuracion', 'configuracion' );
		$this->mybreadcrumb->add( 'Estatus', 'estatus' );

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$this->load->view('estatus/listado', $data);
	}

	public function view( $estatus_id = -1 ) {

		$estatus_info = $this->Estatus_model->get_info($estatus_id);

		foreach (get_object_vars($estatus_info) as $property => $value ) {
			$estatus_info->$property = $value;
		}

		$data['estatus_info'] = $estatus_info;
		$data['nestedview']['main_title'] = 'Estatus';

		$this->mybreadcrumb->add('Configuracion', 'configuracion');
		$this->mybreadcrumb->add('Estatus', 'estatus' );

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$this->load->view('estatus/form', $data);
	}

	public function save($estatus_id = -1 ) {

		if ($estatus_id == -1 )
			$this->form_validation->set_rules('estatus', 'Estatus', 'trim|required|is_unique[estatus.estatus]');
		else 
			$this->form_validation->set_rules('estatus', 'Estatus', 'trim|required');

		$this->form_validation->set_rules('cuota', 'Cuota', 'trim|required|numeric');

		$this->form_validation->set_rules('periodicidad', 'Periodicidad', 'callback_chech_periodicidad');
		$this->form_validation->set_message('check_periodicidad', 'Tiene que seleccionar una periodicidad');

		if ( $this->form_validation->run() == false ) {
			$this->view($estatus_id);
			return false;
		}

		$estatus_data = array(
			'estatus' => $this->input->post('estatus'),
			'cuota' => $this->input->post('cuota'),
			'periodicidad' => $this->input->post('periodicidad'),
			'activo' => $this->input->post('activo')
		);

		if ( $estatus_id != -1 ){
			$estatus_data['id'] = $estatus_id;
		}

		if ( $this->Estatus_model->save($estatus_data, $estatus_id)) {
			if ( $estatus_id == -1 ) {
				$msg = "Estatus insertado con éxito";
				$this->flash->setMessage($msg, $this->flash->getSuccessType());
			} else {
				$msg = "Estatus modificado con éxito";
				$this->flash->setMessage($msg, $this->flash->getSuccessType());
			}
			$this->flash->setFlashMessages();
			redirect('estatus');
		} else {
			$msg = "Ocurrió un error al insertar el estatus";
			$this->flash->setMessage($msg, $this->flash->getErrorType());
			$this->flash->setFlashMessages();
			redirect('estatus');
		}
	}

	public function delete($estatus_id) {
		if ( $this->Estatus_model->delete($estatus_id)) {
			$msg = "Estatus eliminado con exito";
			$this->flash->setMessage($msg, $this->flash->getSuccessType());
			$this->flash->setFlashMessages();
			redirect('estatus');
		} else {
			$msg = "Ocurrió un error al eliminar el status";
			$this->flash->setMessage($msg, $this->flash->getErrorType());
			$this->flash->setFlashMessages();
			redirect('estatus');
		}
	}

	public function chech_periodicidad($item) {
		if ( $item == '' )
			return false;
		return true;
	}

}