<div class="agent-contact-wrapper agent-card-<?php echo esc_attr( $agent_card_style ); ?>">
	<?php do_action( 'rem_agent_box', $author_id, $agent_card_style ); ?>

	<div class="contact-agent">
		<form method="post" class="contact-agent-form" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>" role="form" data-toggle="validator">
			<input type="hidden" name="agent_id" value="<?php echo esc_attr($author_id); ?>">
			<input type="hidden" name="action" value="rem_contact_agent">
			<input type="hidden" name="rem_contact_nonce" value="<?php echo wp_create_nonce( 'rem-contact-nonce' ); ?>" />
		    <?php global $post; if(isset($post->ID)){ ?>
		    	<input type="hidden" name="property_id" value="<?php echo esc_attr($post->ID); ?>">
		    <?php } ?>

			<div class="form-group">
	            <label for="client_name"><?php esc_attr_e( 'Name', 'real-estate-manager' ); ?> *</label>
	            <input name="client_name" id="client_name" type="text" class="form-control" required>
			</div>
			<div class="form-group">
	        	<label for="client_email"><?php esc_attr_e( 'Email', 'real-estate-manager' ); ?> *</label>
	            <input type="email" class="form-control" name="client_email" id="client_email" required>
			</div>
			<div class="form-group">
	        	<label for="client_phone"><?php esc_attr_e( 'Phone', 'real-estate-manager' ); ?> *</label>
	        	<input <?php echo esc_attr( $intlTelInputVars ); ?> type="<?php echo esc_attr($phone_field); ?>" class="form-control" name="client_phone" id="client_phone" required>
			</div>
			<div class="form-group">
	        	<label for="client_msg"><?php esc_attr_e( 'Your Message', 'real-estate-manager' ); ?> *</label>
	            <textarea name="client_msg" id="client_msg" class="form-control text-form" required></textarea>
			</div>
			<?php do_action( 'rem_agent_contact_before_submit', $author_id ); ?>
			<button class="btn btn-default" type="submit"><?php esc_attr_e( 'Send Message', 'real-estate-manager' ); ?></button>
		</form>
		<div class="alert with-icon alert-info sending-email" style="display:none;" role="alert">
			<i class="icon fa fa-info"></i>
			<span class="msg"><?php esc_attr_e( 'Sending Email, Please Wait...', 'real-estate-manager' ); ?></span>
		</div>
	</div>
</div>