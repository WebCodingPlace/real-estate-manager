<div class="agent-box-card grey">
	<div class="image-content">
		<div class="rem-profile-image">
			<?php do_action( 'rem_agent_picture', $author_id ); ?>
		</div>						
	</div>
	<div class="info-agent" style="padding-bottom:0;">
		<?php if (!is_author()) { ?>
			<span class="name">
				<?php 
					$user_info = get_userdata($author_id);
					echo rem_wpml_translate($user_info->display_name, 'Agent', 'display_name_'.$author_id);
				?>
			</span>
		<?php } ?>
		<?php
			$user_info = get_userdata($author_id);
			$email = $user_info->user_email;
			$phone = get_user_meta( $author_id, 'rem_mobile_url' , true );
		?>
		<ul class="list">
			<?php if ($email != '') { ?>
				<li style="padding:10px;"><b><i class="fas fa-envelope"></i> :</b> <?php echo esc_attr($email); ?></li>
			<?php } ?>
			<?php
				global $rem_ob;
				$agent_fields = $rem_ob->get_agent_fields();
	            foreach ($agent_fields as $field) {
	                if ((isset($field['display']) && in_array('card', $field['display']) && get_user_meta( $author_id, $field['key'] , true ) != '') || $field['key'] == 'rem_agent_url') {
	                    $url = get_user_meta( $author_id, $field['key'] , true );
	                    $url = rem_wpml_translate($url, 'Agent', $field['key'].'_'.$author_id);
	                    $target = '_blank';
	                    if ($url != '' && $url != 'disable') { ?>
	                        <li style="padding:10px;"><b><i class="<?php echo esc_attr($field['icon_class']); ?>"></i> :</b> <?php echo esc_url($url); ?></li>
	                    <?php
	                    } 
	                }
	            } ?>
		</ul>
		<?php if (!is_author()) { ?>
			<a href="<?php echo get_author_posts_url( $author_id ); ?>" class="btn btn-default btn-block"><?php esc_attr_e( 'More Info', 'real-estate-manager' ); ?></a>
		<?php } ?>
	</div>
</div>