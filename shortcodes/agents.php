<div class="ich-settings-main-wrap rem-list-agents">
	<div class="row <?php echo ($masonry == 'enable') ? 'masonry-agents' : '' ; ?>">
		<?php foreach ($agents as $agent) { ?>
			<div class="<?php echo esc_attr($columns); ?> rem-agent-container">
				<div class="agent-contact-wrapper agent-card-<?php echo esc_attr($style); ?>">
					<?php do_action( 'rem_agent_box', $agent->ID, $style ); ?>
				</div>
			</div>
		<?php } ?>
	</div>
</div>