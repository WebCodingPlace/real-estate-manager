<div class="wrap ich-settings-main-wrap">
	<h3 class="page-header">
		<?php esc_attr_e( 'Real Estate Manager - Settings', 'real-estate-manager' ); ?> <small>v<?php echo REM_VERSION; ?></small>
		
	</h3>
	<div class="row">
		<div class="col-sm-3">
			<div class="list-group wcp-tabs-menu">
				<?php $all_fields_settings = $this->admin_settings_fields();
					foreach ($all_fields_settings as $panel) { ?>
						<a href="#<?php echo esc_attr($panel['panel_name']); ?>" role="button" class="list-group-item">
							<?php echo (isset($panel['icon'])) ? wp_kses_post($panel['icon']) : '' ; ?>
							<?php echo esc_attr($panel['panel_title']); ?>
						</a>
				<?php } ?>
			</div>			
		</div>
		<div class="col-sm-9">
			<form id="rem-settings-form" class="form-horizontal">
				<input type="hidden" name="action" value="wcp_rem_save_settings">
				<input type="hidden" name="rem_nonce_settings" value="<?php echo wp_create_nonce('rem-nonce-settings'); ?>" />
				<?php $all_fields_settings = $this->admin_settings_fields();
					foreach ($all_fields_settings as $panel) { ?>
						<div class="panel panel-default panel-settings" id="<?php echo esc_attr($panel['panel_name']); ?>">
							<div class="panel-heading">
								<b><?php echo (isset($panel['icon'])) ? wp_kses_post($panel['icon']) : '' ; ?> <?php echo esc_attr($panel['panel_title']); ?></b>
							</div>
							<div class="panel-body">
								<?php foreach ($panel['fields'] as $field) {
									if (class_exists('Landz_Theme_Init')) {
										if (!isset($field['theme_dependable']) || $field['theme_dependable'] == false) {
											echo $this->render_setting_field($field);
										}
									} else {
										echo $this->render_setting_field($field);
									}
								} ?>
							</div>
						</div>
				<?php } ?>
				<p class="text-right">
					<span class="wcp-progress" style="display:none;"><?php esc_attr_e( 'Please Wait...', 'real-estate-manager' ); ?></span>					
					<input class="btn btn-success" type="submit" value="<?php esc_attr_e( 'Save Settings', 'real-estate-manager' ); ?>">
				</p>
			</form>
		</div>
	</div>
</div>