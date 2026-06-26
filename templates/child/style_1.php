<?php get_header();
	global $post;
	$author_id = $post->post_author;
	$max_width = apply_filters( 'rem_max_container_width', '1170px' );
	$sticky_class = '';
	if (rem_get_option('agent_sidebar_sticky') == 'enable'){
		$sticky_class = 'rem_sticky_sidebar';
	}
	$parent_id = $post->post_parent;
?>
		<div id="rem-listing-<?php the_ID(); ?>" class="ich-settings-main-wrap rem-listing-top rem-single-listing-1 bg-white">
			<div class="container" style="max-width: <?php echo esc_attr($max_width); ?>;margin:0 auto;">
				<div class="row">
					<div class="col-sm-6">
						<a href="<?php echo get_permalink( $parent_id ) ?>">
							<h1><?php echo get_the_title( $parent_id ); ?></h1>
						</a>
						<span class="badge-under-heading"><?php echo rem_get_field_value('property_purpose', $parent_id); ?></span>
						<address class="ich-settings-main-wrap">
							<i class="fa fa-map-marker-alt" aria-hidden="true"></i>
							<?php echo rem_get_field_value('property_address', $parent_id); ?>
						</address>
					</div>
					<div class="col-sm-6 text-right">
						<ul class="list-unstyled">
							<li class="rem-listing-price">
								<?php echo rem_get_field_value('property_price', $parent_id); ?>
							</li>
							<li class="rem-listing-area">
								<?php echo rem_get_field_value('property_area', $parent_id); ?>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>

		<div id="rem-listing-<?php the_ID(); ?>" class="ich-settings-main-wrap rem-single-listing-1 rem-listing-gallery bg-white">
			<div class="container" style="max-width: <?php echo esc_attr($max_width); ?>;margin:0 auto;">
				<div class="row">
					<div class="col-sm-12">
						<?php
							/**
							 * Hook: rem_single_property_page_slider.
							 */
							do_action( 'rem_single_property_page_slider', get_the_id() );
						?>
					</div>
				</div>
			</div>
		</div>

		<div id="rem-listing-<?php the_ID(); ?>" class="ich-settings-main-wrap rem-listing-content rem-single-listing-1">
			<div class="container" style="max-width: <?php echo esc_attr($max_width); ?>;margin:0 auto;">
			<?php
			if ( ! post_password_required($post) ) {
				if( have_posts() ){
					while( have_posts() ){
						the_post();  ?>
						<div class="row">
							<div class="col-lg-8 col-md-12">
								<div class="rem-block-wrap">
									<h2><?php the_title(); ?></h2>
									<div class="description">
										<?php the_content(); ?>
									</div>
								</div>
								<div id="rem-property-content">
								<?php
									/**
									 * Hook: rem_single_property_page_contents.
									 */
									do_action( 'rem_single_property_page_childs', get_the_id() );

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
								?>
								</div>
							</div>
							<div class="col-lg-4 col-md-12 <?php echo esc_attr($sticky_class); ?>">
								<?php
									do_action( 'rem_single_property_agent', $author_id );
									$p_sidebar = rem_get_option('property_page_sidebar', '');
									if ( is_active_sidebar( $p_sidebar )  ) {
										dynamic_sidebar( $p_sidebar );
									}
								?>
							</div>
						</div>
			<?php
				 	}
				}
			} else {
				echo get_the_password_form();
			}
			?>
			</div>
		</div>
<?php get_footer(); ?>