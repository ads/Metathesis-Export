<?php
/**
 *	Metathesis: Thesis -> All in One SEO Pack Import/Export
 */
class Metathesis_Thesis extends Metathesis
{

	static function target( $targets = array() )
	{
		if ( !is_array($targets) )
			$targets = array();
		
		if ( class_exists( 'All_in_One_SEO_Pack' ) ):
			$targets[] = array(
				'target' => 'Thesis',
				'type' => 'Theme',
				'source' => 'All in One SEO Pack plugin',
				'class' => 'Metathesis_Thesis',
				'button' => 'Import AIOSEOP Data',
				'desc' => 'Imports the All in One SEO Pack plugin metadata into the equivalent fields in the Thesis Theme.',
			);
		endif;

		$targets = apply_filters( 'metathesis_target_thesis', $targets );

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

		$data = apply_filters( 'metathesis_export_thesis', $data );

		return $data;
	}
	
	public function import()
	{
		$data = $this->export();
		$data = apply_filters( 'metathesis_import_thesis', $data );
		
		foreach( $data as $post_id => $datum ):
			extract( $datum );
			update_post_meta( $post_id, 'thesis_title', $_aioseop_title );
			update_post_meta( $post_id, 'thesis_description', $_aioseop_description );
			update_post_meta( $post_id, 'thesis_keywords', $_aioseop_keywords );
		endforeach;

		return true;
	}
}
add_filter( 'metathesis_targets', array( 'Metathesis_Thesis', 'target' ) );
?>