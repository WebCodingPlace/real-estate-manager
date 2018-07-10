<div class="wrap ich-settings-main-wrap">
	<h3 class="page-header"><?php _e( 'Real Estate Manager - Settings', 'real-estate-manager' ); ?> <small>v<?php echo REM_VERSION; ?></small></h3>
	<div class="row">
		<div class="col-sm-3">
			<div class="list-group wcp-tabs-menu">
				<?php $all_fields_settings = $this->admin_settings_fields();
					foreach ($all_fields_settings as $panel) { ?>
						<a href="#<?php echo str_replace(' ', '-', strtolower($panel['panel_title'])); ?>" role="button" class="list-group-item">
							<?php echo (isset($panel['icon'])) ? $panel['icon'] : '' ; ?>
							<?php echo $panel['panel_title']; ?>
						</a>
				<?php } ?>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading"><?php _e( 'If 404 Page is displaying', 'real-estate-manager' ); ?></div>
				<div class="panel-body">
					<?php _e( 'Go to Settings -> Permalinks and click Save Changes button', 'real-estate-manager' ); ?>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading"><?php _e( 'If Maps not displaying', 'real-estate-manager' ); ?></div>
				<div class="panel-body">
					<?php _e( 'Create a Google Maps API using google and paste it in Maps API field.', 'real-estate-manager' ); ?>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading"><?php _e( 'Change Property Page Design', 'real-estate-manager' ); ?></div>
				<div class="panel-body">
					<?php _e( 'Copy the following file and paste it into your theme\'s root', 'real-estate-manager' ); ?>
					<code>templates/single/default.php</code>.
					<?php _e( 'Now change its name to', 'real-estate-manager' ) ?>
					<code>single-rem_property.php</code>.
					<?php _e( 'Then change Property Page Template option to From Theme', 'real-estate-manager' ); ?>.
					<?php _e( 'Now you can make changes in this template file.', 'real-estate-manager' ); ?>
				</div>
			</div>
			<div class="panel panel-default">
				<div class="panel-heading"><?php _e( 'Need Help? Any Suggestions?', 'real-estate-manager' ); ?></div>
				<div class="panel-body">
					<?php _e( 'Please contact us', 'real-estate-manager' ); ?>
					<a href="https://webcodingplace.com/contact-us/" target="_blank"><?php _e( 'HERE', 'real-estate-manager' ); ?></a>
					<?php _e( 'for assistance.', 'real-estate-manager' ); ?>
				</div>
			</div>			
		</div>
		<div class="col-sm-9">
			<form id="rem-settings-form" class="form-horizontal">
				<input type="hidden" name="action" value="wcp_rem_save_settings">
				<?php $all_fields_settings = $this->admin_settings_fields();
					foreach ($all_fields_settings as $panel) { ?>
						<div class="panel panel-default" id="<?php echo str_replace(' ', '-', strtolower($panel['panel_title'])); ?>">
							<div class="panel-heading">
								<b><?php echo (isset($panel['icon'])) ? $panel['icon'] : '' ; ?> <?php echo $panel['panel_title']; ?></b>
							</div>
							<div class="panel-body">
								<?php foreach ($panel['fields'] as $field) {
									$this->render_setting_field($field);
								} ?>
							</div>
						</div>
				<?php } ?>
				<p class="text-right">
					<span class="wcp-progress" style="display:none;"><?php _e( 'Please Wait...', 'real-estate-manager' ); ?></span>					
					<input class="btn btn-success" type="submit" value="<?php _e( 'Save Settings', 'real-estate-manager' ); ?>">
				</p>
			</form>
		</div>
	</div>
</div>