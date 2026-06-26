<div class="ich-settings-main-wrap ">
	<div class="rem-categories-wrap">
		<div class="row <?php echo isset($attrs['masonry']) && $attrs['masonry'] == 'enable' ? 'masonry-cats' : ''; ?>">
			<?php 
            if (!empty($categories)) {

                $col_class = (isset($attrs['class'])) ? esc_attr($attrs['class']) : 'col-sm-6' ;
                $images_size = (isset($attrs['images_size'])) ? esc_attr($attrs['images_size']) : 'full' ;
                $images_height = (isset($attrs['images_height'])) ? esc_attr($attrs['images_height']) : '' ;
                $data_attrs = '';
                if ($images_height != '') {
                    $col_class = $col_class.' rem-fixed-cats';
                    $data_attrs = "data-imagesheight=$images_height";
                }

                foreach ($categories as $cat) {
    				$term = get_term( $cat->term_id, 'rem_property_cat' );
    				$image_id = get_term_meta( $cat->term_id, 'category-image-id', true );
    				 ?>
    				<div <?php echo esc_attr( $data_attrs ); ?> class="<?php echo esc_attr( $col_class ); ?> rem-cat">
    					<div class="rem-cat-inner">
    					    <div class="rem-cat-avatar">
    					        <a href="<?php echo get_term_link($cat->term_id); ?>">
    					           <?php echo wp_get_attachment_image( $image_id, $images_size ); ?>
    					        </a>
    					    </div>
    					    <div class="rem-cat-content">
    					        <a href="<?php echo get_term_link($cat->term_id); ?>">
    						        <div class="rem-cat-info">
    						            <h2 class="rem-cat-name"> 
    						                <?php echo esc_attr($cat->name); ?>
    						            </h2>
    						            <span>
                                            <?php echo sprintf( _n( '%s property', '%s properties', $cat->count, 'real-estate-manager' ), $cat->count ); ?>
                                        </span>
    						        </div>
    						        <div class="rem-cat-description"> 
    							        <p><?php echo esc_attr($cat->description); ?></p>
    						        </div>
    					        </a>
    					    </div>
    					</div>
    				</div>
    				<?php 
    			} 
            }else { ?>
                <p><?php esc_attr_e( 'Categories Not found', 'real-estate-manager' ); ?></p>
            <?php } ?>
		</div>
	</div>
</div>