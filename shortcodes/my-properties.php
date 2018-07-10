<div class="ich-settings-main-wrap">
<div id="user-profile">
	<div class="table-responsive property-list">
		<table class="table-striped table-hover">
		  <thead>
			<tr>
				<th><?php _e( 'Thumbnail', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Title', 'real-estate-manager' ); ?></th>
				<th class="hidden-xs"><?php _e( 'Type', 'real-estate-manager' ); ?></th>
				<th class="hidden-xs hidden-sm"><?php _e( 'Added', 'real-estate-manager' ); ?></th>
				<th class="hidden-xs"><?php _e( 'Purpose', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Status', 'real-estate-manager' ); ?></th>
				<th><?php _e( 'Actions', 'real-estate-manager' ); ?></th>
			</tr>
		  </thead>
		  <tbody>
			<?php 
				$current_user_data = wp_get_current_user();
				$args = array(
					'author'	=> $current_user_data->ID,
					'post_type' => 'rem_property',
					'posts_per_page' => 10,
					'post_status' => array( 'pending', 'draft', 'future', 'publish' )
				);
		    	if (is_front_page()) {
		    		$paged = ( get_query_var('page') ) ? get_query_var('page') : 1;
		    	} else {
					$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
		    	}
				$args['paged'] = $paged;

				$myproperties = new WP_Query( $args );
				if( $myproperties->have_posts() ){
					while( $myproperties->have_posts() ){ 
						$myproperties->the_post(); ?>	
							<tr>
								<td class="img-wrap">
									<?php do_action( 'rem_property_picture', get_the_id(), 'thumbnail' ); ?>
								</td>
								<td><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a> <?php echo get_post_meta(get_the_id(),'rem_property_address', true); ?></td>
								<td class="hidden-xs"><?php echo ucfirst(get_post_meta(get_the_id(),'rem_property_type', true )); ?></td>
								<td class="hidden-xs hidden-sm"><?php the_time('Y/m/d'); ?></td>
								<td class="hidden-xs"><?php echo ucfirst(get_post_meta(get_the_id(),'rem_property_purpose', true )); ?></td>
								<td>
									<?php
										$p_status = get_post_status(get_the_id());
										$status_class = ($p_status == 'publish') ? 'label-success' : 'label-info' ;
									?>
									<span class="label <?php echo $status_class; ?>"><?php echo ucfirst($p_status); ?></span></td>
								<td>
									<?php
										$edit_page_id = rem_get_option('property_edit_page', 1);
										$link_page = get_permalink( $edit_page_id );

									?>
									<a href="<?php echo esc_url( add_query_arg( 'property_id', get_the_id(), $link_page ) ); ?>"><i class="fas fa-pencil-alt"></i></a>
									
									<?php $delete_url = get_delete_post_link(get_the_id());
										if ($delete_url != '') { ?>
											<a href="<?php echo $delete_url; ?>"><i class="fa fa-trash"></i></a>
										<?php }
									?>
								</td>
							</tr>
						<?php 
					}
					wp_reset_postdata();
				}
			?>
		  </tbody>
		</table>
		<?php do_action( 'rem_pagination', $paged, $myproperties->max_num_pages ); ?>
	</div>
</div>
</div>