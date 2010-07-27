<?php
/*
Plugin Name: Metathesis
Plugin URI: http://adsdevshop.com/products/
Description: Easily export the metadata stored in custom fields by the Thesis theme into other formats used by compatible plugins. Provides an extensible system for adding additional export targets.
Version: 1.1.1
Author: Atlantic Dominion Solutions
Author URI: http://adsdevshop.com/
*/

class MetathesisPlugin {

	public function __construct()
	{
		add_action( 'admin_menu', array( &$this, 'admin_menu' ) );
		add_action( 'init', array( &$this, 'process' ) );
	}
	
	public function admin_menu()
	{
		add_submenu_page( 'tools.php', 'Metathesis', 'Metathesis', 'export', 'metathesis', array( &$this, 'options' ) );
	}
	
	public function options()
	{
		$this->render('options');
	}
	
	public function process()
	{
		if ( !empty( $_POST['metathesis_submit'] ) ):
			if ( class_exists( $_POST['metathesis_class'] ) ):
				$metathesis = new $_POST['metathesis_class'];
				$result = $metathesis->import();
				if ( $result ):
					$this->render_message( 'Metasynthesis Complete.' );
				endif;
			else:
				$this->render_error( $_POST['metathesis_class'] . ' class does not exist.' );
			endif;
		endif;
	}
	
	static function targets()
	{
		$targets = array();
		$targets = apply_filters( 'metathesis_targets', $targets );
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

include('adapters/Metathesis.php');
include('adapters/Metathesis_AIOSEOP_CSV.php');
include('adapters/Metathesis_AIOSEOP.php');
include('adapters/Metathesis_Thesis.php');

$metathesisplugin = new MetathesisPlugin();
?>