<?php
/**
 * The template file for displaying property archives
 *
 * @package Real Estate Manager
 * @since REM 1.0
 */

get_header();
$max_width = apply_filters( 'rem_max_container_width', '1170px' );
$a_sidebar = rem_get_option('archive_sidebar', '');
?>
	<div class="ich-settings-main-wrap">
		<div style="max-width:<?php echo esc_attr($max_width); ?>; width:100%; margin:0 auto;">
			<h2><?php echo get_the_archive_title(); ?></h2>
			<?php if (!empty(get_the_archive_description())){ ?>
				<div class="rem-list-properties-description">
					<?php echo get_the_archive_description(); ?>
				</div>
			<?php } ?>
			<div class="row">
				<div class="<?php echo (is_active_sidebar( $a_sidebar )) ? 'col-sm-8 col-md-9' : 'col-sm-12'; ?>">
					<div class="row">
						<?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>
							<div id="property-<?php the_ID(); ?>" <?php post_class(rem_get_option('archive_page_cols', 'col-sm-3')); ?>>
								<?php do_action('rem_property_box', $post->ID, rem_get_option('archive_listing_style', '3')) ?>
							</div>
						<?php } } ?>
					</div>	
				</div>

				<?php if ( is_active_sidebar( $a_sidebar )  ) { ?>
					<div class="col-sm-4 col-md-3">
						<?php dynamic_sidebar( $a_sidebar ); ?>
					</div>
				<?php } ?>
			</div>
			<div class="row">
				<div class="col-sm-12">
					<?php do_action( 'rem_pagination' ); ?>
				</div>
			</div>
		</div>
	</div>
<?php get_footer(); ?>