<?php
global $wp_query;

$big = 999999999; // need an unlikely integer

$pagination_links = paginate_links( array(
	
	'base'    => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
	'format'  => '?paged=%#%',
	'current' => max( 1, get_query_var( 'paged' ) ),
	'total'   => $wp_query->max_num_pages,
	'type'    => 'array'

) );

?>
<?php if ( $pagination_links ) { ?>
	<?php do_action( 'monolith_before_pagination', $loop ); ?>
	<div class="pagination-links">
		<ul class="pagination">
			<?php foreach ( $pagination_links AS $link ) { ?>
				<li><?php echo $link ?></li>
			<?php } ?>
		</ul>
	</div>
	<?php do_action( 'monolith_after_pagination', $loop ); ?>
<?php } ?>