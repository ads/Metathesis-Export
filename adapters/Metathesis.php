<?php
/**
 *	Metathesis Import/Export Base Class
 */
class Metathesis
{
	/**
	 *	Modifies the $targets array with the metathesis_get_targets filter
	 *
	 *	@param $targets array An array passed in by the filter. Your class can add or remove items, but most of the time they just add their own and pass it along
	 *	@return array The modified $targets array
	 */
	static function target( $targets = array() )
	{
		if ( !is_array( $targets ) )
			$targets = array();

		$targets = apply_filters( 'metathesis_target', $targets );

		if ( class_exists('Metathesis') ):
			$targets[] = array(
				'target' => 'CSV File',
				'type' => 'File',
				'source' => 'Thesis Theme',
				'class' => 'Metathesis',
				'button' => 'Download CSV File',
				'desc' => 'Exports the Thesis SEO metadata as a CSV file',
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

		$data = apply_filters( 'metathesis_export', $data );

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
		$data = apply_filters( 'metathesis_import', $data );

		$defaults = array('post_id' => '', 'thesis_title' => '', 'thesis_description' => '', 'thesis_keywords' => '', 'thesis_noindex' => '');
		$defaults = apply_filters( 'metathesis_import_defaults', $data );		
		
		$export = fopen( 'php://temp/maxmemory:' . (5*1024*1024), 'r+' );
		fputcsv( $export, array( 'post_id' => 'post_id', 'thesis_title' => 'title', 'thesis_description' => 'description', 'thesis_keywords' => 'keywords', 'thesis_noindex' => 'noindex' ) );
		
		foreach($data as $id => $datum ):
			$defaults['post_id'] = $id;
			$datum = array_merge( $defaults, $datum );
			extract( $datum );
			fputcsv( $export, array( $post_id, $thesis_title, $thesis_description, $thesis_keywords, $thesis_noindex ) );
		endforeach;

		rewind( $export );
		$csv = stream_get_contents( $export );
		fclose( $export );
		
		header( 'Content-type: application/octet-stream' );
		header( 'Content-Disposition: attachment; filename="metathesis-export.csv"' );
		echo $csv;

		exit();
	}

}
add_filter( 'metathesis_targets', array( 'Metathesis', 'target' ) );
?>