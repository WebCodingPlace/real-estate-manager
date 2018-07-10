<div class="agent-box-card grey">
	<div class="image-content">
		<div class="rem-profile-image">
			<?php do_action( 'rem_agent_picture', $author_id ); ?>
		</div>						
	</div>
	<div class="info-agent">
		<?php if (!is_author()) { ?>
			<span class="name">
				<?php echo get_user_meta( $author_id, 'first_name', true ); ?>
				<?php echo get_user_meta( $author_id, 'last_name', true ); ?>									
			</span>
		<?php } ?>
		<?php if (get_user_meta( $author_id, 'rem_user_tagline', true ) != '') { ?>
			<div class="text text-center">
				<?php echo get_user_meta( $author_id, 'rem_user_tagline', true ); ?>
			</div>
		<?php } ?>
		<?php do_action( 'rem_contact_social_icons', $author_id ); ?>
	</div>
</div>