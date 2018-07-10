<div class="agent-box-card grey">
	<div class="image-content">
		<div class="rem-profile-image">
			<?php do_action( 'rem_agent_picture', $author_id ); ?>
		</div>						
	</div>
	<div class="info-agent" style="padding-bottom:0;">
		<?php if (!is_author()) { ?>
			<span class="name">
				<?php echo get_user_meta( $author_id, 'first_name', true ); ?>
				<?php echo get_user_meta( $author_id, 'last_name', true ); ?>									
			</span>
		<?php } ?>
		<?php
			$user_info = get_userdata($author_id);
			$email = $user_info->user_email;
			$phone = get_user_meta( $author_id, 'rem_mobile_url' , true );
		?>
		<ul class="list">
			<li style="padding:10px;"><b><i class="fas fa-phone"></i> :</b> <?php echo $phone; ?></li>
			<li style="padding:10px;"><b><i class="fas fa-envelope"></i> :</b> <?php echo $email; ?></li>
		</ul>
		<?php if (!is_author()) { ?>
			<a href="<?php echo get_author_posts_url( $author_id ); ?>" class="btn btn-default btn-block"><?php _e( 'More Info', 'real-estate-manager' ); ?></a>
		<?php } ?>
	</div>
</div>