<?php if (!defined('BASEPATH')) {die('Direct access not permited.');} 

/**
 * Clase Mybreadcrub (library)
 * Control sobre el camino de migas
 */
class Mybreadcrumb {

	private $breadcrumbs = array();

	public function __construct() {
	}

	/**
    * Método add
    * Método SETTER para añadir bloques título-url al array breadcrumbs
    * Parámetros: título de la sección ($title) y enlace ($href)
    * Return: 
    */
    public function add( $title, $href ) {
		
        // Si falta alguno de los parámetros devolvemos nulo
        if ( !$title || !$href ) return;
		
        // En caso contrario añadimos ambos valores al array breadcrumbs
        $this->breadcrumbs[] = array('title' => $title, 'href' => $href );
	}

	/**
    * Método render
    * Método GETTER para obtener el camino de migas completo a partir de las filas del array breadcrumb
    * Parámetros: 
    * Return: el camino de migas completo e interactivo ($output)
    */
    public function render() {
        
		$output =  '<ul class="mybreadcrumb">';
        
        //Iteramos el array para anidar las rutas
		foreach ($this->breadcrumbs as $index => $breadcrumb) {
			$output .= '<li><a href="'.base_url().$breadcrumb['href'].'">'.$breadcrumb['title'].'</a></li>';
		}	
        
		$output .= '</ul>';
        
		return $output;
	}
}