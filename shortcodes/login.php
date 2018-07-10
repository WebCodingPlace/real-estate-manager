<?php
if (is_user_logged_in()) {
	echo $content;
} else { ?>
<div class="ich-settings-main-wrap">
	<div id="login-page">
		<div class="box">	
			<form id="rem-login-form" data-ajaxurl="<?php echo admin_url( 'admin-ajax.php' ); ?>" data-redirect="<?php echo $redirect; ?>">
				<p class="title"><?php echo $heading; ?></p>
				<div class="field">
					<input type="hidden" value="rem_user_login" name="action">	
					<input type="text" required placeholder="<?php _e( 'Username or email', 'real-estate-manager' ); ?>" name="rem_username" class="form-control" id="email">
					<i class="fa fa-user user"></i>
				</div>
				<div class="field">
					<input type="password" required placeholder="<?php _e( 'Password', 'real-estate-manager' ); ?>" name="rem_userpass" class="form-control" id="password">
					<i class="fa fa-ellipsis-h"></i>
				</div>
				<div class="field footer-form text-right">
					<span class="remember"><input class="labelauty" name="rememberme" type="checkbox" data-labelauty="<?php _e( 'Keep me signed in', 'real-estate-manager' ); ?>"></span>
					<button class="btn btn-default button-form" type="submit"><?php _e( 'Login', 'real-estate-manager' ); ?></button>
				</div>

				<div class="alert with-icon login-alert alert-danger" role="alert" style="display:none;">
					<i class="icon fa fa-exclamation-triangle"></i>
					<span class="login-status" style="margin-top: 12px;margin-left: 10px;"></span>
				</div>

			</form>
		</div>	
	</div>
</div>
<?php } ?>