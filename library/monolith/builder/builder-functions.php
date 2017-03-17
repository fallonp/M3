<?php

/**
 * Bootstrap function for this class so it can be called directly from a theme in Wordpress style
 *
 * @param string|null $layout The layout file to use
 * @param array|null $args The arguments to be passed to the function
 * @param object|null $query The Wordpress WP_Query object to be used
 */
function monolith_build( $layout = null, $args = null, $query = null, $cache = null ) {
	new Bigspring\Monolith\Builder( $layout, $args, $query, $cache );
}

function monolith_grid( $part = null, $classes = null, $args = null, $query = null, $cache = null ) {
	
	if ( $classes ) { // ensure we set the right builder arg for the size parameter
		$args['classes'] = $classes;
	}
	
	new Bigspring\Monolith\Builder( array( 'layout' => 'grid', 'part' => $part ), $args, $query, $cache );
}

function monolith_accordion( $args = null, $query = null, $cache = null ) {
	new Bigspring\Monolith\Builder( array(
		'layout' => 'accordion',
		'part'   => 'accordion-item'
	), $args, $query, $cache );
}

function monolith_list( $classes = null, $args = null, $query = null, $cache = null ) {
	if ( $classes ) { // ensure we set the right builder arg for the size parameter
		$args['classes'] = $classes;
	}
	new Bigspring\Monolith\Builder( array( 'layout' => 'list', 'part' => 'list-item' ), $args, $query, $cache );
}

function monolith_tabs( $args = null, $query = null, $cache = null ) {
	new Bigspring\Monolith\Builder( array( 'layout' => 'tabs', 'part' => 'tab-item' ), $args, $query, $cache );
}
