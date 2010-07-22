<?php
/**
 *	Metathesis: All in One SEO Pack Import/Export
 */
class Metathesis_AIOSEOP extends Metathesis
{

	static function target( $targets = array() )
	{
		if ( !is_array($targets) )
			$targets = array();
		
		if ( class_exists( 'All_in_One_SEO_Pack' ) ):
			$targets[] = array(
				'target' => 'All in One SEO Pack',
				'type' => 'Plugin',
				'source' => 'Thesis Theme',
				'class' => 'Metathesis_AIOSEOP',
				'button' => 'Import Thesis Data',
				'desc' => 'Imports the Thesis theme metadata into the equivalent fields in the free version of the All in One SEO Pack plugin.',
			);
		endif;

		$targets = apply_filters( 'metathesis_target_aioseop', $targets );

		return $targets;
	}
	
	public function import()
	{
		$data = $this->export();
		$data = apply_filters( 'metathesis_import_aioseop', $data );
		
		foreach( $data as $post_id => $datum ):
			extract( $datum );
			update_post_meta( $post_id, '_aioseop_title', $thesis_title );
			update_post_meta( $post_id, '_aioseop_description', $thesis_description );
			update_post_meta( $post_id, '_aioseop_keywords', $thesis_keywords );
		endforeach;

		return true;
	}
}
add_filter( 'metathesis_targets', array( 'Metathesis_AIOSEOP', 'target' ) );
?>