<?php

class AIOSEOP_MetathesisImport extends MetathesisImport
{

	static function target( $targets = array() )
	{
		if ( !is_array($targets) )
			$targets = array();
		
		if ( class_exists( 'All_in_One_SEO_Pack' ) ):
			$targets[] = array(
				'name' => 'All in One SEO Pack',
				'type' => 'Plugin',
				'class' => 'AIOSEOP_MetathesisImport',
				'button' => 'Import Thesis Data',
				'desc' => 'Imports the thesis metadata into the equivalent fields in All in One SEO Pack plugin.',
			);
		endif;

		return $targets;
	}
	
	public function import()
	{
		$data = $this->export();
		foreach( $data as $post_id => $datum ):
			extract( $datum );
			update_post_meta( $post_id, '_aioseop_title', $thesis_title );
			update_post_meta( $post_id, '_aioseop_description', $thesis_description );
			update_post_meta( $post_id, '_aioseop_keywords', $thesis_keywords );
		endforeach;

		return true;
	}
}
add_filter( 'metathesis_get_targets', array( 'AIOSEOP_MetathesisImport', 'target' ) );
?>