<?php get_header();
	global $post;
	$author_id = $post->post_author;
	$author_info = get_userdata($author_id);
	$max_width = apply_filters( 'rem_max_container_width', '1170px' );
?>
		<section id="property-content" class="ich-settings-main-wrap" style="max-width: <?php echo $max_width; ?>;margin:0 auto;">

			<div class="">
				<div class="row">

					<div id="post-<?php the_ID(); ?>" <?php post_class('col-sm-12 col-md-12'); ?>>
					<?php if( have_posts() ){ while( have_posts() ){ the_post(); ?>
	
						<?php do_action( 'rem_single_property_slider', get_the_id() ); ?>
						<?php do_action( 'rem_single_property_contents', get_the_id() ); ?>
						
					<?php } } ?>
					</div>

				</div>
			</div>
		</section>
<?php get_footer(); ?>