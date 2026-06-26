<form class="form-contact contact-agent-form" method="post" role="form" data-toggle="validator" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>">
    <input type="hidden" name="agent_id" value="<?php echo esc_attr( $author_id ); ?>">
    <input type="hidden" name="action" value="rem_contact_agent">
    <input type="hidden" name="rem_contact_nonce" value="<?php echo wp_create_nonce( 'rem-contact-nonce' ); ?>" />
    <?php if(isset($_GET['property_id'])){ ?>
    	<input type="hidden" name="property_id" value="<?php echo intval($_GET['property_id']); ?>">
    <?php } else {
        global $post;
        if(isset($post->ID)){ ?>
            <input type="hidden" name="property_id" value="<?php echo intval($post->ID); ?>">
        <?php }
    } ?>
    <div class="row">
        <div class="col-md-6 col-sm-12">
            <label for="client_name"><?php esc_attr_e( 'Name', 'real-estate-manager' ); ?> *</label>
            <input name="client_name" id="client_name" type="text" class="form-control" required>
        </div>
        <div class="col-md-6 col-sm-12">
        	<label for="client_email"><?php esc_attr_e( 'Email', 'real-estate-manager' ); ?> *</label>
            <input type="email" class="form-control" name="client_email" id="client_email" required>
        </div>
        <div class="col-md-12 col-sm-12">
        	<label for="client_phone"><?php esc_attr_e( 'Phone', 'real-estate-manager' ); ?> *</label>
        	<input <?php echo esc_attr( $intlTelInputVars ); ?> type="<?php echo esc_attr( $phone_field ); ?>" class="form-control" name="client_phone" id="client_phone" required>
        </div>
        <div class="col-md-12 col-sm-12">
        	<label for="client_msg"><?php esc_attr_e( 'Your Message', 'real-estate-manager' ); ?> *</label>
            <textarea name="client_msg" id="client_msg" class="form-control text-form" required></textarea>
        </div>
        <div class="col-sm-12">
            <?php do_action( 'rem_agent_contact_before_submit', $author_id ); ?>
        </div>
        <div class="col-md-12 col-sm-12">
            <button type="submit" class="btn btn-default"><span class=""></span> <?php esc_attr_e( 'SEND MESSAGE', 'real-estate-manager' ); ?></button>
        </div>
    </div><!-- /.row -->
</form><!-- /.form -->
<br>
<div class="alert with-icon alert-info sending-email" style="display:none;" role="alert">
    <i class="icon fa fa-info"></i>
    <span class="msg"><?php esc_attr_e( 'Sending Email, Please Wait...', 'real-estate-manager' ); ?></span>
</div>