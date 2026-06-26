<?php

/**
 * Single Property Template for Divi Theme
 */

get_header();
global $post;
$author_id = $post->post_author;
$author_info = get_userdata($author_id);
$max_width = apply_filters( 'rem_max_container_width', '1170px' );
$is_page_builder_used = et_pb_is_pagebuilder_used( get_the_ID() );
$sticky_class = '';
if (rem_get_option('agent_sidebar_sticky') == 'enable'){
	$sticky_class = 'rem_sticky_sidebar';
}
?>

<div id="main-content">

<?php if ( ! $is_page_builder_used ) : ?>

	<div class="container">
		<div id="content-area" class="clearfix">
			<div id="left-area">

<?php endif; ?>

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				<?php if ( ! $is_page_builder_used ) : ?>

					<h1 class="entry-title main_title"><?php the_title(); ?></h1>
				<?php
					$thumb = '';

					$width = (int) apply_filters( 'et_pb_index_blog_image_width', 1080 );

					$height = (int) apply_filters( 'et_pb_index_blog_image_height', 675 );
					$classtext = 'et_featured_image';
					$titletext = get_the_title();
					$alttext = get_post_meta( get_post_thumbnail_id(), '_wp_attachment_image_alt', true );
					$thumbnail = get_thumbnail( $width, $height, $classtext, $alttext, $titletext, false, 'Blogimage' );
					$thumb = $thumbnail["thumb"];

					if ( 'on' === et_get_option( 'divi_page_thumbnails', 'false' ) && '' !== $thumb )
						print_thumbnail( $thumb, $thumbnail["use_timthumb"], $alttext, $width, $height );
				?>

				<?php endif; ?>

					<div class="entry-content">
						<section id="property-content" class="ich-settings-main-wrap" style="padding:0 !important;max-width: <?php echo esc_attr($max_width); ?>;margin:0 auto;">
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
						</section>
					</div> <!-- .entry-content -->

				<?php
					if ( ! $is_page_builder_used && comments_open() && 'on' === et_get_option( 'divi_show_pagescomments', 'false' ) ) comments_template( '', true );
				?>

				</article> <!-- .et_pb_post -->

			<?php endwhile; ?>

<?php if ( ! $is_page_builder_used ) : ?>

			</div> <!-- #left-area -->
			
			<div id="sidebar" class="ich-settings-main-wrap">
			<div class="<?php echo esc_attr($sticky_class); ?>">
					
				<?php
					do_action( 'rem_single_property_agent', $author_id );
					$p_sidebar = rem_get_option('property_page_sidebar', '');
					if ( is_active_sidebar( $p_sidebar )  ) {
						dynamic_sidebar( $p_sidebar );
					}
				?>				
			</div>
			</div>
		</div> <!-- #content-area -->
	</div> <!-- .container -->

<?php endif; ?>

</div> <!-- #main-content -->

<?php

get_footer();
