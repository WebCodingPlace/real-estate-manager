<?php get_header();
	global $post;
	$author_id = $post->post_author;
	$author_info = get_userdata($author_id);
	$max_width = apply_filters( 'rem_max_container_width', '1170px' );
?>
		<section id="property-content" class="ich-settings-main-wrap" style="max-width: <?php echo esc_attr($max_width); ?>;margin:0 auto;">

			<div class="">
				<div class="row">
					<div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-12 col-md-12'); ?>>
					<?php if( have_posts() ){ while( have_posts() ){ the_post();

						/**
						 * Hook: rem_single_property_page_slider.
						 */
						do_action( 'rem_single_property_page_slider', get_the_id() );

						/**
						 * Hook: rem_single_property_page_title.
						 */
						do_action( 'rem_single_property_page_title', get_the_id() );

						/**
						 * Hook: rem_single_property_page_contents.
						 */
						do_action( 'rem_single_property_page_contents', get_the_id() );

						/**
						 * Hook: rem_single_property_page_sections.
						 */
						do_action( 'rem_single_property_page_sections', get_the_id() );

						/**
						 * Hook: rem_single_property_page_features.
						 */
						do_action( 'rem_single_property_page_features', get_the_id() );

						/**
						 * Hook: rem_single_property_page_map.
						 */
						do_action( 'rem_single_property_page_map', get_the_id() );

						/**
						 * Hook: rem_single_property_page_tags.
						 */
						do_action( 'rem_single_property_page_tags', get_the_id() );

						/**
						 * Hook: rem_single_property_page_edit.
						 */
						do_action( 'rem_single_property_page_edit', get_the_id() );
						
					} } ?>
					</div>
				</div>
			</div>
		</section>
<?php get_footer(); ?>