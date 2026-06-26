<?php get_header();
	global $post;
	$author_id = $post->post_author;
	$author_info = get_userdata($author_id);
	$max_width = apply_filters( 'rem_max_container_width', '1170px' );
	$sticky_class = '';
	if (rem_get_option('agent_sidebar_sticky') == 'enable'){
		$sticky_class = 'rem_sticky_sidebar';
	}
?>
		<section id="property-content" class="ich-settings-main-wrap" style="max-width: <?php echo esc_attr($max_width); ?>;margin:0 auto;">

			<div class="">
				<div class="row">
					<div class="col-sm-12">
						<div class="section-title line-style parent-listing-title">
                        	<h3 class="title"><a href="<?php echo get_permalink( $post->post_parent ) ?>"><?php echo get_the_title( $post->post_parent ); ?></a></h3>
                        </div>
					</div>
				</div>
				<div class="row">
					<?php if ( ! post_password_required($post) ) { ?>

						<div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-8 col-md-9'); ?>>
						<?php if( have_posts() ){ while( have_posts() ){ the_post();  ?>

							<?php
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
								do_action( 'rem_single_property_page_map', $post->post_parent );

								/**
								 * Hook: rem_single_property_page_tags.
								 */
								do_action( 'rem_single_property_page_tags', get_the_id() );

								/**
								 * Hook: rem_single_property_page_edit.
								 */
								do_action( 'rem_single_property_page_edit', get_the_id() );
							?>

						<?php } } ?>
						</div>
						
						<div class="col-sm-4 col-md-3 <?php echo esc_attr($sticky_class); ?>">
							<?php
								do_action( 'rem_single_property_agent', $author_id );
								$p_sidebar = rem_get_option('property_page_sidebar', '');
								if ( is_active_sidebar( $p_sidebar )  ) {
									dynamic_sidebar( $p_sidebar );
								}
							?>
						</div>
					<?php } else {
						echo get_the_password_form();
					} ?>

				</div>
			</div>
		</section>
<?php get_footer(); ?>