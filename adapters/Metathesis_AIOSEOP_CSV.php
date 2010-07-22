<?php
/**
 *	Metathesis All in One SEO Pack to CSV Export
 */
class Metathesis_AIOSEOP_CSV extends Metathesis
{
	static function target( $targets = array() )
	{
		if ( !is_array( $targets ) )
			$targets = array();

		$targets = apply_filters( 'metathesis_target_aioseop_csv', $targets );

		if ( class_exists('All_in_One_SEO_Pack') ):
			$targets[] = array(
				'target' => 'CSV File',
				'type' => 'File',
				'source' => 'All in One SEO Pack',
				'class' => 'Metathesis_AIOSEOP_CSV',
				'button' => 'Download CSV File',
				'desc' => 'Exports the All in One SEO metadata as a CSV file.',
			);
		endif;

		return $targets;
	}

	protected function export()
	{
		global $wpdb;
		$data = array();
		
		$posts = $wpdb->get_results("select post_id, meta_key, meta_value from {$wpdb->postmeta} where meta_key = '_aioseop_title' OR  meta_key = '_aioseop_description' OR  meta_key = '_aioseop_keywords';");
		foreach( $posts as $post ):
			$data[$post->post_id][$post->meta_key] = $post->meta_value;
		endforeach;

		$data = apply_filters( 'metathesis_export_aioseop_csv', $data );

		return $data;
	}
	
	function import()
	{
		$data = $this->export();
		$data = apply_filters( 'metathesis_import_aioseop_csv', $data );

		$defaults = array('post_id' => '', '_aioseop_title' => '', '_aioseop_description' => '', '_aioseop_keywords' => '');
		$defaults = apply_filters( 'metathesis_import_aioseop_csv_defaults', $data );		
		
		$export = fopen( 'php://temp/maxmemory:' . (5*1024*1024), 'r+' );
		fputcsv( $export, array( 'post_id' => 'post_id', '_aioseop_title' => 'title', '_aioseop_description' => 'description', '_aioseop_keywords' => 'keywords' ) );
		
		foreach($data as $id => $datum ):
			$defaults['post_id'] = $id;
			$datum = array_merge( $defaults, $datum );
			extract( $datum );
			fputcsv( $export, array( $post_id, $_aioseop_title, $_aioseop_description, $_aioseop_keywords ) );
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
add_filter( 'metathesis_targets', array( 'Metathesis_AIOSEOP_CSV', 'target' ) );
?>