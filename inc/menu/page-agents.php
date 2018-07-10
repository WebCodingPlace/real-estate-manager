<?php
	$pending_agents = get_option( 'rem_pending_users' );
	$args = array(
		'role'         => 'rem_property_agent',
	); 
	$registered_agents = get_users( $args );	
?>
<div class="wrap ich-settings-main-wrap">
	<?php if (isset($_GET['agent_id'])) {
		$single_agent = $pending_agents[$_GET['agent_id']];
		global $rem_ob;
		$agent_fields = $rem_ob->get_agent_fields();		
	?>
	<div class="panel panel-info">
		<div class="panel-heading">
			<h3 class="panel-title">
				<?php echo (isset($single_agent['first_name'])) ? $single_agent['first_name'] : '' ; ?>
				<?php echo (isset($single_agent['last_name'])) ? $single_agent['last_name'] : '' ; ?></h3>
		</div>
		<div class="panel-body">
			<table class="table table-bordered">
				<?php foreach ($agent_fields as $field) {
					if (isset($single_agent[$field['key']])) { ?>
						<tr>
							<th><?php echo $field['title'] ?></th>
							<td><?php echo $single_agent[$field['key']]; ?></td>
						</tr>
					<?php }
				} ?>
			</table>
		</div>
	</div>
	<?php } ?>
	<?php if (isset($_GET['approved_agent_id'])) {
		$approved_agent_id = $_GET['approved_agent_id'];
		global $rem_ob;
		$agent_fields = $rem_ob->get_agent_fields();		
	?>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php echo get_user_meta( $approved_agent_id, 'first_name', true ); ?> <?php echo get_user_meta( $approved_agent_id, 'last_name', true ); ?></h3>
		</div>
		<div class="panel-body">
			<table class="table table-bordered">
				<?php foreach ($agent_fields as $field) { ?>
					<tr>
						<th><?php echo $field['title'] ?></th>
						<td><?php echo get_user_meta( $approved_agent_id, $field['key'], true ); ?></td>
					</tr>
				<?php } ?>
			</table>
		</div>
	</div>
	<?php } ?>	
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php _e( 'Pending Agents', 'real-estate-manager' ); ?> - <?php echo (!empty($pending_agents)) ? count($pending_agents) : '0' ; ?></h3>
		</div>
		<div class="panel-body">
			<?php if (is_array($pending_agents) && !empty($pending_agents)) { ?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th><?php _e( 'Username', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'Email', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'First Name', 'real-estate-manager' ) ?></th>
							<th><?php _e( 'Last Name', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'Date of Registration', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'Action', 'real-estate-manager' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($pending_agents as $index => $agent) { ?>
							<tr>
								<td><?php echo $agent['username'] ?></td>
								<td><?php echo $agent['useremail'] ?></td>
								<td><?php echo (isset($agent['first_name'])) ? $agent['first_name'] : '' ; ?></td>
								<td><?php echo (isset($agent['last_name'])) ? $agent['last_name'] : '' ; ?></td>
								<td><?php echo $agent['time'] ?></td>
								<td>
									<button class="btn btn-sm btn-danger deny-user" data-userindex="<?php echo $index; ?>"><?php _e( 'Deny', 'real-estate-manager' ); ?></button>
									<button class="btn btn-sm btn-success approve-user" data-userindex="<?php echo $index; ?>"><?php _e( 'Approve', 'real-estate-manager' ); ?></button>
									<a href="<?php echo esc_url( add_query_arg( 'agent_id', $index ) ); ?>" class="btn btn-sm btn-primary"><?php _e( 'Details', 'real-estate-manager' ); ?></a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } else { ?>
				<div class="alert alert-info">
					<?php _e( 'You dont have any pending agents.', 'real-estate-manager' ); ?> 
				</div>
			<?php } ?>
		</div>
	</div>

	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title"><?php _e( 'Registered Agents', 'real-estate-manager' ); ?> - <?php echo count($registered_agents); ?></h3>
		</div>
		<div class="panel-body">
			<?php if (is_array($registered_agents) && !empty($registered_agents)) { ?>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th><?php _e( 'Username', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'Email', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'First Name', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'Last Name', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'Properties', 'real-estate-manager' ); ?></th>
							<th><?php _e( 'Profile', 'real-estate-manager' ); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($registered_agents as $agent) {
							$agent_info = get_userdata($agent->ID); ?>
							<tr>
								<td><?php echo $agent_info->user_login; ?></td>
								<td><?php echo $agent_info->user_email; ?></td>
								<td><?php echo get_user_meta( $agent->ID, 'first_name', true ); ?></td>
								<td><?php echo get_user_meta( $agent->ID, 'last_name', true ); ?></td>
								<td><?php echo count_user_posts( $agent->ID, 'rem_property' ); ?></td>
								<td>
									<a class="btn btn-sm btn-info" target="_blank" href="<?php echo get_author_posts_url( $agent->ID ); ?>"><?php _e( 'View Profile', 'real-estate-manager' ); ?></a>
									<a href="<?php echo esc_url( add_query_arg( 'approved_agent_id', $agent->ID ) ); ?>" class="btn btn-sm btn-primary"><?php _e( 'Details', 'real-estate-manager' ); ?></a>
								</td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			<?php } else { ?>
				<div class="alert alert-info">
					<?php _e( 'You dont have any registered agents.', 'real-estate-manager' ); ?> 
				</div>
			<?php } ?>
		</div>
	</div>
	<div class="text-right">
		<a href="<?php echo admin_url( 'user-new.php' ); ?>" class="btn btn-primary"><?php _e( 'Register New Agent', 'real-estate-manager' ); ?></a>
	</div>
</div>