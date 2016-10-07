<?php
/*
Template Name: Full Width
 *
 * @package FoundationPress
 * @since FoundationPress 1.0.0
*/
get_header(); ?>

<?php get_template_part( 'template-parts/header-standard' ); ?>


	<div id="page-full-width" role="main">
		<?php do_action( 'foundationpress_before_content' ); ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<article <?php post_class('main-content') ?> id="post-<?php the_ID(); ?>">
				<?php do_action( 'foundationpress_page_before_entry_content' ); ?>
				<div class="entry-content">
					<?php the_content(); ?>


<?php monolith_grid('card', 'row small-up-1 medium-up-2 large-up-4',
  array(
    'has_image'    => true,
    'has_summary'  => false,
    'has_readmore' => false,
  ),
  array(
      'post_type'      => 'page',
      'posts_per_page' => - 1,
    )
  );
?>



				</div>
			</article>
		<?php endwhile;?>
		<?php do_action( 'foundationpress_after_content' ); ?>
	</div>


<?php get_footer();