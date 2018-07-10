<div class="ich-settings-main-wrap">
<form id="agent_login" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-redirect="<?php echo $redirect; ?>">
	<section id="rem-agent-page">
		<div class="row">
				<input type="hidden" value="rem_agent_register" name="action">
				<div class="col-sm-12">
					<?php
						global $rem_ob;
						$field_tabs = rem_get_agent_fields_tabs();
						$agent_fields = $rem_ob->get_agent_fields();

					foreach ($field_tabs as $tab_name => $tab_title) { ?>
						<div class="section-title line-style no-margin">
							<h3 class="title"><?php echo $tab_title; ?></h3>
						</div>
						<ul class="profile create">
							<?php foreach ($agent_fields as $field) {
								if (isset($field['tab']) && $field['tab'] == $tab_name && in_array('register', $field['display'])) {
									$this->render_registration_field($field);
								}
							} ?>
						</ul>
						<br>
					<?php } ?>
						
				</div>
				<?php if (rem_get_option('captcha_on_registration') == 'on') { ?>
					<script src='https://www.google.com/recaptcha/api.js'></script>
					<div class="col-sm-12">
						<div class="g-recaptcha" data-sitekey="<?php echo rem_get_option('captcha_site_key', '6LcDhUQUAAAAAFAsfyTUPCwDIyXIUqvJiVjim2E9'); ?>"></div>
					</div>
				<?php } ?>
				<?php do_action( 'rem_register_agent_before_register_button' ); ?>
				<div class="col-sm-12">
					<button class="btn btn-default signin-button" type="submit"><i class="fa fa-sign-in"></i> <?php _e( 'Sign up', 'real-estate-manager' ); ?></button>
				</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<br><br>
				<div class="alert with-icon alert-info agent-register-info" style="display:none;" role="alert">
					<span class="glyphicon glyphicon-info-sign pull-left"></span>
					&nbsp;
					<span class="msg"></span>
				</div>
			</div>			
		</div>
	</section>
</form>
</div>