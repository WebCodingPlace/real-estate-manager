<div class="ich-settings-main-wrap" id="rem-agent-page">
<form action="" id="agent-profile-form">
	<input type="hidden" name="action" value="rem_save_profile_front">
	<input type="hidden" name="agent_id" value="<?php echo esc_attr($agent_id); ?>">
	<input type="hidden" class="rem-ajax-url" value="<?php echo admin_url('admin-ajax.php'); ?>">

	<?php
		global $rem_ob;
		$field_tabs = rem_get_agent_fields_tabs();
		$agent_fields = $rem_ob->get_agent_fields();

	foreach ($field_tabs as $tab_name => $tab_title) { ?>
	<?php echo ($tab_name != 'personal_info') ? '<br>' : '' ; ?>
		<div class="section-title line-style no-margin">
			<h3 class="title"><?php echo esc_attr($tab_title); ?></h3>
		</div>
		<ul class="profile edit-agent-profile">
			<?php if ($tab_name == 'personal_info') { ?>
				<li>
					<span><?php esc_attr_e( 'Username', 'real-estate-manager' ); ?></span> <?php echo esc_attr($current_user->user_login); ?>
					<i class="icon fa fa-lock"></i>
				</li>
			<?php } ?>
			<?php
				foreach ($agent_fields as $field) {
					if (isset($field['tab']) && $field['tab'] == $tab_name && isset($field['display']) && in_array('edit', $field['display'])) {
						$this->render_agent_edit_field($field, $agent_id);
					}
				}
			?>
		</ul>
		<?php } ?>
		<?php if (rem_get_option('agent_location') == 'enable') {
			?>
			<input type="hidden" id="agent_longitude" name="agent_longitude" value="<?php echo esc_attr($agent_longitude); ?>">
			<input type="hidden" id="agent_latitude" name="agent_latitude" value="<?php echo esc_attr($agent_latitude); ?>">
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

		<?php do_action( 'rem_edit_agent_before_button', $agent_id ); ?>
	<input type="submit" value="<?php esc_attr_e( 'Save Changes', 'real-estate-manager' ); ?>" class="btn btn-default">
	<a href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>" class="btn btn-default"><?php esc_attr_e( 'Logout', 'real-estate-manager' ); ?></a>
	<div class="rem-res">
		<p class="alert alert-info"><?php esc_attr_e( 'Saving Changes...', 'real-estate-manager' ); ?></p>
	</div>
</form>
</div>