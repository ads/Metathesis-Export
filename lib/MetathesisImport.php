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
	protected function export()
	{
		global $wpdb;
		$data = array();
		
		$posts = $wpdb->get_results("select post_id, meta_key, meta_value from {$wpdb->postmeta} where meta_key = 'thesis_title' OR  meta_key = 'thesis_description' OR  meta_key = 'thesis_keywords' OR meta_key = 'thesis_noindex';");
		foreach( $posts as $post ):
			$data[$post->post_id][$post->meta_key] = $post->meta_value;
		endforeach;
		return $data;
	}
	
	/**
	 *	This takes the prepared data and imports it into the target location. In this case its converted to CSV format,
	 *	and pushed out to the users browser as a download.
	 *	
	 *	@return void This script returns output to the browser and exits the process.
	 */
	function import()
	{
		$data = $this->export();
		$default = array('post_id' => '', 'thesis_title' => '', 'thesis_description' => '', 'thesis_keywords' => '', 'thesis_noindex' => 0);
		
		$export = fopen('php://temp/maxmemory:'. (5*1024*1024), 'r+');

		fputcsv($export, array('post_id' => 'post_id', 'thesis_title' => 'title', 'thesis_description' => 'description', 'thesis_keywords' => 'keywords', 'thesis_noindex' => 'noindex') );
		foreach($data as $id => $datum ):
			$default['post_id'] = $id;
			$datum = array_merge( $default, $datum );
			extract( $datum );
			fputcsv( $export, array( $post_id, $thesis_title, $thesis_description, $thesis_keywords, $thesis_noindex ) );
		endforeach;
		rewind( $export );
		$csv = stream_get_contents( $export );
		fclose( $export );
		
		header('Content-type: application/octet-stream');
		header('Content-Disposition: attachment; filename="metathesis-export.csv"');
		echo $csv;
		exit();
	}

}
add_filter('metathesis_get_targets', array( 'MetathesisImport', 'target' ) );
?>