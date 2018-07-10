<div class="ich-settings-main-wrap">
	<div class="row <?php echo ($masonry == 'enable') ? 'masonry-agents' : '' ; ?>">
		<?php foreach ($agents as $agent) { ?>
			<div class="<?php echo $columns; ?> rem-agent-container">
				<div class="agent-box-card grey">
					<div class="image-content">
						<div class="rem-profile-image">
							<?php do_action( 'rem_agent_picture', $agent->ID ); ?>
						</div>						
					</div>
					<div class="info-agent">
						<span class="name">
							<?php echo get_user_meta( $agent->ID, 'first_name', true ); ?>
							<?php echo get_user_meta( $agent->ID, 'last_name', true ); ?>								
						</span>
						<div class="text">
							<?php echo get_user_meta( $agent->ID, 'rem_user_tagline', true ); ?>
						</div>
						<?php do_action( 'rem_contact_social_icons', $agent->ID ); ?>
					</div>
				</div>
			</div>
		<?php } ?>
	</div>
</div>