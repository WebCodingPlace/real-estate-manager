<?php
	$max_width = apply_filters( 'rem_max_container_width', '1170px' );
?>
<section id="rem-agent-page" class="ich-settings-main-wrap">
	<div style="max-width:<?php echo esc_attr($max_width); ?>; width:100%; margin:0 auto;">
		<div class="row">
			<div class="col-sm-12 col-md-12">
				<div class="row">
					<div class="col-sm-4 col-md-4">
						<?php $agent_card = rem_get_option('agent_page_agent_card', 'enable');
							if ($agent_card == 'enable') {
								$agent_card_style = rem_get_option('agent_card_style', '1');  ?>
							<div class="agent-contact-wrapper agent-card-<?php echo esc_attr( $agent_card_style ); ?>">
							
								<?php do_action( 'rem_agent_box', $author_id, $agent_card_style ); ?>
							
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
															<div class="skillbar-title"><span><?php echo esc_attr($single_skill[0]); ?></span></div>
															<div class="skillbar-bar"></div>
															<div class="skill-bar-percent"><?php echo trim($single_skill[1]); ?></div>
														</div>
												<?php }
												
											}
										}
									?>
								</div>
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
							<?php
								$user_info = get_userdata($author_id);
								echo rem_wpml_translate($user_info->display_name, 'Agent', 'display_name_'.$author_id);
							?>
							</h1>
						</div>
						<br>
						<span class="text">
							<?php
								$description = get_user_meta( $author_id, 'description', true );
								echo rem_wpml_translate($description, 'Agent', 'description_'.$author_id);
							?>
						</span>
						<?php
							$agent_location = rem_get_option('agent_location', 'enable');
							$show_location = get_user_meta( $author_id, 'rem_user_location', true );
							
							if ($agent_location == 'enable' && $show_location == 'enable') {
								do_action( 'agent_page_location', $author_id ); 
							}
						?>
						<hr>
						<?php do_action( 'agent_page_contact_form', $author_id ); ?>
						<?php do_action( 'rem_single_agent_after_contact_form', $author_id ); ?>
					</div>
				</div>

			</div>				
		</div>
		
		<?php do_action( 'rem_single_agent_before_slider', $author_id ); ?>
		<?php

		$actual_props_args = array(
			'posts_per_page' => 10,
			'post_type' => 'rem_property',
			'author' => $author_id,
		);

		$actual_props_args = apply_filters( 'rem_agent_page_slider_args', $actual_props_args );

		$actual_properties = new WP_Query($actual_props_args);


        $additional_props_args = array(
			'posts_per_page' => 5,
			'post_type' => 'rem_property',
        	'meta_query' => array(
	            array(
	                'key'     => 'rem_property_multiple_agents',
	                'value'   => $author_id,
	                'compare' => 'LIKE',
	            ),
	        ),
        );

		$additional_properties = new WP_Query($additional_props_args);


		$listing_style = rem_get_option('agent_listing_style', '2');
		$property_style = apply_filters( 'rem_agent_page_slider_style', $listing_style );

		$the_query = new WP_Query();
		$the_query->posts = array_merge( $actual_properties->posts, $additional_properties->posts );
		?>

		<?php if ( is_array($the_query->posts) ) : ?>
			<div class="section-title line-style no-margin">
				<h3 class="title"><?php esc_attr_e( 'My Properties', 'real-estate-manager' ); ?></h3>
				<div class="pull-right">
					<a href="#" class="btn btn-sm my-listings-left"><i class="fa fa-angle-left"></i></a>
					<a href="#" class="btn btn-sm my-listings-right"><i class="fa fa-angle-right"></i></a>
				</div>
			</div>
			
			<section class="wcp-slick">
				<?php foreach($the_query->posts as $post) : setup_postdata( $post ); ?>
					<div class="my-property-wrap">
						<?php do_action('rem_property_box', $post->ID, $property_style, '_blank') ?>
					</div>
				<?php endforeach; ?>
			</section>

			<?php wp_reset_postdata(); ?>

		<?php else : ?>
			
		<?php endif; ?>

		<?php do_action( 'rem_single_agent_after_slider', $author_id ); ?>

	</div>
</section>