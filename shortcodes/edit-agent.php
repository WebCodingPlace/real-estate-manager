<?php
	$current_user = wp_get_current_user();
	$agent_id = $current_user->ID;
	$agent_email = $current_user->user_email;
?>
<div class="ich-settings-main-wrap" id="rem-agent-page">
<form action="" id="agent-profile-form">
	<input type="hidden" name="action" value="rem_save_profile_front">
	<input type="hidden" name="agent_id" value="<?php echo $agent_id; ?>">
	<input type="hidden" class="rem-ajax-url" value="<?php echo admin_url('admin-ajax.php'); ?>">

	<?php
		global $rem_ob;
		$field_tabs = rem_get_agent_fields_tabs();
		$agent_fields = $rem_ob->get_agent_fields();

	foreach ($field_tabs as $tab_name => $tab_title) { ?>
	<?php echo ($tab_name != 'personal_info') ? '<br>' : '' ; ?>
		<div class="section-title line-style no-margin">
			<h3 class="title"><?php echo $tab_title; ?></h3>
		</div>
		<ul class="profile edit-agent-profile">

			<?php if ($tab_name == 'personal_info') { ?>

				<li>
					<span><?php _e( 'Username', 'real-estate-manager' ); ?></span> <?php echo $current_user->user_login; ?>
					<i class="icon fa fa-lock"></i>
				</li>

			<?php } ?>

			<?php
				foreach ($agent_fields as $field) {
					if (isset($field['tab']) && $field['tab'] == $tab_name && in_array('edit', $field['display'])) {
						$this->render_agent_edit_field($field, $agent_id);
					}
				}
			?>
			</ul>
		<?php } ?>
	<br>
		<?php do_action( 'rem_edit_agent_before_button', $agent_id ); ?>
	<input type="submit" value="<?php _e( 'Save Changes', 'real-estate-manager' ); ?>" class="btn btn-default">
	<a href="<?php echo esc_url( wp_logout_url(home_url()) ); ?>" class="btn btn-default"><?php _e( 'Logout', 'real-estate-manager' ); ?></a>
	<div class="rem-res">
		<p class="alert alert-info"><?php _e( 'Saving Changes...', 'real-estate-manager' ); ?></p>
	</div>
</form>
</div>