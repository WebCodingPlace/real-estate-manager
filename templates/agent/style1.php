<?php
	$first_name = get_user_meta( $author_id, 'first_name', true );
	$last_name = get_user_meta( $author_id, 'last_name', true );
	$tagline = get_user_meta( $author_id, 'rem_user_tagline', true );
?>
<div class="agent-box-card grey">
	<div class="image-content">
		<div class="rem-profile-image">
			<?php do_action( 'rem_agent_picture', $author_id ); ?>
		</div>						
	</div>
	<div class="info-agent">
		<?php if (!is_author()) { ?>
			<span class="name">
				<?php 
					$user_info = get_userdata($author_id);
					echo rem_wpml_translate($user_info->display_name, 'Agent', 'display_name_'.$author_id);
				?>
			</span>
		<?php } ?>
		<?php if ($tagline != '') { ?>
			<div class="text text-center">
				<?php echo rem_wpml_translate($tagline, 'Agent', 'rem_user_tagline_'.$author_id); ?>
			</div>
		<?php } ?>
		<?php do_action( 'rem_contact_social_icons', $author_id ); ?>
	</div>
</div>