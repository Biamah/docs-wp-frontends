<?php
/**
 * Add custom capabilities to a role
 *
 * @param string $role_name
 * @param string|array $capabilities
 * @return void
 */
function myapp_add_capabilities_to_role( $role_name, $capabilities ) {
	if ( ! is_array( $capabilities ) ) {
		$role = get_role( $role_name );
		return $role->add_cap( $capabilities );
	}

	foreach ( $capabilities as $cap )
		myapp_add_capabilities_to_role( $role_name, $cap );
}