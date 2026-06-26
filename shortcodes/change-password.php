<div class="ich-settings-main-wrap">
	<div class="section-title line-style no-margin">
		<h3 class="title"><?php echo esc_attr($title); ?></h3>
	</div>
	<?php if ($subtitle != '') { ?>
		<div>
			<p><?php echo stripcslashes($subtitle); ?></p>
		</div>
	<?php } ?>
	<form action="#" method="POST" class="rem-change-password-form" data-redirect="<?php echo esc_url($redirect); ?>">
		<div class="field-wrap">
			<label for="old-password"><?php esc_attr_e( 'Old Password', 'real-estate-manager' ); ?></label>
			<input class="form-control" type="password" id="old-password" name="rem_old_passsword" required>
		</div>

		<div class="field-wrap">
			<label for="new-password"><?php esc_attr_e( 'New Password', 'real-estate-manager' ); ?></label>
			<input class="form-control" type="password" id="new-password" name="rem_new_passsword" required>
		</div>

		<div class="field-wrap">
			<label for="repeat-password"><?php esc_attr_e( 'Repeat Password', 'real-estate-manager' ); ?></label>
			<input class="form-control" type="password" id="repeat-password" name="rem_repeat_passsword" required>
		</div>
		
		<?php if ($clear_sessions == 'enable') { ?>
			<div class="checkbox">
			  <label>
			    <input type="checkbox" class="logoutall" value="yes"> <?php esc_attr_e( 'Log Out Everywhere Else', 'real-estate-manager' ); ?>
			  </label>
			</div>
		<?php } ?>

		<input class="btn btn-default" type="submit" value="<?php esc_attr_e( 'Save Changes', 'real-estate-manager' ); ?>">
	</form>
</div>