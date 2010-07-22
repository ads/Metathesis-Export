<?php
/**
 *	Metathesis Import
 */
class MetathesisImport
{
	
	
	/**
	 *	Modifies the $targets array with the metathesis_get_targets filter
	 *
	 *	@param $targets array An array passed in by the filter. Your class can add or remove items, but most of the time they just add their own and pass it along
	 *	@return array The modified $targets array
	 */
	static function target( $targets = array() )
	{
		if ( !is_array($targets) )
			$targets = array();
		
		if ( class_exists('MetathesisImport') ):
			$targets[] = array(
				'name' => 'Raw Data',
				'type' => 'File',
				'class' => 'MetathesisImport',
				'button' => 'Download Export File',
				'desc' => 'Exports the raw metadata as a CSV file',
			);
		endif;

		return $targets;
	}

	/**
	 * This gets the thesis data and prepares it for this adaptor's target. Most subclasses shouldn't have to define this one unless they want to do something funky
	 */
	function export()
	{
		global $wpdb;
		krumo($wpdb->postmeta);
//		$wpdb->get_results("select post_id, meta_key, meta_value from wp_postmeta where meta_key = 'thesis_title' OR  meta_key = 'thesis_description' OR  meta_key = 'thesis_keywords' OR meta_key = 'thesis_noindex';");
	}
	
	/**
	 *	This takes the prepared data and puts in the target location.
	 */
	function import()
	{
		return 'doing import';
	}

}
add_filter('metathesis_get_targets', array( 'MetathesisImport', 'target' ) );
?>