<?php
/**
 * Retrieve all custom taxonomy capabilities
 *
 * @param string $taxonomy
 * @return array
 */
function myapp_get_all_taxonomy_capabilities_mapped( $taxonomy )
{
	return array(
		'manage_terms' => "manage_$taxonomy",
		'edit_terms'   => "edit_$taxonomy",
		'delete_terms' => "delete_$taxonomy",
		'assign_terms' => "assign_$taxonomy",
	);	
}