<?php get_header();
    global $wp_query;
    $curauth = $wp_query->get_queried_object();
    $author_info = $curauth;
    $author_id = $curauth->ID;
    $max_width = apply_filters( 'rem_max_container_width', '1170px' );
?>
<section id="rem-agent-page" class="ich-settings-main-wrap">
	<div style="max-width:<?php echo $max_width; ?>; width:100%; margin:0 auto;">
		<div class="row">				

			<div class="col-sm-12 col-md-12">
				<div class="row">
					<div class="col-sm-4 col-md-4 col-xs-12">
						<?php $agent_card = rem_get_option('agent_page_agent_card', 'enable');
							if ($agent_card == 'enable') { ?>
							
							<?php
								$agent_card_style = rem_get_option('agent_card_style', '1'); 
								do_action( 'rem_agent_box', $author_id, $agent_card_style );
							?>
							
						<div class="skill-box">
							<?php
								$author_skills = get_user_meta( $author_id, 'rem_user_skills', true );
								$allskills = explode(PHP_EOL, $author_skills);
								if (is_array($allskills)) {
									foreach ($allskills as $skill) {
										$single_skill = explode(',', $skill);
										if (isset($single_skill[0]) && isset($single_skill[1])) {
												?>
												<div class="skillbar" data-percent="<?php echo trim($single_skill[1]); ?>">
													<div class="skillbar-title"><span><?php echo $single_skill[0]; ?></span></div>
													<div class="skillbar-bar"></div>
													<div class="skill-bar-percent"><?php echo trim($single_skill[1]); ?></div>
												</div>
										<?php }
										
									}
								}
							?>
						</div>

						<?php } ?>

						<?php
							$p_sidebar = rem_get_option('agent_page_sidebar', '');
						    if ( is_active_sidebar( $p_sidebar )  ) :
						        dynamic_sidebar( $p_sidebar ); 
						    endif;
						?>
					</div>				
					<div class="col-sm-8 col-md-8 col-xs-12">
						<div class="section-title line-style no-margin">
							<h1 class="name title">
								<?php echo get_user_meta( $author_id, 'first_name', true ); ?>
								<?php echo get_user_meta( $author_id, 'last_name', true ); ?>
							</h1>
						</div>
						<br>
						<span class="text">
							<?php echo get_user_meta( $author_id, 'description', true ); ?>
						</span>
						<hr>
						<?php do_action( 'agent_page_contact_form', $author_id ); ?>
						<?php do_action( 'rem_single_agent_after_contact_form', $author_id ); ?>
					</div><!-- /.col-md-8 -->
				</div>

			</div>				
		</div>
		<?php do_action( 'rem_single_agent_before_slider', $author_id ); ?>
		<?php 
		$property_args = array(
			'posts_per_page' => 10,
			'post_type' => 'rem_property',
			'author' => $author_id,
		);
		$the_query = new WP_Query( $property_args ); ?>

		<?php if ( $the_query->have_posts() ) : ?>
			<div class="section-title line-style no-margin">
				<h3 class="title"><?php _e( 'My Properties', 'real-estate-manager' ); ?></h3>
			</div>
			
			<section class="wcp-slick">
				<?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
					<div style="padding:10px;">
						<?php do_action('rem_property_box', $post->ID, 3, '_blank') ?>
					</div>
				<?php endwhile; ?>
			</section>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			
		<?php endif; ?>

		<?php do_action( 'rem_single_agent_after_slider', $author_id ); ?>

	</div><!-- ./container -->
</section>
<?php get_footer(); ?>