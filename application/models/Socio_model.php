<?php
if ( !defined('BASEPATH') ){ die('Direct access not permited.'); }

/**
* Clase Socio_model MODELO
* Operaciones de base de datos con tablas de socios
*/

class Socio_model extends CI_Model {

	public function __construct() {
		parent::__construct();
		$this->load->database();
	}

	/**
	 * Método exists
     * Comprueba si un socio existe mediante el id
     * Params: id de socio
     * Return: boolean
	 */
	public function exists($socio_id) {
        
		$this->db->from('socio');
		$this->db->where('socio.id', $socio_id );

		return ($this->db->get()->num_rows() == 1 );
	}

	/**
     * Método get_all
	 * Obtiene la lista de socios completa
     * Params:
     * Return: listado de socios
	 */
	public function get_all( $limit = 10000, $offset = 0 ) {

		$this->db->from('socio');
		$this->db->where('eliminado', 0);
		$this->db->order_by('apellido1, apellido2, nombre', 'ASC');
		$this->db->limit($limit);
		$this->db->offset($offset);
        
		return $this->db->get();
	}

	/**
	 * Método get_total_rows
     * Devuelve el total de socios activos
     * Params: 
     * Return: número de socios activos
	 */
	public function get_total_rows() {
        
		$this->db->from('socio');
		$this->db->where('eliminado', 0);
        
		return $this->db->count_all_results();
	}

	/**
     * Método get_info
	 * Devuelve los datos de un socio por si id
     * Params: id de socio
     * Return: registro completo del socio
	 */
	public function get_info( $socio_id ) {
        
        // obtenemos el registro
		$query = $this->db->get_where('socio', array('socio.id' => $socio_id ), 1);
        
		// Si existe devolvemos el registro completo
        if ( $query->num_rows() == 1 ){
            
			return $query->row();
            
		} else {
            
            // Si no existe generamos un objeto con todas las propiedades vacías para permitir la creación de un nuevo socio
			$socio_obj = new stdClass;
            
			foreach ($this->db->list_fields('socio') as $field ) {
                
				$socio_obj->$field = '';
			}
            
			return $socio_obj;
		}
	}

    /**
    * Método control_change_pass
    * Devuelve TRUE si ejecuta el update y false en caso contrario
    * Params 
    * Return: boolean
    **/
    public function control_change_pass($string_recovery, $check_email) {
        
        $this->db->set('recuperar', $string_recovery);
        $this->db->where('id', $check_email);
        
        if ($this->db->update('socio')){
            
            return true;
            
        }else{            
        
            return false;
            
        } 
        
    }
    
	/**
     * Método check_mail
	 * Devuelve TRUE si el correo existe y está activo
     * Params: email
     * Return: id | null
	 */
	public function check_mail( $email_to_check ) {
        
        // obtenemos el registro
		$query = $this->db->get_where('socio', array('email' => $email_to_check, 'eliminado' => 0 ), 1);
        
		// Si existe devolvemos el id
        if ( $query->num_rows() == 1 ){
            
            $row = $query->row();
            return $row->id;
            
		} else {
            
            // Si no existe devolvemos null
            return null;
		}
	}
    
    
	/**
     * Método save
	 * Introduce los datos de un nuevo socio o reemplaza los datos de uno existente
     * Params: objeto de datos, id de socio
     * Return: boolean
	 */
	public function save( &$socio_data, $socio_id = false ) {
        
        // Si es un nuevo socio guardamos en BBDD y actualizamos el objeto socio_data con el nuevo Id de socio.
        if ( !$socio_id || !$this->exists($socio_id) ) {
            
			if ( $this->db->insert('socio', $socio_data ) ) {
                
				$socio_data['id_socio'] = $this->db->insert_id();
                
				return true;
			}
            
            // Si no se guarda con éxito devolvemos false
			return false;
		}
        
        // Si el parámetro Id existe reemplazamos el registro con el objeto socio_data, devolviendo un booleano
		$this->db->where('id', $socio_id );
        
		return $this->db->update( 'socio', $socio_data );
	}


	/**
     * Método is_logged_in
	 * Comprueba si hay una sesión de usuario abierta
     * Params: 
     * Return: boolean
	 */
	public function is_logged_in() {
        
        // devuelve TRUE si existe el valor "id_socio" en la sesión
		return ($this->session->userdata('id_socio') != false );
        
	}

	/**
     * Método get_logged_in_socio_info
	 * Si existe la sesión de usuario, devuelve el registro completo del socio autenticado
     * Params: 
     * Return: registro del socio autenticado o boolean si no hay sesión activa
	 */
	public function get_logged_in_socio_info() {
        
		if($this->is_logged_in()) {
            
			return $this->get_info($this->session->userdata('id_socio'));
            
		}
        
		return false;
	}

	/**
     * Método delete_socio
	 * Marca un socio como eliminado, no lo borra.
     * Params: id de socio                                                                      
     * Return: boolean
	 */
	public function delete_item( $socio_id ) {
        
        $data = array(
            'eliminado' => 1
        );

        $this->db->where('id', $socio_id);

        
        return ($this->db->update('socio', $data));
		
	}
    


    /**
	protected function nameize($string) {
		return str_name_case($string);
	}
    */

}