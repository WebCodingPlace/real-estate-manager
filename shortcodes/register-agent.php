<div class="ich-settings-main-wrap">
	<form id="agent_login">
		<section id="rem-agent-page">
			<div class="row">
				<div class="col-sm-12">
					<?php
						global $rem_ob;
						$field_tabs = rem_get_agent_fields_tabs();
						$agent_fields = $rem_ob->get_agent_fields();

						$wpml_current_language = apply_filters( 'wpml_current_language', NULL );
						if ($wpml_current_language) {
							echo '<input type="hidden" name="wpml_user_email_language" value="'.$wpml_current_language.'">';
						}
						
				        // checking for the tabs which have fields
				        $valid_tabs = array();
				        foreach ($field_tabs as $tab_key => $tab_title) {
				            foreach ($agent_fields as $field) {
				                $field_tab = (isset($field['tab'])) ? $field['tab'] : '' ;
				                if ($field_tab == $tab_key && !in_array($field_tab, $valid_tabs)) {
				                   $valid_tabs[] = $field_tab; 
				                }
				            }
				        }						

					foreach ($field_tabs as $tab_name => $tab_title) {
						if (in_array($tab_name, $valid_tabs)) { ?>
						<div class="tab-wrap-<?php echo esc_attr($tab_name); ?>"></div>
						<div class="section-title line-style no-margin <?php echo esc_attr($tab_name); ?>">
							<h3 class="title"><?php echo esc_attr($tab_title); ?></h3>
						</div>
						<ul class="profile create">
							<?php foreach ($agent_fields as $field) {
								if (isset($field['tab']) && $field['tab'] == $tab_name && isset($field['display']) && in_array('register', $field['display'])) {
									$this->render_registration_field($field);
								}
							} ?>
						</ul>
						<br>
						<?php } ?>
					<?php } ?>
					<?php if (rem_get_option('agent_location') == 'enable') { ?>
						<input type="hidden" id="agent_longitude" name="agent_longitude">
						<input type="hidden" id="agent_latitude" name="agent_latitude">
						<div class="tab-wrap-location"></div>
						<div class="section-title line-style no-margin location">
							<h3 class="title"><?php esc_attr_e( 'Location', 'real-estate-manager' ); ?></h3>
						</div>
						<ul class="profile create">
							<?php if (rem_get_option('use_map_from', 'leaflet') == 'google_maps') { ?>
								<input type="text" class="form-control" id="search-map" placeholder="<?php esc_attr_e( 'Type to Search...', 'real-estate-manager' ); ?>">
							<?php } ?>
							
							<div id="map-canvas" style="height: 300px"></div>

							<div id="position"><i class="fa fa-map-marker-alt"></i> <?php esc_attr_e( 'Drag the pin to the location on the map', 'real-estate-manager' ); ?></div>
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
				<?php if ($required_text != '') { ?>
					<div class="col-sm-12">
						<label><input type="checkbox" required> <?php echo wp_kses_post($required_text); ?></label>
					</div>
				<?php } ?>
				<?php do_action( 'rem_register_agent_before_register_button' ); ?>
					<div class="col-sm-12">
						<button class="btn btn-default signin-button" type="submit"><i class="far fa-hand-point-right"></i> <?php esc_attr_e( 'Sign up', 'real-estate-manager' ); ?></button>
					</div>
			</div>
		</section>
	</form>
</div>