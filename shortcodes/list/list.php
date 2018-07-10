<?php
if ( $the_query->have_posts() ) {
	$masonry_class = ($masonry == 'enable') ? 'masonry-properties' : '';
	echo '<div class="ich-settings-main-wrap">'; ?>
	<?php if ($top_bar == 'enable') { ?>	
	<div class="row rem-topbar">
		<form method="GET" action="#">
		<div class="col-sm-3 col-xs-8">
			<input type="hidden" name="list_style" value="<?php echo (isset($_GET['list_style'])) ? $_GET['list_style'] : '' ; ?>">
			<select class="form-control" name="sort_by" onchange="this.form.submit()">
				<?php
					$sorting_options = $this->lists_sorting_options();
					foreach ($sorting_options as $option) {
						$selected = (isset($_GET['sort_by']) && $_GET['sort_by'] == $option['value']) ? 'selected' : '' ; ?>
						<option <?php echo $selected; ?> value="<?php echo $option['value']; ?>"><?php echo $option['title']; ?></option>
					<?php }
				?>
			</select>
		</div>
		<div class="col-sm-6 hidden-xs"></div>
		<div class="col-sm-3 col-xs-4 text-right">
			<div class="btn-group" role="group" aria-label="...">
			  <a href="<?php echo esc_url( add_query_arg( 'list_style', 'list' ) ); ?>" class="btn btn-default <?php echo ($style == '1') ? 'active' : '' ; ?>">
				<span class="glyphicon glyphicon-th-list"></span>
			  </a>
			  <a href="<?php echo esc_url( add_query_arg( 'list_style', 'grid' ) ); ?>" class="btn btn-default <?php echo ($style != '1') ? 'active' : '' ; ?>">
				<span class="glyphicon glyphicon-th"></span>
			  </a>
			</div>			
		</div>
		</form>
	</div>
	<?php } ?>
	
	<?php 
	echo '<div class="row '.$masonry_class.'">';
	while ( $the_query->have_posts() ) {
		$the_query->the_post();
		echo '<div id="property-'.get_the_id().'" class="'.join(' ', get_post_class($class)).'">';
			do_action('rem_property_box', get_the_id(), $style);
		echo '</div>';
	}
	echo '</div>';
	/* Restore original Post Data */
	wp_reset_postdata();
	if ($pagination == 'enable') {
		do_action( 'rem_pagination', $paged, $the_query->max_num_pages );
	}				
	echo '</div>';
} else {
	echo __( 'No Properties Found!', 'real-estate-manager' );
}
?>