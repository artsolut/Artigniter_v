<?php if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }


class Periodicidad extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('Periodicidad_model');
		$this->load->model('Usuario_model');
		$this->load->library('flash', 'mybreadcrumb');
		$this->load->helper('form', 'form_validation', 'url');
	}

	/**
	 * Vista principal
	 */
	public function index() {
        
        if ( !$this->Usuario_model->is_logged_in() )
				redirect('login');

		$periodicidad_obj = $this->Periodicidad_model->get_all();
		$data['nestedview']['main_title'] = "Periodicidad cuotas";
		$data['periodicidad_data'] = $periodicidad_obj;

		$this->mybreadcrumb->add( 'Configuracion', 'configuracion' );
		$this->mybreadcrumb->add( 'Periodicidad cuotas', 'periodicidad' );

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$this->load->view('periodicidad/listado', $data);
	}

	public function view( $periodicidad_id = -1 ) {

		$periodicidad_info = $this->Periodicidad_model->get_info($periodicidad_id);

		foreach (get_object_vars($periodicidad_info) as $property => $value ) {
			$periodicidad_info->$property = $value;
		}

		$data['periodicidad_info'] = $periodicidad_info;
		$data['nestedview']['main_title'] = 'Periodicidad cuotas';

		$this->mybreadcrumb->add('Configuracion', 'configuracion');
		$this->mybreadcrumb->add('Periodicidad cuotas', 'periodicidad' );

		$data['nestedview']['breadcrumb'] = $this->mybreadcrumb->render();

		$this->load->view('periodicidad/form', $data);
	}

	public function save($periodicidad_id = -1 ) {

		if ($periodicidad_id == -1 )
			$this->form_validation->set_rules('nombre', 'Nombre periodo', 'trim|required|is_unique[periodicidad.nombre]');
		else 
			$this->form_validation->set_rules('nombre', 'Nombre periodo', 'trim|required');

		$this->form_validation->set_rules('periodicidad', 'Periodo', 'required|numeric|greater_than_equal_to[0]|less_than_equal_to[12]');
		$this->form_validation->set_message('periodicidad', 'Número de meses: 0, 3, 12');

		if ( $this->form_validation->run() == false ) {
			$this->view($periodicidad_id);
			return false;
		}

		$periodicidad_data = array(
			'nombre' => $this->input->post('nombre'),
			'periodicidad' => $this->input->post('periodicidad'),
		);

		if ( $periodicidad_id != -1 ){
			$periodicidad_data['id'] = $periodicidad_id;
		}

		if ( $this->Periodicidad_model->save($periodicidad_data, $periodicidad_id)) {
			
            if ( $periodicidad_id == -1 ) {

                $message_data = array(
                    'item' => 'message',
                    'type' => 'success',
                    'message' => 'Periodo insertado con éxito'
			     );

			} else {
				
                $message_data = array(
                    'item' => 'message',
                    'type' => 'success',
                    'message' => 'Periodo modificado con éxito'
			     );
                
			}
			
            $this->session->set_flashdata($message_data);
			redirect('periodicidad');

		} else {
            
			$message_data = array(
                'item' => 'message',
                'type' => 'danger',
                'message' => 'Ocurrió un error al insertar el periodo'
             );

            $this->session->set_flashdata($message_data);
			redirect('periodicidad');    

		}
	}

	public function delete($periodicidad_id) {
		if ( $this->Periodicidad_model->delete($periodicidad_id)) {
			
            $message_data = array(
                'item' => 'message',
                'type' => 'success',
                'message' => 'Periodo eliminado con éxito'
             );
            
		} else {
			
            $message_data = array(
                'item' => 'message',
                'type' => 'danger',
                'message' => 'Ocurrió un error al eliminar el periodo'
             );

		}

        $this->session->set_flashdata($message_data);
        redirect('periodicidad');  
        
    }
    

	public function chech_periodicidad($item) {
        
		if ( $item == '' )
            
			return false;
        
		return true;
	}

}