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
}
add_filter( 'metathesis_get_targets', array( 'AIOSEOP_MetathesisImport', 'target' ) );
?>