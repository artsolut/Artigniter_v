<?php if (!defined('BASEPATH')) {die('Direct access not permited.');} 

class Mybreadcrumb {

	private $breadcrumbs = array();

	public function __construct() {
	}

	public function add( $title, $href ) {
		if ( !$title || !$href ) return;
		$this->breadcrumbs[] = array('title' => $title, 'href' => $href );
	}

	public function render() {
		$output =  '<ul class="mybreadcrumb">';
		foreach ($this->breadcrumbs as $index => $breadcrumb) {
			$output .= '<li><a href="'.base_url().$breadcrumb['href'].'">'.$breadcrumb['title'].'</a></li>';
		}	
		$output .= '</ul>';
		return $output;
	}
}