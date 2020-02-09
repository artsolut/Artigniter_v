<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }


class Area extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Area_model');
		$this->load->library('mybreadcrumb', 'flash');
		$this->load->helper('form', 'form_validation', 'url' );
	}

	/**
	 * Vista principal
	 */
	public function index() {

		$areas_obj = $this->Area_model->get_all();
		$data['nestedview']['main_title'] = "Listado de areas";
		$data['areas_data'] = $areas_obj;

		$this->mybreadcrumb->add( 'Configuracion', 'configuracion' );
		$this->mybreadcrumb->add( 'Areas profesionales', 'area' );

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$this->load->view('area/listado', $data);
	}


	public function view( $area_id = -1 ) {
		$area_info = $this->Area_model->get_info($area_id);

		foreach (get_object_vars($area_info) as $property => $value ) {
			$area_info->$property = $value;
		}

		$data['area_info'] = $area_info;
		$data['nestedview']['main_title'] = 'Area profesional';

		$this->mybreadcrumb->add('Configuracion', 'configuracion');
		$this->mybreadcrumb->add('Area profesional', 'area' );

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$this->load->view('area/form', $data);

	}

	public function save( $area_id = -1 ) {

		if ( $area_id == -1 )
			$this->form_validation->set_rules('area', 'Área', 'trim|required|is_unique[area_profesional.area]');
		else
			$this->form_validation->set_rules('area', 'Área', 'trim|required');

		if ( $this->form_validation->run() == false ){
			$this->view($area_id);
			return false;
		}

		$area_data = array(
			'area' => $this->input->post('area')
		);

		if ( $area_id != -1 ) {
			$area_data['id'] = $area_id;
		}

		if ( $this->Area_model->save( $area_data, $area_id )) {
			if ( $area_id == -1 ) {
				$msg = "Área profesional insertada con éxito";
				$this->flash->setMessage($msg, $this->flash->getSuccessType());
			} else {
				$msg = "Área profesional modificada con éxito";
				$this->flash->setMessage($msg, $this->flash->getSuccessType());
			}
			$this->flash->setFlashMessages();
			redirect('area');
		} else {
			$msg = "Ocurrió un error al insertar el area profesional";
			$this->flash->setMessage($msg, $this->flash->getErrorType());
			$this->flash->setFlashMessages();
			redirect('area');
		}
	}

	/**
	 * Elimina un area profesional seleccionado
	 */
	public function delete($area_id) {
		if ( $this->Area_model->delete($area_id)) {
			$msg = 'Área profesional eliminada con éxito';
			$this->flash->setMessage($msg, $this->flash->getSuccessType());
			$this->flash->setFlashMessages();
			redirect('area');
		} else {
			$msg = 'Ocurrió un error al eliminar el area';
			$this->flash->setMessage($msg, $this->flash->getErrorType());
			$this->flash->setFlashMessages();
			redirect('area');
		}
	}

}