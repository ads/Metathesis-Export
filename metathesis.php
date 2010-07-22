<?php
/*
Plugin Name: Metathesis: Export
Plugin URI: http://adsdevshop.com/products/
Description: Easily export the metadata stored in custom fields by the Thesis theme into other formats used by compatible plugins. Provides an extensible system for adding additional export targets.
Version: 0.2
Author: Eric Marden
Author URI: http://xentek.net/ 
*/

class Metathesis {

	public function __construct()
	{
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
	}
	
	public function admin_menu()
	{
		add_submenu_page('tools.php', 'Metathesis Export', 'Metathesis', 'export', 'metathesis-export', array( &$this, 'options' ) );
	}
	
	public function options()
	{
		$this->render('options');
	}
	
	static function targets()
	{
		$targets = array();
		$targets = apply_filters('metathesis_get_targets',$targets);
		return $targets;
	}
	
	protected function render($view, $args = array(), $ajax = false) 
	{
		extract( $args );

		if ( $ajax ):
			ob_start();
		endif;

		$file = rtrim(dirname( __FILE__ ), '/') . '/view/' . $view . '.php';
		if ( file_exists( $file ) ):
			include $file;
		else:
			echo '<pre>' . $file . ' not found.</pre>';
		endif;

		if ( $ajax ):
			$output = ob_get_contents();
			ob_end_clean();
			return $output;
		endif;
	}

	protected function render_message($message, $timeout = 0) 
	{
?>
	<div class="updated" id="message" onclick="this.parentNode.removeChild(this);">
		<p><?php echo $message; ?></p>
	</div>
<?php
	}
	
	protected function render_error($message) 
	{
?>
	<div class="fade error" id="message">
		<p><?php echo $message ?></p>
	</div>
<?php
	}
}

include('lib/MetathesisImport.php');
include('lib/AIOSEOP_MetathesisImport.php');

$metathesis = new Metathesis();
?>